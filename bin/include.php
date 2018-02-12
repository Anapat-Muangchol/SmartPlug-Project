<?php
session_start();
$base_url = "http://" . $_SERVER['HTTP_HOST'] . "/"; ?>
<link href="<?php echo $base_url; ?>/bin/pace-theme-minimal.css" rel="stylesheet" media="screen"/>
<script src="<?php echo $base_url; ?>/bin/pace.min.js"></script>
<!-- Internet connection check -->
<script src="<?php echo $base_url; ?>/bin/checklost.js"></script>

<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Samrt Plug"/>
<meta name="keywords"
      content="Smart, Plug, smart, plug, smart plug, Smart Plug"/>
<meta name="author" content="BUU"/>
<link rel="shortcut icon" href="<?php echo $base_url; ?>/img/fav.png">

<!-- Bootstrap CSS -->
<link href="<?php echo $base_url; ?>/css/bootstrap.min.css" rel="stylesheet" media="screen"/>

<!-- Main CSS -->
<link href="<?php echo $base_url; ?>/css/main.css" rel="stylesheet" media="screen"/>

<link href="<?php echo $base_url; ?>/style/main.css" rel="stylesheet" media="screen"/>

<!-- Fonts -->
<link href="https://fonts.googleapis.com/css?family=Roboto:100,400,500,700|Trirong:100,400,500,700" rel="stylesheet">

<!-- Ion Icons -->
<link href="<?php echo $base_url; ?>/fonts/icomoon/icomoon.css" rel="stylesheet"/>

<!-- Animate CSS -->
<link rel="stylesheet" media="screen" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">

<!-- HTML5 shiv and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
<script src="http://smartplug.informatics.buu.ac.th/js/html5shiv.js"></script>
<script src="http://smartplug.informatics.buu.ac.th/js/respond.min.js"></script>
<![endif]-->