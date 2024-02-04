<?php

namespace App\Http\Controllers\Admin\EmployeeManagement\Employees;

use App\Http\Controllers\Controller;
use App\Models\EmployeePosition;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetResourcesForEmployeeFormController extends Controller
{
    public function __invoke(): JsonResponse
    {
        try {
            $employeePositions = EmployeePosition::select('id', 'name', 'slug')->get();

            return response()->json($employeePositions, 200);
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }
}
