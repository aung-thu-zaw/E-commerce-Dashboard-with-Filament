<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChefController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $chefs = Employee::whereHas('employeePosition', function ($query) {
                $query->where('name', 'like', '%Chef%');
            })
            ->select("id", "employee_position_id", "name", "image")
            ->with("employeePosition:id,name")
            ->where("status", "active")
            ->orderBy("id", "desc")
            ->paginate(8)
            ->withQueryString();

            return response()->json($chefs, 200);
        } catch (\Exception $e) {
            return $this->apiExceptionResponse($e);
        }
    }

}
