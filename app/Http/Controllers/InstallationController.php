<?php

namespace App\Http\Controllers;

use App\Models\InstallationService;
use Illuminate\View\View;

class InstallationController extends Controller
{
    public function __invoke(): View
    {
        return view('installation', [
            'installationService' => InstallationService::query()->available()->first(),
        ]);
    }
}
