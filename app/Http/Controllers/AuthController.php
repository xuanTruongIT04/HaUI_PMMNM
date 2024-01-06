<?php

namespace App\Http\Controllers;

use App\Http\Jobs\SendResetPasswordJob;
use App\Http\Jobs\VerificationAccountJob;
use App\Http\Presenter\Response as PresenterResponse;
use App\Http\Requests\Auth\BlockUserRequest;
use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Http\Requests\Auth\CreateUserRequest;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Auth\UpdateUserRequest;
use App\Http\Requests\Auth\VerificationRequest;
use App\UseCase\User\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function login(LoginRequest $request)
    {
        try {
            $token = $this->userService->attempt($request->validated());
            if (! $token) {
                return PresenterResponse::responseError(Response::$statusTexts[Response::HTTP_UNAUTHORIZED], Response::HTTP_UNAUTHORIZED);
            }

            return $this->respondWithToken($token);
        } catch (\Exception $ex) {
            return PresenterResponse::responseError($ex->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function createUser(CreateUserRequest $request)
    {
        try {
            $data = $this->userService->createUser($request->except('password_confirmation'));

            return PresenterResponse::BaseResponse(
                Response::HTTP_OK,
                'Create user successfully',
                $data
            );
        } catch (\Exception $ex) {
            return PresenterResponse::responseError($ex->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function me()
    {
        $data = auth()->user();
        if ($data) {
            return PresenterResponse::BaseResponse(
                Response::HTTP_OK,
                'Get information user successfully',
                $data
            );
        } else {
            return PresenterResponse::responseError('Retrieving information failed because you are not logged in!', Response::HTTP_UNAUTHORIZED);
        }
    }

    public function logout()
    {
        try {
            auth()->logout();

            return PresenterResponse::responseDoesNotData(
                Response::HTTP_OK,
                'Successfully logged out'
            );
        } catch (\Exception $ex) {
            return PresenterResponse::responseError($ex->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        try {
            $email = $request->input('email');
            $token = Str::random(60);
            $this->userService->updateOrInsertPasswordReset($email, $token);
            $resetUrl = env('APP_FRONT_URL').'auth/reset-password/'.$token;
            dispatch(new SendResetPasswordJob($email, $resetUrl));

            return PresenterResponse::responseDoesNotData(
                Response::HTTP_OK,
                'Password reset email has been sent to your email, please check within 30 minutes to change your password'
            );
        } catch (\Exception $ex) {
            return PresenterResponse::responseError($ex->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        DB::beginTransaction();
        try {
            $password = $request->input('password');
            $token = $request->token;
            $passwordResetRecord = $this->userService->getPasswordResetByToken($token);

            if (! $passwordResetRecord) {
                return PresenterResponse::responseDoesNotData(Response::HTTP_NOT_FOUND, 'Invalid token, please try it again');
            }

            //Update password
            $passwordHashed = Hash::make($password);

            $this->userService->updatePassword($passwordResetRecord->email, $passwordHashed);

            //Delete password reset with old token
            $this->userService->deletePasswordReset($token);

            DB::commit();

            return PresenterResponse::responseDoesNotData(
                Response::HTTP_OK,
                'Password reset successfully'
            );
        } catch (\Exception $ex) {
            DB::rollback();

            return PresenterResponse::responseError($ex->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function verificationSend(VerificationRequest $request)
    {
        try {
            $email = $request->input('email');

            $user = $this->userService->findByEmail($email);

            if (! $user) {
                return PresenterResponse::responseDoesNotData(Response::HTTP_NOT_FOUND, 'User not found');
            }

            $token = Str::random(60);

            $this->userService->updateOrInsertPasswordReset($email, $token);

            if ($user) {
                $userId = $user->id;
            }

            $resetUrl = env('APP_FRONT_URL').'verify-account/'.$userId.'/'.$token;

            dispatch(new VerificationAccountJob($email, $resetUrl));

            return PresenterResponse::responseDoesNotData(
                Response::HTTP_OK,
                'Link verification account has been sent to your email, please check within 30 minutes to verification'
            );
        } catch (\Exception $ex) {
            return PresenterResponse::responseError($ex->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function verificationGet(Request $request)
    {
        $userId = $request->idUser;

        $dataUpdate = [
            'email_verified_at' => now(),
        ];

        $statusVerify = $this->userService->updateUserVerified($userId, $dataUpdate);

        return PresenterResponse::BaseResponse(
            Response::HTTP_OK,
            'Password reset successfully',
            $statusVerify
        );
    }

    public function getDetailUser($idUser)
    {
        try {
            $data = $this->userService->getDetailUser($idUser);

            return PresenterResponse::BaseResponse(
                Response::HTTP_OK,
                'Get information user successfully',
                $data
            );
        } catch (\Exception $ex) {
            return PresenterResponse::responseError($ex->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateUser($idUser, UpdateUserRequest $request)
    {
        try {
            $data = $request->validated();

            $result = $this->userService->updateUser($idUser, $data);

            if ($result) {
                $dataUser = $this->userService->getDetailUser($idUser);

                return PresenterResponse::BaseResponse(
                    Response::HTTP_OK,
                    'Updated information user successfully',
                    $dataUser
                );
            } else {
                return PresenterResponse::responseDoesNotData(Response::HTTP_UNPROCESSABLE_ENTITY, 'Updated information user failed, please try it again!');
            }
        } catch (\Exception $ex) {
            return PresenterResponse::responseError($ex->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function blockUser(BlockUserRequest $request)
    {
        try {
            $userId = $request->input('id');

            $statusBlocked = $this->userService->updateUserBlocked($userId);

            return PresenterResponse::BaseResponse(
                Response::HTTP_OK,
                'Blocked user successfully',
                $statusBlocked
            );
        } catch (\Exception $ex) {
            return PresenterResponse::responseError($ex->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        try {
            $oldPassword = $request->input('old_password');
            $email = $request->input('email');

            $isCheckPassword = $this->userService->checkOldPassword($email, $oldPassword);
            if($isCheckPassword) {
                $password = $request->input('password');
                $passwordHashed = Hash::make($password);
                $isCheckUpdated = $this->userService->updatePassword($email, $passwordHashed);
                if($isCheckUpdated) {
                    return PresenterResponse::responseDoesNotData(
                        Response::HTTP_OK,
                        'Change password successfully'
                    );
                } else {
                    return PresenterResponse::responseDoesNotData(Response::HTTP_FORBIDDEN, "Change password fail because old password is incorrect");
                }

            } else {
                return PresenterResponse::responseDoesNotData(Response::HTTP_FORBIDDEN, "Change password fail because old password is incorrect");
            }

        } catch (\Exception $ex) {
            return PresenterResponse::responseError($ex->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    protected function respondWithToken($token)
    {
        return PresenterResponse::BaseResponse(
            Response::HTTP_OK,
            'Login successfully',
            [
                'token' => [
                    'accessToken' => $token,
                    'tokenType' => 'bearer',
                    'expiresIn' => auth()->factory()->getTTL() * 60,
                ],
                'user' => auth()->user(),
            ]
        );
    }
}
