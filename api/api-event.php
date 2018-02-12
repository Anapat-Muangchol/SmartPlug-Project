<?php

$function = $_POST['function'];

if ($function == "getCurrent") {
    require("../classes/Graph.php");
    $object = new Graph();

    $object->getCurrent($_POST['plug_id'], $_POST['outlet_number'], $_POST['length']);
} elseif ($function == "searchPlug") {
    require("../classes/Search.php");
    $object = new Search();

    $object->searchPlug($_POST['keyword']);
} elseif ($function == "getHistory") {
    require("../classes/Search.php");
    $object = new Search();

    $object->getHistory($_POST['date']);
} elseif ($function == "getSummary") {
    require("../classes/Search.php");
    $object = new Search();

    $object->getSummary($_POST['plug_id'], $_POST['outlet_number'], $_POST['month'], $_POST['year']);
} elseif ($function == "getUnit") {
    require("../classes/Search.php");
    $object = new Search();

    $object->getUnit($_POST['plug_id'], $_POST['outlet_number'], $_POST['month'], $_POST['year']);
}

//echo "test";
?>