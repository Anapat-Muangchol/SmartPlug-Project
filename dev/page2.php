<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Import CSS and JS Library -->
    <?php echo file_get_contents("bin/include.html"); ?>
    <!-- Import CSS and JS Library -->

    <!-- C3 CSS -->
    <link href="css/c3/c3.css" rel="stylesheet"/>
    <!-- OdoMeter CSS -->
    <link rel="stylesheet" href="css/odometer.css"/>

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
    <?php require("bin/header.php"); ?>
</header>
<!-- Header ends -->

<!-- Left sidebar start -->
<?php require("bin/leftSidebar.php"); ?>
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
                                id="baconOdometer" class="odometer">0</span>&nbspA&nbsp<span id="up-or-down"></span>
                        </div>
                    </div>
                    <div class="social-details clearfix"></div>
                </div>
            </div>
        </div>
        <!-- Row ends -->
        <!-- Row starts -->
        <!--div class="row gutter">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="panel height2">
                    <div class="panel-heading">
                        <h4 class="panel-title">Plug 1 Current use(c3 graph)</h4>
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
<script src="js/jquery.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>

<!-- Sparkline Graphs -->
<!-- <script src="js/sparkline/sparkline.js"></script> -->
<script src="js/sparkline/retina.js"></script>
<script src="js/sparkline/custom-sparkline.js"></script>

<!-- jquery ScrollUp JS -->
<script src="js/scrollup/jquery.scrollUp.js"></script>

<!-- D3 JS -->
<script src="js/d3/d3.v3.min.js"></script>
<script src="js/d3/d3.powergauge.js"></script>

<!-- C3 Graphs -->
<script src="js/c3/c3.min.js"></script>
<script src="js/c3/c3.custom.js"></script>

<!-- NVD3 JS -->
<script src="js/nvd3/nv.d3.js"></script>
<script src="js/nvd3/nv.d3.custom.boxPlotChart.js"></script>

<!-- Horizontal Bar JS -->
<script src="js/horizontal-bar/horizBarChart.min.js"></script>
<script src="js/horizontal-bar/horizBarCustom.js"></script>

<!-- Gauge Meter JS -->
<script src="js/gaugemeter/gaugeMeter-2.0.0.min.js"></script>
<script src="js/gaugemeter/gaugemeter.custom.js"></script>

