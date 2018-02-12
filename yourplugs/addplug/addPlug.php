<?php
header('Content-type: application/json');
require("../../classes/Plug.php");
$plug = new Plug();
$form_data = file_get_contents('php://input');
$plugData = json_decode($form_data);
$plug->plugOwner($plugData->plugCode, $plugData->plugName, $plugData->plugLocation);
//$stmt = mysqli_prepare($plug->db_link, "SELECT `plug_id` FROM `SMP_Plug` WHERE `plug_code` = ?");
//mysqli_stmt_bind_param($stmt, 's', $plugData->plugCode);
//mysqli_stmt_execute($stmt);
//mysqli_stmt_bind_result($stmt, $plugID);
//mysqli_stmt_fetch($stmt);
//$plug->editPlugDesc($plugID, $plugData->plugName, $plugData->plugLocation);
//echo $plugID;
//echo $plugData->plugName;
//echo $plugData->plugLocation;
