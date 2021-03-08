<?php
require_once("../../../application/controller/las.control.class.php");
$ddr = new ddr();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Lab Attendance System</title>
    <link type="text/css" rel="stylesheet" href="../../../js/jqui/css/ui-lightness/jquery-ui-1.10.4.custom.css" />
    <link type="text/css" rel="stylesheet" href="../../../css/ddr.css" />
    <script type="text/javascript" src="../../../js/jqui/js/jquery-1.10.2.js"></script>
    <script type="text/javascript" src="../../../js/jqui/js/jquery-ui-1.10.4.custom.min.js"></script>
    <script type="text/javascript" src="js/auth-ddr.js"></script>
</head>
<body>
    <header>
        <div class="las-login-left"></div>
        <div class="las-login-right"></div>
        <div class="las-login-name">Register User for OLAMS</div>
    </header>    
    <div class="las-login-main">
        <ul class="ui-ul-login">
            <li>Name</li>
            <li><input type="text" class="las-screen-name" placeholder="Enter Applicant's Name" /></li>
            <li>Department</li>
            <li><select class="las-user-dept"><?php $ddr->get_designations(); ?></select></li>
            <li>Email<span class="ui-login-span-right">(e.g. yourid@aus.ac.in)</span></li>
            <li><input type="text" class="las-user-mail" placeholder="Enter Applicant's AUS Email" /></li>            
            <li><input type="button" value="Authenticate" class="ui-do-auth" /></li>
        </ul>                         
    </div>
    <div id="err-message" title="Error">
        <span id="err"></span>
    </div>
    <div id="las-register-dialog" title="Registration Successful">
        <div class="ui-reg-form-container"></div>
    </div>
</body>
</html>