<?php

namespace Src\Auth\Infrastructure\Database\Repositories;

use App\Models\User;
use Laravel\Sanctum\PersonalAccessToken;
use Log;
use Src\Auth\Domain\Exceptions\InvalidCredentialsException;
use Src\Auth\Domain\Exceptions\InvalidRefreshTokenException;
use Src\Auth\Domain\Repositories\UserRepository;
use Src\Auth\Domain\ValueObjects\AccessToken;
use Src\Auth\Domain\ValueObjects\Auth;
use Src\Auth\Domain\ValueObjects\Credentials;
use Src\Auth\Domain\ValueObjects\RefreshToken;
use Src\Auth\Domain\ValueObjects\User as AuthUser;
use Src\Shared\Exceptions\DatabaseException;
use Str;
use Throwable;

class UserEloquentRepository implements UserRepository
{
    /**
     * @throws DatabaseException
     */
    public function login(Credentials $credentials): Auth
    {
        try {

            $user = User::whereEmail($credentials->getEmail())->select('password', 'id')->first();

            if (! $user || ! password_verify($credentials->getPassword(), $user->password)) {
                throw new InvalidCredentialsException();
            }

            return $this->generateAuth($user);

        } catch (Throwable $th) {

            if ($th instanceof InvalidCredentialsException) {
                throw $th;
            }

            Log::error($th->getMessage());

            throw new DatabaseException();
        }
    }

    /**
     * @throws InvalidRefreshTokenException
     * @throws DatabaseException
     */
    public function refreshToken(RefreshToken $refreshToken): Auth
    {
        try {
            $token = PersonalAccessToken::where('token', $refreshToken->value())
                ->where('name', 'refresh_token')
                ->with('tokenable')
                ->first();

            if (! $token) {
                throw new InvalidRefreshTokenException();
            }
            $user = $token->tokenable;

            return $this->generateAuth($user);
        } catch (Throwable $th) {

            if ($th instanceof InvalidRefreshTokenException) {
                throw $th;
            }

            Log::error($th->getMessage());

            throw new DatabaseException();
        }
    }

    /**
     * @throws DatabaseException
     */
    public function logout(AuthUser $user): void
    {
        try {
            $user = User::find($user->getId());

            $user->tokens()->delete();

            $user->refreshToken()->delete();
        } catch (Throwable $throwable) {
            Log::error($throwable->getMessage());

            throw new DatabaseException();
        }
    }

    private function generateAuth(User $user): Auth
    {
        $expiresAt = now()->addDay();
        $token     = $user->createToken('auth_token', ['*'], $expiresAt);

        return new Auth(
            new AccessToken(
                $token->plainTextToken,
                $expiresAt
            ),
            $this->generateRefreshToken($user),
            new AuthUser($user->id)
        );
    }

    private function generateRefreshToken(User $user): RefreshToken
    {
        $refreshToken = Str::random(60);

        $user->refreshToken()->delete();

        $user->refreshToken()->create([
            'name'      => 'refresh_token',
            'token'     => $refreshToken,
            'abilities' => ['*'],
        ]);

        return new RefreshToken($refreshToken);
    }
}
