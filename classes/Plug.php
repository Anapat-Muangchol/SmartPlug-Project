<?php

session_start();

require("db.php");

class Plug extends db
{
    // public
    public $plug_num_of_outlets;
    public $plug_name;
    public $plug_location;

    // Private
    private $plug_id;
    private $member_id;
    private $member_api_key;


    // Methods
    function __construct()
    {
        // Database Connect
        $this->Open();
        $this->member_id = mysqli_real_escape_string($this->db_link, $_SESSION["member_id"]);
        $this->member_api_key = mysqli_real_escape_string($this->db_link, $_SESSION['member_api_key']);

        //------ Test ------
        $this->member_id = 1;
        $this->member_api_key = "9ee581f8a96ee81c8f1845535e87bc97";
    }

    public function getDetailAllPlug()
    {
        //---------- Authentication Check ----------
        if ((!$this->checkAPIKey($this->member_id, $this->member_api_key)) || empty($this->member_id) || empty($this->member_api_key)) return false;
        //------------------------------------------

        mysqli_query($this->db_link, "SET NAMES UTF8");
        $sql = "SELECT `plug_id`, `plug_code`, `plug_num_of_outlets`, `plug_name`, `plug_location` FROM `SMP_Plug` WHERE `plug_mem_id` = '$this->member_id' ";
        if ($resultList = mysqli_query($this->db_link, $sql)) {
            $out = "{\"status\": true, \"lists\" : [";
            for ($i = 0; $i < $resultList->num_rows; $i++) {
                if ($i != 0) $out .= ",";

                $temp = mysqli_fetch_object($resultList);
                //echo "plug_id : ".$temp->plug_id;
                $sql = "SELECT `outlet_switch_state`, `outlet_status` FROM `SMP_Outlet` WHERE `outlet_plug_id` = '$temp->plug_id' ";
                //echo $sql;
                $result = mysqli_query($this->db_link, $sql);
                //echo $error.":";
                $num_of_outlet = $result->num_rows;
                $switch_state = 0;
                $num_of_outlet_active = 0;
                while ($obj = mysqli_fetch_object($result)) {
                    if ($obj->outlet_status == 1) {
                        $switch_state = $obj->outlet_switch_state;
                        $num_of_outlet_active++;
                    }else if ($obj->outlet_status == 2){
						$switch_state = 2;
					}
                }

                $sum_current = 0;
                for ($j = 1; $j <= $num_of_outlet; $j++) {
                    $sql = "SELECT `used_current` FROM `SMP_Used` WHERE `used_plug_id` = '$temp->plug_id' AND `used_outlet_number` = '$j' ORDER BY `used_time` DESC LIMIT 1";
                    //echo $sql;
                    $result = mysqli_query($this->db_link, $sql);
                    //echo $error.":";
                    $sum_current += mysqli_fetch_object($result)->used_current;
                }

                $out .= "{\"plug_id\": " . $temp->plug_id . ",\"plug_code\": \"" . $temp->plug_code . "\",\"plug_num_of_outlets\": " . $temp->plug_num_of_outlets . ",\"plug_name\": \"" . $temp->plug_name . "\",\"plug_location\": \"" . $temp->plug_location . "\",\"switch_state\": \"" . $switch_state . "\",\"num_of_outlet_active\": " . $num_of_outlet_active . ",\"sum_current\": " . $sum_current . "}";
            }
            $out .= "]}";
            echo $out;
        } else {
            echo "{\"status\": false}";
        }

    }

    public function checkCodePlug($plug_code)
    {
        $sql = "";
        mysqli_query($this->db_link, "SET NAMES UTF8");
        $plug_code = mysqli_real_escape_string($this->db_link, $plug_code);
        $sql = "SELECT `plug_mem_id` FROM `SMP_Plug` WHERE `plug_code` = '$plug_code';";
        $result = mysqli_query($this->db_link, $sql);
        $num = $result->num_rows;
        //echo $num;

        $plug_mem_id = mysqli_fetch_object($result)->plug_mem_id;

        if ($num > 0 && $plug_mem_id == null) {
            return true;
        }
        return false;

    }

