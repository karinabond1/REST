<?php
include ('Cars.php');
include ('../../config.php');

class Server
{
    private $server;
    private $method;
    private $url;
    private $cars;

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->url = $_SERVER['REQUEST_URI'];
        $this->cars = new Cars();
    }

    public function methodChoose()
    {
        list($s, $u, $r, $ser, $a, $fol, $meth,$view) = explode('/', $this->url, 8);
        switch($this->method)
        {
            case 'GET':
                $this->setMethod('get'.ucfirst($meth), $view);
                break;
            case 'DELETE':
                $this->setMethod('delete'.ucfirst($meth).'()', $view);
                break;
            case 'POST':
                $this->setMethod('post'.ucfirst($meth).'()', $view);
                break;
            case 'PUT':
                $this->setMethod('put'.ucfirst($meth).'()', $view);
                break;
            default:
                return false;
        }
    }

    private function setMethod($method, $param=false)
    {
        if (method_exists($this->cars, $method))
        {
            $carsRes = call_user_func([$this->cars,$method], $param);
            if(!$param || $param=='.json'){
                $this->makeJson($carsRes);
            }elseif($param=='.txt'){
                $this->makeTxt($carsRes);
            }elseif($param=='.xml'){
                $this->makeXml($carsRes);
            }elseif($param=='.html'){
                $this->makeHtml($carsRes);
            }
        }
    }

    private function makeJson($arr)
    {
        echo json_encode($arr);
    }

    private function makeTxt($arr)
    {
        print_r($arr);
    }

    private function makeXml($arr)
    {
        $data = array('total_stud' => 500);
        $xmlData = new SimpleXMLElement('<?xml version="1.0"?><car></car>');
        $this->arrayToXml($arr,$xmlData);
        $result = $xmlData->asXML();
        echo $result;
    }

    private function makeHtml($arr)
    {
        $res = '<table>';
        if (is_array($arr))
        {
            $first = $arr[0];
            $res .= '<tr>';
            foreach ($first as $key => $val)
            {
                $res .= '<th>' . $key . '</th>';
            }
            $res .= '</tr>';
            foreach ($arr as $item)
            {
                $res .= '<tr>';
                foreach ($item as $field)
                {
                    $res .= '<td>' . $field . '</td>';
                }
            }
            $res .= '</tr>';
        }
        elseif (is_object($arr))
        {
            $first = $arr;
            $res .= '<tr>';
            foreach ($first as $key => $val)
            {
                $res .= '<th>' . $key . '</th>';
            }
            $res .= '</tr>';
            $res .= '<tr>';
            foreach ($arr as $field)
            {
                $res .= '<td>' . $field . '</td>';
            }
            $res .= '</tr>';
        }
        $res .= '</table>';
        echo $res;
    }

    private function arrayToXml( $data, &$xmlData ) {
        foreach( $data as $key => $value ) {
            if( is_numeric($key) ){
                $key = 'item'.$key;
            }
            if( is_array($value) ) {
                $subnode = $xmlData->addChild($key);
                $this->arrayToXml($value, $subnode);
            } else {
                $xmlData->addChild("$key",htmlspecialchars("$value"));
            }
         }
    }
    
}