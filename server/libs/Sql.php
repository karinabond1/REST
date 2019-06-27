<?php

class Sql
{
    private $mysql;

    public function __construct()
    {
        $this->mysql = new PDO("mysql:host=" . HOST . ";port=" . PORT . ";dbname=" . DATABASE, USER_NAME, USER_PASS);
        $this->mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getCars()
    {
        $cars = array();

        try {            

            $selectCars = $this->mysql->prepare("SELECT autoshop_cars.id,autoshop_cars.model, autoshop_brand.brand FROM autoshop_cars inner join autoshop_brand on autoshop_cars.brand_id=autoshop_brand.id;");
            $selectCars->execute();

            $indexCars = 0;
            while ($row = $selectCars->fetch(PDO::FETCH_ASSOC)) {
                $cars[$indexCars] = $row;
                $indexCars++;
            }

        }catch (PDOException $e) {
            echo $str = 'Error:+ ' . $e->getMessage();
        }
        return $cars;
        //return false;
    }

    public function getCar($id)
    {
        $cars = array();
        try {

            $selectCarinfo = $this->mysql->prepare("SELECT  autoshop_cars.id,autoshop_brand.brand,autoshop_cars.model, autoshop_cars.year_issue, autoshop_cars.engin_capacity, autoshop_cars.max_speed, autoshop_cars.price FROM autoshop_cars inner join autoshop_brand on autoshop_cars.brand_id=autoshop_brand.id WHERE autoshop_cars.id = " . $id);
            $selectCarinfo->execute();
            $indexCar = 0;
            while ($row = $selectCarinfo->fetch(PDO::FETCH_ASSOC)) {
                $cars[$indexCar] = $row;
                $indexCar++;
            }
            $selectColor = $this->mysql->prepare("SELECT autoshop_color.color FROM autoshop_color INNER JOIN autoshop_car_color ON autoshop_color.id=autoshop_car_color.color_id WHERE autoshop_car_color.car_id = " . $id . ";");
            $selectColor->execute();
            while ($row = $selectColor->fetch(PDO::FETCH_ASSOC)) {
                $cars[$indexCar] = $row;
                $indexCar++;
            }

        } catch (PDOException $e) {
            echo $str = 'Error:+ ' . $e->getMessage();
        }
        return $cars;
    }

    public function getSearchResult($brand, $model, $year, $engine, $speed, $color, $priceFrom, $priceTo)
    {
        $cars = array();
        $result = array();
        //var_dump($obj);
        echo "<br><br>";
        $sql = "SELECT autoshop_cars.id,autoshop_cars.model, autoshop_brand.brand FROM autoshop_cars inner join autoshop_brand on autoshop_cars.brand_id=autoshop_brand.id WHERE autoshop_cars.year_issue=?";
        $par[] = $year;
        if ($brand != '') {
            $sql .= " AND autoshop_brand.brand=?";
            $par[] = $brand;
        }
        if ($model != '') {
            $sql .= " AND autoshop_cars.model=?";
            $par[] = $model;
        }
        if ($year != 0) {
            $sql .= " AND autoshop_cars.year_issue=?";
            $par[] = $year;
        }
        if ($engine != 0) {
            $sql .= " AND autoshop_cars.engin_capacity=?";
            $par[] = $engine;
        }
        if ($speed != 0) {
            $sql .= " AND autoshop_cars.max_speed=?";
            $par[] = $speed;
        }
        if ($priceFrom != 0) {
            $sql .= " AND autoshop_cars.price>=?";
            $par[] = $priceFrom;
        }
        if ($priceTo != 0) {
            $sql .= " AND autoshop_cars.price<=?";
            $par[] = $priceTo;
        }
        $selectCars = $this->mysql->prepare($sql);
        $selectCars->execute($par);
        $indexCar = 0;
        while ($row = $selectCars->fetch(PDO::FETCH_ASSOC)) {
            $cars[$indexCar] = $row;
            $indexCar++;
        }
        $carsId = array();
        if ($color != '') {
            $selectColor = $this->mysql->prepare("SELECT autoshop_car_color.car_id FROM autoshop_car_color INNER JOIN autoshop_color ON autoshop_car_color.color_id=autoshop_color.id WHERE autoshop_color.color = ?");
            $parC[] = $color;
            $selectColor->execute($parC);
            $indexColor = 0;
            while ($row = $selectColor->fetch(PDO::FETCH_ASSOC)) {
                $carsId[$indexColor] = $row["car_id"];
                $indexColor++;
            }

            foreach ($carsId as $carCol) {
                foreach ($cars as $car) {
                    if ($car["id"] === $carCol) {
                        array_push($result, $car);
                    }
                }
            }
            return $result;
        } else {
            return $cars;
        }
    }

    public function postBuy($car_id, $name, $surname, $payment)
    {
        $res = array();
        $sendCarInfo = $this->mysql->prepare("INSERT INTO autoshop_client_order (car_id,name,surname,payment) VALUES(?,?,?,?);");
        $par[] = $car_id;
        $par[] = $name;
        $par[] = $surname;
        $par[] = $payment;
        $res = $sendCarInfo->execute($par);
        if ($res) {
            return 'yes';
        } else {
            return 'no';
        }
    } 
}