    public function plugOwner($plug_code, $plugName, $plugLocation)
    {
        //---------- Authentication Check ----------
        if ((!$this->checkAPIKey($this->member_id, $this->member_api_key)) || empty($this->member_id) || empty($this->member_api_key)) return false;
        //------------------------------------------

        $sql = "";
        mysqli_query($this->db_link, "SET NAMES UTF8");
        $plug_code = mysqli_real_escape_string($this->db_link, $plug_code);
        $plugName = mysqli_real_escape_string($this->db_link, $plugName);
        $plugLocation = mysqli_real_escape_string($this->db_link, $plugLocation);
        if ($this->checkCodePlug($plug_code)) {
            $sql = "UPDATE `SMP_Plug` SET `plug_mem_id` = '$this->member_id', `plug_name` = '$plugName', `plug_location` = '$plugLocation' WHERE `plug_code` = '$plug_code';";
            if (mysqli_query($this->db_link, $sql)) {
                echo "{\"status\": true, \"message\": \"Successfully\"}";
                return;
            }
        }
        echo "{\"status\": false, \"message\": \"This plug is already owned or Plug code is wrong.\"}";
        return;
    }

    public function powerPlugOff($plug_id)
    {
        //---------- Authentication Check ----------
        if ((!$this->checkAPIKey($this->member_id, $this->member_api_key)) || empty($this->member_id) || empty($this->member_api_key)) return false;
        //------------------------------------------

        $plug_id = mysqli_real_escape_string($this->db_link, $plug_id);
        $sql = "UPDATE `SMP_Outlet` SET `outlet_switch_state` = 0 WHERE `outlet_plug_id` = '$plug_id' ";
        if (mysqli_query($this->db_link, $sql)) {
            echo "{\"status\": true, \"message\": \"Successfully\"}";
            return;
        }
        echo "{\"status\": false, \"message\": \"Can't be query on the database.\"}";
        return;
    }

    public function powerPlugOn($plug_id)
    {
        //---------- Authentication Check ----------
        if ((!$this->checkAPIKey($this->member_id, $this->member_api_key)) || empty($this->member_id) || empty($this->member_api_key)) return false;
        //------------------------------------------

        $plug_id = mysqli_real_escape_string($this->db_link, $plug_id);
        $sql = "UPDATE `SMP_Outlet` SET `outlet_switch_state` = 1 WHERE `outlet_plug_id` = '$plug_id' ";
        if (mysqli_query($this->db_link, $sql)) {
            echo "{\"status\": true, \"message\": \"Successfully\"}";
            return;
        }
        echo "{\"status\": false, \"message\": \"Can't be query on the database.\"}";
        return;
    }

    public function getPlugRealtime($plug_id)
    {
        //---------- Authentication Check ----------
        if ((!$this->checkAPIKey($this->member_id, $this->member_api_key)) || empty($this->member_id) || empty($this->member_api_key)) return false;
        //------------------------------------------

        $error = false;
        //echo $error.":";
        $plug_id = mysqli_real_escape_string($this->db_link, $plug_id);
        mysqli_query($this->db_link, "SET NAMES UTF8");
        $sql = "SELECT `outlet_switch_state`, `outlet_status` FROM `SMP_Outlet` WHERE `outlet_plug_id` = '$plug_id' ";
        //echo $sql;
        if (!$result = mysqli_query($this->db_link, $sql)) $error = true;
        //echo $error.":";
        $num_of_outlet = $result->num_rows;
        $switch_state = 0;
        $num_of_outlet_active = 0;
        while ($obj = mysqli_fetch_object($result)) {
            if ($obj->outlet_status == 1) {
                $switch_state = $obj->outlet_switch_state;
                $num_of_outlet_active++;
            }else if ($obj->outlet_status == 2){
				$switch_state = 2;
			}
        }

        $sum_current = 0;
        for ($i = 1; $i <= $num_of_outlet; $i++) {
            $sql = "SELECT `used_current` FROM `SMP_Used` WHERE `used_plug_id` = '$plug_id' AND `used_outlet_number` = '$i' ORDER BY `used_time` DESC LIMIT 1";
            //echo $sql;
            if (!$result = mysqli_query($this->db_link, $sql)) $error = true;
            //echo $error.":";
            $sum_current += mysqli_fetch_object($result)->used_current;
        }

        if (!$error) {
            echo "{\"status\": true, \"switch_state\": \"" . $switch_state . "\", \"num_of_outlet_active\" : " . $num_of_outlet_active . ", \"sum_current\":" . $sum_current . "}";
            return;
        } else {
            echo "{\"status\": false, \"message\": \"Can't be query on the database.\"}";
            return;
        }

    }

