<?php

namespace App\Services;

use App\Core\Request;
use App\Models\User;

class UserService
{
    public static function validateRegisterForm(array $data)
    {
        $validator = require __DIR__ . '/../Validation/validator.php';

        $validation = $validator->make($data, [
            'username' => 'required|min:6|max:15|alpha_dash',
            'email' => 'required|email|emailAvailable',
            'password' => 'required|min:8|alpha_dash',
            'confirm_password' => 'required|same:password'
        ]);

        $validation->validate();

        if ($validation->fails()) {
            return $validation->errors()->toArray();
        }
    }

    public static function createUser($data)
    {
        unset($data['confirm_password']);
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        $user_model = new User;
        $new_user = $user_model->create($data);

        return $new_user;
    }

    public static function validateLoginForm(array $data, $is_admin = 0)
    {
        $user_model = new User;
        $user_raw = $user_model->filter(['email' => $data['email'], 'is_admin' => $is_admin]);
        $res = [
            'user' => !empty($user_raw) ? $user_raw[0] : null,
            'error' => null
        ];
    
        if (!($res['user'] && password_verify($data['password'], $res['user']['password']))) {
            $res['error'] = 'Invalid email or password';
        }

        return $res;
    }

    public static function login($user)
    {
        $_SESSION['user_id'] = $user['id'];
    }

    public static function logout()
    {
        unset($_SESSION['user_id']);
    }

    static public function getUsers()
    {
        $user_model = new User;

        return $user_model->filter();
    }

    static public function removeUser(Request $request)
    {
        $user_model = new User;
        $user_model->delete('id', $request->matches['user_id']);
    }
}