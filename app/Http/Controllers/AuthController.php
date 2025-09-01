<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Laravel\Socialite\Facades\Socialite;
use App\Services\AuthService;
use Illuminate\Support\Facades\Cache;

class AuthController extends Controller
{
    public function __construct()
    {
        
    }
    public function redirectToProvider($driver)
    {
        return Socialite::driver($driver)->redirect();
    }
    public function handleProviderCallback(AuthService $authService, $driver)
    {
        try {
            $socialiteUser = Socialite::driver($driver)->user();
            $authService->handleUser($driver, $socialiteUser);
            Cache::put('social_login', true, 604800);
            return Redirect::route('home');
        } catch (\Exception $e) {
            Log::error('Socialite authentication failed for driver ' . $driver . ': ' . $e->getMessage());
            return Redirect::route('login')->withErrors('Authentication failed, please try again.');
        }
    }
}
