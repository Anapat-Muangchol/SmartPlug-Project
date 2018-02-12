<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Import CSS and JS Library -->
    <?php require("../bin/include.php");
    require("../bin/checkSession.php");
    ?>

    <!-- Import CSS and JS Library -->
    <link rel="stylesheet" href="summary.css">
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all"/>

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
        <div id="render" class="row gutter">
            <!-- Plug Info -->
            <div id="plug-render" class='col-lg-4 col-md-4 col-sm-4 col-xs-12'>
            </div>
            <!-- End Plug Info -->
            <!-- Summary Info -->
            <div id="summary-render" style="color:#3e3e3e;" class='summary col-lg-8 col-md-8 col-sm-8 col-xs-12'>
                <form id="select-form">
                    <select id="select-outlets" class="select-time" name="outlet">

                    </select>
                    <select id="select-month" class="select-time" name="months">
                        <option value="January">January</option>
                        <option value="February">February</option>
                        <option value="March" selected>March</option>
                        <option value="April">April</option>
                        <option value="May">May</option>
                        <option value="June">June</option>
                        <option value="July">July</option>
                        <option value="August">August</option>
                        <option value="September">September</option>
                        <option value="October">October</option>
                        <option value="November">November</option>
                        <option value="December">December</option>
                    </select>
                    <select id="select-year" class="select-time" name="years">
                        <option value="2017">2017</option>
                    </select>
                    <input type="submit" id="submit-btn" class="btn btn-default" value="OK">
                </form>
                <div id="chartdiv" class="smart-plug-card-yellow"></div>
            </div>
            <!-- End Summary Info -->
        </div>
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

<!-- amChart -->
<script src="../../amcharts/amcharts.js"></script>
<script src="../../amcharts/serial.js"></script>
<script src="../../amcharts/themes/black.js"></script>
<script src="../../amcharts/plugins/export/export.min.js"></script>
<!-- self script -->
<script src="summary.js"></script>

<script>
    //add active link to sidemenu
    document.getElementById('summary_sidemenu').className += "active selected"
</script>
<!-- Custom JS -->
<script src="../js/custom.js"></script>
</body>
</html>