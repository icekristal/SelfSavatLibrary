<?php
/**
 * Created by PhpStorm.
 * User: ПК
 * Date: 19.07.2017
 * Time: 9:57
 */

namespace fnc;


class Security
{

    //Проверка форм
    public static function FormChar($param,$connect=null){
            if(isset($connect)){
                $param = mysqli_real_escape_string($connect,$param);
            }

        return nl2br(htmlspecialchars(trim($param), ENT_QUOTES), false);
    }


}