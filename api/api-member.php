<?php

$function = $_POST['function'];

require("../classes/Member.php");
$object = new Member();

if ($function == "login") {
    $object->login($_POST['email'], $_POST['password']);

} elseif ($function == "update_api_key") {
    $object->update_api_key($_POST['member_id'], $_POST['email']);

} elseif ($function == "logout") {
    $object->logout();

}

//echo "test";
?>