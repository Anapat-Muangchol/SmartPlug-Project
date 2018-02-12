<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sign In - Smart Plug</title>
    <?php require("../bin/include.php");
    if ($_COOKIE['member_id'] || $_SESSION['member_id']) { ?>
        <script>
            window.location.assign("<?php echo $base_url; ?>/yourplugs");
        </script>
        <?php
    }
    ?>
    <!-- Error CSS -->
    <link href="login.css" rel="stylesheet" media="screen">
    <!-- Font Awesome CDN -->
    <script src="https://use.fontawesome.com/b42e023c7b.js"></script>
</head>
<body>
<?php require("../bin/test_con.php"); ?>
<div id="box" class="animated bounceIn">
    <div id="top_header">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 318.03 463" style="height: 300px;"><defs><style>.a82af0b9-1168-42fc-a15b-c21c4fa91ab4{fill:#333;}.\35 bf378dd-b390-4c83-9a7e-3ab37d364990{fill:#fff;}.\31 fa9209d-e016-4325-9c13-9ce88e836ad5{fill:#666;}.c85d241b-34ca-4da2-8613-94c619471c49{fill:#b3b3b3;}.\35 c30b7c0-e6d5-4c10-b831-9da0a14625cf{fill:#c2c2c2;}.\37 d063a49-c9e6-4587-96bd-224158342cac{fill:#262626;}</style></defs><title>SmartPlugLogo</title><g id="3aa68788-60b7-429a-8763-2dfa27d981cf" data-name="Layer 1"><rect class="a82af0b9-1168-42fc-a15b-c21c4fa91ab4" x="39.11" y="187.77" width="248" height="248" rx="28.61" ry="28.61"/><rect class="5bf378dd-b390-4c83-9a7e-3ab37d364990" x="44.98" y="193.64" width="236.25" height="236.25" rx="28.61" ry="28.61"/><path class="1fa9209d-e016-4325-9c13-9ce88e836ad5" d="M96.64,211.75a35.33,35.33,0,1,1-35.33,35.33,35.37,35.37,0,0,1,35.33-35.33m0-1A36.33,36.33,0,1,0,133,247.09a36.33,36.33,0,0,0-36.33-36.33Z"/><circle class="a82af0b9-1168-42fc-a15b-c21c4fa91ab4" cx="96.64" cy="247.09" r="30.13"/><path class="1fa9209d-e016-4325-9c13-9ce88e836ad5" d="M226.16,211.75a35.33,35.33,0,1,1-35.33,35.33,35.37,35.37,0,0,1,35.33-35.33m0-1a36.33,36.33,0,1,0,36.33,36.33,36.33,36.33,0,0,0-36.33-36.33Z"/><circle class="a82af0b9-1168-42fc-a15b-c21c4fa91ab4" cx="226.16" cy="247.09" r="30.13"/><path class="c85d241b-34ca-4da2-8613-94c619471c49" d="M195.63,138.43a10,10,0,0,1-7.07-2.93,36,36,0,0,0-50.91,0,10,10,0,0,1-14.14-14.14,56.07,56.07,0,0,1,79.2,0,10,10,0,0,1-7.07,17.07Z"/><path class="c85d241b-34ca-4da2-8613-94c619471c49" d="M213.44,109.43a10,10,0,0,1-7.07-2.93,61.14,61.14,0,0,0-86.52,0A10,10,0,0,1,105.7,92.36a81.14,81.14,0,0,1,114.81,0,10,10,0,0,1-7.07,17.07Z"/><path class="c85d241b-34ca-4da2-8613-94c619471c49" d="M242.77,88.43a10,10,0,0,1-7.07-2.93,102.78,102.78,0,0,0-145.19,0A10,10,0,0,1,76.37,71.36a122.81,122.81,0,0,1,173.48,0,10,10,0,0,1-7.07,17.07Z"/><path class="a82af0b9-1168-42fc-a15b-c21c4fa91ab4" d="M165.09,302.11a9.84,9.84,0,0,1,8,8,1.45,1.45,0,0,1-1.43,1.69h-6.8a1.45,1.45,0,0,1-1.45-1.45v-6.8A1.45,1.45,0,0,1,165.09,302.11Z"/><path class="5c30b7c0-e6d5-4c10-b831-9da0a14625cf" d="M161.45,302.11a9.84,9.84,0,0,0-8,8,1.45,1.45,0,0,0,1.43,1.69h6.8a1.45,1.45,0,0,0,1.45-1.45v-6.8A1.45,1.45,0,0,0,161.45,302.11Z"/><path class="a82af0b9-1168-42fc-a15b-c21c4fa91ab4" d="M161.45,321.66a9.84,9.84,0,0,1-8-8,1.45,1.45,0,0,1,1.43-1.69h6.8a1.45,1.45,0,0,1,1.45,1.45v6.8A1.45,1.45,0,0,1,161.45,321.66Z"/><path class="7d063a49-c9e6-4587-96bd-224158342cac" d="M165.09,321.66a9.84,9.84,0,0,0,8-8,1.45,1.45,0,0,0-1.43-1.69h-6.8a1.45,1.45,0,0,0-1.45,1.45v6.8A1.45,1.45,0,0,0,165.09,321.66Z"/><circle class="5bf378dd-b390-4c83-9a7e-3ab37d364990" cx="226.16" cy="247.09" r="11.46"/><circle class="5bf378dd-b390-4c83-9a7e-3ab37d364990" cx="96.64" cy="247.09" r="11.46"/><path class="a82af0b9-1168-42fc-a15b-c21c4fa91ab4" d="M163.11,408.1a35.67,35.67,0,0,0,32-19.83,11,11,0,0,0-9.78-15.84H140.92a11,11,0,0,0-9.78,15.84A35.67,35.67,0,0,0,163.11,408.1Z"/><circle class="5c30b7c0-e6d5-4c10-b831-9da0a14625cf" cx="163.4" cy="157.54" r="11.46"/></g></svg>
        <h5>
            Sign in to access to your<br/>
            Plug control panel.
        </h5>
        <p id="err-signin" style="color:red"></p>
    </div>
    <div id="inputs">
        <form id="form-signin">
            <div class="form-block">
                <input type="text" id="email-signin" placeholder="Email" required>
                <span id="err-email" style="display: none" class="help-block"></span>
            </div>
            <div class="form-block">
                <input type="password" id="password-signin" placeholder="Password" required>
                <span id="err-password" style="display: none" class="help-block"></span>
                <button id="show-password-btn" class="btn btn-default" type="button"><span class="icon-eye3"></span>
                </button>
            </div>
            <input type="submit" value="Sign In">
        </form>
    </div>
    <div id="bottom" class="clearfix">
        <a href="<?php echo $base_url; ?>createuser">Create account</a>
        <div class="pull-right">
            <label class="switch pull-right">
                <input type="checkbox" id="remember-radio" class="switch-input">
                <span class="switch-label" data-on="Yes" data-off="No"></span>
                <span class="switch-handle"></span>
            </label>
        </div>
        <div class="pull-right">
            <span class="cb-label">Remember</span>
        </div>
    </div>
</div>
<script src="login.js"></script>
</body>
</html>