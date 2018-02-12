<!DOCTYPE html>
<html lang="en">
<head>

    <!-- Import CSS and JS Library -->
    <?php require("../bin/include.php");
    require("../bin/checkSession.php");
    ?>
    <!-- Import CSS and JS Library -->

    <title>History - Smart Plug</title>

    <!-- Datepicker -->
    <link rel="stylesheet" href="../css/datepicker.css"/>

</head>

<body>

<!-- Header starts -->
<header>
    <?php require("../bin/header.php"); ?>
</header>
<!-- Header ends -->

<!-- Left sidebar start -->
<?php require("../bin/leftSidebar.php"); ?>
<!-- Left sidebar end -->

<!-- Dashboard Wrapper Start -->
<div class="dashboard-wrapper">

    <!-- Container fluid Starts -->
    <div class="container-fluid">

        <!-- Row starts -->
        <div class="row gutter">

            <div class="col-lg-8 col-md-9 col-sm-12 col-xs-12">
                <div class="panel">
                    <div class="panel-body">
                        <div id="history"></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                <div class="panel height2">
                    <div class="panel-heading">
                        <h4>Datepicker</h4>
                    </div>
                    <div class="panel-body no-padding">
                        <div id="datepicker"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Row ends -->

    </div>
    <!-- Container fluid ends -->

</div>
<!-- Dashboard Wrapper End -->

<script>
    //add active link to sidemenu
    document.getElementById('history_sidemenu').className += "active selected";
</script>

<script src="history.js"></script>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="../js/jquery.js"></script>


<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="../js/bootstrap.min.js"></script>

<!-- jquery ScrollUp JS -->
<script src="../js/scrollup/jquery.scrollUp.js"></script>

