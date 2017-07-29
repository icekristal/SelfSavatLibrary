<?php


namespace fnc;


class Validator
{

    public static function CheckingEmail($email){
        $result = true;
        if(!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/",$email)){
            $result = false;
        }
        return $result;
    }

    //Проверяем является ли запрос JSON
    public static function isJson(){
        if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
            return false;
        }else{
            if(strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
                return false;
            }
        }
        return true;
    }

    //Проверяем на пустоту входящего массива
    public static function isEmpty($array = array()){
        $Valid = true;
        foreach ($array as $item){
            if(empty($item)){
                $Valid = false;
            }
        }
        return $Valid;
    }


}