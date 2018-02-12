<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Import CSS and JS Library -->
    <?php require("../../bin/include.php"); ?>
    <link rel="stylesheet" href="addplug.css">
    <!-- Import CSS and JS Library -->

    <title>Add Plug - Smart Plug</title>

</head>
<body>
<?php require("../../bin/test_con.php"); ?>
<!-- Loading starts -->
<div class="loading-wrapper">
    <div class="loading">
        <h5>Loading...</h5>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>
</div>
<!-- Loading ends -->
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
                <div id="plugForm">
                    <form class="animated">
                        <div class="plug-title gradient-ffc107-ff9800-diagonal">
                            <p><span class="icon-cord"></span>&nbsp;<b>Plug&nbsp;1</b></p>
                        </div>
                        <div class="line-red"></div>
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
                                                   placeholder="plug name here">
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
                                            <label for="plugBarcode">Plug barcode</label>
                                            <input type="text" class="form-control" id="plugBarcode"
                                                   placeholder="code here" required autofocus>
                                            <span id="err-1" class="help-block">*please fill your plug code</span>
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
                                                   placeholder="plug location here">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" style="display: none"></button>
                    </form>
                </div>

                <div id="submit-panel" class="panel animated">
                    <div class="panel-body">
                        <div class="no-margin">
                            <button type="submit" id="submit-btn" class="btn btn-default" disabled><b>Submit</b>
                            </button>
                            <button type="button" id="more-btn" class="btn btn-default" disabled>Add more...</button>
                        </div>
                    </div>
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
<script src="addPlug_old.js"></script>
<!-- Custom JS -->
<script src="../../js/custom.js"></script>
<script>
    window.onload = function () {
        document.querySelector("form").className += " bounceInUp";
        setTimeout(function () {
            document.querySelector("#submit-panel").className += " bounceInUp";
        }, 250)
    };
</script>
</body>
</html>
