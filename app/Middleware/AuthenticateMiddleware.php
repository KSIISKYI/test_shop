<?php

namespace App\Middleware;

use App\Core\{Middleware, Request};
use App\Models\User;

class AuthenticateMiddleware extends Middleware
{
    function handle(Request $request)
    {
        $user_model = new User;

        if (!isset($_SESSION['user_id']) || !$user = $user_model->get('id', $_SESSION['user_id'])) {
            return $this->raise_httm_error(401, 'Not Unauthorized');
        }

        $request->user = $user;
        
        return $request;   
    }
}
