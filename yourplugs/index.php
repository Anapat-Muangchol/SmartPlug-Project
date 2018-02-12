<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Import CSS and JS Library -->
    <?php require("../bin/include.php");
    require("../bin/checkSession.php");
    ?>

    <!-- Import CSS and JS Library -->
    <link rel="stylesheet" href="yourplugs.css">

    <!-- OdoMeter CSS -->
    <link rel="stylesheet" href="../css/odometer.css"/>

    <title>Your Plugs - Smart Plug</title>
</head>
<body>
<?php require("../bin/test_con.php"); ?>
<!-- Header starts -->
<header>
    <?php require("../bin/header.php"); ?>
</header>
<!-- Header ends -->

<!-- Left sidebar start -->
<?php require("../bin/leftSidebar.php"); ?>
<!-- Left sidebar end -->
<!-- Dashboard Wrapper Start -->
<div class="dashboard-wrapper bounceIn">
    <!-- Container fluid Starts -->
    <div class="container-fluid">
        <!-- Plug Info -->
        <div id="plug-render" class='row gutter'>
        </div>
        <!-- End Plug Info -->
    </div>
    <!-- Container fluid ends -->
</div>
<!-- Dashboard Wrapper End -->

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="../js/jquery.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="../js/bootstrap.min.js"></script>

<!-- jquery ScrollUp JS -->
<script src="../js/scrollup/jquery.scrollUp.js"></script>

<!-- Horizontal Bar JS -->
<script src="../js/horizontal-bar/horizBarChart.min.js"></script>
<script src="../js/horizontal-bar/horizBarCustom.js"></script>

<!-- Peity JS -->
<script src="../js/peity/peity.min.js"></script>
<script src="../js/peity/custom-peity.js"></script>

<!-- Circliful js -->
<script src="../js/circliful/circliful.min.js"></script>
<script src="../js/circliful/circliful.custom.js"></script>

<!-- Paho MQTT -->
<script src="../bin/mqttws31-min.js"></script>
<!-- Odometer JS -->
<script src="../js/odometer/odometer.min.js"></script>
<!-- self script Mock Plug Data -->
<script src="yourplugs.js"></script>

<script>
    //add active link to sidemenu
    document.getElementById('yourplugs_sidemenu').className += "active selected"
</script>
<!-- Custom JS -->
<script src="../js/custom.js"></script>
</body>
</html>