<?php

namespace App\Validation\Rules;

use Rakit\Validation\Rule;

use App\Models\User;

class EmailAvailable extends Rule
{
    protected $message = "Email address ':value' is already taken";

    public function check($value): bool
    {
        $user_model = new User;
        return !$user_model->get('email', $value);
    }
}
