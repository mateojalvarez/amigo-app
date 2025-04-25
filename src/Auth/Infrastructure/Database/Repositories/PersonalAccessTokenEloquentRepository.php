<?php

namespace Src\Auth\Infrastructure\Database\Repositories;

use Laravel\Sanctum\PersonalAccessToken;
use Log;
use Src\Auth\Domain\Repositories\PersonalAccessTokenRepository;
use Src\Auth\Domain\ValueObjects\Token;
use Src\Shared\Exceptions\DatabaseException;
use Throwable;

class PersonalAccessTokenEloquentRepository implements PersonalAccessTokenRepository
{
    /**
     * @throws DatabaseException
     */
    public function isVerified(Token $token): bool
    {
        try {

            $tokenModel = PersonalAccessToken::findToken($token->getPlainValue());

            if (! $tokenModel) {
                return false;
            }

            if (! $tokenModel->verified_at) {
                return false;
            }

            return true;

        } catch (Throwable $throwable) {
            Log::error($throwable->getMessage());

            throw new DatabaseException();
        }
    }

    /**
     * @throws DatabaseException
     */
    public function setAsVerified(Token $token): void
    {
        try {

            $tokenModel = PersonalAccessToken::findToken($token->getPlainValue());

            $tokenModel->verified_at = now();
            $tokenModel->save();

        } catch (Throwable $throwable) {
            Log::error($throwable->getMessage());

            throw new DatabaseException();
        }
    }
}
