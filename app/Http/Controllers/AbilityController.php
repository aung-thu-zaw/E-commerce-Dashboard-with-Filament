<?php

namespace App\Http\Controllers;

use App\Http\Resources\AbilityCollection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AbilityController extends Controller
{
    public function __invoke(): JsonResponse
    {
        $abilities = auth()->user()->permissions->pluck('name')->all();

        return response()->json($abilities);

    }
}
