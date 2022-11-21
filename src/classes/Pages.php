<?php

declare(strict_types=1);

class Pages 
{
    /**Gets all the file names is the pages fold*/
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
    
}
?>