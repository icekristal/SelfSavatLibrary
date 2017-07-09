<?php

function userauthcheckadmin($right=null){
        global $adminhref;
    if(!isset($_SESSION['usertop'])){
        redirect("{$adminhref}/auth/");
    }


    if($right){
        if($_SESSION['usertop']['right']<$right){
            writelogfile('admin',$_SESSION['usertop']['login'],'Переход в зону без прав доступа',1);
            redirect("{$adminhref}/notright/");
        }
    }
}