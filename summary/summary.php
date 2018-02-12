<?php
header('Content-type: application/json');
require("../classes/Graph.php");
$graph = new Graph();
$form_data = file_get_contents('php://input');
$userData = json_decode($form_data);
$graph->getCurrent($userData->plugID, $userData->outletNumber, $userData->length);