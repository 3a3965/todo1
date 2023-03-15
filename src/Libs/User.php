<?php

namespace Psixoz\Todo\Libs;

class User
{
    private $user;
    public function __construct($user){
        $this->user = $user ? : [];
    }
    public function __get($name){
        if (array_key_exists($name, $this->user)) {
            return $this->user[$name];
        }else{
            return null;
        }
    }
}