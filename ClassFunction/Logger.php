<?php

namespace fnc;

class Logger
{

    protected $PATH;
    protected $name_user; //Логин или uniqe hash
    protected $message;
    protected $type_message;
    private $type_message_t;

    function __construct($name_user,$message,$type_message)
    {
        $this->name_user=$name_user;
        $this->message=$message;
        $this->type_message=$type_message;

        $this->checkPATHwrite();
        $this->getTypeMessage();
        $this->setNewLog();
    }


    protected function checkPATHwrite(){
        if(!is_dir("../logs")){
            mkdir("../logs");
            $this->PATH = "../logs";
        }else{
            $this->PATH = "../logs";
            if(!file_exists($this->PATH."/".date("d.m.y").".log")){
                $fp=fopen ($this->PATH."/".date("d.m.y").".log", "w");
                fwrite($fp,"--> Первая запись в файле <--".PHP_EOL);
                $this->PATH="../logs/".date("d.m.y").".log";
                fclose($fp);
            }else{
                $this->PATH="../logs/".date("d.m.y").".log";
            }
        }
    }


    protected function setNewLog()
    {
        $end_message=$this->type_message_t." : ".date("H:i:s")." User-> ".$this->name_user."/*/ Message-> ".$this->message;
        $fp = fopen ($this->PATH, "a");
        fwrite($fp,$end_message.PHP_EOL);
        fclose($fp);
    }

    /**
     * @return mixed
     */
    protected function getTypeMessage()
    {

        if($this->type_message==1){
            $this->type_message_t = "Ошибка";
        }elseif ($this->type_message==2){
            $this->type_message_t = "Все хорошо";
        }elseif($this->type_message==9){
            $this->type_message_t="КРИТИЧНО";
        }else{
            $this->type_message_t="???";
        }

        return $this->type_message_t;
    }






}