    public function checkPlugOwner($plug_id)
    {
        $sql = "";
        mysqli_query($this->db_link, "SET NAMES UTF8");
        $plug_id = mysqli_real_escape_string($this->db_link, $plug_id);
        $sql = "SELECT `plug_mem_id` FROM `SMP_Plug` WHERE `plug_id` = '$plug_id';";
        $result = mysqli_query($this->db_link, $sql);
        $plug_mem_id = mysqli_fetch_object($result)->plug_mem_id;

        if ($plug_mem_id == $this->member_id) {
            return true;
        }
        return false;

    }

    public function checkPlugOwnerAndNumOfOutlet($plug_id, $outlet_number)
    {
        $sql = "";
        mysqli_query($this->db_link, "SET NAMES UTF8");
        $plug_id = mysqli_real_escape_string($this->db_link, $plug_id);
        $outlet_number = mysqli_real_escape_string($this->db_link, $outlet_number);
        $sql = "SELECT `plug_mem_id`, `plug_num_of_outlets` FROM `SMP_Plug` WHERE `plug_id` = '$plug_id';";
        $result = mysqli_query($this->db_link, $sql);
        $result = mysqli_fetch_object($result);
        $plug_mem_id = $result->plug_mem_id;
        $plug_num_of_outlets = $result->plug_num_of_outlets;

        if ($plug_mem_id == $this->member_id && $outlet_number <= $plug_num_of_outlets) {
            return true;
        }
        return false;

    }

    public function editPlugDesc($plug_id, $plug_name, $plug_location)
    {
        //---------- Authentication Check ----------
        if ((!$this->checkAPIKey($this->member_id, $this->member_api_key)) || empty($this->member_id) || empty($this->member_api_key)) return false;
        //------------------------------------------

        $plug_id = mysqli_real_escape_string($this->db_link, $plug_id);
        $plug_name = mysqli_real_escape_string($this->db_link, $plug_name);
        $plug_location = mysqli_real_escape_string($this->db_link, $plug_location);

        if (!$this->checkPlugOwner($plug_id)) {
            echo "{\"status\": false, \"message\": \"You don't own this plug.\"}";
            return;
        }
        mysqli_query($this->db_link, "SET NAMES UTF8");
        $sql = "UPDATE `SMP_Plug` SET `plug_name`='$plug_name', `plug_location`='$plug_location' WHERE `plug_id` = '$plug_id' AND `plug_mem_id` = '$this->member_id'; ";
        //echo $sql;
        if (mysqli_query($this->db_link, $sql)) {
            echo "{\"status\": true, \"message\": \"Edit successfully\"}";
            return;
        }
        echo "{\"status\": false, \"message\": \"Can't be query on the database.\"}";
        return;
    }

    public function cancelPlugOwner($plug_id)
    {
        //---------- Authentication Check ----------
        //if ((!$this->checkAPIKey($this->member_id, $this->member_api_key)) || empty($this->member_id) || empty($this->member_api_key)) return false;
        //------------------------------------------

        $plug_id = mysqli_real_escape_string($this->db_link, $plug_id);

        if (!$this->checkPlugOwner($plug_id)) {
            echo "{\"status\": false, \"message\": \"You don't own this plug.\"}";
            return;
        }

        mysqli_query($this->db_link, "SET NAMES UTF8");
        $sql = "UPDATE `SMP_Plug` SET `plug_mem_id`=NULL WHERE `plug_id` = '$plug_id' AND `plug_mem_id` = '$this->member_id'; ";
        //echo $sql;
        if (mysqli_query($this->db_link, $sql)) {
            echo "{\"status\": true, \"message\": \"Cancel plug successfully\"}";
            return;
        }
        echo "{\"status\": false, \"message\": \"Can't be query on the database.\"}";
        return;
    }
}



//echo "comeOn";
