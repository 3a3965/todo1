<?php

namespace Psixoz\Todo\Models;

use Psixoz\Todo\Libs\Model;

class TodoModel extends Model
{
    protected $limit = 3;
    protected $sorting = ['name', 'email', 'status'];

    public function add(){
        if( $this->post['name'] && $this->post['email'] && $this->post['task'] ){
            if (!filter_var($this->post['email'], FILTER_VALIDATE_EMAIL)) {
                return $this->modelError("Неверный формат E-mail");
            }
            if(!$this->db_query("INSERT INTO 
                             todo(`name`,`email`,`task`) 
                             VALUES(?,?,?)",
                             [
                                 $this->post['name'],
                                 $this->post['email'],
                                 $this->post['task']
                             ])){
                return $this->modelError("Ошибка добавления задачи");
            }
        }else{
            return $this->modelError("Не заполнено одно из полей");
        }

        return $this->modelSuccess("Задача добавлена");

    }



    public function update($id){
        if(!$this->db_query("UPDATE `todo` SET
                             `status` = ?,
                             `task` = ?,
                             `adminEdited` = ?
                             WHERE
                             `id` = ?
                             ",
            [
                $this->post['status'],
                $this->post['task'],
                $this->post['adminEdited'],
                $id
            ])){
            return $this->modelError("Ошибка редактирования задачи");
        }
    }
}