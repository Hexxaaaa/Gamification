<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Activitylog\Models\Activity;

class SocialAuthController extends Controller
{
    /**
     * Redirect the user to the social provider authentication page.
     *
     * @param string $provider
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToProvider($provider)
    {
        // Validate that the provider is supported
        if (!in_array($provider, ['google'])) { // Add other providers as needed
            abort(404);
        }

        return response()->redirectTo(Socialite::driver($provider)->redirect()->getTargetUrl());
    }

    /**
     * Obtain the user information from the social provider.
     *
     * @param string $provider
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleProviderCallback($provider)
    {
        try {
            // Retrieve user information from the provider
            $socialUser = Socialite::driver($provider)->stateless()->user();
        } catch (\Exception $e) {
            // Log the exception
            activity()
                ->withProperties(['error' => $e->getMessage()])
                ->log('Social Authentication Failed');

            return redirect()->route('login')->with('error', 'Authentication failed.');
        }

        // Find or create the user
        $user = User::where('email', $socialUser->getEmail())->first();

        if (!$user) {
            // Create a new user if not found
            $user = User::create([
                'name' => $socialUser->getName() ?? $socialUser->getNickname(),
                'email' => $socialUser->getEmail(),
                'password' => Hash::make(Str::random(24)), // Generate a random password
                'is_admin' => false,
                'active' => true,
                // Add other fields as necessary
            ]);

            // Log user registration via socialite
            activity()
                ->causedBy($user)
                ->withProperties(['provider' => $provider, 'provider_id' => $socialUser->getId()])
                ->log('User Registered via Socialite');
        }

        // Log the user in
        Auth::login($user, true);

        // Log successful social authentication
        activity()
            ->causedBy($user)
            ->withProperties(['provider' => $provider, 'provider_id' => $socialUser->getId()])
            ->log('User Logged In via Socialite');

        // Redirect to intended page or dashboard
        return redirect()->intended(route('user.dashboard'))
                         ->with('success', 'Login successful via ' . ucfirst($provider) . '!');
    }
}