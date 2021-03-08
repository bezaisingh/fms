<?php
session_start();
if(!isset($_GET['session']) || $_SESSION['session'] != stripslashes($_GET['session'])){
    session_destroy();
    header("location:./");
}
require_once("../controller/ddr.control.class.php");
$ddr = new ddr();
?>
<html lang="en">
    <head>
        <title>Dashboard | Search</title>
        <link rel="shortcut icon" href="images/favicon.ico" />
        <link type="text/css" rel="stylesheet" href="js/jqui/css/ui-lightness/jquery-ui-1.10.4.custom.css" />
        <link type="text/css" rel="stylesheet" href="css/ddr.css" />        
        <script type="text/javascript" src="js/jqui/js/jquery-1.10.2.js"></script>
        <script type="text/javascript" src="js/jqui/js/jquery-ui-1.10.4.custom.min.js"></script>        
        <script type="text/javascript" src="js/ddr.js"></script>                
    </head>
    <body>
        <?php include_once("acc-info.php"); ?>  
        <center>
        <header class="dds-header-menu">
            <ul>                
                <li class="ddr-dash-index">Home</li>
                <li class="ddr-dash-board">Entry</li>
                <li class="ddr-dash-single-day-report">Single Day Report</li>
                <li class="ddr-dash-multi-day-report">Multiple day Report</li>
                <li class="ddr-dash-search ddr-highlight">Search</li>
                <li class="ddr-dash-acc">Account</li>
                <li class="ddr-log-out">Logout</li>
            </ul>
        </header>
        </center>
        <div class="ddr-form">
            <ul>
                <li><input type="text" class="ddr-search-txt" placeholder="Enter your file no/subject/dispatch no" /></li>
            </ul>            
            <div class="ddr-searched-data"></div>
        </div>
        <div id="err-message" title="Error">
            <span id="err"></span>
        </div>
        <div id="info-doc-file" title="Basic Information &amp; Transition Details">
            <div class="ddr-df-info"></div>
        </div>
        <div id="logout-message" title="Logout">
            <span id="msg">Are you sure to logout?</span>
        </div>
        <div id="acc-change" title="Account Update">
            Change your password<br/><br/>
            <input type="password" size="40" max="25" id="ui-psw-change" placeholder="New Pasasword" />
        </div>
        <div id="close-file" title="File Close">
            <div class="ddr-file-close-info">Are you sure to close this file?</div>            
        </div>
        <div id='ddr-sub-details' title='Subject Details'>
            <p class='ddr-sub-text'></p>
        </div>
        <input type="hidden" value="<?php echo stripslashes($_GET['session']); ?>" id="ddr-sess-val" />
    </body>
</html>