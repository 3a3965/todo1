<?php

namespace Psixoz\Todo\Models;

use Psixoz\Todo\Libs\Model;
use Psixoz\Todo\Libs\User;

class UsersModel extends Model
{
    public function authorizeUser(){
        if($this->post['login'] && $this->post['password']){
            $user = $this->db_select("SELECT * FROM users 
                                       WHERE `login` = ?",
                                       [
                                           $this->post['login']
                                       ],
                                       true);

            if( $user['id'] && password_verify($this->post['password'], $user['password']) ){
                static::setUser($user);
            }else{
                return $this->modelError("Неверные логин или пароль");
            }
        }else{
            return $this->modelError("Не заполнен логин или пароль");
        }
    }

    public function unAuthorizeUser(){
        static::setUser(null);
    }

    public static function setUser($user){
        $_SESSION['user'] = $user;
    }

    public static function getUser(){
        return new User($_SESSION['user']);
    }

}