<!-- Odometer JS -->
<script src="js/odometer/odometer.min.js"></script>
<script>
    window.onload = function () {
        /*
         Variables
         */

        //store current uses 1440
        var amp = ['Plug 1', 7, 12, 21, 26, 27, 30, 39, 48, 55, 60, 60, 65, 74, 77, 80, 85, 85, 94, 95, 96, 102, 105, 113, 122, 126, 129, 131, 140, 141, 149, 150, 154, 155, 155, 159, 163, 165, 169, 172, 174, 183, 184, 193, 199, 201, 196, 192, 186, 184, 183, 175, 171, 171, 169, 162, 154, 154, 147, 145, 138, 134, 133, 125, 118, 117, 115, 110, 110, 110, 110, 109, 104, 99, 98, 96, 94, 92, 87, 80, 73, 71, 70, 62, 54, 54, 51, 47, 47, 41, 39, 34, 33, 24, 23, 22, 16, 16, 13, 13, 7, 7, 16, 20, 23, 24, 31, 31, 32, 36, 36, 41, 41, 47, 51, 52, 55, 56, 65, 69, 78, 83, 88, 88, 89, 96, 97, 97, 105, 114, 114, 117, 122, 129, 134, 135, 141, 150, 152, 161, 164, 164, 173, 174, 177, 183, 191, 199, 201, 195, 190, 188, 188, 180, 179, 170, 165, 158, 154, 145, 136, 135, 129, 124, 116, 107, 105, 105, 104, 102, 93, 93, 88, 84, 79, 74, 72, 72, 63, 55, 50, 44, 42, 34, 31, 23, 16, 13, 13, 5, 12, 17, 25, 28, 32, 39, 40, 40, 43, 45, 50, 54, 56, 61, 68, 76, 83, 83, 86, 92, 92, 95, 102, 111, 116, 125, 125, 126, 128, 135, 135, 138, 144, 144, 144, 151, 152, 152, 160, 162, 167, 168, 172, 172, 179, 183, 188, 195, 201, 201, 199, 197, 192, 183, 178, 178, 178, 174, 174, 171, 162, 159, 150, 141, 133, 129, 126, 118, 109, 105, 98, 95, 88, 79, 74, 66, 63, 61, 55, 52, 48, 45, 39, 34, 28, 23, 22, 15, 12, 12, 3, 6, 13, 20, 22, 28, 32, 33, 42, 42, 43, 49, 53, 58, 60, 66, 70, 70, 74, 76, 84, 92, 96, 96, 104, 109, 118, 123, 125, 134, 141, 149, 149, 158, 158, 162, 162, 169, 170, 173, 177, 179, 185, 188, 190, 190, 199, 200, 198, 192, 185, 178, 175, 168, 160, 156, 148, 142, 139, 130, 126, 119, 116, 112, 107, 102, 99, 97, 95, 86, 85, 79, 76, 72, 70, 61, 54, 49, 42, 33, 32, 30, 22, 18, 10, 17, 23, 27, 29, 29, 33, 40, 44, 46, 51, 59, 60, 61, 67, 70, 79, 81, 86, 89, 97, 103, 106, 107, 107, 113, 115, 115, 120, 129, 138, 140, 144, 150, 156, 156, 164, 166, 169, 171, 172, 178, 179, 180, 186, 190, 199, 208, 201, 200, 196, 195, 187, 179, 171, 169, 160, 153, 152, 146, 140, 138, 130, 130, 121, 121, 121, 121, 115, 114, 112, 104, 100, 94, 87, 87, 81, 78, 72, 65, 59, 56, 56, 52, 45, 37, 37, 34, 34, 25, 22, 22, 22, 22, 17, 17, 9, 18, 19, 19, 27, 32, 37, 37, 44, 45, 46, 51, 56, 58, 62, 66, 68, 69, 71, 76, 82, 84, 84, 85, 92, 96, 97, 100, 103, 104, 111, 118, 127, 136, 143, 152, 160, 168, 176, 182, 188, 195, 202, 200, 196, 195, 187, 187, 186, 177, 176, 172, 167, 164, 162, 159, 156, 153, 146, 140, 131, 123, 114, 114, 108, 103, 94, 87, 78, 75, 68, 60, 57, 49, 41, 32, 25, 24, 23, 21, 15, 10, 12, 19, 19, 25, 27, 29, 30, 38, 46, 46, 55, 60, 63, 69, 72, 79, 80, 88, 88, 88, 91, 100, 107, 115, 123, 126, 132, 139, 139, 142, 144, 144, 148, 152, 155, 163, 169, 176, 180, 185, 188, 193, 200, 197, 188, 181, 180, 172, 166, 161, 158, 152, 148, 139, 135, 129, 125, 124, 123, 114, 112, 109, 101, 98, 89, 81, 78, 70, 62, 59, 50, 48, 40, 38, 32, 26, 22, 19, 15, 13, 12, 3, 9, 11, 17, 21, 24, 24, 27, 35, 43, 47, 50, 56, 59, 67, 72, 73, 81, 88, 89, 94, 100, 103, 104, 106, 111, 113, 113, 117, 117, 121, 128, 132, 136, 143, 144, 146, 154, 156, 164, 173, 174, 183, 186, 187, 195, 204, 198, 197, 197, 190, 188, 184, 182, 178, 172, 167, 165, 163, 156, 156, 154, 145, 136, 134, 126, 118, 118, 114, 110, 101, 94, 90, 86, 82, 77, 77, 75, 70, 66, 58, 58, 50, 45, 36, 34, 26, 26, 25, 17, 16, 9, 12, 15, 17, 23, 28, 33, 35, 40, 40, 45, 48, 49, 54, 63, 67, 67, 74, 78, 86, 89, 89, 96, 96, 101, 109, 111, 116, 121, 129, 135, 144, 149, 150, 158, 161, 162, 166, 170, 178, 187, 194, 197, 198, 202, 202, 197, 190, 190, 182, 178, 171, 170, 168, 161, 159, 159, 152, 151, 143, 143, 143, 134, 131, 124, 120, 116, 114, 112, 107, 106, 102, 100, 94, 92, 91, 88, 87, 87, 86, 85, 85, 81, 76, 75, 66, 61, 56, 48, 44, 44, 40, 40, 35, 29, 26, 18, 14, 10, 14, 16, 22, 24, 25, 27, 34, 34, 41, 45, 48, 57, 66, 69, 73, 75, 80, 82, 87, 88, 90, 92, 92, 100, 103, 105, 107, 108, 114, 115, 121, 128, 135, 140, 140, 149, 155, 163, 171, 179, 187, 193, 201, 196, 188, 181, 177, 168, 165, 159, 151, 142, 137, 130, 125, 121, 115, 109, 109, 109, 103, 95, 93, 84, 84, 78, 73, 72, 64, 63, 61, 53, 47, 41, 34, 34, 31, 26, 21, 20, 13, 5, 13, 18, 24, 28, 34, 43, 46, 53, 53, 56, 58, 58, 64, 66, 71, 71, 80, 85, 87, 95, 101, 102, 110, 114, 117, 118, 119, 123, 130, 135, 135, 139, 147, 155, 162, 165, 174, 180, 186, 195, 195, 203, 199, 190, 183, 175, 167, 164, 164, 162, 153, 153, 153, 145, 137, 128, 127, 122, 120, 119, 112, 112, 112, 109, 100, 92, 89, 89, 81, 80, 72, 68, 66, 66, 60, 55, 54, 45, 37, 30, 24, 24, 21, 17, 16, 9, 18, 26, 31, 35, 42, 42, 44, 45, 54, 56, 60, 67, 74, 75, 79, 85, 86, 92, 100, 106, 106, 107, 108, 111, 113, 116, 121, 129, 135, 139, 139, 142, 149, 156, 156, 162, 167, 170, 176, 183, 190, 196, 197, 198, 204, 199, 190, 189, 183, 175, 171, 163, 156, 148, 144, 139, 132, 124, 123, 118, 116, 111, 109, 101, 97, 90, 87, 82, 75, 67, 58, 55, 54, 50, 48, 42, 40, 33, 31, 31, 24, 19, 14, 9, 14, 23, 28, 33, 33, 40, 48, 53, 59, 61, 61, 61, 69, 74, 78, 81, 83, 87, 93, 101, 105, 108, 117, 122, 129, 138, 139, 141, 143, 149, 154, 154, 159, 163, 169, 170, 179, 187, 188, 192, 194, 200, 192, 188, 185, 181, 172, 166, 166, 166, 161, 157, 154, 148, 139, 132, 131, 126, 123, 122, 113, 108, 108, 105, 100, 94, 89, 82, 80, 76, 73, 65, 57, 55, 46, 38, 38, 34, 28, 25, 25, 16, 7, 9, 9, 12, 15, 16, 25, 32, 36, 36, 44, 49, 51, 56, 57, 61, 66, 72, 72, 80, 89, 91, 97, 106, 110, 117, 126, 134, 143, 144, 150, 159, 167, 174, 182, 191, 191, 200, 193, 185, 180, 176, 174, 167, 160, 154, 145, 138, 136, 128, 123, 118, 113, 106, 101, 94, 92, 84, 79, 73, 72, 66, 65, 65, 57, 54, 45, 36, 30, 24, 15, 8, 8, 11, 15, 20, 23, 26, 29, 37, 41, 44, 53, 57, 59, 61, 65, 68, 70, 77, 83, 87, 96, 98, 107, 109, 114, 121, 130, 139, 146, 153, 159, 159, 166, 174, 178, 180, 186, 186, 188, 196, 196, 197, 206, 198, 189, 185, 178, 175, 171, 165, 163, 160, 154, 153, 147, 142, 136, 129, 120, 115, 106, 101, 96, 90, 82, 73, 72, 68, 64, 60, 60, 58, 56, 50, 42, 36, 29, 27, 18, 16, 15, 6, 10, 11, 15, 15, 18, 18, 21, 21, 26, 30, 32, 38, 44, 53, 60, 69, 72, 77, 86, 93, 96, 97, 105, 107, 111, 112, 112, 114, 119, 119, 120, 122, 129, 131, 133, 142, 149, 153, 159, 167, 167, 175, 175, 177, 177, 177, 179, 187, 190, 196, 198, 202, 196, 191, 190, 186, 178, 173, 169, 163, 162, 160, 158, 149, 144, 139, 135, 127, 127, 124, 124, 115, 114, 112, 103, 95, 87, 82, 80, 77, 72, 66, 66, 64, 55, 55, 48, 40, 31, 30, 27, 23, 20, 11, 4, 5, 5, 7, 9, 18, 21, 23, 31, 34, 39, 45, 53, 59, 65, 66, 75, 84, 92, 101, 102, 103, 103, 106, 108, 117, 126, 130, 130, 138, 141, 147, 156, 160, 168, 175, 183, 187, 190, 196, 198, 202, 199, 192, 187, 182
        ];
        var amChartData = [7, 12, 21, 26, 27, 30, 39, 48, 55, 60, 60, 65, 74, 77, 80, 85, 85, 94, 95, 96, 102, 105, 113, 122, 126, 129, 131, 140, 141, 149, 150, 154, 155, 155, 159, 163, 165, 169, 172, 174, 183, 184, 193, 199, 201, 196, 192, 186, 184, 183, 175, 171, 171, 169, 162, 154, 154, 147, 145, 138, 134, 133, 125, 118, 117, 115, 110, 110, 110, 110, 109, 104, 99, 98, 96, 94, 92, 87, 80, 73, 71, 70, 62, 54, 54, 51, 47, 47, 41, 39, 34, 33, 24, 23, 22, 16, 16, 13, 13, 7, 7, 16, 20, 23, 24, 31, 31, 32, 36, 36, 41, 41, 47, 51, 52, 55, 56, 65, 69, 78, 83, 88, 88, 89, 96, 97, 97, 105, 114, 114, 117, 122, 129, 134, 135, 141, 150, 152, 161, 164, 164, 173, 174, 177, 183, 191, 199, 201, 195, 190, 188, 188, 180, 179, 170, 165, 158, 154, 145, 136, 135, 129, 124, 116, 107, 105, 105, 104, 102, 93, 93, 88, 84, 79, 74, 72, 72, 63, 55, 50, 44, 42, 34, 31, 23, 16, 13, 13, 5, 12, 17, 25, 28, 32, 39, 40, 40, 43, 45, 50, 54, 56, 61, 68, 76, 83, 83, 86, 92, 92, 95, 102, 111, 116, 125, 125, 126, 128, 135, 135, 138, 144, 144, 144, 151, 152, 152, 160, 162, 167, 168, 172, 172, 179, 183, 188, 195, 201, 201, 199, 197, 192, 183, 178, 178, 178, 174, 174, 171, 162, 159, 150, 141, 133, 129, 126, 118, 109, 105, 98, 95, 88, 79, 74, 66, 63, 61, 55, 52, 48, 45, 39, 34, 28, 23, 22, 15, 12, 12, 3, 6, 13, 20, 22, 28, 32, 33, 42, 42, 43, 49, 53, 58, 60, 66, 70, 70, 74, 76, 84, 92, 96, 96, 104, 109, 118, 123, 125, 134, 141, 149, 149, 158, 158, 162, 162, 169, 170, 173, 177, 179, 185, 188, 190, 190, 199, 200, 198, 192, 185, 178, 175, 168, 160, 156, 148, 142, 139, 130, 126, 119, 116, 112, 107, 102, 99, 97, 95, 86, 85, 79, 76, 72, 70, 61, 54, 49, 42, 33, 32, 30, 22, 18, 10, 17, 23, 27, 29, 29, 33, 40, 44, 46, 51, 59, 60, 61, 67, 70, 79, 81, 86, 89, 97, 103, 106, 107, 107, 113, 115, 115, 120, 129, 138, 140, 144, 150, 156, 156, 164, 166, 169, 171, 172, 178, 179, 180, 186, 190, 199, 208, 201, 200, 196, 195, 187, 179, 171, 169, 160, 153, 152, 146, 140, 138, 130, 130, 121, 121, 121, 121, 115, 114, 112, 104, 100, 94, 87, 87, 81, 78, 72, 65, 59, 56, 56, 52, 45, 37, 37, 34, 34, 25, 22, 22, 22, 22, 17, 17, 9, 18, 19, 19, 27, 32, 37, 37, 44, 45, 46, 51, 56, 58, 62, 66, 68, 69, 71, 76, 82, 84, 84, 85, 92, 96, 97, 100, 103, 104, 111, 118, 127, 136, 143, 152, 160, 168, 176, 182, 188, 195, 202, 200, 196, 195, 187, 187, 186, 177, 176, 172, 167, 164, 162, 159, 156, 153, 146, 140, 131, 123, 114, 114, 108, 103, 94, 87, 78, 75, 68, 60, 57, 49, 41, 32, 25, 24, 23, 21, 15, 10, 12, 19, 19, 25, 27, 29, 30, 38, 46, 46, 55, 60, 63, 69, 72, 79, 80, 88, 88, 88, 91, 100, 107, 115, 123, 126, 132, 139, 139, 142, 144, 144, 148, 152, 155, 163, 169, 176, 180, 185, 188, 193, 200, 197, 188, 181, 180, 172, 166, 161, 158, 152, 148, 139, 135, 129, 125, 124, 123, 114, 112, 109, 101, 98, 89, 81, 78, 70, 62, 59, 50, 48, 40, 38, 32, 26, 22, 19, 15, 13, 12, 3, 9, 11, 17, 21, 24, 24, 27, 35, 43, 47, 50, 56, 59, 67, 72, 73, 81, 88, 89, 94, 100, 103, 104, 106, 111, 113, 113, 117, 117, 121, 128, 132, 136, 143, 144, 146, 154, 156, 164, 173, 174, 183, 186, 187, 195, 204, 198, 197, 197, 190, 188, 184, 182, 178, 172, 167, 165, 163, 156, 156, 154, 145, 136, 134, 126, 118, 118, 114, 110, 101, 94, 90, 86, 82, 77, 77, 75, 70, 66, 58, 58, 50, 45, 36, 34, 26, 26, 25, 17, 16, 9, 12, 15, 17, 23, 28, 33, 35, 40, 40, 45, 48, 49, 54, 63, 67, 67, 74, 78, 86, 89, 89, 96, 96, 101, 109, 111, 116, 121, 129, 135, 144, 149, 150, 158, 161, 162, 166, 170, 178, 187, 194, 197, 198, 202, 202, 197, 190, 190, 182, 178, 171, 170, 168, 161, 159, 159, 152, 151, 143, 143, 143, 134, 131, 124, 120, 116, 114, 112, 107, 106, 102, 100, 94, 92, 91, 88, 87, 87, 86, 85, 85, 81, 76, 75, 66, 61, 56, 48, 44, 44, 40, 40, 35, 29, 26, 18, 14, 10, 14, 16, 22, 24, 25, 27, 34, 34, 41, 45, 48, 57, 66, 69, 73, 75, 80, 82, 87, 88, 90, 92, 92, 100, 103, 105, 107, 108, 114, 115, 121, 128, 135, 140, 140, 149, 155, 163, 171, 179, 187, 193, 201, 196, 188, 181, 177, 168, 165, 159, 151, 142, 137, 130, 125, 121, 115, 109, 109, 109, 103, 95, 93, 84, 84, 78, 73, 72, 64, 63, 61, 53, 47, 41, 34, 34, 31, 26, 21, 20, 13, 5, 13, 18, 24, 28, 34, 43, 46, 53, 53, 56, 58, 58, 64, 66, 71, 71, 80, 85, 87, 95, 101, 102, 110, 114, 117, 118, 119, 123, 130, 135, 135, 139, 147, 155, 162, 165, 174, 180, 186, 195, 195, 203, 199, 190, 183, 175, 167, 164, 164, 162, 153, 153, 153, 145, 137, 128, 127, 122, 120, 119, 112, 112, 112, 109, 100, 92, 89, 89, 81, 80, 72, 68, 66, 66, 60, 55, 54, 45, 37, 30, 24, 24, 21, 17, 16, 9, 18, 26, 31, 35, 42, 42, 44, 45, 54, 56, 60, 67, 74, 75, 79, 85, 86, 92, 100, 106, 106, 107, 108, 111, 113, 116, 121, 129, 135, 139, 139, 142, 149, 156, 156, 162, 167, 170, 176, 183, 190, 196, 197, 198, 204, 199, 190, 189, 183, 175, 171, 163, 156, 148, 144, 139, 132, 124, 123, 118, 116, 111, 109, 101, 97, 90, 87, 82, 75, 67, 58, 55, 54, 50, 48, 42, 40, 33, 31, 31, 24, 19, 14, 9, 14, 23, 28, 33, 33, 40, 48, 53, 59, 61, 61, 61, 69, 74, 78, 81, 83, 87, 93, 101, 105, 108, 117, 122, 129, 138, 139, 141, 143, 149, 154, 154, 159, 163, 169, 170, 179, 187, 188, 192, 194, 200, 192, 188, 185, 181, 172, 166, 166, 166, 161, 157, 154, 148, 139, 132, 131, 126, 123, 122, 113, 108, 108, 105, 100, 94, 89, 82, 80, 76, 73, 65, 57, 55, 46, 38, 38, 34, 28, 25, 25, 16, 7, 9, 9, 12, 15, 16, 25, 32, 36, 36, 44, 49, 51, 56, 57, 61, 66, 72, 72, 80, 89, 91, 97, 106, 110, 117, 126, 134, 143, 144, 150, 159, 167, 174, 182, 191, 191, 200, 193, 185, 180, 176, 174, 167, 160, 154, 145, 138, 136, 128, 123, 118, 113, 106, 101, 94, 92, 84, 79, 73, 72, 66, 65, 65, 57, 54, 45, 36, 30, 24, 15, 8, 8, 11, 15, 20, 23, 26, 29, 37, 41, 44, 53, 57, 59, 61, 65, 68, 70, 77, 83, 87, 96, 98, 107, 109, 114, 121, 130, 139, 146, 153, 159, 159, 166, 174, 178, 180, 186, 186, 188, 196, 196, 197, 206, 198, 189, 185, 178, 175, 171, 165, 163, 160, 154, 153, 147, 142, 136, 129, 120, 115, 106, 101, 96, 90, 82, 73, 72, 68, 64, 60, 60, 58, 56, 50, 42, 36, 29, 27, 18, 16, 15, 6, 10, 11, 15, 15, 18, 18, 21, 21, 26, 30, 32, 38, 44, 53, 60, 69, 72, 77, 86, 93, 96, 97, 105, 107, 111, 112, 112, 114, 119, 119, 120, 122, 129, 131, 133, 142, 149, 153, 159, 167, 167, 175, 175, 177, 177, 177, 179, 187, 190, 196, 198, 202, 196, 191, 190, 186, 178, 173, 169, 163, 162, 160, 158, 149, 144, 139, 135, 127, 127, 124, 124, 115, 114, 112, 103, 95, 87, 82, 80, 77, 72, 66, 66, 64, 55, 55, 48, 40, 31, 30, 27, 23, 20, 11, 4, 5, 5, 7, 9, 18, 21, 23, 31, 34, 39, 45, 53, 59, 65, 66, 75, 84, 92, 101, 102, 103, 103, 106, 108, 117, 126, 130, 130, 138, 141, 147, 156, 160, 168, 175, 183, 187, 190, 196, 198, 202, 199, 192, 187, 182
        ];


        /*
         functions
         */

        function upOrdown() {

            console.log(amp);
            // update graph
            currentUseChart.load({
                columns: [
                    amp
                ]
            });
        }

        /*
         call
         */

        //random value to show
        //var intervalRandom = setInterval(upOrdown, 3000);

        /*
         c3 graph
         */
        var currentUseChart = c3.generate({
            bindto: '#currentUseGraph',
            data: {
                columns: [
                    amp
                ],
                type: 'area-spline'
                ,
                name: 'Plug 1'
                ,
                color: '#BF7A6A',

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

        chart.addListener("dataUpdated", zoomChart);
        // when we apply theme, the dataUpdated event is fired even before we add listener, so
        // we need to call zoomChart here
        zoomChart();
        // this method is called when chart is first inited as we listen for "dataUpdated" event
        function zoomChart() {
            // different zoom methods can be used - zoomToIndexes, zoomToDates, zoomToCategoryValues
            chart.zoomToIndexes(0, chartData.length - 1);
        }

        // generate times
        function generateChartData() {
            var chartData = [];
            // set date date
            var firstDate = new Date('October 31, 2016 00:00:00');

            // and generate 1 day minutes
            for (var i = 0; i < 1440; i++) {
                var newDate = new Date(firstDate);
                // each time we add one minute
                newDate.setMinutes(newDate.getMinutes() + i);
                // add data item to the array
                chartData.push({
                    date: newDate,
                    visits: amChartData[i]
                });
            }
            return chartData;
        }
    };
</script>

<!-- amChart -->
<script src="amcharts/amcharts.js"></script>
<script src="amcharts/serial.js"></script>
<!--script src="amcharts/plugins/export/export.min.js"></script-->
<!--script src="amcharts/plugins/export/export.css"></script-->
<script src="amcharts/themes/dark.js"></script>

<!-- Peity JS -->
<script src="js/peity/peity.min.js"></script>
<script src="js/peity/custom-peity.js"></script>

<!-- Circliful js -->
<script src="js/circliful/circliful.min.js"></script>
<script src="js/circliful/circliful.custom.js"></script>

<!-- Custom JS -->
<script src="js/custom.js"></script>
</body>
</html>