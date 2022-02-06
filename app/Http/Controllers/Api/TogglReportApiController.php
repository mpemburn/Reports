<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\TogglService;
use Illuminate\Http\JsonResponse;

class TogglReportApiController extends Controller
{
    public function index(TogglService $service): JsonResponse
    {
        $report = $service->getEntries();
        return response()->json([
            'valid' => auth()->check(),
            'report' => $report
        ]);
    }

    public function store(TogglService $service) {
        $service->importFromApi();

        return response()->json([
            'valid' => auth()->check(),
        ]);
    }
}
