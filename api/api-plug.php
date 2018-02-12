<?php

$function = $_POST['function'];

require("../classes/Plug.php");
$object = new Plug();

if ($function == "getDetailAllPlug") {
    $object->getDetailAllPlug();
} elseif ($function == "checkCodePlug") {
    if ($object->checkCodePlug($_POST['plug_code'])) {
        echo "{\"status\": true}";
    } else {
        echo "{\"status\": false}";
    }
} elseif ($function == "plugOwner") {
    $object->plugOwner($_POST['plug_code']);
} elseif ($function == "powerPlugOff") {
    $object->powerPlugOff($_POST['plug_id']);
} elseif ($function == "powerPlugOn") {
    $object->powerPlugOn($_POST['plug_id']);
} elseif ($function == "getPlugRealtime") {
    $object->getPlugRealtime($_POST['plug_id']);
} elseif ($function == "checkPlugOwner") {
    if ($object->checkPlugOwner($_POST['plug_id'])) {
        echo "{\"status\": true}";
    } else {
        echo "{\"status\": false}";
    }
} elseif ($function == "checkPlugOwnerAndNumOfOutlet") {
    if ($object->checkPlugOwnerAndNumOfOutlet($_POST['plug_id'], $_POST['outlet_number'])) {
        echo "{\"status\": true}";
    } else {
        echo "{\"status\": false}";
    }
} elseif ($function == "editPlugDesc") {
    $object->editPlugDesc($_POST['plug_id'], $_POST['plug_name'], $_POST['plug_location']);
} elseif ($function == "cancelPlugOwner") {
    $object->cancelPlugOwner($_POST['plug_id']);
}


?>