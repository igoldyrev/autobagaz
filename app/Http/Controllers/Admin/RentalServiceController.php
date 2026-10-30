<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RentalServiceRequest;
use App\Models\AdminActivityLog;
use App\Models\RentalService;
use App\Services\AdminActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class RentalServiceController extends Controller
{
    public function edit(): View
    {
        return view('admin.rental-service.edit', ['service' => RentalService::current()]);
    }

    public function update(RentalServiceRequest $request): RedirectResponse
    {
        $paths = [];
        $oldPaths = [];
        try {
            foreach (['contract', 'rules'] as $kind) {
                if ($request->hasFile($kind)) {
                    $paths[$kind.'_path'] = $request->file($kind)->store('rental-documents', 'local');
                    if (! $paths[$kind.'_path']) {
                        throw new \RuntimeException('Не удалось сохранить документ.');
                    }
                }
            }
            DB::transaction(function () use ($request, $paths, &$oldPaths): void {
                $service = RentalService::query()->lockForUpdate()->findOrFail(1);
                foreach ($paths as $key => $path) {
                    if ($service->$key) {
                        $oldPaths[] = $service->$key;
                    }
                }
                $data = $request->safe()->except(['contract', 'rules']);
                $data['groups'] = array_values($data['groups']);
                $data['rates'] = array_map(fn ($rate) => ['min_days' => (int) $rate['min_days'], 'max_days' => isset($rate['max_days']) ? (int) $rate['max_days'] : null, 'prices' => array_values($rate['prices'])], array_values($data['rates']));
                $service->update([...$data, ...$paths]);
                app(AdminActivityLogger::class)->record($request->user(), AdminActivityLog::ACTION_UPDATED, 'Изменены настройки услуги проката'.($paths ? ': заменены документы' : ''), 'rental_service', $service->id, $service->name);
            });
        } catch (\Throwable $exception) {
            Storage::disk('local')->delete(array_values($paths));
            throw $exception;
        }
        Storage::disk('local')->delete($oldPaths);

        return back()->with('success', 'Услуга проката сохранена.');
    }
}
