<?php
include ('Shop.php');
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
        list($s, $u, $r, $ser, $a, $class, $meth, $view) = explode('/', $this->url, 8);
        switch($this->method)
        {
            case 'GET':
                $this->setMethod(ucfirst($class),'get'.ucfirst($meth), $view);
                break;
            case 'DELETE':
                $this->setMethod(ucfirst($class),'delete'.ucfirst($meth).'()', $view);
                break;
            case 'POST':
                $this->setMethod(ucfirst($class),'post'.ucfirst($meth).'()', $view);
                break;
            case 'PUT':
                $this->setMethod(ucfirst($class),'put'.ucfirst($meth).'()', $view);
                break;
            default:
                return false;
        }
    }

    private function setMethod($class, $method, $view=false)
    {
        $obj = new $class();
        if (method_exists($obj, $method))
        {
            $carsRes = call_user_func([$obj, $method], $view);
            $this->viewer->view($carsRes, $view);            
        }
    }    
}