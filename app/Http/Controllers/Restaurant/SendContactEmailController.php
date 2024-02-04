<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Restaurant\ContactUsRequest;
use App\Mail\ContactUsMail;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SendContactEmailController extends Controller
{
    public function __invoke(ContactUsRequest $request): JsonResponse
    {
        try {
            Mail::to(env('MAIL_FROM_ADDRESS'))->queue(new ContactUsMail($request->name, $request->email, $request->phone, $request->message));

            return response()->json(['message' => 'Email sent successfully!'], 200);

        } catch (\Exception $e) {
            $this->apiExceptionResponse($e);
        }
    }
}
