<?php

namespace App\Middleware;

use App\Core\{Middleware, Request};
use App\Models\User;

class IsAdminMiddleware extends Middleware
{
    function handle(Request $request)
    {
        if (!$request->user['is_admin']) {
            return $this->raise_httm_error(401, 'Not Unauthorized');
        }
        
        return $request;   
    }
}
