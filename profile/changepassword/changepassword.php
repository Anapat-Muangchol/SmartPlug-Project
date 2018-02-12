<?php
header('Content-type: application/json');
require("../../classes/Member.php");
$member = new Member();
$form_data = file_get_contents('php://input');
$userData = json_decode($form_data);

//echo $userData->old_password . " | " . $userData->new_password;
if ($member->editPassword($userData->old_password, $userData->new_password)) {
    echo "true";
} else {
    echo "false";
}