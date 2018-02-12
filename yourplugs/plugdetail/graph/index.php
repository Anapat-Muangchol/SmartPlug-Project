<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Import CSS and JS Library -->
    <?php require("../../../bin/include.php"); ?>
    <link rel="stylesheet" href="graph.css">
    <!-- Import CSS and JS Library -->
    <!-- OdoMeter CSS -->
    <link rel="stylesheet" href="../../../css/odometer.css"/>

    <title>Graph - Smart Plug</title>

</head>
<body>
<?php require("../../../bin/test_con.php"); ?>
<!-- Header starts -->
<header>
    <?php require("../../../bin/header.php"); ?>
</header>
<!-- Header ends -->

<!-- Left sidebar start -->
<?php require("../../../bin/leftSidebar.php"); ?>
<!-- Left sidebar end -->
<!-- Dashboard Wrapper Start -->
<div class="dashboard-wrapper">
    <!-- Container fluid Starts -->
    <div class="container-fluid">
        <div class="row gutter">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="panel">
                    <div class="col-md-12">
                        <p>Plug <?php echo $_GET['plug_id']; ?> : Current use </p>
                        <div>
                            <i class="icon-bolt" style="color: yellow;"></i>&nbsp<span
                                    id="baconOdometer" class="odometer">0</span>&nbspA&nbsp<span id="up-or-down"></span>
                            <span style="position: absolute; right: 0px;"><label><input type="checkbox" id="auto-update"
                                                                                        onclick="clickUpdate()">&nbspAuto update</label></span>
                        </div>
                    </div>
                    <div class="social-details clearfix"></div>
                </div>
            </div>
        </div>
        <div class="row gutter">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="panel" style="height: auto">
                    <div class="panel-heading">
                        <h4 class="panel-title">Plug <?php echo $_GET['plug_id']; ?> Current use(amChart)</h4>
                    </div>
                    <div class="panel-body">
                        <div id='send-command-loading' class='cssload-container'>
                            <div class='cssload-shaft1'></div>
                            <div class='cssload-shaft2'></div>
                            <div class='cssload-shaft3'></div>
                            <div class='cssload-shaft4'></div>
                            <div class='cssload-shaft5'></div>
                            <div class='cssload-shaft6'></div>
                            <div class='cssload-shaft7'></div>
                            <div class='cssload-shaft8'></div>
                            <div class='cssload-shaft9'></div>
                            <div class='cssload-shaft10'></div>
                        </div>
                        <div id="chartdiv" style="display: block"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container fluid ends -->
</div>
<!-- Dashboard Wrapper End -->


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="../../../js/jquery.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="../../../js/bootstrap.min.js"></script>

<!-- Odometer JS -->
<script src="../../../js/odometer/odometer.min.js"></script>

<!-- jquery ScrollUp JS -->
<script src="../../../js/scrollup/jquery.scrollUp.js"></script>

<!-- Circliful js -->
<script src="../../../js/circliful/circliful.min.js"></script>
<script src="../../../js/circliful/circliful.custom.js"></script>

<!-- amChart -->
<script src="../../../../amcharts/amcharts.js"></script>
<script src="../../../../amcharts/serial.js"></script>
<!--script src="amcharts/plugins/export/export.min.js"></script-->
<!--script src="amcharts/plugins/export/export.css"></script-->
<script src="../../../../amcharts/themes/dark.js"></script>
<script>
    //add active link to sidemenu
    document.getElementById('yourplugs_sidemenu').className += "active selected"
