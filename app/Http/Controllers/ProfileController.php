<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function updateTTD()
    {
        request()->validate([
            "ttd" => 'required|file|image|max:2024'
        ]);
        $user = auth()->user();
        if (request()->hasFile('ttd')) {
            // Menghapus gambar lama jika ada
            if ($user->ttd) {
                $oldImagePath = storage_path('app/private/' . $user->ttd);
                if (file_exists($oldImagePath) && $user->ttd != "default-2.png") {
                    unlink($oldImagePath); // Menghapus file gambar lama
                }
            }

            // Menyimpan gambar yang baru
            $file = request()->file('ttd');
            $randomName = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('ttd', $randomName, ['disk' => 'private']);
            $user->ttd = "ttd/" . $randomName;
        }
        $user->save();
        // dd($user);
        return Redirect::route('profile.edit')->with('status', 'ttd-updated');

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
