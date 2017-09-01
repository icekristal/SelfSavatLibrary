<?php
/*Проверка безопасности*/

function FormChar($param){
    global $connect;

    $param = mysqli_real_escape_string($connect,$param);

    return nl2br(htmlspecialchars(trim($param), ENT_QUOTES), false);

}

function check_email($email){
    $result = true;
    if(!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/",$email)){
        $result = false;
    }
    return $result;
}

//Получаем IP клиента
function getRealIpAddr() {
    if (!empty($_SERVER['HTTP_CLIENT_IP']))        // Определяем IP
    { $ip=$_SERVER['HTTP_CLIENT_IP']; }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
    { $ip=$_SERVER['HTTP_X_FORWARDED_FOR']; }
    else { $ip=$_SERVER['REMOTE_ADDR']; }
    return $ip;
}

function authzahodclient(){
    $ip_client = getRealIpAddr();
    $ip_client = FormChar($ip_client);
    $bot = "";
    if (strstr($_SERVER['HTTP_USER_AGENT'], 'YandexBot')) {$bot='YandexBot';} //Выявляем поисковых ботов
    elseif (strstr($_SERVER['HTTP_USER_AGENT'], 'Googlebot')) {$bot='Googlebot';}
    else { $bot=$_SERVER['HTTP_USER_AGENT']; }


    $userhash = isset($_COOKIE["hash4kidss"]) ? $_COOKIE["hash4kidss"] : null;

    if (!$userhash) {
        /* Если это новый пользователь, то добавляем ему cookie, уникальные для него */
        $userhash = uniqid();
        setcookie("hash4kidss", $userhash, 0x6FFFFFFF);
    }

    $href_new_client = $_SERVER['REQUEST_URI'];
    if(!empty($_SERVER['HTTP_REFERER'])){
        $href_new_client_pere = $_SERVER['HTTP_REFERER'];
    }else{
        $href_new_client_pere = 'Прямой заход';
    }
    /*
        $rez_check = CheckTodayUser($userhash,$ip_client);
        if(!$rez_check){
            WriteTrafic($userhash,$ip_client,$bot,$href_new_client,$href_new_client_pere);
        }
    */

}

//Функция записи логов
function writelogfile($directory,$login,$text,$result){
    if($result==1){
        $resultt = 'Ошибка : ';
    }else{
        $resultt = 'Успех : ';
    }
    $date_now = date('d.m.y');
    $date_write = date('H:i:s');

    $textwrite = $date_write." // ".$resultt.$text;
    $file_name = $date_now.'.txt';

    if(!is_dir("../logs/{$directory}/{$login}")){
        mkdir("../logs/{$directory}/".$login);
    }

    $file_pp = "../logs/$directory/$login/$file_name";
    if ( !file_exists( "$file_pp" ) ) { // если файл НЕ существует
        $fp = fopen ("$file_pp", "w");
        fwrite($fp,$textwrite.PHP_EOL);
        fclose($fp);
    } else {
        $fp = fopen ("$file_pp", "a");
        fwrite($fp,$textwrite.PHP_EOL);
        fclose($fp);
    }

    if($directory=="admin"){
        TOTwritelogfile($directory,$login,$text,$result);
    }elseif($directory=="users"){
        $email_user = getAllUserInfo($login);
        $email_user = $email_user[0];
        TOTwritelogfile($directory,$email_user['email'],$text,$result);
    }

}

//Функция записи логов - общие логин
function TOTwritelogfile($directory,$login,$text,$result){
    if($result==1){
        $result = 'Ошибка : ';
    }else{
        $result = 'Успех : ';
    }
    $date_now = date('d.m.y');
    $date_write = date('H:i:s');

    $textwrite = $date_write." // ".$result."** ".$login." ** ".$text;
    $file_name = $date_now.'.txt';
    $file_pp = "../logs/total/$directory/$file_name";
    if ( !file_exists( "$file_pp" ) ) { // если файл НЕ существует
        $fp = fopen ("$file_pp", "w");
        fwrite($fp,$textwrite.PHP_EOL);
        fclose($fp);
    } else {
        $fp = fopen ("$file_pp", "a");
        fwrite($fp,$textwrite.PHP_EOL);
        fclose($fp);
    }
}

function isjson(){
    if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
        redirect('/error/');
    }else{
        if(strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
            redirect('/error/');
        }
    }
}


//Проверка на пустоты данных которые пришли
function ValidEmpty($array_info = array()){
    $Valid = true;
    foreach ($array_info as $item){
        if(empty($item)){
            $Valid = false;
        }
    }
    return $Valid;
}

function checkRegisterParamsTotal($login,$email,$password,$passwordq){
    $res = null;

    if(! $login){
        $res['success']= false;
        $res['message'] = message_info(1,'Введите логин');
    }

    if(! $email){
        $res['success']= false;
        $res['message'] = message_info(1,'Введите email');
    }

    if(! check_email($email)){
        $res['success']= false;
        $res['message'] = message_info(1,'Email введен не верно');
    }

    if(! $password){
        $res['success']= false;
        $res['message'] = message_info(1,'Введите пароль');
    }

    if(! $passwordq){
        $res['success']= false;
        $res['message'] = message_info(1,'Введите поле - повторите пароль');
    }

    if($password != $passwordq){
        $res['success']= false;
        $res['message'] = message_info(1,'Пароли не совпадают');
    }


    return $res;
}
