<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 10/11/2559
 * Time: 14:44
 */
session_start();

class db
{
    /*
     * Connection detail.
     */
    private $db_host = "localhost";
    private $db_user = "smp";
    private $db_password = "Once&forall";
    private $db_database_select = "smp";
    public $db_link = null;

    /*
     * Connect or disconnect the database.
     */
    public function Open()
    {
        if (isset($this->db_link)) {
            echo "Warning : You already connected to MySql.";
        } else {
            $this->db_link = mysqli_connect($this->db_host, $this->db_user, $this->db_password, $this->db_database_select);
            if (mysqli_error($this->db_link)) {
                die("Connection failed: " . mysqli_error($this->db_link));
            }
            return true;
        }
        return false;
    }

    public function Close()
    {
        mysqli_close($this->db_link);
    }

    public function getAPIKey($member_id)
    {
        mysqli_query($this->db_link, "SET NAMES UTF8");
        $member_id = mysqli_real_escape_string($this->db_link, $member_id);
        $sql = "SELECT `member_api_key` FROM `SMP_Member` WHERE `member_id` = '$member_id' ";
        //echo $sql;
        $result = mysqli_query($this->db_link, $sql);
        return mysqli_fetch_object($result)->member_api_key;
    }

    public function checkAPIKey($member_id, $member_api_key)
    {
        $member_id = mysqli_real_escape_string($this->db_link, $member_id);
        $member_api_key_form_db = $this->getAPIKey($member_id);
        if ($member_api_key == $member_api_key_form_db) {
            return true;
        } else {
            return false;
        }
    }

}

/*
$object = new db();
$object->Open();
//echo $object->checkAPIKey(1, "1-IDMEM-c274737ea3ad499cdae5591f8084295");
//echo true.":true";
//echo false.":false";
if($object->checkAPIKey(1, "1-IDMEM-c274737ea3ad499cdae5591f80842958"))echo "true";
else echo "false";
*/