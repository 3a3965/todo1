<?php

namespace Psixoz\Todo\Libs;

class Controller
{
    public $post = array();
    public $get = array();
    public $session = array();
    public $data = array();
    public $user;

    public function __construct(){
        $this->post = $_POST;
        $this->get = $_GET;
        $this->session = $_SESSION;
        $this->user = \Psixoz\Todo\Models\UsersModel::getUser();
    }

    public function index(){

    }

    public function loadModel($model_name){
        $model_name = 'Psixoz\Todo\Models\\'.$model_name;

        $model_data = $this->prepareModelData();

        return new $model_name($model_data);
    }

    public function loadView($path){
        require 'src/Views/'.$path;
    }

    public static function redirect($path){
        header('Location: '.$path);
    }

    public function prepareModelData(){
        return [
            'post' => array_map(array($this, 'filterItem'), $this->post),
            'get' => array_map(array($this, 'filterItem'), $this->get),
            'session' => $this->session,
        ];
    }

    public function filterItem($item){
        if( is_array($item) ){
            return array_map(array($this, 'filterItem'), $item);
        }else {
            return htmlspecialchars(trim($item));
        }
    }

    public function setPageErrorOrSuccess($modelResult){
        if( $modelResult['error'] ){
            $this->setPageError($modelResult['error']);
        }else{
            $this->setPageSuccess($modelResult['success']);
        }
    }

    public function setPageError($text){
        $_SESSION['pageError'] = $text;
    }
    public function setPageSuccess($text){
        $_SESSION['pageSuccess'] = $text;
    }

    public function getPageError(){
        $error = $this->session['pageError'] ? : '';
        $this->setPageError(null);
        return $error;
    }

    public function getPageSuccess(){
        $success = $this->session['pageSuccess'] ? : '';
        $this->setPageSuccess(null);
        return $success;
    }

    public function makeSort($field){
        if( isset($this->get['order'][$field]) ){
            $asc_desc = $this->get['order'][$field] == 'asc' ? 'desc' : 'asc';
        }else{
            $asc_desc = 'asc';
        }
        return ['order' => [$field => $asc_desc]];
    }

    public function printUrl($params=null, $resetparams=null){
        $g = $this->get;

        if(is_array($resetparams)){
            foreach($resetparams as $rv){
                unset($g[$rv]);
            }
        }
        $get = $this->makeURL($params,$g);

        unset($get['url']);
        $get = http_build_query($get);
        $url=strtok($_SERVER["REQUEST_URI"],'?');
        return $get ? substr($url.'?'.$get,1) : substr($url,1);
    }

    public function makeUrl($params=null,$get=[]){
        if(is_array($params)){
            foreach($params as $k=>$v){
                if(is_array($v) && isset($get[$k]) ){
                    $get[$k] = $this->makeUrl($v,$get[$k]);
                }else{
                    $get[$k] = $v;

                    if($get[$k]=='')
                        unset($get[$k]);
                }
            }
        }
        return $get;
    }
}