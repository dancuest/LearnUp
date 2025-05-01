<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     * 
     * @OA\Get(
     *      path="/auth/email/verify/{id}/{hash}",
     *      operationId="verifyEmail",
     *      tags={"auth"},
     *      summary="Verify email address",
     *      description="Mark the authenticated user's email address as verified.",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="User ID",
     *          required=true,
     *          @OA\Schema(type="integer", example=1)
     *      ),
     *      @OA\Parameter(
     *          name="hash",
     *          in="path",
     *          description="Email verification hash",
     *          required=true,
     *          @OA\Schema(type="string", example="abc123")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Email verified successfully"
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Invalid verification link"
     *      )
     * )
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard', absolute: false) . '?verified=1');
        }

        if ($request->user()->markEmailAsVerified()) {
            /** @var \Illuminate\Contracts\Auth\MustVerifyEmail $user */
            $user = $request->user();

            event(new Verified($user));
        }

        return redirect()->intended(route('dashboard', absolute: false) . '?verified=1');
    }
}
