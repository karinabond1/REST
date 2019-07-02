<?php

include ('../../config.php');

class Viewer
{
    public function view($res, $view)
    {
        if(!$view){
            $view=JSON;        }
        if($view=='.json'){
            $this->makeJson($res);
        }elseif($view=='.txt'){
            $this->makeTxt($res);
        }elseif($view=='.xml'){
            $this->makeXml($res);
        }elseif($view=='.html'){
            $this->makeHtml($res);
        }else{
            $this->makeJson($res);
        }
    }

    private function makeJson($arr)
    {
        //header('Content-Type: application/json; charset=utf-8');
        echo json_encode($arr);
    }

    private function makeTxt($arr)
    {
        echo '<pre>',print_r($arr),'</pre>';
    }

    private function makeXml($arr)
    {
        $data = array('total_stud' => 500);
        $xmlData = new SimpleXMLElement('<?xml version="1.0"?><car></car>');
        $this->arrayToXml($arr,$xmlData);
        $result = $xmlData->asXML();
 	    header('Content-Type: application/xml; charset=utf-8');
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
