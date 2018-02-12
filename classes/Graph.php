<?php

session_start();

require("db.php");

class Graph extends db
{
    /*
     * public
     */


    /*
     * Private
     */
    private $member_id;
    private $member_api_key;


    /*
     * Methods
     */

    function __construct()
    {
        /*
        * Database Connect
        */
        $this->Open();
        $this->member_id = mysqli_real_escape_string($this->db_link, $_SESSION["member_id"]);
        $this->member_api_key = mysqli_real_escape_string($this->db_link, $_SESSION['member_api_key']);

        //------ Test ------
        // $this->member_id = 1;
        // $this->member_api_key = "9ee581f8a96ee81c8f1845535e87bc97";
    }

    public function getCurrent($plug_id, $outlet_number, $length)
    {
        //---------- Authentication Check ----------
        if ((!$this->checkAPIKey($this->member_id, $this->member_api_key)) || empty($this->member_id) || empty($this->member_api_key)) return false;
        //------------------------------------------
        //used_plug_id, used_outlet_number, used_time, used_current

        $plug_id = mysqli_real_escape_string($this->db_link, $plug_id);
        $outlet_number = mysqli_real_escape_string($this->db_link, $outlet_number);
        $length = mysqli_real_escape_string($this->db_link, $length);
        mysqli_query($this->db_link, "SET NAMES UTF8");
        $sql = "";
        if ($length == "all") {
            $sql = "SELECT * FROM ( SELECT `used_time`, `used_current` FROM `SMP_Used` WHERE `used_plug_id` = '$plug_id' AND `used_outlet_number` = '$outlet_number' ORDER BY `used_time` DESC) SUB ORDER BY `used_time` ASC;";
        } else {
            $sql = "SELECT * FROM ( SELECT `used_time`, `used_current` FROM `SMP_Used` WHERE `used_plug_id` = '$plug_id' AND `used_outlet_number` = '$outlet_number' ORDER BY `used_time` DESC LIMIT " . $length . ") SUB ORDER BY `used_time` ASC;";
        }
        //echo $sql;
        if ($result = mysqli_query($this->db_link, $sql)) {
            $out = "{\"status\": true, \"lists\" : [";
            for ($i = 0; $i < $result->num_rows; $i++) {
                if ($out != "{\"status\": true, \"lists\" : [") $out .= ",";
                $out .= json_encode(mysqli_fetch_object($result));
            }
            $out .= "]}";
            echo $out;
        } else {
            echo "{\"status\": false}";
        }
    }

}

