<?php


namespace fnc;


class DateFormat
{

    public static function dmyHi($data){
        $dat_ra = date_create($data);
        $data_click=date_format($dat_ra, 'd.m.y H:i');
        return $data_click;
    }

    public static function dm($data){
        $dat_ra = date_create($data);
        $data_click=date_format($dat_ra, 'd.m');
        return $data_click;
    }

    public static function RusMounts($month){
        $rus = array(
            1 => 'Январь',
            2 => 'Февраль',
            3 => 'Март',
            4 => 'Апрель',
            5 => 'Май',
            6 => 'Июнь',
            7 => 'Июль',
            8 => 'Август',
            9 => 'Сентябрь',
            10 => 'Октябрь',
            11 => 'Ноябрь',
            12 => 'Декабрь'
        );
        return $rus[$month];
    }

    public static function RusMountsPadezh($month){
        $rus = array(
            1 => 'Января',
            2 => 'Февраля',
            3 => 'Марта',
            4 => 'Апреля',
            5 => 'Мая',
            6 => 'Июня',
            7 => 'Июля',
            8 => 'Августа',
            9 => 'Сентября',
            10 => 'Октября',
            11 => 'Ноября',
            12 => 'Декабря'
        );
        return $rus[$month];
    }


}