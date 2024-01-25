<?php

namespace App\Http\Controllers\Admin\AccountManagement;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ChangeRegisteredAccountStatusController extends Controller
{
    public function __invoke(Request $request, User $user): JsonResponse
    {
        try {
            $request->validate(['status' => ['required', Rule::in(['active', 'suspended'])]]);

            $user->update(['status' => $request->status]);

            return response()->json($user, 200);
        } catch (\Exception $e) {
            $this->apiExceptionResponse($e);
        }
    }
}
