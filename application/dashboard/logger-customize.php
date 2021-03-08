<?php
session_start();
if(!isset($_GET['session']) || $_SESSION['session'] != stripslashes($_GET['session'])){
    session_destroy();
    header("location:./");
}
require_once("../controller/ddr.control.class.php");
$ddr = new ddr();
$json = json_decode($ddr->get_editable_data($_GET['id']));
?>
<html lang="en">
    <head>
        <title>Dashboard | Update</title>
        <link rel="shortcut icon" href="images/favicon.ico" />
        <link type="text/css" rel="stylesheet" href="js/jqui/css/ui-lightness/jquery-ui-1.10.4.custom.css" />
        <link type="text/css" rel="stylesheet" href="css/ddr.css" />        
        <script type="text/javascript" src="js/jqui/js/jquery-1.10.2.js"></script>
        <script type="text/javascript" src="js/jqui/js/jquery-ui-1.10.4.custom.min.js"></script>
        <script type="text/javascript" src="js/ckeditor/ckeditor.js"></script>
        <script type="text/javascript" src="js/ddr.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                CKEDITOR.replace( 'ddrdocsubject', {
                    uiColor: '#203040'
                });
                CKEDITOR.instances.ddrdocsubject.setData('<?php echo stripslashes($json->subject); ?>');
                $( ".ddr-date" ).datepicker({
                    showOn: "button",
                    buttonImage: "images/calendar.gif",
                    buttonImageOnly: true,
                    minDate: -7,
                    maxDate: 0,
                    buttonText: "Select Date"
                });                
                $('input:radio[name=f-type][value="' + <?php echo $json->cat; ?> + '"]').click();
                $('input:radio[name=doc-file][value="' + <?php echo $json->type; ?> + '"]').click();
                $('.ddr-from option[value="' + <?php echo $json->from; ?> + '"]').prop('selected', true);
                $('.ddr-to option[value="' + <?php echo $json->to; ?> + '"]').prop('selected', true);
            });
        </script>        
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
                <li class="ddr-dash-search">Search</li>
                <li class="ddr-dash-acc">Account</li>
                <li class="ddr-log-out">Logout</li>
            </ul>
        </header>
        </center>
        <div class="ddr-form">
            <div class="ddr-label"></div>
            <ul>
                <li><label><input type="radio" name="f-type" checked="checked" value="0" class="ddr-rcv" />Receiving</label>&nbsp;&nbsp;<label><input type="radio" name="f-type" class="ddr-disp" value="1" />Dispatching</label></li>
                <li><label><input type="radio" name="doc-file" checked="checked" value="0" class="ddt-doc" />Document</label>&nbsp;&nbsp;<label><input type="radio" name="doc-file" value="1" class="ddt-file"/>File</label></li>
                <li><form autocomplete="off"><input type="text" size="50%" class="ddr-doc-no" placeholder="Document Reference No / File No" maxlength="100" readonly="readonly" value="<?php echo $json->dfno; ?>"/></form></li>                
                <li><input type="text" size="50" class="ddr-date" readonly="readonly" placeholder="Receiving / Dispatching Date" value="<?php echo $json->date; ?>" /></li>
                <li><input type="text" size="10" class="ddr-disp-no" placeholder="Dispatch No." value="<?php echo $json->despno; ?>" /></li>
                <li><select class="ddr-from"><option value="">-- Received From --</option><?php $ddr->get_designations(); ?></select></li>
                <li><select class="ddr-to"><option value="">-- Sending To --</option><?php $ddr->get_designations(); ?></select></li>
                <li><textarea class="ddr-doc-subject" id="ddrdocsubject"></textarea></li>
                <li><input type="button" size="50" value="Update" class="aus-ddr-update" data-val="<?php echo $_GET['id']; ?>" /></li>
            </ul>
            <select class="ddr-auto-text"></select>
        </div>
        <div id="info-message" title="Information">
            <span id="msg"></span>
        </div>
        <div id="err-message" title="Error">
            <span id="err"></span>
        </div>
        <div id="logout-message" title="Logout">
            <span id="msg">Are you sure to logout?</span>
        </div>
        <div id="acc-change" title="Account Update">
            Change your password<br/><br/>
            <input type="password" size="40" max="25" id="ui-psw-change" placeholder="New Pasasword" />
        </div>
        <input type="hidden" value="<?php echo stripslashes($_GET['session']); ?>" id="ddr-sess-val" />
        <input type="hidden" id="maxdfid" value="" />
    </body>
</html>