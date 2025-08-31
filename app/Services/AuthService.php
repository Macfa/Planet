<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Contracts\User as SocialiteUser;

class AuthService
{
    protected User $user;
    //
    public function __construct(User $user)
    {
        $this->user = $user;
    }
    public function handleUser(string $driver, SocialiteUser $socialiteUser)
    {
        // 유저 검증 
        $exist_user = $this->user->where('provider_id', $socialiteUser->getId())
            ->where('provider', $driver)
            ->first();

        if($exist_user)
        {
            // 기존 유저
            $exist_user->update([
                'updated_at' => now(),
            ]);
            Auth::login($exist_user);
        } else {
            // 신규 유저
            $new_user = $this->user->create([
                'name' => $socialiteUser->getName(),
                'email' => $socialiteUser->getEmail(),
                'provider_id' => $socialiteUser->getId(),
                'provider' => $driver,
                'avatar' => $socialiteUser->getAvatar(),
            ]);
            Auth::login($new_user);
            // return $new_user;
        }
    }
}