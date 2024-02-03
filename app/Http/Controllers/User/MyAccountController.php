<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\MyAccountRequest;
use App\Http\Requests\User\UserDeleteRequest;
use App\Http\Traits\ImageUpload;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class MyAccountController extends Controller
{
    use ImageUpload;

    public function update(MyAccountRequest $request): JsonResponse
    {
        try {
            $avatar = isset($request->avatar) && !is_string($request->avatar) ? $this->updateImage($request->avatar, $request->user()->avatar, 'avatars/users') : $request->user()->avatar;

            $request->user()->fill([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'avatar' => $avatar,
            ]);

            if ($request->user()->isDirty('email')) {
                $request->user()->email_verified_at = null;
            }

            $request->user()->save();

            return response()->json($request->user(), 200);
        } catch (\Exception $e) {
            $this->apiExceptionResponse($e);
        }
    }

    public function destroy(UserDeleteRequest $request): JsonResponse|Response
    {
        try {
            $user = $request->user();

            Auth::guard('web')->logout();

            $user->delete();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return response()->noContent();
        } catch (\Exception $e) {
            $this->apiExceptionResponse($e);
        }
    }
}
