<?php

namespace Tests\Helpers;

use App\Models\User;
use Laravel\Sanctum\PersonalAccessToken;

trait AuthHelper
{
    public function withAuthenticatedHeaders(?User $user = null)
    {
        if (! $user) {
            $user = User::factory()->create();
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        $tokenModel              = PersonalAccessToken::findToken($token);
        $tokenModel->verified_at = now();
        $tokenModel->save();

        return $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ]);
    }
}
