<?php

namespace App\UseCase\User;

use App\UseCase\DataCommonFormatter;

interface UserUseCase
{
    public function getAllUser(): DataCommonFormatter;

    public function attempt(array $data);

    public function createUser(array $data);

    public function findByEmail(string $email);

    public function updateUserVerified($id, $dataUpdate);

    public function updateUserBlocked($id);

    public function updateUser($idUser, $data);

    public function updateOrInsertPasswordReset($email, $token);

    public function getPasswordResetByToken($token);

    public function getDetailUser($id);

    public function checkOldPassword($email, $password);
    public function updatePassword($email, $password);

    public function deletePasswordReset($token);
}
