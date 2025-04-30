<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     * 
     * @OA\Post(
     *      path="/auth/email/verification-notification",
     *      operationId="sendEmailVerificationNotification",
     *      tags={"auth"},
     *      summary="Send email verification notification",
     *      description="Send a new email verification notification to the user.",
     *      @OA\Response(
     *          response=200,
     *          description="Verification link sent successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="string", example="verification-link-sent")
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="User already verified"
     *      )
     * )
     */
    public function store(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard', absolute: false));
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    }
}
