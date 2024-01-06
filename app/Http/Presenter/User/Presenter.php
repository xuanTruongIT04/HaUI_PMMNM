<?php

namespace App\Http\Presenter\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class Presenter
{
    public static function convertUserToPresenter(User $user)
    {
        return [
            'id' => $user->id,
            'fullname' => $user->name,
            'username' => $user->username,
            'email' => $user->email,
            'role' => $user->role,
        ];
    }

    public static function convertListUserToPresenter(Collection $listUser)
    {
        $dataConvert = $listUser->map(function ($data) {
            return [
                'id' => $data->id,
                'fullname' => $data->name,
                'username' => $data->username,
                'email' => $data->email,
                'role' => $data->role,
            ];
        });

        return $dataConvert;
    }
}
