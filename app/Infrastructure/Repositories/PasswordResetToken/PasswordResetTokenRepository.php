<?php

namespace App\Infrastructure\Repositories\PasswordResetToken;

use App\Infrastructure\Repositories\EloquentRepository;
use App\Models\PasswordResetToken;

class PasswordResetTokenRepository extends EloquentRepository implements IPasswordResetTokenRepository
{
    public function getModel()
    {
        return PasswordResetToken::class;
    }

    public function updateOrInsertPasswordReset($email, $token)
    {
        return $this->_model->updateOrInsert(
            ['email' => $email],
            [
                'token' => $token,
                'created_at' => now(),
            ]
        );
    }

    public function getPasswordResetByToken($token)
    {
        return $this->_model::where('token', $token)->first();
    }

    public function deletePasswordReset($token)
    {
        return $this->_model::where('token', $token)->delete();
    }
}
