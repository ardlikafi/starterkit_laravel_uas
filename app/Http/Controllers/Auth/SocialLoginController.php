<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();
            
            $user = User::where("{$provider}_id", $socialUser->id)
                ->orWhere('email', $socialUser->email)
                ->first();

            if (!$user) {
                $user = User::create([
                    'name' => $socialUser->name,
                    'email' => $socialUser->email,
                    'password' => bcrypt(str_random(16)),
                    "{$provider}_id" => $socialUser->id,
                    'avatar' => $socialUser->avatar,
                    'role' => 'wartawan',
                ]);
            } else {
                $user->update([
                    "{$provider}_id" => $socialUser->id,
                    'avatar' => $socialUser->avatar,
                ]);
            }

            Auth::login($user);

            return redirect()->intended('/dashboard');
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Social login failed. Please try again.');
        }
    }
} 