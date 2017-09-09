<?php
/**
 * Created by PhpStorm.
 * User: ПК
 * Date: 20.07.2017
 * Time: 15:44
 */

namespace fnc;


class Entrance
{
    private $user_hash;
    private $user_ip;
    private $user_referer;
    public $user_session;

    function __construct($session_user = null)
    {

        list($check_bot,$user_agent) = $this->SpotSearchBot();
        $this->user_hash=$user_agent;
        if($check_bot){
            if(!$this->checkUserSession($session_user)){
                if(!$this->NewOrOldUser()){
                    $this->setCookieHash();
                }else{
                    $this->user_hash=$this->NewOrOldUser();
                }
            }else{
                $this->setUserSession($_SESSION[$session_user]);
                $this->user_hash=$this->user_session['login'];

            }
        }
    }

    private function checkUserSession($session_user){
        if(isset($_SESSION[$session_user])){
            return true;
        }
        return false;
    }

    /**
     * @param mixed $user_session
     */
    private function setUserSession($user_session)
    {
        $this->user_session = $user_session;
    }

    /**
     * @return mixed
     */
    public function getUserSession()
    {
        return $this->user_session;
    }
    /**
     * @return mixed
     */
    public function getUserHash()
    {
        return $this->user_hash;
    }
    public function getUserHashTotal(){
        if(!$this->NewOrOldUser()){
            $this->setCookieHash();
        }else{
            $this->user_hash=$this->NewOrOldUser();
        }
        return $this->user_hash;
    }

    /**
     * @return mixed
     */
    public function getUserIp()
    {
        $this->user_ip = $this->IdentifyUserIP();
        $this->user_ip = Security::FormChar($this->user_ip);
        return $this->user_ip;
    }
    /**
     * @return mixed
     */
    public function getUserReferer()
    {
        if(!empty($_SERVER['HTTP_REFERER'])){
            $this->user_referer = $_SERVER['HTTP_REFERER'];
        }else{
            $this->user_referer = 'Прямой заход';
        }

        return $this->user_referer;
    }


    /**
     * Инициализцаия IP пользователя
     * @return mixed
     */
    private function IdentifyUserIP(){
        if (!empty($_SERVER['HTTP_CLIENT_IP']))        // Определяем IP
        { $ip=$_SERVER['HTTP_CLIENT_IP']; }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        { $ip=$_SERVER['HTTP_X_FORWARDED_FOR']; }
        else { $ip=$_SERVER['REMOTE_ADDR']; }
        return $ip;
    }

    private function SpotSearchBot(){
        $check_result = true;
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        if (strstr($user_agent, 'YandexBot'))
        {
            $check_result=false;
            $bot='YandexBot';
        }elseif (strstr($_SERVER['HTTP_USER_AGENT'], 'Googlebot')) {
            $check_result=false;
            $bot='Googlebot';
        }else{
            $bot=$_SERVER['HTTP_USER_AGENT'];
        }
        return array($check_result,$bot);
    }

    private function setCookieHash(){
        $userhash = uniqid('UQE');
        setcookie("UserHash", $userhash,  time()+60*60*24*30*12*5,"/");
        return $this->user_hash = $userhash;
    }

    private function NewOrOldUser(){
        $userhash = isset($_COOKIE["UserHash"]) ? $_COOKIE["UserHash"] : null;
        $result = $userhash;
        if($userhash==null){
            $result =false;
        }
        return $result;
    }


}