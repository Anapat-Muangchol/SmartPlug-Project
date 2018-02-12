<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Import CSS and JS Library -->
    <?php require("../../bin/include.php");
    require("../../bin/checkSession.php");
    ?>
    <link rel="stylesheet" href="plugdetail.css">
    <!-- Import CSS and JS Library -->
    <!-- OdoMeter CSS -->
    <link rel="stylesheet" href="../../css/odometer.css"/>
    <!-- Font Awesome CDN -->
    <script src="https://use.fontawesome.com/b42e023c7b.js"></script>
    <title>Your plug - Smart Plug</title>

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
        <div id="plug-detail" class='row gutter'>
            <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                <div id="plug-detail-form" class="smart-plug-card-yellow">
                    <form id="form-panel">
                        <div class="plug-detail-info">
                            <h3 id="name-of-plug">Loading...</h3>
                            <button type="button" class="btn btn-default" data-toggle="collapse"
                                    data-target="#edit-panel">Edit
                            </button>
                        </div>
                        <div id="edit-panel" class="collapse">
                            <div id="editDetailSuccessful" style="text-align: center">
                                <p style="font-size: 20vh; color:#ffffff">
                                    <i class="fa fa-check" aria-hidden="true"></i>
                                </p>
                            </div>
                            <div class="panel animated" style="border-top: 1px solid">
                                <div id="plug-name-panel" class="panel-body">
                                    <div class="styled-input">
                                        <div class="form-group">
                                            <label id="plug-name-label" for="plug-name">Name</label>
                                            <input type="text" class="form-control" id="plug-name"
                                                   placeholder="e.g. Jenny's room" value="">
                                            <span id="err-plug-name" class="err help-block" style="display:none;">*Require plug name</span>
                                        </div>
                                    </div>
                                </div>
                                <div id="plug-location-panel" class="panel-body">
                                    <div class="styled-input">
                                        <div class="form-group">
                                            <label id="plug-location-label" for="plug-location">Location</label>
                                            <input type="text" class="form-control" id="plug-location"
                                                   placeholder="e.g. 12/12 xxx xxx" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div id="delete-panel" class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="panel-body" style="padding-left: 15px;">
                                        <input type="button" id="delete-btn" data-toggle="modal"
                                               data-target="#del-confirm" class="btn btn-default"
                                               value="DELETE PLUG">
                                        <!-- Modal -->
                                        <div id="del-confirm" class="modal fade" role="dialog">
                                            <div class="modal-dialog">
                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close"
                                                                data-dismiss="modal">&times;</button>
                                                        <h4 class="modal-title">Delete this plug ?</h4>
                                                    </div>
                                                    <div class="modal-body" style="color: #ffffff">
                                                        This option will remove the plug, but you can it again.
                                                    </div>
                                                    <div class="modal-footer">
                                                        <input type="button" id="del-confirm-btn"
                                                               class="btn btn-default" value="Yes, delete it">
                                                        <button type="button" class="btn btn-default"
                                                                data-dismiss="modal">Cancel
                                                        </button>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="submit-panel" class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="panel-body" style="text-align: right;padding-right: 15px;">
                                        <input type="submit" id="submit-btn" class="btn btn-default" value="Save">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- outlets Info -->
        <div id="outlets-render" class='row gutter'>
        </div>
        <!-- End outlets Info -->
    </div>
    <!-- Container fluid ends -->
</div>
<script>
    var plug_id = <?php if (isset($_GET['plug_id'])) echo $_GET['plug_id']; else echo -1;?>
</script>
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
    document.getElementById('yourplugs_sidemenu').className += "active selected"
</script>
<!-- Paho MQTT -->
<script src="../../bin/mqttws31-min.js"></script>
<!-- Odometer JS -->
<script src="../../js/odometer/odometer.min.js"></script>
<!-- Self script -->
<script src="plugdetail.js"></script>
<!-- Custom JS -->
<script src="../../js/custom.js"></script>
<script>
    window.onload = function () {

    };
</script>
</body>
</html>
                                                                                                                     