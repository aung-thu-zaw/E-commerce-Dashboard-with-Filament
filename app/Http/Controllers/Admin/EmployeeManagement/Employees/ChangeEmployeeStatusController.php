<?php

namespace App\Http\Controllers\Admin\EmployeeManagement\Employees;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ChangeEmployeeStatusController extends Controller
{
    public function __invoke(Request $request, Employee $employee): JsonResponse
    {
        try {
            $request->validate(['status' => ['required', Rule::in(['active','inactive'])]]);

            $employee->update(['status' => $request->status]);

            $employee->load('employeePosition:id,name');

            return response()->json($employee, 200);
        } catch (\Exception $e) {
            $this->apiExceptionResponse($e);
        }
    }
}
