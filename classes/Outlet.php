<?php

session_start();

require("db.php");

class Outlet extends db
{
    /*
     * public
     */
    public $outlet_number;
    public $outlet_switch_state;
    public $outlet_status;
    public $outlet_current_electronic;

    /*
     * Private
     */
    private $outlet_plug_id;
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
       $this->member_id = 1;
       $this->member_api_key = "9ee581f8a96ee81c8f1845535e87bc97";
    }

    public function getDetailPlugByID($plug_id)
    {
        //---------- Authentication Check ----------
        if ((!$this->checkAPIKey($this->member_id, $this->member_api_key)) || empty($this->member_id) || empty($this->member_api_key)) return false;
        //------------------------------------------

        $plug_id = mysqli_real_escape_string($this->db_link, $plug_id);
        mysqli_query($this->db_link, "SET NAMES UTF8");
        $sql = "SELECT `plug_code`, `plug_num_of_outlets`, `plug_name`, `plug_location` FROM `SMP_Plug` WHERE `plug_id` = '$plug_id' AND `plug_mem_id` = '$this->member_id'; ";
        //echo $sql;
        if ($result = mysqli_query($this->db_link, $sql)) {
            echo "{\"status\": true, \"desc\" : " . json_encode(mysqli_fetch_object($result)) . "}";
        } else {
            echo "{\"status\": false}";
        }

    }

    public function getOutletRealtime($plug_id, $outlet_number)
    {
        //---------- Authentication Check ----------
        if ((!$this->checkAPIKey($this->member_id, $this->member_api_key)) || empty($this->member_id) || empty($this->member_api_key)) return false;
        //------------------------------------------

        $plug_id = mysqli_real_escape_string($this->db_link, $plug_id);
        $outlet_number = mysqli_real_escape_string($this->db_link, $outlet_number);
        $sql = "SELECT o.`outlet_plug_id`, o.`outlet_number`, o.`outlet_switch_state`, o.`outlet_status`, o.`outlet_current_electronic`, u.`used_current` FROM `SMP_Outlet` o LEFT JOIN `SMP_Used` u ON o.`outlet_plug_id`=u.`used_plug_id` AND o.`outlet_number`=u.`used_outlet_number` AND o.`outlet_plug_id` = '$plug_id' AND o.`outlet_number` = '$outlet_number' ORDER BY u.`used_time` DESC LIMIT 1;";
        if ($result = mysqli_query($this->db_link, $sql)) {
            echo "{\"status\": true, \"desc\" : " . json_encode(mysqli_fetch_object($result)) . "}";
        } else {
            echo "{\"status\": false}";
        }
    }

    public function getAllOutletInPlug($plug_id)
    {
        //---------- Authentication Check ----------
        if ((!$this->checkAPIKey($this->member_id, $this->member_api_key)) || empty($this->member_id) || empty($this->member_api_key)) return false;
        //------------------------------------------

        $plug_id = mysqli_real_escape_string($this->db_link, $plug_id);

        $sql = "SELECT `plug_num_of_outlets`, `plug_name`, `plug_location` FROM `SMP_Plug` WHERE `plug_id` = '$plug_id' AND `plug_mem_id` = '$this->member_id'; ";
        //echo $sql;
        $out = "";
        if ($result = mysqli_query($this->db_link, $sql)) {
            $tem = mysqli_fetch_object($result);
            $out .= "{\"status\": true, \"plug_num_of_outlets\" : " . $tem->plug_num_of_outlets . ", \"plug_name\" : \"" . $tem->plug_name . "\", \"plug_location\" : \"" . $tem->plug_location . "\", \"lists\" : [";

            for ($i = 1; $i <= $tem->plug_num_of_outlets; $i++) {
                $sql = "SELECT o.`outlet_plug_id`, o.`outlet_number`, o.`outlet_switch_state`, o.`outlet_status`, o.`outlet_current_electronic`, u.`used_current` FROM `SMP_Outlet` o LEFT JOIN `SMP_Used` u ON o.`outlet_plug_id`=u.`used_plug_id` AND o.`outlet_number`=u.`used_outlet_number` AND o.`outlet_plug_id` = '$plug_id' AND o.`outlet_number` = '$i' ORDER BY u.`used_time` DESC LIMIT 1;";
                if ($result = mysqli_query($this->db_link, $sql)) {
                    $out .= json_encode(mysqli_fetch_object($result));
                    if ($i < $tem->plug_num_of_outlets) $out .= ", ";
                } else {
                    echo "{\"status\": false}";
                    return;
                }
            }

            $out .= "]}";
            echo $out;
        } else {
            echo "{\"status\": false}";
        }

    }

    public function powerOutletOff($outlet_plug_id, $outlet_number)
    {
        //---------- Authentication Check ----------
        if ((!$this->checkAPIKey($this->member_id, $this->member_api_key)) || empty($this->member_id) || empty($this->member_api_key)) return false;
        //------------------------------------------

        $outlet_plug_id = mysqli_real_escape_string($this->db_link, $outlet_plug_id);
        $outlet_number = mysqli_real_escape_string($this->db_link, $outlet_number);
        $sql = "UPDATE `SMP_Outlet` SET `outlet_switch_state` = 0 WHERE `outlet_plug_id` = '$outlet_plug_id' AND `outlet_number` = '$outlet_number'";
        if (mysqli_query($this->db_link, $sql)) {
            echo "{\"status\": true, \"message\": \"Successfully\"}";
            return;
        }
        echo "{\"status\": false, \"message\": \"Can't be query on the database.\"}";
        return;
    }

    public function powerOutletOn($outlet_plug_id, $outlet_number)
    {
        //---------- Authentication Check ----------
        if ((!$this->checkAPIKey($this->member_id, $this->member_api_key)) || empty($this->member_id) || empty($this->member_api_key)) return false;
        //------------------------------------------

        $outlet_plug_id = mysqli_real_escape_string($this->db_link, $outlet_plug_id);
        $outlet_number = mysqli_real_escape_string($this->db_link, $outlet_number);
        $sql = "UPDATE `SMP_Outlet` SET `outlet_switch_state` = 1 WHERE `outlet_plug_id` = '$outlet_plug_id' AND `outlet_number` = '$outlet_number'";
        if (mysqli_query($this->db_link, $sql)) {
            echo "{\"status\": true, \"message\": \"Successfully\"}";
            return;
        }
        echo "{\"status\": false, \"message\": \"Can't be query on the database.\"}";
        return;
    }

    public function changeElectronic($outlet_plug_id, $outlet_number, $electronic)
    {
        //---------- Authentication Check ----------
        if ((!$this->checkAPIKey($this->member_id, $this->member_api_key)) || empty($this->member_id) || empty($this->member_api_key)) return false;
        //------------------------------------------

        $outlet_plug_id = mysqli_real_escape_string($this->db_link, $outlet_plug_id);
        $outlet_number = mysqli_real_escape_string($this->db_link, $outlet_number);
        $outlet_current_electronic = mysqli_real_escape_string($this->db_link, $electronic);
        $sql = "UPDATE `SMP_Outlet` SET `outlet_current_electronic` = '$outlet_current_electronic' WHERE `outlet_plug_id` = '$outlet_plug_id' AND `outlet_number` = '$outlet_number'";
        if (mysqli_query($this->db_link, $sql)) {
            echo "{\"status\": true, \"message\": \"Successfully\"}";
            return;
        }
        echo "{\"status\": false, \"message\": \"Can't be query on the database.\"}";
        return;
    }
}

