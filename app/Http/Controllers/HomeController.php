<?php

namespace App\Http\Controllers;

use App\Models\VehicleMake;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $vehicleMakes = Schema::hasTable('vehicle_makes')
            ? VehicleMake::query()->active()->orderBy('name')->get(['id', 'name'])
            : collect();

        return view('home', compact('vehicleMakes'));
    }
}
