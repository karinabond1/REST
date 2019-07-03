<?php
include_once ('Server.php');
include_once('Sql.php');

class User extends Server
{
    private $sql;

    public function __construct()
    {
        $this->sql = new Sql();
    }

    public function postUserInfo()
    {
        $userInfo = $this->sql->postUser($_REQUEST['name'],$_REQUEST['surname'],$_REQUEST['email'],$_REQUEST['password']);
        if($userInfo){
            return $this->response($userInfo, 200);
        }
        return $this->response('Data not found', 404);
    }

    public function getUserLog($arr)
    {
        $userLog = $this->sql->getUserLog($arr);
        if($userLog){
            return $this->response($userLog, 200);
        }
        return $this->response('Data not found', 404);
    }
}