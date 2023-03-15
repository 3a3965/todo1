<?php

namespace Psixoz\Todo\Controllers;

use Psixoz\Todo\Libs\Controller;
use Psixoz\Todo\Middleware\AuthMiddleware;

class Todo extends Controller
{
    public function index(){
        $model = $this->loadModel('TodoModel');
        $this->data = $model->index();

        $this->loadView('_templates/header.php');
        $this->loadView('Todo/index.php');
        $this->loadView('_templates/footer.php');
    }

    public function add(){
        $model = $this->loadModel('TodoModel');
        $this->setPageErrorOrSuccess($model->add());

        $this->redirect('/');
    }

    public function edit($id){
        AuthMiddleware::isAdmin();

        $model = $this->loadModel('TodoModel');
        $this->data = $model->getById($id);

        $this->loadView('_templates/header.php');
        $this->loadView('Todo/edit.php');
        $this->loadView('_templates/footer.php');
    }

    public function update($id){
        AuthMiddleware::isAdmin();

        $model = $this->loadModel('TodoModel');
        $result = $model->update($id);
        $this->setPageErrorOrSuccess($result);

        if( $result['error'] ){
            $this->redirect('/todo/edit/'.$id);
        }else{
            $this->redirect('/');
        }
    }
}