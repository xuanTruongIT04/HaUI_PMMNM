<?php

namespace App\UseCase\User;

use App\Infrastructure\Repositories\PasswordResetToken\IPasswordResetTokenRepository;
use App\Infrastructure\Repositories\User\IUserRepository;
use App\Models\Status;
use App\UseCase\DataCommonFormatter;

class UserService implements UserUseCase
{
    private $userRepo;

    private $passwordResetTokenRepo;

    public function __construct(IUserRepository $userRepo, IPasswordResetTokenRepository $passwordResetTokenRepo)
    {
        $this->userRepo = $userRepo;
        $this->passwordResetTokenRepo = $passwordResetTokenRepo;
    }

    public function getAllUser(): DataCommonFormatter
    {
        return $this->userRepo->getAllUser();
    }

    public function attempt(array $data)
    {
        return $this->userRepo->attempt($data);
    }

    public function createUser(array $data)
    {
        $data['status_id'] = Status::STATUS_INACTIVE;

        return $this->userRepo->createUser($data);
    }

    public function findByEmail(string $email)
    {
        return $this->userRepo->findByEmail($email);
    }

    public function updateUserVerified($id, $dataUpdate)
    {
        $dataUpdate['status_id'] = Status::STATUS_ACTIVE;

        return $this->userRepo->updateUser($id, $dataUpdate);
    }

    public function updateUserBlocked($id)
    {
        $dataUpdate['status_id'] = Status::STATUS_INACTIVE;

        return $this->userRepo->updateUser($id, $dataUpdate);
    }

    public function updateUser($idUser, $data)
    {
        return $this->userRepo->updateUser($idUser, $data);
    }

    public function updateOrInsertPasswordReset($email, $token)
    {
        return $this->passwordResetTokenRepo->updateOrInsertPasswordReset($email, $token);
    }

    public function getPasswordResetByToken($token)
    {
        return $this->passwordResetTokenRepo->getPasswordResetByToken($token);
    }

    public function getDetailUser($id)
    {
        return $this->userRepo->getDetailUser($id);
    }

    public function updatePassword($email, $password)
    {
        return $this->userRepo->updatePassword($email, $password);
    }

    public function checkOldPassword($email, $oldPassword)
    {
        $user = $this->userRepo->checkOldPassword($email, $oldPassword);

        if ($user) {
            return true;
        }
        return false;
    }

    public function deletePasswordReset($token)
    {
        return $this->passwordResetTokenRepo->deletePasswordReset($token);
    }
}
