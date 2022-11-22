<?php

declare(strict_types=1);

class Pages
{
    /**Gets all the file names is the pages fold*/
    public static function getFolderFileNames(string $folder): array
    {
        $arr = array_reverse(glob("pages/$folder/*.php"));
        return array_map(function($result) 
        {
            return substr($result, strlen("pages/"), strlen($result) - strlen($result) - 4);
        }, $arr);
    }
}
// 

?>