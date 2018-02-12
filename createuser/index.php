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
    if ($_SESSION['member_id']) { ?>
        <script>
            window.location.assign("<?php echo $base_url; ?>dev/arisethem/yourplugs");
        </script>
        <?php
    }
    ?>
    <!-- Font Awesome CDN -->
    <script src="https://use.fontawesome.com/b42e023c7b.js"></script>
    <link rel="stylesheet" href="createuser.css">
    <!-- Import CSS and JS Library -->
    <title>Create Account - Smart Plug</title>

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

<!-- Dashboard Wrapper Start -->
<div class="dashboard-wrapper">
    <!-- Container fluid Starts -->
    <div style="margin-top: 21px;" class="container-fluid">
        <div class="row gutter">
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"></div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <p id="back-btn" style="font-size: 1.2em;">
                    <a style="color: #FFEB3B;" href="../signin/">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i><b> Back to Sign in</b>
                    </a>
                </p>
                <div class="panel text-white smart-plug-card-yellow" style="margin-top: 10px">
                    <div class="panel-heading center-text">Let's create your account!</div>
                    <div id="chat-div" class="panel-body chat-height" style="overflow-y: auto;overflow-x: hidden;">
                        <!-- Message -->
                        <ul id="chats-box" class="chats">
                        </ul>
                        <!-- Message end-->
                    </div>
                    <div id="chat-input">
                        <form id="message-input">
                            <div class="form-group">
                                <div>
                                    <input type="text" class="form-control" id="user-input"
                                           placeholder="type message..." disabled>
                                    <span id="span-icon-eye" style="display: none"
                                          class="input-group-addon"><i id="i-icon-eye"></i></span>
                                </div>
                            </div>
                        </form>
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
<script src="../js/jquery.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="../js/bootstrap.min.js"></script>

<!-- jquery ScrollUp JS -->
<script src="../js/scrollup/jquery.scrollUp.js"></script>

<!-- Circliful js -->
<script src="../js/circliful/circliful.min.js"></script>
<script src="../js/circliful/circliful.custom.js"></script>
<!-- Self script -->
<script src="createuser.js"></script>
<script>
    window.onload = function () {

    }
</script>
</body>
</html>

