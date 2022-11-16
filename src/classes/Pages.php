<?php

declare(strict_types=1);

class Pages 
{
    public static function getPagesFileNames() : array
    {
        $result = array();
        $arr = array_reverse(glob("pages/*.php"));
        foreach($arr as $value)
        {
            $result[] = ucfirst(substr($value, 6, strlen($value) -10));
        }
        return $result;
    }
    public static function getHeader()
    {
        $page = substr($_SERVER["REQUEST_URI"], 10);
        $dotPos = strpos($page, "?");
        if($dotPos)
            return substr($page, 0, $dotPos);
        return $page;
       
    }
}
?>