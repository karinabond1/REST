<?php
include ('Sql.php');
include ('../../config.php');

class Server
{
    private $sql;
    private $server;

    public function __construct()
    {
        $this->sql = new Sql();
    }

    public function method()
    {
        $url = $_SERVER['REQUEST_URI'];
        list($s, $a, $d, $db, $table, $path) = explode('/', $url, 6);

        switch($this->method)
        {
            case 'GET':
                $this->setMethod('get'.ucfirst($table), explode('/', $path));
                break;
            case 'DELETE':
                $this->setMethod('delete'.ucfirst($table), explode('/', $path));
                break;
            case 'POST':
                $this->setMethod('post'.ucfirst($table), explode('/', $path));
                break;
            case 'PUT':
                $this->setMethod('put'.ucfirst($table), explode('/', $path));
                break;
            default:
                return false;
        }
    }

    function setMethod($method, $param=false)
    {
        if ( method_exists($this, $method) )
        {
            call_user_func(......);
        }
    }

    public function cars()
    {
        $cars = $this->sql->getCars();
        if($cars){
            return $cars;
        }else{
            return "There is some problem with cars. Please, try again later!";
        }
    }

    public function car($id)
    {
        $carInfo = $this->sql->getCar($id);
        if($carInfo){
            return $carInfo;
        }else{
            return "There is some problem with car. Please, try again later!";
        }
    }

    public function searchResult($brand, $model, $year, $engine, $speed, $color, $priceFrom, $priceTo)
    {
        $info = $this->sql->getSearchResult($brand, $model, $year, $engine, $speed, $color, $priceFrom, $priceTo);
        if($info){
            return $info;
        }else{
            return "There is some problem with search result. Please, try again later!";
        }
    }

    public function buy($car_id, $name, $surname, $payment)
    {
        $buyInfo = $this->sql->postBuy($car_id, $name, $surname, $payment);
        if($buyInfo){
            return $buyInfo;
        }else{
            return "There is some problem with buying proccess. Please, try again later!";
        }
    }
}