</script>
<!-- get plug_id from get method -->
<script>
    var plug_id = <?php if (isset($_GET['plug_id'])) echo $_GET['plug_id']; else echo "-1";?>;
    var outlet_number = <?php if (isset($_GET['outlet_number'])) echo $_GET['outlet_number']; else echo "-1";?>;

    var oldCurrent = -1;

    var autoUpdated;
    function clickUpdate() {

        if (document.getElementById("auto-update").checked) {
            autoUpdated = setInterval(function () {
                autoUpdate();
            }, 5000);
            //alert("true");
        } else {
            clearInterval(autoUpdated);
            //alert("false");
        }
    }

    function autoUpdate() {
        var getCurrent = function () {
            var callBack = $.Deferred();
            var http = new XMLHttpRequest();
            var url = "../../../api/api-event.php";
            var params = "function=getCurrent&plug_id=" + plug_id + "&outlet_number=" + outlet_number + "&length=300";
            http.open("POST", url, true);

            //Send the proper header information along with the request
            http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

            http.onreadystatechange = function () {//Call a function when the state changes.
                if (http.readyState == 4 && http.status == 200) {
                    var JSONRsponse = JSON.parse(http.responseText);
                    if (JSONRsponse.status) {
                        //alert("success");
                        callBack.resolve(JSONRsponse.lists);
                    } else {
                        alert("error");
                        window.location = "../../";
                    }
                }
            };
            http.send(params);
            return callBack.promise();
        };

        /*
         Generate HTML from plug
         */
        var htmlRender = "";
        var divNodePlug = document.createElement("div");
        var indexItem = 0;

        var wait = getCurrent();
        wait.then(function (result) {
            genChart(result);
        })
    }

    /*
     Generate Chart
     */
    function genChart(result) {
        /*
         Variables
         */
        var currentList = result;
        var lastIndex = currentList.length - 1;

        if (oldCurrent == -1) {
            document.getElementById('up-or-down').innerHTML = "";
        } else if (oldCurrent > currentList[lastIndex].used_current) {
            document.getElementById('up-or-down').innerHTML = "<i class='icon-triangle-down' style='color: green;'></i>";
        } else if (oldCurrent < currentList[lastIndex].used_current) {
            document.getElementById('up-or-down').innerHTML = "<i class='icon-triangle-up' style='color: red;'></i>";
        } else {
            document.getElementById('up-or-down').innerHTML = "";
        }
        oldCurrent = currentList[lastIndex].used_current;
        document.getElementById('baconOdometer').innerHTML = currentList[lastIndex].used_current;


        /*
         functions
         */

        /*
         amChart
         */
        var drawChart = function (result) {
            var chartData = result;
            var chart = AmCharts.makeChart("chartdiv", {
                "type": "serial",
                "theme": "dark",
                "marginRight": 80,
                "dataProvider": result,
                "valueAxes": [{
                    "position": "left",
                    "title": "consume"
                }],
                "graphs": [{
                    "id": "g1",
                    "fillAlphas": 0.4,
                    "valueField": "visits",
                    "balloonText": "<div style='margin:5px; font-size:19px;'>Consume(amp):<b>[[value]]</b></div>"
                }],
                "chartScrollbar": {
                    "graph": "g1",
                    "scrollbarHeight": 80,
                    "backgroundAlpha": 0,
                    "selectedBackgroundAlpha": 0.1,
                    "selectedBackgroundColor": "#888888",
                    "graphFillAlpha": 0,
                    "graphLineAlpha": 0.5,
                    "selectedGraphFillAlpha": 0,
                    "selectedGraphLineAlpha": 1,
                    "autoGridCount": true,
                    "color": "#AAAAAA"
                },
                "chartCursor": {
                    "categoryBalloonDateFormat": "JJ:NN, DD MMMM",
                    "cursorPosition": "mouse"
                },
                "categoryField": "date",
                "categoryAxis": {
                    "minPeriod": "mm",
                    "parseDates": true
                },
                "export": {
                    "enabled": true,
                    "dateFormat": "YYYY-MM-DD HH:NN:SS"
                }
            });
            var hideLoader = new Promise(function (resolve, reject) {
                document.getElementById("send-command-loading").style.display = "none";
                if (document.getElementById("send-command-loading").style.display === "none") {
                    resolve();
                }
            });
            hideLoader.then(function () {
                document.getElementById("chartdiv").style.display = "block";
            });

            chart.addListener("dataUpdated", zoomChart);
            // when we apply theme, the dataUpdated event is fired even before we add listener, so
            // we need to call zoomChart here
            zoomChart();
            // this method is called when chart is first inited as we listen for "dataUpdated" event
            function zoomChart() {
                // different zoom methods can be used - zoomToIndexes, zoomToDates, zoomToCategoryValues
                chart.zoomToIndexes(0, chartData.length - 1);
            }
        };

        // generate times
        var generateChartData = function () {
            var chartData = [];
            for (var i = 0; i < currentList.length; i++) {
                // add data item to the array
                chartData.push({
                    date: currentList[i].used_time,
                    visits: currentList[i].used_current
                });
                if (i === currentList.length - 1) {
                    drawChart(chartData);
                }
            }
        };
        generateChartData();

        /*
         call
         */

        //random value to show
        //var intervalRandom = setInterval(upOrdown, 3000);


        // generate times
        /*
         function generateChartData() {
         var chartData = [];
         // set date date
         var firstDate = new Date('October 31, 2016 00:00:00');

         // and generate 1 day minutes
         for (var i = 0; i < 480; i++) {
         var newDate = new Date(firstDate);
         // each time we add one minute
         newDate.setMinutes(newDate.getMinutes() + (i*3));
         // add data item to the array
         chartData.push({
         date: newDate,
         visits: amChartData[i]
         });
         }
         return chartData;
         }*/
    }
</script>
<!-- Self script -->
<script src="graph.js"></script>
<!-- Custom JS -->
<script src="../../../js/custom.js"></script>

</body>
</html>
