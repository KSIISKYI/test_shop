<?php

namespace App\Middleware;

use App\Core\{Middleware, Request};
use App\Models\User;

class GuestMiddleware extends Middleware
{
    function handle(Request $request)
    {
        $user_model = new User;
        
        if (isset($_SESSION['user_id']) && $user_model->get('id', $_SESSION['user_id'])) {
            redirect(route(['name' => 'home']));
        }

        return $request;
    }
}
