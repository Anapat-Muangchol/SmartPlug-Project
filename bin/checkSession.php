<?php
if (!$_COOKIE['member_id'] && !$_SESSION['member_id']) { ?>
    <script>
        window.location.assign("<?php echo $base_url; ?>/signin");
    </script>
    <?php
} else if ($_COOKIE['member_id']) {
    $_SESSION["member_id"] = $_COOKIE['member_id'];
    $_SESSION["member_first_name"] = $_COOKIE['member_first_name'];
    $_SESSION["member_last_name"] = $_COOKIE['member_last_name'];
    $_SESSION['member_api_key'] = $_COOKIE['member_api_key'];
}
?>