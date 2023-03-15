<?php

namespace Psixoz\Todo\Middleware;

use Psixoz\Todo\Libs\Controller;
use Psixoz\Todo\Models\UsersModel;

class AuthMiddleware
{
    public static function isAdmin(){
        $user = UsersModel::getUser();
        if( !$user->isAdmin ){
            Controller::redirect('/auth/');
            exit();
        }
    }
}