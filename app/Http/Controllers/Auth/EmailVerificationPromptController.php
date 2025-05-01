<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class EmailVerificationPromptController extends Controller
{
    /**
     * Show the email verification prompt page.
     * 
     * @OA\Get(
     *      path="/auth/email/verify",
     *      operationId="showEmailVerificationPrompt",
     *      tags={"auth"},
     *      summary="Show email verification prompt",
     *      description="Display the email verification prompt page.",
     *      @OA\Response(
     *          response=200,
     *          description="Email verification prompt displayed"
     *      ),
     *      @OA\Response(
     *          response=302,
     *          description="Redirect to dashboard if already verified"
     *      )
     * )
     */
    public function __invoke(Request $request): Response|RedirectResponse
    {
        return $request->user()->hasVerifiedEmail()
            ? redirect()->intended(route('dashboard', absolute: false))
            : Inertia::render('auth/verify-email', ['status' => $request->session()->get('status')]);
    }
}
