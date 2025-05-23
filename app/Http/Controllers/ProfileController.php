<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;


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

        // Validation déjà faite via ProfileUpdateRequest
        $validated = $request->validated();

        // Ne pas modifier parent_code sauf si user est talib ou ab
        if (!in_array($user->type, ['ab', 'talib'])) {
            unset($validated['parent_code']);
        }

        $user->fill($validated);

        // Invalider email vérifié si il a changé
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
    public function uploadProfileImage(Request $request): RedirectResponse
{
    $request->validate([
        'image' => 'required|image|max:2048',
    ]);

    $user = $request->user();

    // حدف الصورة القديمة إلى كانت
    if ($user->profile_image) {
        Storage::disk('public')->delete($user->profile_image);
    }

    // تخزين الصورة
    $path = $request->file('image')->store('profile_images', 'public');

    // حفظ المسار في قاعدة البيانات
    $user->profile_image = $path;
    $user->save();

    return Redirect::back()->with('status', 'تم تحديث الصورة بنجاح.');
}

}
