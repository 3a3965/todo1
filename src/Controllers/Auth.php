<?php

namespace Psixoz\Todo\Controllers;

use Psixoz\Todo\Libs\Controller;

class Auth extends Controller
{
    public function index(){
        $this->loadView('_templates/header.php');
        $this->loadView('Auth/index.php');
        $this->loadView('_templates/footer.php');
    }

    public function authorizeUser(){
        $model = $this->loadModel('UsersModel');
        $result = $model->authorizeUser();
        $this->setPageErrorOrSuccess($result);

        if( $result['error'] ){
            $this->redirect('/auth/');
        }else{
            $this->redirect('/');
        }

    }
    public function unAuthorizeUser(){
        $model = $this->loadModel('UsersModel');
        $model->unAuthorizeUser();

        $this->redirect('/');
    }
}