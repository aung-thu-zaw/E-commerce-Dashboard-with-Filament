<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class AbilityController extends Controller
{
    public function __invoke(): JsonResponse
    {
        $abilities = auth()->user()->permissions->pluck('name')->all();

        return response()->json($abilities);

    }
}
