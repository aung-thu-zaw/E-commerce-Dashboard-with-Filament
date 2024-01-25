<?php

namespace App\Http\Controllers\Admin\Newsletter;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\NewsletterRequest;
use App\Mail\NewsletterMail;
use App\Models\Subscriber;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;

class SendNewsletterController extends Controller
{
    public function __invoke(NewsletterRequest $request): JsonResponse
    {
        try {
            $subscribers = Subscriber::where('status', 'subscribed')->get();

            $subscribers->each(function ($subscriber) use ($request) {
                Mail::to($subscriber->email)->queue(new NewsletterMail($request->subject, $request->content));
            });

            return response()->json(['message' => 'Newsletter sent successfully!'], 200);
        } catch (\Exception $e) {
            $this->apiExceptionResponse($e);
        }
    }
}
