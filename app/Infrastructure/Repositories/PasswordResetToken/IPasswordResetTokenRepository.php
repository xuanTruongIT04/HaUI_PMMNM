<?php

namespace App\Infrastructure\Repositories\PasswordResetToken;

interface IPasswordResetTokenRepository
{
    public function updateOrInsertPasswordReset($email, $token);

    public function getPasswordResetByToken($token);

    public function deletePasswordReset($token);
}
