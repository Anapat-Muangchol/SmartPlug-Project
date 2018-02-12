<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Import CSS and JS Library -->
    <?php require("../../bin/include.php"); ?>
    <!-- Import CSS and JS Library -->
    <!-- Title -->
    <title>Your Plugs - Smart Plug</title>
    <!-- C3 CSS -->
    <link href="../../css/c3/c3.css" rel="stylesheet"/>
    <!-- OdoMeter CSS -->
    <link rel="stylesheet" href="../../css/odometer.css"/>
    <style>
        @-webkit-keyframes moving-dashes {
            100% {
                stroke-dashoffset: -30px;
            }
        }
        @keyframes moving-dashes {
            100% {
                stroke-dashoffset: -30px;
            }
        }
        .c3-line {
            stroke-dasharray: 3px;
            stroke-linecap: round;
            stroke-linejoin: round;
            animation: moving-dashes 3s linear infinite;
        }
        #chartdiv {
            width: 100%;
            height: 500px;
        }
    </style>

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
        <!-- Row starts -->
        <div class="row gutter">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="panel">
                    <div class="col-md-12">
                        <p>Plug 1 : Current use </p>
                        <div><i class="icon-bolt" style="color: yellow;"></i>&nbsp<span
                                    id="baconOdometer" class="odometer">145</span>&nbspA&nbsp<span
                                    id="up-or-down"></span></div>
                    </div>
                    <div class="social-details clearfix"></div>
                </div>
            </div>
        </div>
        <!-- Row ends -->
        <!-- Row starts -->
        <div class="row gutter">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="panel height2">
                    <div class="panel-heading">
                        <h4 class="panel-title">Plug 1 Current use</h4>
                    </div>
                    <div class="panel-body">
                        <div id="currentUseGraph" class="chart-height1"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Row ends -->
        <!-- Row starts amChart here-->
        <div class="row gutter">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="panel" style="height: auto">
                    <div class="panel-heading">
                        <h4 class="panel-title">Plug 1 Current use(amChart)</h4>
                    </div>
                    <div class="panel-body">
                        <div id="chartdiv"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Row ends amChart here-->
    </div>
    <!-- Container fluid ends -->
</div>
<!-- Dashboard Wrapper End -->

<!-- Footer Start -->
<footer>
    <?php echo file_get_contents("bin/footer.html"); ?>
</footer>
<!-- Footer end -->

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="../../js/jquery.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="../../js/bootstrap.min.js"></script>

<!-- Sparkline Graphs -->
<!-- <script src="js/sparkline/sparkline.js"></script> -->
<script src="../../js/sparkline/retina.js"></script>
<script src="../../js/sparkline/custom-sparkline.js"></script>

<!-- jquery ScrollUp JS -->
<script src="../../js/scrollup/jquery.scrollUp.js"></script>

<!-- D3 JS -->
<script src="../../js/d3/d3.v3.min.js"></script>
<script src="../../js/d3/d3.powergauge.js"></script>

<!-- C3 Graphs -->
<script src="../../js/c3/c3.min.js"></script>
<script src="../../js/c3/c3.custom.js"></script>

<!-- NVD3 JS -->
<script src="../../js/nvd3/nv.d3.js"></script>
<script src="../../js/nvd3/nv.d3.custom.boxPlotChart.js"></script>

<!-- Horizontal Bar JS -->
<script src="../../js/horizontal-bar/horizBarChart.min.js"></script>
<script src="../../js/horizontal-bar/horizBarCustom.js"></script>

<!-- Gauge Meter JS -->
<script src="../../js/gaugemeter/gaugeMeter-2.0.0.min.js"></script>
<script src="../../js/gaugemeter/gaugemeter.custom.js"></script>

