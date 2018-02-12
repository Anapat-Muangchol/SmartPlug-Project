<?php
header('Content-type: application/json');
require("../classes/Member.php");
$member = new Member();
$form_data = file_get_contents('php://input');
$userData = json_decode($form_data);

$member->edit($userData->fname, $userData->lname, $userData->tel);
$_SESSION["member_first_name"] = $userData->fname;

//    echo
//    "
//    =======================
//    $userData->fname<br>
//    $userData->lname<br>
//    $userData->tel<br>
//    =======================<br>
//    ";

