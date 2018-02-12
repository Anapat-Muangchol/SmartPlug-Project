<?php

session_start();

require("db.php");

class Search extends db
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

    public function searchPlug($keyword)
    {
        //---------- Authentication Check ----------
        if ((!$this->checkAPIKey($this->member_id, $this->member_api_key)) || empty($this->member_id) || empty($this->member_api_key)) return false;
        //------------------------------------------

        mysqli_query($this->db_link, "SET NAMES UTF8");
        $keyword = mysqli_real_escape_string($this->db_link, $keyword);
        $sql = "SELECT `plug_id`, `plug_code`, `plug_num_of_outlets`, `plug_name`, `plug_location` FROM `SMP_Plug` WHERE `plug_mem_id` = '$this->member_id' AND (`plug_num_of_outlets` LIKE '$keyword' OR `plug_name` LIKE '%$keyword%' OR `plug_location` LIKE '%$keyword%');";
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

    public function getHistory($date)
    {
        //---------- Authentication Check ----------
        if ((!$this->checkAPIKey($this->member_id, $this->member_api_key)) || empty($this->member_id) || empty($this->member_api_key)) return false;
        //------------------------------------------

        mysqli_query($this->db_link, "SET NAMES UTF8");
        $date = mysqli_real_escape_string($this->db_link, $date);
        $sql = "SELECT `report_time_event`, `report_plug_id`, `report_outlet`, `report_plug_name`, `report_plug_location`, `report_status`, `report_current_electronic`, `report_time_duration`, `report_power_use` FROM `SMP_Report` WHERE (`report_status` = 0 OR `report_status` = 1) AND `report_member_id` = '$this->member_id' AND DATE(report_time_event) = '$date' ORDER BY `report_time_event` DESC;";
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

    public function getSummary($plug_id, $outlet_number, $month, $year)
    {
        //---------- Authentication Check ----------
        //if ((!$this->checkAPIKey($this->member_id, $this->member_api_key)) || empty($this->member_id) || empty($this->member_api_key)) return false;
        //------------------------------------------

        mysqli_query($this->db_link, "SET NAMES UTF8");
        $plug_id = mysqli_real_escape_string($this->db_link, $plug_id);
        $outlet_number = mysqli_real_escape_string($this->db_link, $outlet_number);
        $month = mysqli_real_escape_string($this->db_link, $month);
        $year = mysqli_real_escape_string($this->db_link, $year);
        $month_start = $month;
        $month_end = $month+1;
        $year_start = $year;
        $year_end = $year;
        if ($month == 12){
            $month_end = 1;
            $year_end += 1;
        }

        $sql = "SELECT `sum_month_time`, `sum_month_current` FROM `SMP_Summary_Month` WHERE `sum_month_plug_id` = ".$plug_id." AND `sum_month_outlet_number` = '".$outlet_number."' AND `sum_month_time` >= '".$year_start."-".$month_start."-01 00:00:00' AND `sum_month_time` < '".$year_end."-".$month_end."-01 00:00:00' ORDER BY `sum_month_time`;";
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

    public function getUnit($plug_id, $outlet_number, $month, $year)
    {
        //---------- Authentication Check ----------
        //if ((!$this->checkAPIKey($this->member_id, $this->member_api_key)) || empty($this->member_id) || empty($this->member_api_key)) return false;
        //------------------------------------------

        mysqli_query($this->db_link, "SET NAMES UTF8");
        $plug_id = mysqli_real_escape_string($this->db_link, $plug_id);
        $outlet_number = mysqli_real_escape_string($this->db_link, $outlet_number);
        $month = mysqli_real_escape_string($this->db_link, $month);
        $year = mysqli_real_escape_string($this->db_link, $year);
        $month_start = $month;
        $month_end = $month+1;
        $year_start = $year;
        $year_end = $year;
        if ($month == 12){
            $month_end = 1;
            $year_end += 1;
        }

        $sql = "";
        if($outlet_number == "all"){
            $sql = "SELECT sum(report_power_use) unit FROM `SMP_Report` WHERE `report_plug_id` = ".$plug_id." AND `report_time_event` >= '".$year_start."-".$month_start."-01 00:00:00' AND `report_time_event` < '".$year_end."-".$month_end."-01 00:00:00';";
        }else{
            $sql = "SELECT sum(report_power_use) unit FROM `SMP_Report` WHERE `report_plug_id` = ".$plug_id." AND `report_outlet` = '".$outlet_number."' AND `report_time_event` >= '".$year_start."-".$month_start."-01 00:00:00' AND `report_time_event` < '".$year_end."-".$month_end."-01 00:00:00';";
        }
        //echo $sql;
        if ($result = mysqli_query($this->db_link, $sql)) {
            $out = "{\"status\": true, \"desc\" : ";
            $out .= json_encode(mysqli_fetch_object($result));
            $out .= "}";
            echo $out;
        } else {
            echo "{\"status\": false}";
        }

    }
}

