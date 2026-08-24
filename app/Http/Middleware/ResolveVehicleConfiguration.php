<?php

namespace App\Http\Middleware;

use App\Models\VehicleConfiguration;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class ResolveVehicleConfiguration
{
    public const COOKIE_NAME = 'vehicle_configuration_id';

    public const YEAR_COOKIE_NAME = 'vehicle_year';

    public function handle(Request $request, Closure $next): Response
    {
        $configuration = null;
        $vehicleYear = null;

        if (Schema::hasTable('vehicle_configurations')) {
            $selection = $request->query(self::COOKIE_NAME);

            if ($selection === 'clear') {
                Cookie::queue(Cookie::forget(self::COOKIE_NAME));
                Cookie::queue(Cookie::forget(self::YEAR_COOKIE_NAME));
            } else {
                $configurationId = $selection !== null
                    ? filter_var($selection, FILTER_VALIDATE_INT)
                    : filter_var($request->cookie(self::COOKIE_NAME), FILTER_VALIDATE_INT);

                if ($configurationId) {
                    $configuration = VehicleConfiguration::query()
                        ->active()
                        ->whereHas('generation', fn ($query) => $query
                            ->active()
                            ->whereHas('vehicleModel', fn ($models) => $models
                                ->active()
                                ->whereHas('make', fn ($makes) => $makes->active())))
                        ->with(['generation.vehicleModel.make', 'bodyStyle', 'roofType'])
                        ->find($configurationId);
                }

                $cookieBelongsToConfiguration = (string) $request->cookie(self::COOKIE_NAME) === (string) $configuration?->id;
                $yearSelection = $request->query(self::YEAR_COOKIE_NAME);
                $yearCandidate = $yearSelection !== null
                    ? filter_var($yearSelection, FILTER_VALIDATE_INT)
                    : ($cookieBelongsToConfiguration ? filter_var($request->cookie(self::YEAR_COOKIE_NAME), FILTER_VALIDATE_INT) : null);

                if ($configuration && $yearCandidate && $this->supportsYear($configuration, $yearCandidate)) {
                    $vehicleYear = $yearCandidate;
                }

                if ($selection !== null && $configuration) {
                    Cookie::queue(cookie(
                        self::COOKIE_NAME,
                        (string) $configuration->id,
                        60 * 24 * 365,
                        '/',
                        secure: $request->isSecure(),
                        httpOnly: true,
                        sameSite: 'lax',
                    ));
                    if ($vehicleYear) {
                        Cookie::queue(cookie(
                            self::YEAR_COOKIE_NAME,
                            (string) $vehicleYear,
                            60 * 24 * 365,
                            '/',
                            secure: $request->isSecure(),
                            httpOnly: true,
                            sameSite: 'lax',
                        ));
                    } else {
                        Cookie::queue(Cookie::forget(self::YEAR_COOKIE_NAME));
                    }
                } elseif (($selection !== null || $request->hasCookie(self::COOKIE_NAME)) && ! $configuration) {
                    Cookie::queue(Cookie::forget(self::COOKIE_NAME));
                    Cookie::queue(Cookie::forget(self::YEAR_COOKIE_NAME));
                } elseif ($configuration && $request->hasCookie(self::YEAR_COOKIE_NAME) && ! $vehicleYear) {
                    Cookie::queue(Cookie::forget(self::YEAR_COOKIE_NAME));
                }
            }
        }

        $request->attributes->set('vehicleConfiguration', $configuration);
        $request->attributes->set('vehicleYear', $vehicleYear);
        View::share('selectedVehicle', $configuration);
        View::share('selectedVehicleYear', $vehicleYear);

        return $next($request);
    }

    private function supportsYear(VehicleConfiguration $configuration, int $year): bool
    {
        $yearFrom = $configuration->year_from ?: $configuration->generation?->year_from;
        $yearTo = $configuration->year_to ?: $configuration->generation?->year_to;

        return (! $yearFrom || $year >= $yearFrom) && (! $yearTo || $year <= $yearTo);
    }
}
