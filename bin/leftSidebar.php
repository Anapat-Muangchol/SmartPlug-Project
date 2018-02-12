<div id="left-side-bar" class="vertical-nav vertical-nav-sm">

    <!-- Collapse menu starts -->
    <button class="collapse-menu">
        <i class="icon-menu2"></i>
    </button>
    <!-- Collapse menu ends -->

    <!-- Current user starts -->
    <div class="user-details clearfix">
        <a href="<?php echo $base_url; ?>/profile/"><h5
                    class="user-name"><?php echo $_SESSION['member_first_name']; ?></h5></a>
    </div>
    <!-- Current user ends -->

    <!-- Sidebar menu start -->
    <ul class="menu clearfix">
        <li id="yourplugs_sidemenu">
            <a href="<?php echo $base_url; ?>/yourplugs/">
                <i class="icon-cord"></i>
                <!--
                get from http://ux.stackexchange.com/questions/4348/your-vs-my-in-user-interfaces
                better use your instead my
                 -->
                <span class="menu-item">Your Plugs</span>
            </a>
        </li>
        <li id="addplug_sidemenu">
            <a href='<?php echo $base_url; ?>/yourplugs/addplug'>
                <i class="icon-plus"></i>
                <span class="menu-item">Add Plug</span>
            </a>
        </li>
        <li id="summary_sidemenu">
            <a href='<?php echo $base_url; ?>/summary'>
                <i class="icon-chart3"></i>
                <span class="menu-item">Summary</span>
            </a>
        </li>
        <li id="history_sidemenu">
            <a href='<?php echo $base_url; ?>/history'>
                <i class="icon-clock2"></i>
                <span class="menu-item">History</span>
            </a>
        </li>
        <li>
            <a href="<?php echo $base_url; ?>/bin/logout.php">
                <i class="icon-exit"></i>
                <!--
                get from http://ux.stackexchange.com/questions/1080/using-sign-in-vs-using-log-in
                better use sign out instead log out
                 -->
                <span class="menu-item">Sign Out</span>
                <!--span class="down-arrow"></span-->
            </a>
        </li>

    </ul>
    <!-- Sidebar menu snd -->
</div>
