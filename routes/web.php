<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

Route::view('/', 'welcome');


Route::get('/test-mail', function () {
    Mail::raw('Test Mail from Journal App', function ($message) {
        $message->to('user@example.com')->subject('Test Mail');
    });
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/profile', function () {
        return view('profile');
    })->name('profile');
});

Route::get('/auth/{provider}/redirect', function ($provider) {
    return Socialite::driver($provider)->redirect();
})->name('socialite.redirect');


Route::get('/auth/{provider}/callback', function ($provider) {
    try {
        $socialUser = Socialite::driver($provider)->user();
        
        // Handle missing email
        if (!$socialUser->getEmail()) {
            return redirect('/login')->withErrors([
                $provider => "No email returned from $provider provider"
            ]);
        }

        $user = User::updateOrCreate(
            [
                'email' => $socialUser->getEmail(),
            ],
            [
                'name' => $socialUser->getName() ?? $socialUser->getNickname(),
                $provider.'_id' => $socialUser->getId(),
                'password' => bcrypt(Str::random(16)), // Random password for social users
            ]
        );

        // Auto-verify social emails
        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }

        Auth::login($user, true);
        return redirect('/dashboard');
        
    } catch (\Exception $e) {
        Log::error("Socialite error: ".$e->getMessage());
        return redirect('/login')->withErrors([
            $provider => "Failed to authenticate with $provider"
        ]);
    }
})->name('socialite.callback');


require __DIR__.'/auth.php';
