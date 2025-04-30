<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;
use Inertia\Response;

class PasswordController extends Controller
{
    /**
     * Show the user's password settings page.
     * 
     * @OA\Get(
     *      path="/settings/password",
     *      operationId="showPasswordSettingsPage",
     *      tags={"settings"},
     *      summary="Show password settings page",
     *      description="Display the user's password settings page.",
     *      @OA\Response(
     *          response=200,
     *          description="Password settings page displayed"
     *      )
     * )
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('settings/password', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => $request->session()->get('status'),
        ]);
    }

    /**
     * Update the user's password.
     * 
     * @OA\Put(
     *      path="/settings/password",
     *      operationId="updatePassword",
     *      tags={"settings"},
     *      summary="Update password",
     *      description="Update the user's password.",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"current_password", "password", "password_confirmation"},
     *              @OA\Property(property="current_password", type="string", example="oldpassword123"),
     *              @OA\Property(property="password", type="string", example="newpassword123"),
     *              @OA\Property(property="password_confirmation", type="string", example="newpassword123")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Password updated successfully"
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Validation error"
     *      )
     * )
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back();
    }
}
