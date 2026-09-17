<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\InstallationServiceRequest;
use App\Models\InstallationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class InstallationServiceController extends Controller
{
    public function edit(): View
    {
        return view('admin.installation-service.edit', [
            'installationService' => InstallationService::query()->firstOrFail(),
        ]);
    }

    public function update(InstallationServiceRequest $request): RedirectResponse
    {
        InstallationService::query()->firstOrFail()->update($request->validated());

        return to_route('admin.products.installation-service.edit')->with('success', 'Услуга установки сохранена.');
    }
}
