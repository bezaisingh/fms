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
        <title>Dashboard | Entry</title>
        <link rel="shortcut icon" href="images/favicon.ico" />
        <link type="text/css" rel="stylesheet" href="js/jqui/css/ui-lightness/jquery-ui-1.10.4.custom.css" />
        <link rel="stylesheet" type="text/css" href="css/modality.css"/>
        <link type="text/css" rel="stylesheet" href="css/ddr.css" />        
        <script type="text/javascript" src="js/jqui/js/jquery-1.10.2.js"></script>
        <script type="text/javascript" src="js/jqui/js/jquery-ui-1.10.4.custom.min.js"></script>        
        <script type="text/javascript" src="js/ckeditor/ckeditor.js"></script>
        <script type="text/javascript" src="js/modality.jquery.min.js"></script>
        <script type="text/javascript" src="js/ddr.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                CKEDITOR.replace( 'ddrdocsubject', {
                    uiColor: '#203040'
                });
                $(".ddr-disp").trigger("click");
                CKEDITOR.instances.ddrdocsubject.setData("Please enter the subject matter of the file !");
                $( ".ddr-date" ).datepicker({
                    showOn: "button",
                    buttonImage: "images/calendar.gif",
                    buttonImageOnly: true,
                    minDate: 0,
                    maxDate:0,
                    buttonText: "Select Date"
                });
                function getItem( obj ){                    
                    var dfid = obj.dfid;
                    var dfno = obj.dfno;
                    $(".trig-cls").trigger("click");
                    $("#err").empty();
                    $.ajax({
                        url : "./sync?" + new Date().getTime(),
                        type : 'post',
                        data : {getDFInfo:true,dfid:dfid},
                        success : function(data){
                            $(".trig-cls").trigger("click");                            
                            var obj = $.parseJSON(data);
                            var loggerId = obj.loggerId;
                            var transid = obj.transid;
                            var typeid = obj.dtype;                            
                            var fromid = obj.from;
                            var toid = obj.to;
                            var subj = obj.subj;
                            var isRec = obj.isRec;
                            var dispNo = obj.dispno;
                            var loggerDeptId = obj.deptId;
                            var actualID = obj.actualid;
                            var ftitle = obj.ftit;
                            var recvrId = obj.recvrId;
                            //$('input:radio[name=doc-file][value="' + typeid + '"]').click();
                            if (recvrId !== null) {
                                if (loggerId !== recvrId) {
                                    $( ".ddr-doc-no" ).val("");
                                    $("#err-message").dialog( "open" );
                                    $("#err").html("You can't dispatch this file as you are not currently possessing it.<br/><br/>Please check once again!");
                                    return;
                                }
                            }
                            $('.ddr-from option[value="' + fromid + '"]').prop('selected', true);
                            $(".ddr-file-title").val(ftitle);
                            CKEDITOR.instances.ddrdocsubject.setData(subj);
                            $(".ddr-disp-no").val(dispNo);
                            $("#dispno").val(transid);
                            $("#isrec").val(isRec);
                            $("#actualId").val(actualID);
                        },
                        error : function(err){
                            $(".trig-cls").trigger("click");
                            $("#err-message").dialog( "open" );
                            $("#err").html(err.status + ":" + err.statusText);
                            $(that).attr("disabled",false);
                            return;
                        }
                    });                    
                }
                $( ".ddr-doc-no" ).autocomplete({
                    source: "./sync?" + new Date().getTime(),
                    minLength: 3,
                    autoFocus: true,
                    response : function(event, ui){
                        $("#actualId").val("");                        
                    },
                    select: function( event, ui ) {                        
                        getItem( ui.item );
                    }                    
                });
            });
        </script>
        <style>
            .ui-autocomplete-loading {
                background-size: 16px 16px;
                background: white url("./images/autoload.gif") right center no-repeat;
            }
        </style>
    </head>
    <body>
        <?php include_once("acc-info.php"); ?>  
        <center>
        <header class="dds-header-menu">
            <ul>                
                <li class="ddr-dash-index">Home</li>
                <li class="ddr-dash-board ddr-highlight">Entry</li>
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
                <li><!--<label><input type="radio" name="f-type" value="0" class="ddr-rcv" />Receiving</label>&nbsp;&nbsp;--><label><input type="radio" name="f-type" class="ddr-disp" value="1" />Dispatching</label></li>
                <li style="display: none"><label><!--input type="radio" name="doc-file" checked="checked" value="0" />Document</label--><label><input type="radio" name="doc-file" value="1" checked="checked" />File</label></li>
                <li><div class="ui-widget"><input type="text" size="50%" class="ddr-doc-no" placeholder="Dispatched No / File No" maxlength="100"/></div></li>
                <li><div class="ui-widget"><input type="text" size="50%" readonly="readonly" class="ddr-file-title" placeholder="File Title" maxlength="250"/></div></li>
                <li><input type="text" size="15" class="ddr-disp-no" value="" readonly="readonly" /></li>
                <li><select class="ddr-from" disabled="disabled""><option value="">-- Received From --</option><?php $ddr->get_designations(); ?></select></li>
                <li><select class="ddr-to"><option value="">-- Sending To --</option><?php $ddr->get_designations(); ?></select></li>
                <li><textarea class="ddr-doc-subject" id="ddrdocsubject"></textarea></li>
                <li><input type="button" size="50" value="Dispatch" class="aus-ddr-save" /></li>
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
        <div id="recv-message" title="Message">
            <span id="msg">This has already been received</span>
        </div>
        <div id="disp-message" title="Message">
            <span id="msg">This has already been dispatched</span>
        </div>
        <div id="acc-change" title="Account Update">
            Change your password<br/><br/>
            <input type="password" size="40" max="25" id="ui-psw-change" placeholder="New Pasasword" />
        </div>
        <div id="create-message" title="New File">
            <span id="info"></span>
        </div>
        <input type="hidden" value="<?php echo stripslashes($_GET['session']); ?>" id="ddr-sess-val" />
        <input type="hidden" id="deptid" value="<?php echo $_SESSION['logger_dept_id']; ?>" />
        <input type="hidden" id="dispno" value="" />
        <input type="hidden" id="isrec" value="" />
        <input type="hidden" id="actualId" value="" />
        <a href="#modalLoading" class="trig-cls"></a>
        <div id="modalLoading" class="ui-modal-wait" style="display:none;"><br/><center><img src="./images/autoload.gif" width="16" height="16" alt="" border="0" /><br/>Collecting your data....</center></div>
        <script type="text/javascript">            
            $('#modalLoading').modality({
                clickOffToClose: false,
                closeOnEscape: false,
                effect: 'slide-up'              
            });            
        </script> 
    </body>
</html>