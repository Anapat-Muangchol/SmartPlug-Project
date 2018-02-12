<?php
require("../classes/Member.php");
$member = new Member();
$member->logout();
?>
<script>
    window.location.assign("../signin")
</script>
