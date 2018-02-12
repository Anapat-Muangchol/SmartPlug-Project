<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Import CSS and JS Library -->
    <?php require("../../bin/include.php");
    require("../../bin/checkSession.php");
    ?>
    <link rel="stylesheet" href="changepassword.css">
    <!-- Import CSS and JS Library -->
    <!-- Font Awesome CDN -->
    <script src="https://use.fontawesome.com/b42e023c7b.js"></script>
    <title>Add Plug - Smart Plug</title>

</head>
<body>
<?php require("../../bin/test_con.php"); ?>
<!-- Loading starts -->
<!--<div class="loading-wrapper">-->
<!--    <div class="loading">-->
<!--        <h5>Loading...</h5>-->
<!--        <span></span>-->
<!--        <span></span>-->
<!--        <span></span>-->
<!--        <span></span>-->
<!--        <span></span>-->
<!--        <span></span>-->
<!--    </div>-->
<!--</div>-->
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
                <div id="password-change-successful" style="display: none;text-align: center">
                    <p style="font-size: 20vh; color:#38c530">
                        <i class="fa fa-check" aria-hidden="true"></i>
                    </p>
                    <p style="color: white;">Your password has been changed.</p>
                    <p style="font-size: 1.2em;">
                        <a style="color: #FFEB3B;" href="../../yourplugs">
                            <b>Continue </b><i class="fa fa-arrow-right" aria-hidden="true"></i>
                        </a>
                    </p>
                </div>
                <div id="change-password-form" class="smart-plug-card-yellow">
                    <form id="form-panel">
                        <div class="lists-of-secure-pw">
                            <p>Use Strong password that easy to remember but hard for other to guess.</p>
                            <p>Strong password must have:</p>
                            <ul>
                                <li>at least 8 characters.</li>
                                <li>numbers.</li>
                                <li>characters.</li>
                            </ul>
                        </div>
                        <div class="panel animated" style="border-top: 1px solid">
                            <div id="old-password-panel" class="panel-body">
                                <div class="styled-input">
                                    <div class="form-group">
                                        <label id="old-password-label" for="old-password">Current password</label>
                                        <input type="password" class="form-control" id="old-password"
                                               placeholder="your current password...">
                                    </div>
                                </div>
                            </div>
                            <div id="new-password-panel" class="panel-body">
                                <div class="styled-input">
                                    <div class="form-group">
                                        <label id="new-password-label" for="new-password">New password</label>
                                        <input type="password" class="form-control" id="new-password"
                                               placeholder="new password...">
                                    </div>
                                </div>
                            </div>
                            <div id="new-password-confirm-panel" class="panel-body">
                                <div class="styled-input">
                                    <div class="form-group">
                                        <label id="new-password-confirm-label" for="new-password-confirm">Confirm new
                                            password</label>
                                        <input type="password" class="form-control" id="new-password-confirm"
                                               placeholder="type new password again...">
                                    </div>
                                    <p id="err-pw-text" style="display: none">Your new password doesn't match.</p>
                                </div>
                            </div>
                        </div>
                        <div id="submit-panel">
                            <div class="panel-body" style="text-align: right;padding-right: 15px;">
                                <input type="submit" id="submit-btn" class="btn btn-default" value="Save">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
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
<!-- Self script -->
<script src="changepassword.js"></script>
<!-- Custom JS -->
<script src="../../js/custom.js"></script>
<script>

</script>
</body>
</html>

