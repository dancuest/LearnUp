<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class ConfirmablePasswordController extends Controller
{
    /**
     * Show the confirm password page.
     * 
     * @OA\Get(
     *      path="/auth/confirm-password",
     *      operationId="showConfirmPasswordPage",
     *      tags={"auth"},
     *      summary="Show confirm password page",
     *      description="Display the confirm password page.",
     *      @OA\Response(
     *          response=200,
     *          description="Confirm password page displayed"
     *      )
     * )
     */
    public function show(): Response
    {
        return Inertia::render('auth/confirm-password');
    }

    /**
     * Confirm the user's password.
     * 
     * @OA\Post(
     *      path="/auth/confirm-password",
     *      operationId="confirmPassword",
     *      tags={"auth"},
     *      summary="Confirm password",
     *      description="Confirm the user's password.",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"password"},
     *              @OA\Property(property="password", type="string", example="password123")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Password confirmed successfully"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Invalid password"
     *      )
     * )
     */
    public function store(Request $request): RedirectResponse
    {
        if (! Auth::guard('web')->validate([
            'email' => $request->user()->email,
            'password' => $request->password,
        ])) {
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        $request->session()->put('auth.password_confirmed_at', time());

        return redirect()->intended(route('dashboard', absolute: false));
    }
}
