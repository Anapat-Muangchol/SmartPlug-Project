<?php
header('Content-type: application/json');
require("../../classes/Plug.php");
$plug = new Plug();
$form_data = file_get_contents('php://input');
$userData = json_decode($form_data);

$plugCode = $userData->plugCode;

if ($plug->checkCodePlug($plugCode)) {
    echo "true";
} else {
    echo "false";
}