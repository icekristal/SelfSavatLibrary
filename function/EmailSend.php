<?php

class EmailSend
{

    public $users_email = array();
    public $subject = "";
    public $header_begin = "Content-type: text/html; charset=utf-8 \r\n";
    public $header_end;
    public $message = "";

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @param string $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * @param mixed $header_end
     */
    public function setHeaderEnd($header_end,$email_sender)
    {
        $this->header_end = $this->header_begin.$header_end."<{$email_sender}>\r\n";
    }

    /**
     * @param array $users_email
     */
    public function setUsersEmail($users_email)
    {
        $this->users_email = $users_email;
    }

    public function sendEmail(){
        foreach ($this->users_email as $item_email){
          $send_go =  mail ($item_email,$this->subject,$this->message, $this->header_end);
        }
    }


}