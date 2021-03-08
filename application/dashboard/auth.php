<?php
require_once("../controller/ddr.control.class.php");
$ddr = new ddr();
?>
<html lang="en">
    <head>
        <title>Dashboard | Entry</title>
        <link rel="shortcut icon" href="images/favicon.ico" />
        <link type="text/css" rel="stylesheet" href="js/jqui/css/ui-lightness/jquery-ui-1.10.4.custom.css" />
        <link type="text/css" rel="stylesheet" href="css/ddr.css" />        
        <script type="text/javascript" src="js/jqui/js/jquery-1.10.2.js"></script>
        <script type="text/javascript" src="js/jqui/js/jquery-ui-1.10.4.custom.min.js"></script>        
        <script type="text/javascript" src="js/ddr.js"></script>               
    </head>
    <body>
        <header class="dds-header"></header>        
        <div class="ddr-form">
            <center><span style="color: #ffffff;font-size:15px;font-weight:bold">Registration Process</span></center>
            <ul class="ui-ul-login">
                <li>Name</li>
                <li><input type="text" class="ddr-screen-name" placeholder="Enter Applicant's Name" /></li>
                <li>Designation</li>
                <li><select class="ddr-user-dept"><option value=""> --  Select Your Designation -- </option><?php $ddr->get_designations(); ?></select></li>
                <li>Email<span class="ui-login-span-right">(e.g. yourid@aus.ac.in)</span></li>
                <li><input type="text" class="ddr-user-mail" placeholder="Enter Applicant's AUS Email" /></li>            
                <li><input type="button" value="Authenticate" class="ui-do-auth" /></li>
            </ul>
        </div>
        <div id="err-message" title="Error">
            <span id="err"></span>
        </div>
        <div id="info-message" title="Information">
            <span id="msg"></span>
        </div>
        <div id="process-message" title="Processing"><br/>
            <center><img src="./images/autoload.gif" width="16" height="16" border="0" /><br/><br/>Processing.....<br/><br/>Please wait. It might take some time.</center>
        </div>
    </body>
</html>
