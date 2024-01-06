<?php

namespace App\Infrastructure\Repositories\User;

use App\UseCase\DataCommonFormatter;

interface IUserRepository
{
    public function getAllUser(): DataCommonFormatter;

    public function attempt(array $data);

    public function createUser(array $data);

    public function findByEmail(string $email);

    public function getDetailUser($id);

    public function updateUser($id, $dataUpdate);

    public function updatePassword($email, $password);
    public function checkOldPassword($email, $oldPassword);
    public function findById(int $id): DataCommonFormatter;
}
