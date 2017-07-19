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




}