<?php
function d($value = null, $die = 1){

    function debugOut($a){
        echo '<br> <b>'.basename($a['file']).'</b>'
            . " <span style='color:red;'>({$a['line']})</span>"
            . " <span style='color:green;'>({$a['function']})</span>"
            . " <span style='color:black;'><i>".dirname($a['file'])."</i></span>";
    }

    echo '<pre>';
    $trace = debug_backtrace();
    array_walk($trace,'debugOut');
    echo "\n\n";
    var_dump($value);
    echo '</pre>';

    if($die)die;
}
