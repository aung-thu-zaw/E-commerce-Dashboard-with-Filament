<?php

namespace App\Http\Controllers\Admin\EmployeeManagement\Employees;

use App\Actions\Admin\Employees\CreateEmployeeAction;
use App\Actions\Admin\Employees\UpdateEmployeeAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EmployeeManagement\EmployeeRequest;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:employees.view', ['only' => ['index']]);
        $this->middleware('permission:employees.create', ['only' => ['store']]);
        $this->middleware('permission:employees.edit', ['only' => ['show', 'update']]);
        $this->middleware('permission:employees.delete', ['only' => ['destroy']]);
    }

    public function index(): JsonResponse
    {
        try {
            $employees = Employee::search(request('search'))
            ->query(function (Builder $builder) {
                $builder->with('employeePosition:id,name')
                    ->filterBy(request(['status','position']));
            })
            ->orderBy(request('sort', 'id'), request('direction', 'desc'))
            ->paginate(request('per_page', 5))
            ->appends(request()->all());

            return response()->json($employees, 200);
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }

    public function store(EmployeeRequest $request): JsonResponse
    {
        try {
            $employee = (new CreateEmployeeAction())->handle($request->validated());
            return response()->json($employee, 201);
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }

    public function show(Employee $employee): JsonResponse
    {
        try {
            return response()->json($employee, 200);
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }

    public function update(EmployeeRequest $request, Employee $employee): JsonResponse
    {
        try {
            $employee = (new UpdateEmployeeAction())->handle($request->validated(), $employee);
            return response()->json($employee, 200);
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }

    public function destroy(Employee $employee): Response
    {
        try {
            Employee::deleteImage($employee->image);
            $employee->delete();
            return response()->noContent();
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }
}
