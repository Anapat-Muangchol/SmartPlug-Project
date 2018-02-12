<?php
header('Content-type: application/json');
require("../classes/Member.php");
$member = new Member();
$form_data = file_get_contents('php://input');
$userData = json_decode($form_data);

$member->login($userData->email, $userData->password);

if ($userData->remember == "yes") {
    $cookie_expire = time() + (86400 * 15);
    $cookie_path = "/";
    $cookie_member_id = $_SESSION["member_id"];
    $cookie_member_fname = $_SESSION["member_first_name"];
    $cookie_member_lname = $_SESSION["member_last_name"];
    $cookie_member_api_key = $_SESSION['member_api_key'];
    setcookie("member_id", $cookie_member_id, $cookie_expire, $cookie_path);
    setcookie("member_first_name", $cookie_member_fname, $cookie_expire, $cookie_path);
    setcookie("member_last_name", $cookie_member_lname, $cookie_expire, $cookie_path);
    setcookie("member_api_key", $cookie_member_api_key, $cookie_expire, $cookie_path);
}