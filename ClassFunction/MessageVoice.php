<?php

namespace fnc;


class MessageVoice
{

    public $message_status = 0;
    public $message_text = "";
    public $message_status_css = "default";
    public $message_status_prefix = "Неизвестно";

    /**
     * @return string
     */
    public function getMessageText()
    {
        return $this->message_text;
    }

    /**
     * @return string
     */
    public function getMessageStatusPrefix()
    {
        return $this->message_status_prefix;
    }

    /**
     * @param string $message_status_prefix
     */
    public function setMessageStatusPrefix($message_status_prefix)
    {
        $this->message_status_prefix = $message_status_prefix;
    }

    /**
     * @param string $message_status
     */
    public function setMessageStatus($message_status)
    {
        $this->message_status = $message_status;
    }

    /**
     * @param string $message_text
     */
    public function setMessageText($message_text)
    {
        $this->message_text = $message_text;
    }

    /**
     * @param string $message_status_css
     */
    public function setMessageStatusCss($message_status_css)
    {
        $this->message_status_css = $message_status_css;
    }

    /**
     * @return string
     */
    public function getMessageStatusCss()
    {
        if($this->message_status==0){
            $this->setMessageStatusCss("default");
            $this->setMessageStatusPrefix("Неизвестно");
        }elseif ($this->message_status==1){
            $this->setMessageStatusCss("danger");
            $this->setMessageStatusPrefix("Ошибка :");
        }elseif ($this->message_status==2){
            $this->setMessageStatusPrefix("");
            $this->setMessageStatusCss("success");
        }elseif ($this->message_status==3){
            $this->setMessageStatusCss("info");
            $this->setMessageStatusPrefix("Подсказка :");

        }else{
            $this->setMessageStatusPrefix("Неизвестно");
            $this->setMessageStatusCss("default");
        }
        return $this->message_status_css;
    }

    /**
     * @return int
     */
    public function getMessageStatus()
    {

        return $this->message_status;
    }

    public function MessageSend($message_status,$message_text){
           $this->setMessageStatus($message_status);
           $style_message = $this->getMessageStatusCss();
           $this->setMessageText($message_text);
        return "
               <div id='tn-box'  class='alert alert-$style_message alert-dismissable' style='margin-bottom: 3px; margin-top: 5px;'>
   <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
 {$this->getMessageStatusPrefix()} {$this->getMessageText()}</div>
        ";
    }

}