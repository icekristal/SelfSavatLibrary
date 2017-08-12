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


    public static function d($value = null, $die = 1){
        echo '<pre>';
        $trace = debug_backtrace();
        echo self::debugOut($trace);
        echo "\n\n";
        var_dump($value);
        echo '</pre>';

        if($die)die;
    }

    private static function debugOut($a){
        $mt ='<br> <b>'.basename($a['file']).'</b>'
            . " <span style='color:red;'>({$a['line']})</span>"
            . " <span style='color:green;'>({$a['function']})</span>"
            . " <span style='color:black;'><i>".dirname($a['file'])."</i></span>";

        return $mt;
    }
}