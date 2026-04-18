<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $validated = $request->validated();

        foreach (['name', 'username'] as $optionalField) {
            if (!array_key_exists($optionalField, $validated)) {
                continue;
            }

            if ($validated[$optionalField] === null || $validated[$optionalField] === '') {
                unset($validated[$optionalField]);
            }
        }

        if ($request->hasFile('avatar_image')) {
            $file = $request->file('avatar_image');
            $fileName = 'avatar_' . $user->getKey() . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $fileName);
            $validated['avatar_image'] = $fileName;
        }

        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        $user->fill($validated);

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
