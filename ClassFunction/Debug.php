<?php
/**
 * Created by PhpStorm.
 * User: ПК
 * Date: 29.07.2017
 * Time: 22:20
 */

namespace fnc;


class Debug
{

   function __construct($value,$die)
    {
        $this->d($value,$die);
    }

    private function d($value = null, $die = 1){
        echo '<pre>';
        $trace = debug_backtrace();
        echo $this->debugOut($trace);
        echo "\n\n";
        var_dump($value);
        echo '</pre>';

        if($die)die;
    }

    private function debugOut($a){
        $mt ='<br> <b>'.basename($a['file']).'</b>'
            . " <span style='color:red;'>({$a['line']})</span>"
            . " <span style='color:green;'>({$a['function']})</span>"
            . " <span style='color:black;'><i>".dirname($a['file'])."</i></span>";

        return $mt;
    }
}