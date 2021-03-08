<?php
session_start();
require_once("../controller/ddr.control.class.php");
$ddr = new ddr();
?>
<html lang="en">
    <head>
        <title>FMS | Track</title>
        <link rel="shortcut icon" href="images/favicon.ico" />
        <link type="text/css" rel="stylesheet" href="js/jqui/css/ui-lightness/jquery-ui-1.10.4.custom.css" />
        <link type="text/css" rel="stylesheet" href="css/ddr.css" />        
        <script type="text/javascript" src="js/jqui/js/jquery-1.10.2.js"></script>
        <script type="text/javascript" src="js/jqui/js/jquery-ui-1.10.4.custom.min.js"></script>        
        <script type="text/javascript" src="js/ddr.js"></script>                
    </head>
    <body>
        <?php include_once("acc-info.php"); ?>
        <div class="ddr-trans-text">Track Your File Transition</div>
        <div class="ddr-form">
            <ul>
                <li><input type="text" class="ddr-search-txt" placeholder="Enter your file no/subject/dispatch no" /></li>
            </ul>            
            <div class="ddr-searched-data"></div>
        </div>
        <div id="info-doc-file" title="Basic Information &amp; Transition Details">
            <div class="ddr-df-info"></div>
        </div>
        <div id='ddr-sub-details' title='Subject Details'>
            <p class='ddr-sub-text'></p>
        </div>
        <div class="ddr-back">Back</div>
    </body>
</html>