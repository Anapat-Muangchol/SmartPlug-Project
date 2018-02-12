<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Import CSS and JS Library -->
    <?php echo file_get_contents("bin/include.html"); ?>
    <!-- Import CSS and JS Library -->
    <!-- C3 CSS -->
    <link href="css/c3/c3.css" rel="stylesheet"/>

    <!-- NVD3 CSS -->
    <link href="css/nvd3/nv.d3.css" rel="stylesheet"/>

    <!-- Horizontal bar CSS -->
    <link href="css/horizontal-bar/chart.css" rel="stylesheet"/>

    <!-- Calendar Heatmap CSS -->
    <link href="css/heatmap/cal-heatmap.css" rel="stylesheet"/>

    <!-- Circliful CSS -->
    <link rel="stylesheet" href="css/circliful/circliful.css"/>

    <!-- OdoMeter CSS -->
    <link rel="stylesheet" href="css/odometer.css"/>
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

        <!-- Top Bar Starts -->
        <div class="top-bar clearfix">
            <div class="row gutter">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="page-title">
                        <h3>Dashboard</h3>
                        <p>Welcome to Arise Admin Dashboard</p>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <ul class="right-stats" id="mini-nav-right">
                        <li>
                            <a href="javascript:void(0)" class="btn btn-danger"><span id="salesOdometer"
                                                                                      class="odometer">0</span>Sales</a>
                        </li>
                        <li>
                            <a href="tasks.html" class="btn btn-success">
                                <span id="tasksOdometer" class="odometer">0</span>Tasks</a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" class="btn btn-info"><i class="icon-download6"></i> Export</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Top Bar Ends -->

        <!-- Row starts -->
        <div class="row gutter">
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <div class="panel">
                    <div class="social-details clearfix">
                        <div class="social-icon pull-left">
                            <div class="round-icon red-icon">
                                <i class="icon-calendar"></i>
                            </div>
                        </div>
                        <div class="social-num">
                            <h2><span id="appointmentsOdometer" class="odometer">0</span> <span
                                        class="label label-danger">7%</span></h2>
                            <p>Appointments</p>
                            <div class="progress progress-xsx">
                                <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="65"
                                     aria-valuemin="0" aria-valuemax="100" style="width: 65%">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <div class="panel">
                    <div class="social-details clearfix">
                        <div class="social-icon pull-left">
                            <div class="round-icon yellow-icon">
                                <i class="icon-tools"></i>
                            </div>
                        </div>
                        <div class="social-num">
                            <h2><span id="projectsOdometer" class="odometer">0</span><span class="label label-warning">8%</span>
                            </h2>
                            <p>Projects</p>
                            <div class="progress progress-xsx">
                                <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="45"
                                     aria-valuemin="0" aria-valuemax="100" style="width: 45%">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <div class="panel">
                    <div class="social-details clearfix">
                        <div class="social-icon pull-left">
                            <div class="round-icon green-icon">
                                <i class="icon-briefcase"></i>
                            </div>
                        </div>
                        <div class="social-num">
                            <h2><span id="shopOdometer" class="odometer">0k</span><span
                                        class="label label-success">9%</span></h2>
                            <p>Shop</p>
                            <div class="progress progress-xsx">
                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="72"
                                     aria-valuemin="0" aria-valuemax="100" style="width: 72%">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <div class="panel">
                    <div class="social-details clearfix">
                        <div class="social-icon pull-left">
                            <div class="round-icon blue-icon">
                                <i class="icon-presentation"></i>
                            </div>
                        </div>
                        <div class="social-num">
                            <h2><span id="interviewsOdometer" class="odometer">0</span><span
                                        class="label label-info">9+</span></h2>
                            <p>Interviews</p>
                            <div class="progress progress-xsx">
                                <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="30"
                                     aria-valuemin="0" aria-valuemax="100" style="width: 30%">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Row ends -->

        <!-- Row starts -->
        <div class="row gutter">
            <div class="col-lg-6 col-md-9 col-sm-12 col-xs-12">
                <div class="panel height2">
                    <div class="panel-heading">
                        <h4>Audience Overview</h4>
                    </div>
                    <div class="panel-body">
                        <div id="audienceOverview" class="chart-height1"></div>
                        <h1 class="audience-total"><i class="icon-triangle-up"></i>35%<span>/ today</span></h1>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12">
                <div class="row gutter">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="panel height2">
                            <div class="panel-heading">
                                <h4>Visits</h4>
                            </div>
                            <div class="panel-body">
                                <ul class="sales-q2">
                                    <li class="clearfix">
                                        <div class="month-type warning">July</div>
                                        <div class="sale-info">
                                            <h3>18<sup>k</sup><span class="text-yellow"><i class="icon-triangle-up"></i></span>
                                            </h3>
                                        </div>
                                    </li>
                                    <li class="clearfix">
                                        <div class="month-type info">June</div>
                                        <div class="sale-info">
                                            <h3>12<sup>k</sup><span class="text-blue"><i
                                                            class="icon-triangle-up"></i></span></h3>
                                        </div>
                                    </li>
                                    <li class="clearfix">
                                        <div class="month-type">May</div>
                                        <div class="sale-info">
                                            <h3>10<sup>k</sup><span class="text-red"><i class="icon-triangle-down"></i></span>
                                            </h3>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12 col-sm-8 col-xs-12">
                <div class="row gutter">
                    <div class="col-lg-6 col-md-3 col-sm-6 col-xs-6">
                        <div class="panel height1">
                            <div class="panel-heading">
                                <h4>Sessions</h4>
                            </div>
                            <div class="panel-body">
                                <div class="sessions">
                                    <h2>46K</h2>
                                    <div id="sessions" class="graph"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-3 col-sm-6 col-xs-6">
                        <div class="panel height1">
                            <div class="panel-heading">
                                <h4>Users</h4>
                            </div>
                            <div class="panel-body">
                                <div class="sessions">
                                    <h2>27K</h2>
                                    <div id="users" class="graph"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-3 col-sm-6 col-xs-6">
                        <div class="panel height1">
                            <div class="panel-heading">
                                <h4>Duration</h4>
                            </div>
                            <div class="panel-body">
                                <div class="sessions">
                                    <h2>21.55</h2>
                                    <div id="duration" class="graph"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-3 col-sm-6 col-xs-6">
                        <div class="panel height1">
                            <div class="panel-heading">
                                <h4>Bounce Rate</h4>
                            </div>
                            <div class="panel-body">
                                <div class="sessions">
                                    <h2>12.4%</h2>
                                    <div id="bouncerate" class="graph"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Row ends -->

        <!-- Row starts -->
        <div class="row gutter">
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                <div class="row gutter">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="panel height1">
                            <div class="panel-heading">
                                <h4>Tickets</h4>
                            </div>
                            <div class="panel-body">
                                <ul class="tickets">
                                    <li>
                                        <a href="tasks.html">
                                            <h1 class="high no-of-tickets">21</h1>
                                            <p class="ticket-type">High</p>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="tasks.html">
                                            <h1 class="no-of-tickets">6</h1>
                                            <p class="ticket-type">Low</p>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="panel height1">
                            <div class="panel-heading">
                                <h4>Online</h4>
                            </div>
                            <div class="panel-body">
                                <div id="power-gauge"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row gutter">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="panel height1">
                            <div class="panel-heading">
                                <h4>OS Stats</h4>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-4 col-sm-4 col-xs-4">
                                        <div class="os">
                                            <div id="mac"></div>
                                            <p class="no-margin">Mac</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-4">
                                        <div class="os">
                                            <div id="windows"></div>
                                            <p class="no-margin">Windows</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-4">
                                        <div class="os">
                                            <div id="linux"></div>
                                            <p class="no-margin">Linux</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                <div class="panel height2">
                    <div class="panel-heading">
                        <h4>Accounts</h4>
                    </div>
                    <div class="panel-body">
                        <div class="chart-height3" id="bankAccounts">
                            <svg></svg>
                        </div>
                        <ul class="bank-balance clearfix">
                            <li>Credit: <span class="text-green"> $18,378</span></li>
                            <li>Debit: <span class="text-red"> $12,590</span></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                <div class="row gutter">
                    <div class="col-lg-12 col-md-6 col-sm-6 col-xs-12">
                        <div class="panel height1">
                            <div class="panel-heading">
                                <h4>Subscribed Users</h4>
                            </div>
                            <div class="panel-body">
                                <div class="chart-horiz clearfix">
                                    <ul class="sales-bar chart">
                                        <li class="current" title="Trails"><span class="bar"
                                                                                 data-number="5679"></span><span
                                                    class="number">5679</span></li>
                                        <li class="current" title="Subscriptions"><span class="bar"
                                                                                        data-number="3458"></span><span
                                                    class="number">3458</span></li>
                                        <li class="current" title="Expansions"><span class="bar"
                                                                                     data-number="1934"></span><span
                                                    class="number">1934</span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-3 col-sm-3 col-xs-12">
                        <div class="panel height1">
                            <a href="javascript:void(0)" class="sessions">
                                <div class="GaugeMeter" id="GaugeMeter_1" data-percent="48" data-size="118"
                                     data-width="10" data-stripe="2" data-color="#55899C" data-back="#353c48"
                                     data-label="Rank" data-label_color="#FFFFFF"></div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-3 col-sm-3 col-xs-12">
                        <div class="panel height1">
                            <div class="panel-body">
                                <div class="sessions">
                                    <h2 class="left">165<i class="icon-direction up"></i></h2>
                                    <div id="invoice" class="graph"></div>
                                </div>
                                <h5 class="info">Invoices sent</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Row ends -->

        <!-- Row starts -->
        <div class="row gutter">
            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                <div class="row gutter">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="panel height2">
                            <div class="panel-heading">
                                <h4>Customer Rating</h4>
                            </div>
                            <div class="customer-satisfaction">
                                <i class="icon-thumbs-up"></i>
                                <h2>94%</h2>
                                <p>of customers would recommended this App.</p>
                            </div>
                            <div id="customerRating" class="chart-height4"></div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="panel height2">
                            <div class="panel-heading">
                                <h4>Stocks</h4>
                            </div>
                            <div class="panel-body">
                                <ul class="stocks">
                                    <li>
                                        <p class="clearfix">Apple Inc<span><i class="icon-triangle-up text-green"></i>465.45</span>
                                        </p>
                                    </li>
                                    <li>
                                        <p class="clearfix">Google Inc<span><i class="icon-triangle-up text-green"></i>821.9</span>
                                        </p>
                                    </li>
                                    <li>
                                        <p class="clearfix">Yahoo Inc<span><i class="icon-triangle-down text-red"></i>31.88</span>
                                        </p>
                                    </li>
                                    <li>
                                        <p class="clearfix">Facebook Inc<span><i
                                                        class="icon-triangle-up text-green"></i>465.45</span></p>
                                    </li>
                                    <li>
                                        <p class="clearfix">Ebay Inc<span><i class="icon-triangle-down text-red"></i>66.2</span>
                                        </p>
                                    </li>
                                    <li>
                                        <p class="clearfix">Amazon Inc<span><i class="icon-triangle-up text-green"></i>278.73</span>
                                        </p>
                                    </li>
                                    <li>
                                        <p class="clearfix">Microsoft<span><i class="icon-triangle-up text-green"></i>39.64</span>
                                        </p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                <div class="row gutter">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="panel height2">
                            <div class="panel-heading">
                                <h4>App Downloads</h4>
                            </div>
                            <div class="panel-body">
                                <ul class="app-downloads">
                                    <li>
                                        <p class="clearfix">
                                            <i class="icon-appleinc"></i>IOS<span>5769</span>
                                        </p>
                                        <div class="progress progress-md">
                                            <div class="progress-bar progress-bar-danger" role="progressbar"
                                                 aria-valuenow="89" aria-valuemin="0" aria-valuemax="100"
                                                 style="width: 89%">
                                                <span class="sr-only">89% Complete (success)</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <p class="clearfix">
                                            <i class="icon-android"></i>Android<span>2126</span>
                                        </p>
                                        <div class="progress progress-md">
                                            <div class="progress-bar progress-bar-warning" role="progressbar"
                                                 aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"
                                                 style="width: 55%">
                                                <span class="sr-only">55% Complete (success)</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <p class="clearfix">
                                            <i class="icon-windows8"></i>Windows<span>1068</span>
                                        </p>
                                        <div class="progress progress-md">
                                            <div class="progress-bar progress-bar-success" role="progressbar"
                                                 aria-valuenow="29" aria-valuemin="0" aria-valuemax="100"
                                                 style="width: 29%">
                                                <span class="sr-only">29% Complete (success)</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <p class="clearfix">
                                            <i class="icon-download5"></i>Blackberry<span>285</span>
                                        </p>
                                        <div class="progress progress-md">
                                            <div class="progress-bar progress-bar-info" role="progressbar"
                                                 aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"
                                                 style="width: 10%">
                                                <span class="sr-only">10% Complete (success)</span>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="row gutter">
                            <div class="col-md-12">
                                <div class="panel height2">
                                    <div class="panel-heading">
                                        <h4>Transactions</h4>
                                    </div>
                                    <div class="panel-body">
                                        <ul class="transactions">
                                            <li>
                                                <a href="javascript:void(0)">
															<span class="tra-icon">
																<i class="icon-shield3 text-red"></i>
															</span>
                                                    <span class="tra-type">Month Salary</span>
                                                    <span class="tra-amount text-green">+7250</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)">
															<span class="tra-icon">
																<i class="icon-aircraft text-green"></i>
															</span>
                                                    <span class="tra-type">Trip to Venice</span>
                                                    <span class="tra-amount text-red">-1100</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)">
															<span class="tra-icon">
																<i class="icon-shopping-cart text-blue"></i>
															</span>
                                                    <span class="tra-type">Shopping</span>
                                                    <span class="tra-amount text-red">-1890</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)">
															<span class="tra-icon">
																<i class="icon-bowl text-yellow"></i>
															</span>
                                                    <span class="tra-type">Lunch at work</span>
                                                    <span class="tra-amount text-red">-1250</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)">
															<span class="tra-icon">
																<i class="icon-pig text-red"></i>
															</span>
                                                    <span class="tra-type">Money left</span>
                                                    <span class="tra-amount text-green">+9650</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Row ends -->

        <!-- Row starts -->
        <div class="row gutter">
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="panel height1">
                    <div class="panel-heading">
                        <h4>Weekly Sales</h4>
                    </div>
                    <div class="panel-body">
                        <div class="heatmap">
                            <h3 class="text-green">859</h3>
                            <div id="cal-heatmap"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="panel height1">
                    <div class="panel-heading">
                        <h4>Money Spend</h4>
                    </div>
                    <div class="panel-body">
                        <div class="panel-body center-text">
                            <span class="updating-chart">5,3,9,6,5,9,7,3,5,2,5,3,9,6,5,9,7,3,5,2</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="panel height1">
                    <div class="panel-heading">
                        <h4>Mobile vs Desktop</h4>
                    </div>
                    <div class="panel-body">
                        <div id="mobileDesktop" class="chart-height2"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="panel height1">
                    <div class="panel-heading">
                        <h4>Social Engagement</h4>
                    </div>
                    <div class="panel-body">
                        <ul class="social-engagement clearfix">
                            <li class="fb">
                                <a href="javascript:void(0)">
                                    <i class="icon-facebook"></i>
                                </a>
                                <span>45k</span>
                            </li><!--
									-->
                            <li class="tw">
                                <a href="javascript:void(0)">
                                    <i class="icon-twitter"></i>
                                </a>
                                <span>37k</span>
                            </li><!--
									--><!-- <li class="linkedin">
										<a href="javascript:void(0)">
											<i class="icon-linkedin"></i>
										</a>
										<span>18k</span>
									</li> --><!--
									-->
                            <li class="gplus">
                                <a href="javascript:void(0)">
                                    <i class="icon-googleplus"></i>
                                </a>
                                <span>12k</span>
                            </li><!--
									--><!-- <li>
										<a href="javascript:void(0)">
											<i class="icon-rss"></i>
										</a>
										<span>569</span>
									</li> -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- Row ends -->

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

<!-- Calendar Heatmap JS -->
<script src="js/heatmap/cal-heatmap.min.js"></script>
<script src="js/heatmap/cal-heatmap.custom.js"></script>

<!-- Odometer JS -->
<script src="js/odometer/odometer.min.js"></script>
<script src="js/odometer/custom-odometer.js"></script>

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