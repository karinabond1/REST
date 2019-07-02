<?php

include_once ('Sql.php');

class User
{
    private $sql;

    public function __construct()
    {
        $this->sql = new Sql();
    }

    /*public function getCars()
    {
        $cars = $this->sql->getCars();
        if($cars){
            return $cars;
        }else{
            //echo "gg";
            //return "There is some problem with cars. Please, try again later!";
            return header("Location: ../errors.php");
        }
    }

    public function getCar($id)
    {
        $carInfo = $this->sql->getCar($id);
        if($carInfo){
            return $carInfo;
        }else{
            return "There is some problem with car. Please, try again later!";            
        }
    }

    public function getSearchResult($brand, $model, $year, $engine, $speed, $color, $priceFrom, $priceTo)
    {
        $info = $this->sql->getSearchResult($brand, $model, $year, $engine, $speed, $color, $priceFrom, $priceTo);
        if($info){
            return $info;
        }else{
            return "There is some problem with search result. Please, try again later!";
        }
    }*/

    public function postUser()
    {
        $postUser = $this->sql->postUser($_REQUEST['name'],$_REQUEST['surname'],$_REQUEST['email'],$_REQUEST['password']);
        if($postUser){
            return $postUser;
        }else{
            return "There is some problem with buying proccess. Please, try again later!";
        }
    }
}