<?php
header('Content-type: application/json');
require("../../classes/Plug.php");
$plug = new Plug();
$form_data = file_get_contents('php://input');
$plugData = json_decode($form_data);
$plug->cancelPlugOwner($plugData->plugID);