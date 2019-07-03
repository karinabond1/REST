<?php

include_once ('Sql.php');
include_once ('Server.php');

class Shop extends Server
{
    private $sql;

    public function __construct()
    {
        $this->sql = new Sql();
    }

    public function getCars()
    {
        $cars = $this->sql->getCars();
        if($cars){
            return $this->response($cars, 200);
        }
        return $this->response('Data not found', 404);
    }

    public function getCar($id)
    {
        $carInfo = $this->sql->getCar($id);
        if($carInfo){
            return $this->response($carInfo, 200);
        }
        return $this->response('Data not found', 404);
    }

    public function getSearchResult($arr)
    {
        $info = $this->sql->getSearchResult($arr[0],$arr[1],$arr[2],$arr[3],$arr[4],$arr[5],$arr[6],$arr[7]);
        if($info){
            return $this->response($info, 200);
        }
        return $this->response('Data not found', 404);
    }

    public function postBuy()
    {
        $postBuy = $this->sql->postBuy($_REQUEST['user_id'],$_REQUEST['payment']);
        if($postBuy){
            return $this->response($postBuy, 200);
        }
        return $this->response('Data not found', 404);
    }
}