<!-- Datepicker -->
<script src="datepickup.js"></script>
<script>
    $(document).ready(function () {
        var d = new Date();
        var d = d.getFullYear() + "-" + (d.getMonth() + 1) + "-" + d.getDate();
        $.post("../api/api-event.php",
            {
                function: "getHistory",
                date: d
            }
            , function (data, status) {
                if (status === "success") {
                    data = JSON.parse(data);

                    var nf = new Intl.NumberFormat();
                    var his = "<ul class='project-activity'>";
                    if (data.lists.length == 0) {
                        $("#history").html("<h2>No History</h2>");
                        //alert("if");
                    } else {
                        for (var i = 0; i < data.lists.length; i++) {
                            if (data.lists[i].report_status == 0) {
                                his += "<li class='green'><div class='detail-info'><p class='date'>" + data.lists[i].report_time_event.substring(11, 16) + " &nbsp;&nbsp;<a class='text-red' href='#'>" + data.lists[i].report_plug_name + " " + data.lists[i].report_plug_location + "</a> &nbsp;&nbsp;<a class='text-red' href='#'>Outlet " + data.lists[i].report_outlet + "</a> &nbsp;&nbsp;<span style='color: green'>ON</span></p><p class='message'><p><span class='icon-power'></span>&nbsp;<span>" + data.lists[i].report_current_electronic + "</span>&nbsp;&nbsp;</p><hr></div></li>";
                                //alert("ON");
                            } else if (data.lists[i].report_status == 1) {
                                his += "<li class='red'><div class='detail-info'><p class='date'>" + data.lists[i].report_time_event.substring(11, 16) + " &nbsp;&nbsp;<a class='text-red' href='#'>" + data.lists[i].report_plug_name + " " + data.lists[i].report_plug_location + "</a> &nbsp;&nbsp;<a class='text-red' href='#'>Outlet " + data.lists[i].report_outlet + "</a> &nbsp;&nbsp;<span style='color: red'>OFF</span></p><p class='message'><p><span class='icon-power'></span>&nbsp;<span>" + data.lists[i].report_current_electronic + "</span>&nbsp;&nbsp;</p><p><span class='icon-clock2'></span>&nbsp;<span>";
                                var str = data.lists[i].report_time_duration;
                                var time = str.split(":");
                                his += calTime(time[0]) + " " + time[1] + " minutes";
                                his += "</span>&nbsp;&nbsp;<span class='icon-flash'></span>&nbsp;<span>" + data.lists[i].report_power_use + " Unit</span>&nbsp;&nbsp;</p><hr></div></li>";
                                //alert("OFF");
                            }

                        }
                        $("#history").html(his + "</ul>");
                    }

                }
            }
        )
    })


    $("#datepicker").datepicker({
        onSelect: function (dateText, inst) {
            var dateAsString = dateText; //the first parameter of this function
            var dateAsObject = $(this).datepicker('getDate'); //the getDate method
            var date = dateAsObject.getFullYear() + '-' + (dateAsObject.getMonth() + 1) + '-' + dateAsObject.getDate();
            //alert(date);

            $(document).ready(function () {
                $.post("../api/api-event.php",
                    {
                        function: "getHistory",
                        date: date
                    }
                    , function (data, status) {
                        if (status === "success") {
                            data = JSON.parse(data);

                            var nf = new Intl.NumberFormat();
                            var his = "<ul class='project-activity'>";
                            if (data.lists.length == 0) {
                                $("#history").html("<h2>No History</h2>");
                                //alert("if");
                            } else {
                                for (var i = 0; i < data.lists.length; i++) {
                                    if (data.lists[i].report_status == 0) {
                                        his += "<li class='green'><div class='detail-info'><p class='date'>" + data.lists[i].report_time_event.substring(11, 16) + " &nbsp;&nbsp;<a class='text-red' href='#'>" + data.lists[i].report_plug_name + " " + data.lists[i].report_plug_location + "</a> &nbsp;&nbsp;<a class='text-red' href='#'>Outlet " + data.lists[i].report_outlet + "</a> &nbsp;&nbsp;<span style='color: green'>ON</span></p><p class='message'><span class='icon-power'></span>&nbsp;<span>" + data.lists[i].report_current_electronic + "</span>&nbsp;&nbsp;</p><hr></div></li>";
                                        //alert("ON");
                                    } else if (data.lists[i].report_status == 1) {
                                        his += "<li class='red'><div class='detail-info'><p class='date'>" + data.lists[i].report_time_event.substring(11, 16) + " &nbsp;&nbsp;<a class='text-red' href='#'>" + data.lists[i].report_plug_name + " " + data.lists[i].report_plug_location + "</a> &nbsp;&nbsp;<a class='text-red' href='#'>Outlet " + data.lists[i].report_outlet + "</a> &nbsp;&nbsp;<span style='color: red'>OFF</span></p><p class='message'><p><span class='icon-power'></span>&nbsp;<span>" + data.lists[i].report_current_electronic + "</span>&nbsp;&nbsp;</p><p><span class='icon-clock2'></span>&nbsp;<span>";
                                        var str = data.lists[i].report_time_duration;
                                        var time = str.split(":");
                                        his += calTime(time[0]) + " " + time[1] + " minutes";
                                        his += "</span>&nbsp;&nbsp;<span class='icon-flash'></span>&nbsp;<span>" + data.lists[i].report_power_use + " Unit</span>&nbsp;&nbsp;</p><hr></div></li>";
                                        //alert("OFF");
                                    }

                                }
                                $("#history").html(his + "</ul>");
                            }

                        }
                    }
                )
            })

        }
    });

    function calTime(time) {
        time = parseInt(time);
        var ans = "";

        if (time >= 8760) {
            ans += Math.floor(time / 8760) + " years ";
            time = time % 8760;
        }

        if (time >= 720) {
            ans += Math.floor(time / 720) + " months ";
            time = time % 720;
        }
        if (time >= 168) {
            ans += Math.floor(time / 168) + " weeks";
            time = time % 168;
        }
        if (time >= 24) {
            ans += Math.floor(time / 24) + " days ";
            time = time % 24;
        }
        if (time > 0 && time < 24) {
            ans += time + " hours ";
        }

        return ans;
    }

</script>
<!--<script src="../js/jquery-ui.min.js"></script>-->

<!-- D3 JS -->
<script src="../js/d3/d3.v3.min.js"></script>

<!-- C3 Graphs -->
<script src="../js/c3/c3.min.js"></script>
<script src="../js/c3/c3.custom.js"></script>

<!-- JVector Map -->
<script src="../js/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="../js/jvectormap/usa.js"></script>

<!-- ION Slider -->
<script src="../js/ion-slider/ion.rangeSlider.min.js"></script>
<script src="../js/ion-slider/ion.custom.js"></script>

<!-- Gauge Meter JS -->
<script src="../js/gaugemeter/gaugeMeter-2.0.0.min.js"></script>
<script src="../js/gaugemeter/gaugemeter.custom.js"></script>

<!-- Rating JS -->
<script src="../js/rating/jquery.raty.js"></script>

<!-- Custom JS -->
<script src="../js/custom.js"></script>
<script src="../js/custom-widgets.js"></script>
</body>
</html>