<?php

session_start();

require("db.php");

class Member extends db
{
    /*
     * public
     */
    public $member_email;
    public $member_first_name;
    public $member_last_name;
    public $member_telephone;

    /*
     * Private
     */
    private $member_id;
    private $member_password;
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
        $this->member_first_name = mysqli_real_escape_string($this->db_link, $_SESSION["member_first_name"]);
        $this->member_last_name = mysqli_real_escape_string($this->db_link, $_SESSION["member_last_name"]);
        $this->member_api_key = mysqli_real_escape_string($this->db_link, $_SESSION['member_api_key']);
    }

    public function register($member_email, $member_password, $member_first_name, $member_last_name, $member_telephone)
    {
        $member_email = mysqli_real_escape_string($this->db_link, $member_email);

        $member_password = mysqli_real_escape_string($this->db_link, $member_password);
        $member_password = password_hash($member_password, PASSWORD_BCRYPT);

        $member_first_name = mysqli_real_escape_string($this->db_link, $member_first_name);
        $member_last_name = mysqli_real_escape_string($this->db_link, $member_last_name);
        $member_telephone = mysqli_real_escape_string($this->db_link, $member_telephone);

        $sql = "INSERT INTO `SMP_Member`
            (`member_email`, `member_password`, `member_first_name`, `member_last_name`, `member_telephone`, `member_state`) 
            VALUES ('$member_email','$member_password','$member_first_name','$member_last_name', '$member_telephone', 1)";
        mysqli_query($this->db_link, "SET NAMES UTF8");
        mysqli_query($this->db_link, $sql);

        $sql = "SELECT `member_id` FROM `SMP_Member` WHERE `member_email` = '$member_email' ";
        $result = mysqli_query($this->db_link, $sql);
        $member_id = mysqli_fetch_object($result)->member_id;
        $this->update_api_key($member_id, $member_email);
    }

    public function update_api_key($member_id, $member_email)
    {
        $member_id = mysqli_real_escape_string($this->db_link, $member_id);
        $member_api_key = md5(md5($member_id) . "-IDMEM-" . md5($member_email) . "" . md5(time()));
        $sql = "UPDATE `SMP_Member` SET `member_api_key`='$member_api_key' WHERE `member_id` = '$member_id'";
        mysqli_query($this->db_link, $sql);
    }

    public function verify_email($member_email)
    {
        $member_id = mysqli_real_escape_string($this->db_link, $member_email);
        $sql = "UPDATE `SMP_Member` SET `member_state`=1 WHERE `member_email` = '$member_email'";
        mysqli_query($this->db_link, $sql);
    }

    public function isFoundEmail($member_email)
    {
        mysqli_query($this->db_link, "SET NAMES UTF8");
        $member_email = mysqli_real_escape_string($this->db_link, $member_email);
        $sql = "SELECT `member_email` FROM `SMP_Member` WHERE `member_email` = '$member_email' ";
        $result = mysqli_query($this->db_link, $sql);
        if (mysqli_num_rows($result) == 1) return true;
        return false;
    }

    public function getMemberDetail()
    {
        //---------- Authentication Check ----------
        if ((!$this->checkAPIKey($this->member_id, $this->member_api_key)) || empty($this->member_id) || empty($this->member_api_key)) return false;
        //------------------------------------------

        $sql = "SELECT `member_email`, `member_first_name`, `member_last_name`, `member_telephone` FROM `SMP_Member` WHERE `member_id` = '$this->member_id' ";
        $result = mysqli_query($this->db_link, $sql);
        return mysqli_fetch_object($result);
    }

    public function edit($member_first_name, $member_last_name, $member_telephone)
    {
        //---------- Authentication Check ----------
        if ((!$this->checkAPIKey($this->member_id, $this->member_api_key)) || empty($this->member_id) || empty($this->member_api_key)) return false;
        //------------------------------------------

        $sql = "";
        mysqli_query($this->db_link, "SET NAMES UTF8");
        if (isset($member_first_name)) {
            $member_first_name = mysqli_real_escape_string($this->db_link, $member_first_name);
            $sql = "UPDATE `SMP_Member` SET `member_first_name` = '$member_first_name' WHERE `member_id` = '$this->member_id';";
            mysqli_query($this->db_link, $sql);
        }
        if (isset($member_last_name)) {
            $member_last_name = mysqli_real_escape_string($this->db_link, $member_last_name);
            $sql = "UPDATE `SMP_Member` SET `member_last_name` = '$member_last_name' WHERE `member_id` = '$this->member_id';";
            mysqli_query($this->db_link, $sql);
        }
        if (isset($member_telephone)) {
            $member_telephone = mysqli_real_escape_string($this->db_link, $member_telephone);
            $sql = "UPDATE `SMP_Member` SET `member_telephone` = '$member_telephone' WHERE `member_id` = '$this->member_id';";
            mysqli_query($this->db_link, $sql);
        }
    }

    public function editPassword($oldPassword, $newPassword)
    {
        //---------- Authentication Check ----------
        if ((!$this->checkAPIKey($this->member_id, $this->member_api_key)) || empty($this->member_id) || empty($this->member_api_key)) return false;
        //------------------------------------------

        $oldPassword = mysqli_real_escape_string($this->db_link, $oldPassword);
        $newPassword = mysqli_real_escape_string($this->db_link, $newPassword);

        mysqli_query($this->db_link, "SET NAMES UTF8");
        $result = mysqli_query($this->db_link, "SELECT `member_password` FROM `SMP_Member` WHERE `member_id` = '$this->member_id' ");
        $userFound = mysqli_num_rows($result);
        $password_hash_from_db = mysqli_fetch_object($result)->member_password;

        if ($userFound == 1 AND password_verify($oldPassword, $password_hash_from_db)) {
            $newPassword = password_hash($newPassword, PASSWORD_BCRYPT);
            $sql = "UPDATE `SMP_Member` SET `member_password` = '$newPassword' WHERE `member_id` = '$this->member_id';";
            mysqli_query($this->db_link, $sql);
            return true;
        }

        return false;
    }

    public function login($email, $password_from_user)
    {
        $email = mysqli_real_escape_string($this->db_link, $email);
        $password_from_user = mysqli_real_escape_string($this->db_link, $password_from_user);

        mysqli_query($this->db_link, "SET NAMES UTF8");
        $result = mysqli_query($this->db_link, "SELECT `member_id`, `member_email`, `member_password`, `member_first_name`, `member_last_name`, `member_api_key`, `member_state` FROM `SMP_Member` WHERE `member_email` = '$email' ");
        $result = mysqli_fetch_object($result);
        $password_hash_from_db = $result->member_password;

        if ($email == $result->member_email AND password_verify($password_from_user, $password_hash_from_db)) {
            if ($result->member_state == 1) {
                $_SESSION["member_id"] = $result->member_id;
                $_SESSION["member_first_name"] = $result->member_first_name;
                $_SESSION["member_last_name"] = $result->member_last_name;
                $_SESSION['member_api_key'] = $result->member_api_key;
                echo "
                {
                    \"boolean\" : true,
                    \"detail\" : \"right username and password\"
                }";

                return true;
            } elseif ($result->member_state == 0) {
                echo "
                {
                    \"boolean\" : false,
                    \"detail\" : \"please verify your email.\"
                }";

                return false;
            } else {
                echo "
                {
                    \"boolean\" : false,
                    \"detail\" : \"Your account has been baned.\"
                }";

                return false;
            }

        } else {
            echo "
            {
                \"boolean\" : false,
                \"detail\" : \"wrong username or password\"
            }";

            return false;
        }
    }

    public function logout()
    {
        $cookie_expire = time() - 3600;
        $cookie_path = "/";
        setcookie("member_id", "", $cookie_expire, $cookie_path);
        setcookie("member_first_name", "", $cookie_expire, $cookie_path);
        setcookie("member_last_name", "", $cookie_expire, $cookie_path);
        setcookie("member_api_key", "", $cookie_expire, $cookie_path);
        session_destroy();
    }

}

