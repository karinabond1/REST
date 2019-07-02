<?php
include ('Shop.php');
include ('User.php');
include ('Viewer.php');
include ('../../config.php');

class Server
{
    private $server;
    private $method;
    private $url;
    private $viewer;

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->url = $_SERVER['REQUEST_URI'];
        $this->viewer = new Viewer();
    }

    public function methodChoose()
    {
        list($s, $u, $r, $ser, $a, $class, $meth, $par) = explode('/', $this->url, 8);
        //echo $meth."!!!".$par."!!!";
        switch($this->method)
        {
            case 'GET':
                $this->setMethod(ucfirst($class),'get'.ucfirst($meth), $par);
                break;
            case 'DELETE':
                $this->setMethod(ucfirst($class),'delete'.ucfirst($meth).'()', $par);
                break;
            case 'POST':
                $this->setMethod(ucfirst($class),'post'.ucfirst($meth).'()', $par);
                break;
            case 'PUT':
                $this->setMethod(ucfirst($class),'put'.ucfirst($meth).'()', $par);
                break;
            default:
                return false;
        }
    }

    private function setMethod($class, $method, $par=false)
    {
        //$_POST['name'];
        $obj = new $class;
        if (method_exists($obj, $method))
        {
            //echo $par;
            if(stristr($par, '.')){
                $arr = explode('/', $par);
                $carsRes = call_user_func([$obj, $method], $arr[0]);
            $this->viewer->view($carsRes, $arr[1]);
            }elseif(stristr($par, '/') && !stristr($par, '.')){
                $arr = explode('/', $par);
                //echo $par;
                $carsRes = call_user_func([$obj, $method], $arr[0],$arr[1],$arr[2],$arr[3],$arr[4],$arr[5],$arr[6],$arr[7]);
                $this->viewer->view($carsRes, ''); 
            }else{
                $carsRes = call_user_func([$obj, $method], $par);
                $this->viewer->view($carsRes, $par);
            }
                       
        }
    }    
}