<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Import CSS and JS Library -->
    <?php require("../../bin/include.php");
    require("../../bin/checkSession.php");
    ?>
    <link rel="stylesheet" href="addplug.css">
    <!-- Import CSS and JS Library -->
    <!-- Font Awesome CDN -->
    <script src="https://use.fontawesome.com/b42e023c7b.js"></script>
    <title>Add Plug - Smart Plug</title>

</head>
<body>
<?php require("../../bin/test_con.php"); ?>
<!-- Header starts -->
<header>
    <?php require("../../bin/header.php"); ?>
</header>
<!-- Header ends -->

<!-- Left sidebar start -->
<?php require("../../bin/leftSidebar.php"); ?>
<!-- Left sidebar end -->
<!-- Dashboard Wrapper Start -->
<div class="dashboard-wrapper">
    <!-- Container fluid Starts -->
    <div class="container-fluid">
        <div class="row gutter">
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"></div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div id="plugAddSuccessful" style="display: none;text-align: center">
                    <p style="font-size: 20vh; color:#38c530">
                        <i class="fa fa-check" aria-hidden="true"></i>
                    </p>
                    <p style="color: white;">Your plug has been added.</p>
                    <p style="font-size: 1.2em;">
                        <a style="color: #FFEB3B;" href="#" id="add-more-btn">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i><b> add more</b>
                        </a>
                        &nbsp;|&nbsp;
                        <a style="color: #FFEB3B;" href="../../yourplugs">
                            <b>Continue </b><i class="fa fa-arrow-right" aria-hidden="true"></i>
                        </a>
                    </p>
                </div>
                <div id="plugForm" class="smart-plug-card-yellow">
                    <form class="animated">
                        <div class="plug-title">
                            <p><span class="icon-cord"></span>&nbsp;<b>Plug&nbsp;Detail</b></p>
                        </div>
                        <div class="panel">
                            <div class="panel-body">
                                <div class="styled-input-wrapper">
                                    <div class="input-icon">
                                        <i class="icon-cord"></i>
                                    </div>
                                    <div class="styled-input">
                                        <div class="form-group">
                                            <label for="plugName">Plug name</label>
                                            <input type="text" class="form-control" id="plugName"
                                                   placeholder="e.g. Jenny's room">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="styled-input-wrapper">
                                    <div class="input-icon">
                                        <i class="icon-key"></i>
                                    </div>
                                    <div class="styled-input">
                                        <div class="form-group">
                                            <label for="plugBarcode">Plug code<span
                                                        style="color: #E91E63; font-size: 16pt;">*</span></label>
                                            <input type="text" class="form-control" id="plugCode"
                                                   placeholder="e.g. XX:XX:XX:XX:XX:XX" autofocus>
                                            <span id="err" class="help-block"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="styled-input-wrapper">
                                    <div class="input-icon">
                                        <i class="icon-location"></i>
                                    </div>
                                    <div class="styled-input">
                                        <div class="form-group">
                                            <label for="plugLocation">Plug location</label>
                                            <input type="text" class="form-control" id="plugLocation"
                                                   placeholder="e.g. 12/12 xxx xxx">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <button type="submit" id="submit-btn" class="btn btn-default"
                                >Submit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"></div>
        </div>
    </div>
    <!-- Container fluid ends -->
</div>
<!-- Dashboard Wrapper End -->

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="../../js/jquery.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="../../js/bootstrap.min.js"></script>

<!-- jquery ScrollUp JS -->
<script src="../../js/scrollup/jquery.scrollUp.js"></script>

<!-- Horizontal Bar JS -->
<script src="../../js/horizontal-bar/horizBarChart.min.js"></script>
<script src="../../js/horizontal-bar/horizBarCustom.js"></script>

<!-- Peity JS -->
<script src="../../js/peity/peity.min.js"></script>
<script src="../../js/peity/custom-peity.js"></script>

<!-- Circliful js -->
<script src="../../js/circliful/circliful.min.js"></script>
<script src="../../js/circliful/circliful.custom.js"></script>
<script>
    //add active link to sidemenu
    document.getElementById('addplug_sidemenu').className += "active selected"
</script>
<!-- Self script -->
<script src="addPlug.js"></script>
<!-- Custom JS -->
<script src="../../js/custom.js"></script>
<script>

</script>
</body>
</html>
