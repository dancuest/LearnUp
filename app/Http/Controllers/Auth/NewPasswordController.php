<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class NewPasswordController extends Controller
{
    /**
     * Show the password reset page.
     * 
     * @OA\Get(
     *      path="/auth/reset-password/{token}",
     *      operationId="showPasswordResetPage",
     *      tags={"auth"},
     *      summary="Show password reset page",
     *      description="Display the password reset page.",
     *      @OA\Parameter(
     *          name="token",
     *          in="path",
     *          description="Password reset token",
     *          required=true,
     *          @OA\Schema(type="string", example="abc123")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Password reset page displayed"
     *      )
     * )
     */
    public function create(Request $request): Response
    {
        return Inertia::render('auth/reset-password', [
            'email' => $request->email,
            'token' => $request->route('token'),
        ]);
    }

    /**
     * Handle an incoming new password request.
     * 
     * @OA\Post(
     *      path="/auth/reset-password",
     *      operationId="resetPassword",
     *      tags={"auth"},
     *      summary="Reset password",
     *      description="Reset the user's password.",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"email", "password", "password_confirmation", "token"},
     *              @OA\Property(property="email", type="string", example="user@example.com"),
     *              @OA\Property(property="password", type="string", example="newpassword123"),
     *              @OA\Property(property="password_confirmation", type="string", example="newpassword123"),
     *              @OA\Property(property="token", type="string", example="abc123")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Password reset successfully"
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Validation error"
     *      )
     * )
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        if ($status == Password::PasswordReset) {
            return to_route('login')->with('status', __($status));
        }

        throw ValidationException::withMessages([
            'email' => [__($status)],
        ]);
    }
}
