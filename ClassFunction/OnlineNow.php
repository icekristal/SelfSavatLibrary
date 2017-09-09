<?php
/**
 * Created by PhpStorm.
 * User: Savatneev Anton Alex
 * Date: 09.09.2017
 * Time: 18:34
 */

namespace fnc;


class OnlineNow
{

    private $ip_user;
    private $hash_user;
    private $connect;
    private $data_table;

    public function __construct($connect,$data_table="online_now")
    {
     $this->setConnect($connect);
     $this->setDataTable($data_table);

        $ex_table = $this->isTableExists($this->connect,$this->data_table);
        if($ex_table==0){
            $this->createNeedTable();
            $this->processDB();
        }else{
            $this->processDB();
        }
    }

    /**
     * @param mixed $data_table
     */
    public function setDataTable($data_table)
    {
        $this->data_table = $data_table;
    }
    /**
     * @param mixed $connect
     */
    public function setConnect($connect)
    {
        $this->connect = $connect;
    }
    /**
     * @param mixed $hash_user
     */
    public function setHashUser($hash_user)
    {
        $this->hash_user = $hash_user;
    }

    /**
     * @param mixed $ip_user
     */
    public function setIpUser($ip_user)
    {
        $this->ip_user = $ip_user;
    }

    private function processDB(){
        $row_db = $this->selectDB();
        if($row_db!=false){
            $ip_user_in_db = $row_db['user_ip'];
            $hash_user_in_db = $row_db['user_hash'];
            if($ip_user_in_db!=$this->ip_user){
                $this->updateDB();
            }else{
                $this->updateDB();
            }
        }else{
            $this->insertDB();
        }
    }


    private function selectDB(){
        $sql = "SELECT * FROM `{$this->data_table}` WHERE `user_hash`='{$this->hash_user}' LIMIT 1";
        $rs = mysqli_query($this->connect,$sql);
        $row = mysqli_fetch_assoc($rs);
            if(isset($row)){
                return $row;
            }
            return false;
    }

    private function updateDB(){
        $sql = "UPDATE `{$this->data_table}` SET `date_auth`=NOW(),`user_ip`='{$this->ip_user}' WHERE `user_hash`='{$this->hash_user}'";
        $rs = mysqli_query($this->connect,$sql);
        return $rs;
    }

    private function insertDB(){
        $sql = "INSERT INTO `{$this->data_table}` (user_ip, user_hash, city_auth,date_auth)
        VALUES ('{$this->ip_user}','{$this->hash_user}','',NOW())";
        $rs = mysqli_query($this->connect,$sql);
        return $rs;
    }


    private function isTableExists($dbLink, $tableName){
        if ($stmt = mysqli_prepare($dbLink, "SHOW TABLES LIKE '?';")) {
            mysqli_stmt_bind_param($stmt, "s", $tableName);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $result);
            mysqli_stmt_fetch($stmt);
            mysqli_stmt_close($stmt);
        }
        return ( mysqli_affected_rows($dbLink) > 0);
    }

    private function createNeedTable(){
        $sql = "
        CREATE TABLE IF NOT EXISTS `{$this->data_table}` (
  `user_ip` varchar(150) NOT NULL,
  `user_hash` varchar(150) NOT NULL,
  `date_auth` datetime NOT NULL,
  `city_auth` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Онлайн в данный момент';
        ";

        $rs = mysqli_query($this->connect,$sql);
        return $rs;
    }
}