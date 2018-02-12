<!--
Todo show
email
first name
last name
phone number
member date(since)
-->

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Import CSS and JS Library -->
    <?php require("../bin/include.php");
    require("../bin/checkSession.php");
    ?>

    <link rel="stylesheet" href="profile.css">
    <!-- Import CSS and JS Library -->

    <title>Add Plug - Smart Plug</title>
</head>
<body>
<?php require("../bin/test_con.php"); ?>
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
    <?php require("../bin/header.php"); ?>
</header>
<!-- Header ends -->
<!-- Left sidebar start -->
<?php require("../bin/leftSidebar.php"); ?>
<?php
require("../classes/Member.php");
$member = new Member();
$memberDetail = $member->getMemberDetail();
?>
<!-- Left sidebar end -->
<!-- Dashboard Wrapper Start -->
<div class="dashboard-wrapper">
    <!-- Container fluid Starts -->
    <div class="container-fluid">
        <div class="row gutter">
            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
            <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div id="profile-title">
                        <div id="first-letter-fname">
                            <p>
                                <?php echo $memberDetail->member_first_name[0]; ?>
                            </p>
                        </div>
                        <div id="view-email-panel">
                        <span>
                            <?php echo $memberDetail->member_email; ?>
                        </span>
                        </div>
                        <div id="edit-password-panel">
                            <p style="font-size: 1.2em; text-align: center;">
                                <a style="color: white;" href="./changepassword/">
                                    <span class="icon-key" aria-hidden="true"></span> change password
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                    <div id="view-user" class="panel smart-plug-card-yellow">
                        <div id="view-fname-panel" class="panel-body">
                            Name:
                            <p><?php echo $memberDetail->member_first_name . " " . $memberDetail->member_last_name; ?></p>
                        </div>
                        <div id="view-tel-panel" class="panel-body">
                            Tel:<p><?php echo $memberDetail->member_telephone; ?></p>
                        </div>
                        <button type="submit" id="edit-btn" class="btn btn-default">Edit</button>
                    </div>
                    <div id="editable-user-form" style="display: none;" class="smart-plug-card-yellow">
                        <form id="form-panel">
                            <div class="panel animated">
                                <div id="fname-panel" class="panel-body">
                                    <div class="styled-input">
                                        <div class="form-group">
                                            <label id="fname-label" for="fname">First Name</label>
                                            <input type="text" class="form-control" id="fname"
                                                   placeholder="e.g. john"
                                                   value="<?php echo $memberDetail->member_first_name; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div id="lname-panel" class="panel-body">
                                    <div class="styled-input">
                                        <div class="form-group">
                                            <label id="lname-label" for="lname">Last Name</label>
                                            <input type="text" class="form-control" id="lname"
                                                   placeholder="e.g. Doe"
                                                   value="<?php echo $memberDetail->member_last_name; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div id="tel-panel" class="panel-body">
                                    <div class="styled-input">
                                        <div class="form-group">
                                            <label for="tel">Tel.</label>
                                            <input type="tel" class="form-control" id="tel"
                                                   placeholder="e.g. 082831982"
                                                   value="<?php echo $memberDetail->member_telephone; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="submit-panel">
                                <div class="panel-body">
                                    <button type="submit" id="submit-btn" class="btn btn-default">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
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
<!-- Self script -->
<script src="profile.js"></script>
<!-- Custom JS -->
<script src="../js/custom.js"></script>
<script>
    window.onload = function () {

    }
</script>
</body>
</html>

