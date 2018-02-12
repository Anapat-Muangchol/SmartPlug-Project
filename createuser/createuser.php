<?php
header('Content-type: application/json');
require("../classes/Member.php");
$member = new Member();
$form_data = file_get_contents('php://input');
$userData = json_decode($form_data);

$NO_DATA = "s4+K";

$fname = $userData->fname;
$lname = $userData->lname;
$e_mail = $userData->e_mail;
$pw = $userData->pw;
$tel_phone = $userData->tel_phone;

if ($tel_phone === $NO_DATA) {
    $tel_phone = "";
}

$member->register($e_mail, $pw, $fname, $lname, $tel_phone);

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