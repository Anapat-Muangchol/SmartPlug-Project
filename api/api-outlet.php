<?php

$function = $_POST['function'];

require("../classes/Outlet.php");
$object = new Outlet();

if ($function == "getDetailPlugByID") {
    $object->getDetailPlugByID($_POST['plug_id']);
} elseif ($function == "getOutletRealtime") {
    $object->getOutletRealtime($_POST['plug_id'], $_POST['outlet_number']);
} elseif ($function == "getAllOutletInPlug") {
    $object->getAllOutletInPlug($_POST['plug_id']);
} elseif ($function == "powerOutletOff") {
    $object->powerOutletOff($_POST['plug_id'], $_POST['outlet_number']);
} elseif ($function == "powerOutletOn") {
    $object->powerOutletOn($_POST['plug_id'], $_POST['outlet_number']);
} elseif ($function == "changeElectronic") {
    $object->changeElectronic($_POST['plug_id'], $_POST['outlet_number'], $_POST['electronic']);
}


?>