<!-- Odometer JS -->
<script src="../../js/odometer/odometer.min.js"></script>
<script>
    window.onload = function () {
        /*
         Variables
         */

        var beforeVal = document.getElementById('baconOdometer').value;

        //store current uses
        var amp = ['Plug 1',145];


        //alert(beforeVal);

        /*
         functions
         */

        //add active link to sidemenu
        document.getElementById('yourplugs_sidemenu').className += "active selected";

        //must have
        var timeout;
        function graphUpdate(){
            // add new data point to the end
            var newDate = new Date( chart.dataProvider[ chart.dataProvider.length - 1 ].date );
            // each time we add five minute
            newDate.setMinutes( newDate.getMinutes() + 5 );
            var afterVal = Math.floor((Math.random() * 100) + 10);
            amp.push(afterVal);

            document.getElementById('baconOdometer').innerHTML = afterVal;
            if (beforeVal < afterVal) {
                document.getElementById('up-or-down').innerHTML = "<i class='icon-triangle-up' style='color: red;'></i>";
            } else if (beforeVal > afterVal) {
                document.getElementById('up-or-down').innerHTML = "<i class='icon-triangle-down' style='color: green;'></i>";
            } else {
                document.getElementById('up-or-down').innerHTML = "";
            }

            console.log(amp);
            // update c3 graph
            currentUseChart.load({
                columns: [
                    amp
                ]
            });
            // update amChart
            chart.dataProvider.push({
                date: newDate,
                consume: afterVal
            });
            beforeVal = afterVal;
            //must have
            if (timeout)
                clearTimeout(timeout);
            timeout = setTimeout(function () {
                chart.validateData();
            });
        }

        /*
         call
         */

        //random value to show
        setInterval(graphUpdate, 5000);

        /*
         c3 graph
         */
        var currentUseChart = c3.generate({
            bindto: '#currentUseGraph',
            data: {
                columns: [
                    ['Plug 1', 145]
                ],
                type: 'area-spline'
                ,
                name: 'Plug 1'
                ,
                color: '#BF7A6A'

            },
            zoom: {
                enabled: true
            }
        });

        /*
         amChart
         */
        var chartData = generateChartData();
        var chart = AmCharts.makeChart("chartdiv", {
            "type": "serial",
            "theme": "dark",
            "marginRight": 80,
            "dataProvider": chartData,
            "valueAxes": [{
                "position": "left",
                "title": "consume"
            }],
            "graphs": [{
                "id": "g1",
                "fillAlphas": 0.4,
                "valueField": "consume",
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

        chart.addListener("dataUpdated", zoomChart);
        // when we apply theme, the dataUpdated event is fired even before we add listener, so
        // we need to call zoomChart here
        zoomChart();
        // this method is called when chart is first inited as we listen for "dataUpdated" event
        function zoomChart() {
            // different zoom methods can be used - zoomToIndexes, zoomToDates, zoomToCategoryValues
            chart.zoomToIndexes(0, chartData.length - 1);
        }
        // generate some random data, quite different range
        function generateChartData() {
            var chartData = [];
            // current date
            var firstDate = new Date('October 31, 2016 00:00:00');

            for ( var i = 0; i < 1; i++ ) {
                var newDate = new Date( firstDate );
                newDate.setMinutes( newDate.getMinutes() + i );
                // add data item to the array
                chartData.push( {
                    date: newDate,
                    consume: 145
                } );
            }
            return chartData;
        }

    };

</script>
<!-- amChart -->
<script src="../../../amcharts/amcharts.js"></script>
<script src="../../../amcharts/serial.js"></script>
<script src="../../../amcharts/themes/dark.js"></script>

<!-- Peity JS -->
<script src="../../js/peity/peity.min.js"></script>
<script src="../../js/peity/custom-peity.js"></script>

<!-- Circliful js -->
<script src="../../js/circliful/circliful.min.js"></script>
<script src="../../js/circliful/circliful.custom.js"></script>

<!-- Custom JS -->
<script src="../../js/custom.js"></script>
</body>
</html>