<?php
header('Content-type: application/json');
require("../classes/Member.php");
$member = new Member();
$form_data = file_get_contents('php://input');
$userData = json_decode($form_data);

$e_mail = $userData->e_mail;

if ($member->isFoundEmail($e_mail)) {
    echo "true";
} else {
    echo "false";
}

//echo
//"
//    =======================
//    $userData->fname<br>
//    $userData->lname<br>
//    $userData->e_mail<br>
//    $userData->pw<br>
//    $userData->plugID<br>
//    $userData->tel_phone<br>
//    =======================<br>
//    ";