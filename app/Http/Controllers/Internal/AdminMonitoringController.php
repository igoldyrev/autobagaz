<?php

namespace App\Http\Controllers\Internal;

use App\Http\Controllers\Controller;
use App\Services\AdminMonitoringReport;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminMonitoringController extends Controller
{
    public function __invoke(Request $request, AdminMonitoringReport $report): JsonResponse
    {
        $validated = $request->validate([
            'date' => ['nullable', 'date_format:Y-m-d'],
            'limit' => ['nullable', 'integer', 'between:1,10'],
        ]);

        return response()
            ->json($report->build($validated['date'] ?? null, (int) ($validated['limit'] ?? 3)))
            ->header('Cache-Control', 'no-store, private');
    }
}
