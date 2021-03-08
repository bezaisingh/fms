<?php
session_start();
if(!isset($_GET['session']) || $_SESSION['session'] != stripslashes($_GET['session'])){
    session_destroy();
    header("location:./");
}
require_once("../controller/ddr.control.class.php");
$ddr = new ddr();
if(isset($_GET['fno'])){
    $fno = trim(urldecode(stripslashes($_GET['fno'])));
} else {
    $fno = null;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Dashboard | Home</title>
        <link rel="shortcut icon" href="images/favicon.ico" />
        <link type="text/css" rel="stylesheet" href="js/jqui/css/ui-lightness/jquery-ui-1.10.4.custom.css" />
        <link type="text/css" rel="stylesheet" href="css/paginate.css" />
        <link type="text/css" rel="stylesheet" href="css/ddr.css" />
        <script type="text/javascript" src="js/jqui/js/jquery-1.10.2.js"></script>
        <script type="text/javascript" src="js/jqui/js/jquery-ui-1.10.4.custom.min.js"></script>
        <script type="text/javascript" src="js/jquery.paging.js"></script>
        <script type="text/javascript" src="js/ddr.js"></script>
        <?php include_once("php-js-script.php"); ?>
    </head>
    <body>
        <?php include_once("acc-info.php"); ?>
        <center>
        <header class="dds-header-menu">
            <ul>                
                <li class="ddr-dash-index ddr-highlight">Home</li>
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
            <div id="tabs">
                <ul>
                    <li><a href="#tab-pending">Pending<?php if($ddr->get_pending_doc_file_info_count() > 0){echo '&nbsp;('.$ddr->get_pending_doc_file_info_count().')';} ?></a></li>
                    <li><a href="#tab-received">Received</a></li>
                    <li><a href="#tabs-dispatcehd">Dispatched</a></li>
                    <li><a href="#tabs-closed">Closed Files</a></li>
                    <li><a href="#tabs-create-file">Create File</a></li>
                </ul>
                <div id="tab-pending" class="ui-tab-content">
                    <p>
                        <ul class="ul-data ui-pending-data">
                            <?php
                            $obj = $ddr->get_pending_doc_file_info_count();
                            if($obj == 0){
                                ?>
                                <li class="ui-no-rcv"><span>No file has been pending so far</span></li>
                                <?php
                            }
                            ?>
                        </ul>
                        <?php
                        $obj = $ddr->get_pending_doc_file_info_count();
                        if($obj > 0){
                            ?>
                            <div id="ui-pending-page" class="ui-paginate"></div>
                            <?php
                        }
                        ?>
                    </p>                    
                </div>
                <div id="tab-received" class="ui-tab-content">
                    <p>
                        <ul class="ul-data ui-received-data">
                            <?php
                            $obj = $ddr->get_received_doc_file_info_count();
                            if($obj == 0){
                                ?>
                                <li class="ui-no-rcv"><span>No file has been received so far</span></li>
                                <?php
                            }
                            ?>
                        </ul>
                        <?php
                        $obj = $ddr->get_received_doc_file_info_count();
                        if($obj > 0){
                            ?>
                            <div id="ui-received-page" class="ui-paginate"></div>
                            <?php
                        }
                        ?>                       
                    </p>
                </div>
                <div id="tabs-dispatcehd" class="ui-tab-content">
                    <p>
                        <ul class="ul-data ui-dispatcehd-data">
                            <?php
                            $obj = $ddr->get_dispathced_doc_file_info_count();
                            if($obj == 0){
                                ?>
                                <li class="ui-no-rcv"><span>No file has been dispatched so far</span></li>
                                <?php
                            }
                            ?>
                        </ul>
                        <?php
                        $obj = $ddr->get_dispathced_doc_file_info_count();
                        if($obj > 0){
                            ?>
                            <div id="ui-dispatcehd-page" class="ui-paginate"></div>
                            <?php
                        }
                        ?>                     
                    </p>
                </div>
                <div id="tabs-closed" class="ui-tab-content">
                    <p>                    
                        <ul class="ul-data ui-closed-data">
                            <?php
                            $obj = $ddr->get_closed_doc_file_info_count();
                            if($obj == 0){
                                ?>
                                <li class="ui-no-rcv"><span>No file has been closed so far</span></li>
                                <?php
                            }
                            ?>
                        </ul>
                        <?php
                            if($obj > 0){
                                ?>
                                <div id="ui-closed-page" class="ui-paginate"></div>
                                <?php
                            }
                        ?>
                    </p>
                </div>
                <div id="tabs-create-file" class="ui-tab-content">
                    <p>
                        <input type="text" size="60%" maxlength="150" class="ui-create-file" placeholder="Enter a file no" value="<?php echo $fno; ?>" /><br/><br/>
                        <input type="text" size="60%" maxlength="250" class="ui-create-file-title" placeholder="Enter a file title" value="" />&nbsp;&nbsp;<input type="button" value="Create" class="ui-create-btn" />
                    </p>
                    <p>
                        List of files of <i><span class="ui-des"><?php echo $ddr->get_logger_designation(); ?></span></i>
                    </p>
                    <p>
                        <ul class="ul-data ui-create-data">
                            <?php
                            $obj = $ddr->get_create_file_info_count();
                            if($obj == 0){
                                ?>
                                <li class="ui-no-rcv"><span>No file has been created so far</span></li>
                                <?php
                            }
                            ?>
                        </ul>
                        <?php
                            if($obj > 0){
                                ?>
                                <div id="ui-created-page" class="ui-paginate"></div>
                                <?php
                            }
                        ?>
                    </p>
                </div>
            </div>
        </div>        
        <div id="logout-message" title="Logout">
            <span id="msg">Are you sure to logout?</span>
        </div>
        <div id="acc-change" title="Account Update">
            Change your password<br/><br/>
            <input type="password" size="40" max="25" id="ui-psw-change" placeholder="New Pasasword" />
        </div>
        <div id="info-doc-file" title="Basic Information &amp; Transition Details">
            <div class="ddr-df-info"></div>
        </div>
        <div id="close-file" title="File Close">
            <div class="ddr-file-close-info">Are you sure to close this file?</div>
        </div>
        <div id="err-message" title="Error">
            <span id="err"></span>
        </div>
        <div id="create-confirm-message" title="Attention!!!">
            <span id="err-con"></span>
        </div>
        <div id="info-create-message" title="Information">
            <span id="msg-create"></span>
        </div>
        <div id="info-message" title="Information">
            <span id="msg"></span>
        </div>
        <div id='ddr-sub-details' title='Subject Details'>
            <p class='ddr-sub-text'></p>
        </div>
        <input type="hidden" value="<?php echo stripslashes($_GET['session']); ?>" id="ddr-sess-val" />       
    </body>
</html>
