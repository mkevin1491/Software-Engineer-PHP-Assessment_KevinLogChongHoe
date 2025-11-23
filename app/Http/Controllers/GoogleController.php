<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();

            $finduser = User::where('google_id', $user->id)->first();

            if ($finduser) {
                Auth::login($finduser);
                return redirect()->intended('/');
            } else {
                // Logic to handle if user exists by email but not by google_id
                // prevent overwriting password if account exists
                $newUser = User::updateOrCreate(
                    ['email' => $user->email],
                    [
                        'name' => $user->name,
                        'google_id' => $user->id,
                        // Only set a dummy password if the user was actually created (wasRecentlyCreated)
                        'password' => Hash::make(str()->random(16)),
                        // Otherwise, keep their existing password.
                    ]
                );

                // If this is a brand new user, give them a random password
                if ($newUser->wasRecentlyCreated) {
                    $newUser->password = encrypt('123456dummy');
                    $newUser->save();
                }

                Auth::login($newUser);

                return redirect()->intended('/');
            }
        } catch (Exception $e) {
            // It's better to redirect to login with an error than throw a 500 error
            // dd('Error:', $e->getMessage());
            return redirect('/login')->with('error', 'Something went wrong with Google Login: ' . $e->getMessage());     
        }
    }
}
