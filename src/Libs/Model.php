<?php

namespace Psixoz\Todo\Libs;

use PDO;

class Model
{
    public $post;
    public $get;
    public $session;
    protected $db;
    protected $sorting = [];
    protected $limit = 0;
    protected $table = '';

    public function __construct($config){
        $this->post = $config['post'];
        $this->get = $config['get'];
        $this->session = $config['session'];
        $this->table = strtolower(str_replace('Model','',(new \ReflectionClass($this))->getShortName()));

        $this->setDbConnection();
    }

    public function setDbConnection(){
        $dbType = 'mysql';
        $dbHost = 'localhost';
        $dbName = 'c14622_test1_winklers_ru_test1';
        $dbUser = 'c14622_test1_winklers_ru';
        $dbPass = 'KiFcePubrecid72';

        try {
            $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING);
            $this->db = new PDO($dbType . ':host=' . $dbHost . ';dbname=' . $dbName, $dbUser, $dbPass, $options);
            $this->db->exec("set names utf8");
        }catch (\Exception $e){
            echo 'no connection to db';
            exit();
        }
    }

    public function db_select($sql,$array=null,$one=null){
        $query = $this->db_query($sql,$array);
        if($one)
            return $query->fetch();
        else
            return $query->fetchAll();
    }

    public function db_query($sql,$array=null){
        $query = $this->db->prepare($sql);
        if($query->execute($array))
            return $query;
        else{
            return false;
        }
    }

    public function modelError($text){
        return array("error" => $text);
    }

    public function modelSuccess($text){
        return array("success" => $text);
    }

    public function getByid($id){
        return $this->db_select(" SELECT * FROM {$this->table} WHERE `id` = ?", [$id], true);
    }

    public function index(){

        $limit = $this->limit;
        $order = '';
        $table = $this->table;

        $page = isset($this->get['page']) ? $this->get['page'] : 0;
        if($page>1) $page-=1;

        $sql_limit = '';
        if($limit>0) {
            $start = $page * $limit;
            $sql_limit = " LIMIT $start,$limit ";
        }

        if(isset($this->get['order']) && is_array($this->get['order'])){
            $order_field = null;
            foreach ($this->sorting as $s){
                if( isset($this->get['order'][$s]) ) {
                    $asc_desc = $this->get['order'][$s] == 'asc' ? 'ASC' : 'DESC';
                    $order_field = $s;
                }
            }
            $order = $order_field ? " ORDER BY $order_field $asc_desc " : '';
        }

        $basic_sql = " SELECT * FROM $table ";

        $data = $this->db_select("
                                $basic_sql 
                                $order
                                $sql_limit
                                ");

        $total_sql = " SELECT COUNT(id) total FROM $table ";

        $total = $this->db_select("
                                $total_sql
                                ", [], true);

        return ['data' => $data, 'total'=>$total['total'], 'pagination' => array('current' => $page, 'total' => ceil($total['total']/$limit))];
    }
}