<?php

namespace App\Http\Controllers;

use App\Models\AutoBoxManufacturer;
use App\Models\CatalogCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LegacyRedirectController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        $mapping = config('legacy_urls.'.$request->getPathInfo());
        abort_unless(is_array($mapping), 404);
        $parameters = $mapping['parameters'] ?? [];

        if (isset($mapping['manufacturer'])) {
            $manufacturer = AutoBoxManufacturer::query()->active()
                ->whereRaw('LOWER(name) = ?', [mb_strtolower($mapping['manufacturer'])])->firstOrFail();
            $parameters['manufacturer'] = [$manufacturer->id];
        }

        if (isset($parameters['category'])) {
            CatalogCategory::query()->active()->where('slug', $parameters['category'])
                ->whereHas('parent', fn ($query) => $query->active()->where('slug', 'autobagazhniki'))
                ->firstOrFail();
        }

        return redirect()->route($mapping['route'], $parameters, 301);
    }
}
