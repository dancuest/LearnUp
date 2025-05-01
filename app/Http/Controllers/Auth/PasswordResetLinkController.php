<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Inertia\Inertia;
use Inertia\Response;

class PasswordResetLinkController extends Controller
{
    /**
     * Show the password reset link request page.
     * 
     * @OA\Get(
     *      path="/auth/forgot-password",
     *      operationId="showPasswordResetLinkRequestPage",
     *      tags={"auth"},
     *      summary="Show password reset link request page",
     *      description="Display the password reset link request page.",
     *      @OA\Response(
     *          response=200,
     *          description="Password reset link request page displayed"
     *      )
     * )
     */
    public function create(Request $request): Response
    {
        return Inertia::render('auth/forgot-password', [
            'status' => $request->session()->get('status'),
        ]);
    }

    /**
     * Handle an incoming password reset link request.
     * 
     * @OA\Post(
     *      path="/auth/forgot-password",
     *      operationId="sendPasswordResetLink",
     *      tags={"auth"},
     *      summary="Send password reset link",
     *      description="Send a password reset link to the user's email.",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"email"},
     *              @OA\Property(property="email", type="string", example="user@example.com")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Password reset link sent successfully"
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Invalid email address"
     *      )
     * )
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        Password::sendResetLink(
            $request->only('email')
        );

        return back()->with('status', __('A reset link will be sent if the account exists.'));
    }
}
