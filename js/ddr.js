$(document).ready(function(){
    /*document.oncontextmenu = function(){
        return false;
    }
    document.onkeydown = function(e) {
        if (e.ctrlKey && (e.keyCode === 85)) {            
            return false;
        } else {
            return true;
        }
    };*/
    $("#tabs").tabs();
    $(document).tooltip({
      position: {
        my: "center bottom-20",
        at: "center top",
        using: function( position, feedback ) {
          $( this ).css( position );
          $( "<div>" )
            .addClass( "arrow" )
            .addClass( feedback.vertical )
            .addClass( feedback.horizontal )
            .appendTo( this );
        }
      }
    });    
    $("#err-message").dialog({
        autoOpen: false,
        modal: true,
        buttons: {
            Ok: function() {
                $( this ).dialog( "close" );
            }
        }
    });
    $("#create-confirm-message").dialog({
        autoOpen: false,
        modal: true,
        buttons: {
            Confirm: function() {
                $.ajax({
                    url : "./sync?" + new Date().getTime(),
                    type : 'post',
                    data : {crFile:true,fname:encodeURIComponent($(this).data('fno')),ftitle:encodeURIComponent($(this).data('ftit'))},
                    success : function(data){
                        var obj = $.parseJSON(data);
                        $("#err").empty();
                        $("#msg-create").empty();
                        if (obj.isNew === false) {
                            $("#err-message").dialog( "open" );
                            $("#err").html(obj.message);
                            $(that).attr("disabled",false);
                            return;
                        } else {
                            $("#info-create-message").dialog( "open" );
                            $("#msg-create").html(obj.message);    
                        }
                    },
                    error : function(err){
                        $("#err-message").dialog( "open" );
                        $("#err").html(err.status + ":" + err.statusText);
                        $(that).attr("disabled",false);
                        return;
                    }
                });
            },
            Dismiss : function() {
                $( this ).dialog( "close" );
            }
        }
    });
    $("#create-message").dialog({
        autoOpen: false,
        modal: true,
        buttons: {
            Yes: function() {
                window.location.href = "./home?session=" + $("#ddr-sess-val").val() + "&fno=" + encodeURIComponent($(this).data("fno"));
            },
            No : function(){
                $( this ).dialog( "close" );
            }
        }
    });
    $("#info-message").dialog({
        autoOpen: false,
        modal: true,
        buttons: {
            Ok: function() {
                window.location.reload();
            }
        }
    });
    $("#info-create-message").dialog({
        autoOpen: false,
        modal: true,
        buttons: {
            Ok: function() {
                window.location.href = "./home?session=" + $("#ddr-sess-val").val();
            }
        }
    });
    $("#recv-message").dialog({
        autoOpen: false,
        modal: true,
        buttons: {
            Ok: function() {
                window.location.reload();
            }
        }
    });
    $("#disp-message").dialog({
        autoOpen: false,
        modal: true,
        buttons: {
            Ok: function() {
                window.location.reload();
            }
        }
    });
    $("#process-message").dialog({
        autoOpen: false,
        modal: true        
    });
    $("#logout-message").dialog({
        autoOpen: false,
        modal: true,
        buttons: {
            Yes: function() {
                $.ajax({
                    url : "./sync?" + new Date().getTime(),
                    type : 'post',
                    data : {signout:true},
                    success : function(data){
                        var obj = $.parseJSON(data);
                        if (obj.signout === false) {
                            $("#err-message").dialog( "open" );
                            $("#err").html(obj.message);
                            $(that).attr("disabled",false);
                            return;
                        } else {                        
                            window.location.reload();
                        }
                    },
                    error : function(err){
                        $("#err-message").dialog( "open" );
                        $("#err").html(err.status + ":" + err.statusText);
                        $(that).attr("disabled",false);
                        return;
                    }
                });
            },
            No : function(){
                $( this ).dialog( "close" );
            }
        }
    });
    $("#acc-change").dialog({
        autoOpen: false,
        modal: true,
        buttons: {
            Update: function() {
                var pass = $("#ui-psw-change").val().trim();
                if (!pass) {
                    $("#err-message").dialog( "open" );
                    $("#err").html("Please enter your new password!");
                    return;
                }
                $.ajax({
                    url : "./sync?" + new Date().getTime(),
                    type : 'post',
                    data : {accUpdt:true,psw:encodeURIComponent(pass)},
                    success : function(data){
                        var obj = $.parseJSON(data);
                        if (obj.update === false) {
                            $("#err-message").dialog( "open" );
                            $("#err").html(obj.message);
                            return;
                        } else {
                            window.location.reload();
                        }
                    },
                    error : function(err){
                        $("#err-message").dialog( "open" );
                        $("#err").html(err.status + ":" + err.statusText);
                        $(that).attr("disabled",false);
                        return;
                    }
                });
            }
        }
    }); 
    $("#info-doc-file").dialog({
        autoOpen: false,
        modal: true,
        resizable:false,
        width : 800,
        height : 500
    });
    $("#close-file").dialog({
        autoOpen: false,
        modal: true,        
        buttons: {
            Yes: function() {
                var jsonObj = {};
                jsonObj.fclose = true;
                jsonObj.dfid = $(this).data('dfid')
                $.ajax({
                    url : "./sync?" + new Date().getTime(),
                    type : 'post',
                    data : jsonObj,
                    success : function(data){
                        var obj = $.parseJSON(data);
                        if (obj.status === false) {
                            $("#err-message").dialog( "open" );
                            $("#err").html(obj.message);
                            return;
                        } else {                            
                            window.location.reload();
                        }
                    },
                    error : function(err){
                        $("#err-message").dialog( "open" );
                        $("#err").html(err.status + ":" + err.statusText);
                        $(that).attr("disabled",false);
                        return;
                    }
                });
            },
            No : function(){
                $( this ).dialog( "close" );
            }
        }
    });
    $(".ddr-user-email,.ddr-user-pass").on("keyup",function(e){
        if (e.keyCode == 13) {
            $(this).blur();
            $(".ddr-login-btn").trigger("click");
        }
    });
    $(".ddr-login-btn").on("click",function(){
        var that = this;
        var umail = $(".ddr-user-email").val();
        var upass = $(".ddr-user-pass").val();
        $("#err").empty();
        if (!umail) {
            $("#err-message").dialog("open");
            $("#err").html("Please enter your AUS email username !");
            return;
        }
        if (!upass) {
            $("#err-message").dialog("open");
            $("#err").html("Please enter your password !");
            return;
        }
        var email = encodeURIComponent(umail);
        var pass = encodeURIComponent(upass);
        var jsonObj = {};
        jsonObj.signin = true;
        jsonObj.uemail = email;
        jsonObj.upass = upass;
        $("#err").empty();
        $(this).attr("disabled",false);
        $.ajax({
            url : "./sync?" + new Date().getTime(),
            type : 'post',
            data : jsonObj,
            success : function(data){
                var obj = $.parseJSON(data);
                if (obj.auth === false) {
                    $("#err-message").dialog( "open" );
                    $("#err").html(obj.message);
                    $(that).attr("disabled",false);
                    return;
                } else {
                    var session = obj.session;
                    window.location.href = "./home?session=" + session;
                }
            },
            error : function(err){
                $("#err-message").dialog( "open" );
                $("#err").html(err.status + ":" + err.statusText);
                $(that).attr("disabled",false);
                return;
            }
        });
    });
    $(".aus-ddr-save").on("click",function(){
        $(this).attr("disabled",true);
        var that = this;
        var ddrCat = $("input[name='f-type']:checked").val();
        var ddrType = $("input[name='doc-file']:checked").val();
        var docFileNo = $(".ddr-doc-no").val().trim();
        var ddrDespNo = $(".ddr-disp-no").val();
        var previousDispNo = $("#dispno").val();
        var isRec = $("#isrec").val();        
        var ddrFrom = $(".ddr-from").val();
        var ddrTo = $(".ddr-to").val();        
        var ddrSub = CKEDITOR.instances.ddrdocsubject.getData();
        if(ddrType === 0){
            $(that).data('isNew',false);
        }
        $("#err").empty();
        if(typeof(ddrCat) === "undefined"){
            $(that).attr("disabled",false);
            $("#err-message").dialog( "open" );
            $("#err").html("Please select either receiving or dispatching!");
            return;
        }
        if (!docFileNo) {
            $(that).attr("disabled",false);
            $("#err-message").dialog( "open" );
            $("#err").html("Please enter the document or file number!");
            return;
        }        
        if (ddrCat == 1){
            if(ddrDespNo == '') {
                $(that).attr("disabled",false);
                $("#err-message").dialog( "open" );
                $("#err").html("Please enter a despacth no!");
                return;
            }
        }
        /*if ($('.ddr-rcv').is(':checked')){
            if (!ddrFrom) {
                $("#err-message").dialog( "open" );
                $("#err").html("Please select from where it is being received!");
                return;
            }
        }*/
        if ($('.ddr-disp').is(':checked')){
            if (!ddrTo) {
                $(that).attr("disabled",false);
                $("#err-message").dialog( "open" );
                $("#err").html("Please select to where it will be send!");
                return;
            }
        }
        if (!ddrSub) {
            $(that).attr("disabled",false);
            $("#err-message").dialog( "open" );
            $("#err").html("Please enter a subject of the document or file!");
            return;
        }
        if (ddrType == 1) {
            var checkObj = {};
            checkObj.chFile = true;
            checkObj.file = encodeURIComponent(docFileNo);
            $.ajax({
                url : "sync?" + new Date().getTime(),
                type : 'post',
                async : false,
                data : checkObj,
                success : function(data){
                    var obj = $.parseJSON(data);
                    $(that).data('isNew',obj.isNew);
                    if (obj.isNew === true) {
                        $("#create-message").data("fno",obj.fno).dialog( "open" );
                        $("#info").html(obj.message);
                        $(that).attr("disabled",false);
                        return;
                    } else {
                        $(that).data('isNew',obj.isNew);
                    }
                },
                error : function(err){}
            });
        }
        var jsonObj = {};
        if($(that).data('isNew') == false){
            if (isRec == "N") {
                if ($('.ddr-disp').is(':checked')) {
                    $(that).attr("disabled",false);
                    $("#err-message").dialog( "open" );
                    $("#err").html("You must receive first before dispatching!");
                    return;
                }
                jsonObj.ddrUpdateRec = true;
                jsonObj.despNo = previousDispNo;
                jsonObj.isRec = isRec;
            } else {
                jsonObj.ddrSave = true;
                jsonObj.despNo = ddrDespNo;
                jsonObj.ddrCat = ddrCat; //receiving or dispatched
                jsonObj.ddrType = ddrType; //document or file
                if ($("#actualId").val() === "") {
                    jsonObj.docFileNo = encodeURIComponent(docFileNo);
                } else {
                    jsonObj.docFileNo = $("#actualId").val().trim();
                }
                jsonObj.ddrFrom = ddrFrom;
                jsonObj.ddrTo = ddrTo;
                jsonObj.ddrSub = encodeURIComponent(ddrSub);                
                jsonObj.actualId = $("#actualId").val();
            }            
            $.ajax({
                url : "sync?" + new Date().getTime(),
                type : 'post',
                data : jsonObj,
                success : function(data){
                    var obj = $.parseJSON(data);
                    if (obj.err === true) {
                        $("#err-message").dialog( "open" );
                        $("#err").html(obj.message);
                        $(that).attr("disabled",false);
                        return;
                    } else {
                        $(that).attr("disabled",false);
                        $("#info-message").dialog( "open" );
                        $("#msg").html(obj.message);                    
                    }
                },
                error : function(err){$(that).attr("disabled",false);}
            });
        }
    });
    $(".ddr-dash-index").on("click",function(){
        window.location.href = "./home?session=" + $("#ddr-sess-val").val();
    });
    $(".ddr-dash-board").on("click",function(){
        window.location.href = "./entry?session=" + $("#ddr-sess-val").val();
    });
    $(".ddr-log-out").on("click",function(){
        $("#logout-message").dialog( "open" );        
        return;
    });       
    /*$(".ddr-rcv").on("click", function(){
        $(".ddr-disp-no").hide();
        $(".ddr-from").show();
        $(".ddr-to").hide();
    });*/
    $(".ddr-disp").on("click", function(){
        $(".ddr-disp-no").show();
        $(".ddr-from").hide();
        $(".ddr-to").show();
    });
    $(".ddr-dash-search").on("click",function(){
        $.ajax({
            url : "sync?" + new Date().getTime(),
            type : 'post',
            data : {searchPage:true},
            success : function(data){
                if (data) {
                    window.location.href = "./search?session=" + $("#ddr-sess-val").val();
                }
            },
            error : function(err){}
        });        
    });
    $(".ddr-search-txt").on("keyup",function(){
        var txtVal = $(this).val().trim();
        var jsonObj = {};
        jsonObj.srch = true;
        jsonObj.srchData = txtVal;
        $(".ddr-searched-data").empty();
        if (txtVal && txtVal.length >= 3) {
            $(".ddr-searched-data").html('<center><img src="images/loading.GIF" width="32" height="32" alt="" border="0"/><br/><br/><label style="color:#fff">Loading your data.....</label></center>');
            $.ajax({
                url : "./sync?" + new Date().getTime(),
                type : 'post',
                data : jsonObj,
                success : function(data){
                    var obj = $.parseJSON(data);
                    if (obj.length == 0) {
                        $(".ddr-searched-data").html("&nbsp;<font color='#fff' size='3'>Opps.....<br/>&nbsp;We could not find any data with this text!<br/>&nbsp;Try again!</font>");
                        return;
                    }
                    var htmlData = "<div class='ddr-find-count'>" + obj.length + " results found</div><br/><br/><br/><br/>";
                    for(var i = 0; i < obj.length; i++){
                        var id = $.parseJSON(obj[i]).dfid;
                        var no = $.parseJSON(obj[i]).dfno;
                        var tid = $.parseJSON(obj[i]).typeid;
                        var icl = $.parseJSON(obj[i]).isClosed;
                        var src = "";
                        if (tid == "N") {
                            var src = "images/dicon.png";
                            var alt = "Document";
                        }
                        else  {
                            var src = "images/ficon.png";
                            var alt = "File";
                        }
                        if (icl === 'N') {
                            var rcHtml = "<span class='ui-running'>Running</span>";
                        } else {
                            var rcHtml = "<span class='ui-closed'>Closed</span>";
                        }
                        htmlData = htmlData + '<img src="' + src + '" width="16" height="16" alt="' + alt + '" title="' + alt + '" border="0" style="vertical-align:middle"/>&nbsp;&nbsp;<a href="javascript:void(0);" onclick="javascript:getAllData(' + id + ');">' + no + '</a>&nbsp;&nbsp;' + rcHtml + '<br/><br/>';
                    }
                    $(".ddr-searched-data").html(htmlData);
                },
                error : function(err){}
            });
        }
    });
    $(".ddr-public-seasrch").on("click", function(){
        window.location.href = "./track";
    });
    $(".ddr-back").on("click", function(){
        window.location.href = "./";
    });
    $(".aus-ddr-update").on("click", function(){
        var that = this;
        var ddrCat = $("input[name='f-type']:checked").val();
        var ddrType = $("input[name='doc-file']:checked").val();
        var docFileNo = $(".ddr-doc-no").val().trim();
        var ddrDate = $(".ddr-date").val().trim();
        var ddrFrom = $(".ddr-from").val();
        var ddrTo = $(".ddr-to").val();
        var ddrDespNo = $(".ddr-disp-no").val();
        var ddrSub = CKEDITOR.instances.ddrdocsubject.getData();
        $("#err").empty();
        if (ddrCat == 1){
            if(ddrDespNo == '') {
                $("#err-message").dialog( "open" );
                $("#err").html("Please enter a despacth no!");
                return;
            }
        } else {
            ddrDespNo = '';
        }
        if (!ddrFrom) {
            $("#err-message").dialog( "open" );
            $("#err").html("Please select from where it is being received!");
            return;
        }
        if (!ddrTo) {
            $("#err-message").dialog( "open" );
            $("#err").html("Please select to where it will be send!");
            return;
        }
        if (!ddrSub) {
            $("#err-message").dialog( "open" );
            $("#err").html("Please enter a subject of the document or file!");
            return;
        }
        var jsonObj = {};
        jsonObj.ddrUpdate = true;
        jsonObj.id = $(this).attr("data-val");
        jsonObj.ddrCat = ddrCat;
        jsonObj.ddrType = ddrType;
        jsonObj.ddrDate = encodeURIComponent(ddrDate);
        jsonObj.ddrFrom = ddrFrom;
        jsonObj.ddrTo = ddrTo;
        jsonObj.ddrSub = encodeURIComponent(ddrSub);
        jsonObj.despNo = ddrDespNo;
        $(this).attr("disabled",true);
        $.ajax({
            url : "sync?" + new Date().getTime(),
            type : 'post',
            data : jsonObj,
            success : function(data){
                var obj = $.parseJSON(data);
                if (obj.err === true) {
                    $("#err-message").dialog( "open" );
                    $("#err").html(obj.message);
                    $(that).attr("disabled",false);
                    return;
                } else {
                    $("#info-message").dialog( "open" );
                    $("#msg").html(obj.message);                    
                }
            },
            error : function(err){}
        });
    });
    $(".ddr-exp-single-date").datepicker({"dateFormat":"dd/mm/yy","maxDate": "0"});
    $(".ddr-dash-single-day-report").on("click", function(){
        $.ajax({
            url : "./sync?" + new Date().getTime(),
            type : 'post',
            data : {sdr:true},
            success : function(data){
                if (data) {
                    window.location.href = "./single-day-report?session=" + $("#ddr-sess-val").val();
                }
            },
            error : function(err){
                $("#err-message").dialog( "open" );
                $("#err").html(err.status + ":" + err.statusText);
                return;
            }
        });
    });
    $(".ddr-single-day-rpt-btn").on("click",function(){
        var sdate = $(".ddr-exp-single-date").val().trim();
        if (!sdate) {
            $("#err-message").dialog( "open" );
            $("#err").html("Please select a date");
            return;
        }
        var jsonObj = {};
        jsonObj.sdrgen = true;
        jsonObj.sdate = encodeURIComponent(sdate);
        $(".ddr-searched-data").html('<center><img src="images/loading.GIF" width="32" height="32" alt="" border="0"/><br/><br/><label style="color:#fff">Loading your data.....</label></center>');
        $.ajax({
            url : "./sync?" + new Date().getTime(),
            type : 'post',
            data : jsonObj,
            success : function(data){
                var obj = $.parseJSON(data);                
                var htmlData = '';
                if (obj.length == 0) {
                    $(".ddr-searched-data").html("&nbsp;<font color='#fff' size='3'>Opps.....<br/>&nbsp;We could not find any data with this date!<br/>&nbsp;Try again!</font>");
                    return;
                }
                var htmlData = "<div class='ddr-find-count'>" + obj.length + " results found</div><br/><br/><br/><br/>";
                for(var i = 0; i < obj.length; i++){
                    var id = $.parseJSON(obj[i]).dfid;
                    var no = $.parseJSON(obj[i]).dfno;
                    var tid = $.parseJSON(obj[i]).typeid;
                    var src = "";
                    if (tid == "N") {
                        var src = "images/dicon.png";
                        var alt = "Document";
                    }
                    else  {
                        var src = "images/ficon.png";
                        var alt = "File";
                    }                        
                    htmlData = htmlData + '<img src="' + src + '" width="16" height="16" alt="' + alt + '" title="' + alt + '" border="0" style="vertical-align:middle"/>&nbsp;&nbsp;<a href="javascript:void(0);" onclick="javascript:getAllData(' + id + ');">' + no + '</a><br/><br/>';
                }
                $(".ddr-searched-data").html(htmlData);
            },
            error : function(err){}
        });
    });
    $(".ddr-exp-fdate").datepicker({"dateFormat":"dd/mm/yy","maxDate": "0"});
    $(".ddr-exp-ldate").datepicker({"dateFormat":"dd/mm/yy","maxDate": "0"});
    $(".ddr-dash-multi-day-report").on("click", function(){
        $.ajax({
            url : "./sync?" + new Date().getTime(),
            type : 'post',
            data : {mdr:true},
            success : function(data){
                if (data) {
                    window.location.href = "./multiple-day-report?session=" + $("#ddr-sess-val").val();
                }
            },
            error : function(err){
                $("#err-message").dialog( "open" );
                $("#err").html(err.status + ":" + err.statusText);
                return;
            }
        });
    });
    $(".ddr-multi-day-rpt-btn").on("click",function(){
        var fdate = $(".ddr-exp-fdate").val().trim();
        var ldate = $(".ddr-exp-ldate").val().trim();
        if (!fdate) {
            $("#err-message").dialog( "open" );
            $("#err").html("Please select a start date");
            return;
        }
        if (!ldate) {
            $("#err-message").dialog( "open" );
            $("#err").html("Please select a end date");
            return;
        }
        var jsonObj = {};
        jsonObj.mdrgen = true;
        jsonObj.fdate = encodeURIComponent(fdate);
        jsonObj.ldate = encodeURIComponent(ldate);
        $(".ddr-searched-data").html('<center><img src="images/loading.GIF" width="32" height="32" alt="" border="0"/><br/><br/><label style="color:#fff">Loading your data.....</label></center>');
        $.ajax({
            url : "./sync?" + new Date().getTime(),
            type : 'post',
            data : jsonObj,
            success : function(data){
                var obj = $.parseJSON(data);                
                var htmlData = '';
                if (obj.length == 0) {
                    $(".ddr-searched-data").html("&nbsp;<font color='#fff' size='3'>Opps.....<br/>&nbsp;We could not find any data between these dates!<br/>&nbsp;Try again!</font>");
                    return;
                }
                var htmlData = "<div class='ddr-find-count'>" + obj.length + " results found</div><br/><br/><br/><br/>";
                $(".ddr-searched-data").empty();
                for(var i = 0; i < obj.length; i++){
                    var id = $.parseJSON(obj[i]).dfid;
                    var no = $.parseJSON(obj[i]).dfno;
                    var tid = $.parseJSON(obj[i]).typeid;
                    var src = "";
                    if (tid == "N") {
                        var src = "images/dicon.png";
                        var alt = "Document";
                    }
                    else  {
                        var src = "images/ficon.png";
                        var alt = "File";
                    }                        
                    htmlData = htmlData + '<img src="' + src + '" width="16" height="16" alt="' + alt + '" title="' + alt + '" border="0" style="vertical-align:middle"/>&nbsp;&nbsp;<a href="javascript:void(0);" onclick="javascript:getAllData(' + id + ');">' + no + '</a><br/><br/>';                    
                }
                $(".ddr-searched-data").html(htmlData);                
            },
            error : function(err){}
        });
    });
    $(".ddr-dash-acc").on("click", function(){
        $("#acc-change").dialog("open");        
    });
    $(".ui-do-auth").on("click",function(){
        var _this = this;
        var name = $(".ddr-screen-name").val().trim();
        var dept = $(".ddr-user-dept").val();
        var email = $(".ddr-user-mail").val().trim();
        /*if (!name) {
            $("#err-message").dialog( "open" );
            $("#err").html("Name is left blank<br/>You must enter a name!");
            return;
        }*/
        if (!dept) {
            $("#err-message").dialog( "open" );
            $("#err").html("Department is not selected<br/>You must select a department!");
            return;
        }
        if (!email) {
            $("#err-message").dialog( "open" );
            $("#err").html("Email is left blank<br/>You must enter your email id!");
            return;
        } else {
            var arr = email.split("@");
            if (arr[1] !== "aus.ac.in") {
                $("#err-message").dialog( "open" );
                $("#err").html("You must enter your AUS email id!");
                return;
            }
        }
        var jsonObj = {};
        jsonObj.reg = true;
        jsonObj.name = '';
        jsonObj.dept = encodeURIComponent(dept);
        jsonObj.email = encodeURIComponent(email);
        $(this).attr("disabled",true);
        $("#process-message").dialog( "open" );        
        $.ajax({
            url : "./sync?" + new Date().getTime(),
            type : 'post',
            data : jsonObj,
            success : function(data){
                var obj = $.parseJSON(data);                
                if (obj.err) {
                    $("#err-message").dialog( "open" );
                    $("#err").html(obj.message);
                    return;
                } else {                    
                    $("#info-message").dialog( "open" );
                    $("#msg").html(obj.message);
                    return;
                }
            },
            error : function(err){
                $("#close-file").dialog( "open" );
                $("#err").html(err.status + ":" + err.statusText);
                return;
            }
        });
    });    
    $(".ui-create-btn").on("click",function(){
        var filename = $(".ui-create-file").val().trim();
        var filetitle = $(".ui-create-file-title").val().trim();
        if (!filename) {
            $("#err-message").dialog( "open" );
            $("#err").html("Please enter a file name");
            return;
        }
        if (!filetitle) {
            $("#err-message").dialog( "open" );
            $("#err").html("Please enter a file title");
            return;
        }
        $("#err").empty();
        $("#create-confirm-message").data('fno',filename).data('ftit',filetitle).dialog( "open" );
        $("#err-con").html("By clicking 'Confirm' button, you are going to create a file with no. <b><i>" + filename + "</i></b><br/><br/>Please make sure that <b><i>" + $(".ui-des").text() + "</i></b> is the owner of this file.");
        return;
    });    
});
function getAllData(args,val,id) {    
    $("#info-doc-file").dialog('open');
    if (id !== undefined) {
        var _id = id;
    }
    if (val === 1) {
        var receiveBtn = {
            "Receive": function () {                
                var _isRec = "N";
                var _jsonObj = {};
                _jsonObj.ddrUpdateRec = true;
                _jsonObj._despNo = _id;
                _jsonObj._isRec = _isRec;
                $.ajax({
                    url : "./sync?" + new Date().getTime(),
                    type : 'post',
                    data : _jsonObj,
                    success : function(data){
                        var obj = $.parseJSON(data);
                        if (obj.err === true) {
                            $("#err-message").dialog( "open" );
                            $("#err").html(obj.message);
                            $(that).attr("disabled",false);
                            return;
                        } else {
                            $("#info-message").dialog( "open" );
                            $("#msg").html(obj.message);                    
                        }
                    },
                    error : function(err){
                        $("#close-file").dialog( "open" );
                        $("#err").html(err.status + ":" + err.statusText);
                        return;
                    }
                });
            }
        };
        $("#info-doc-file").dialog('option', 'buttons', receiveBtn);
    } else {
        var receiveBtn = {};
        $("#info-doc-file").dialog('option', 'buttons', receiveBtn);
    }
    
    var jsonObj = {};
    jsonObj.info = true;
    jsonObj.dfid = args;
    $(".ddr-sub-text").empty();
    $(".ddr-df-info").empty();
    $(".ddr-df-info").html("<center><img src='images/loading.GIF' width='50' height='50' border='0' alt='' style='margin-top:10%' /><br/><br/>Loading.....</center>");
    $.ajax({
        url : "./sync?" + new Date().getTime(),
        type : 'post',
        data : jsonObj,
        success : function(data){
            var obj = $.parseJSON(data);            
            var htmlString = "<table width='100%' cellspacing='2' cellpadding='2' align='center' class='ddr-info-table'>" +
                            "<tbody>" +
                                "<tr>" +
                                    "<td width='100%'><strong>Status : </strong>" + obj[0].basicinfo.isClosed + "&nbsp;&nbsp;" + obj[0].basicinfo.close + "</td>" + 
                                "</tr>" +
                                "<tr>" +
                                    "<td width='100%'><strong>Item Type : </strong>" + obj[0].basicinfo.type + "</td>" + 
                                "</tr>" +                                
                                "<tr>" +
                                    "<td width='100%'><strong>Item No. : </strong>" + obj[0].basicinfo.dfno + "</td>" + 
                                "</tr>" +
                                "<tr>" +
                                    "<td width='100%'><strong>Item Title : </strong>" + obj[0].basicinfo.ftitle + "</td>" + 
                                "</tr>" +
                                "<tr>" +
                                    "<td width='100%'><strong>Item Subject. : </strong><a href='javascript:void(0);' onclick='javascript:subjectPopup(this);' id='ddr-subct-text'>" + obj[0].basicinfo.subject + "</a></td>" + 
                                "</tr>" + 
                                "<tr>" +
                                    "<td width='100%'><strong>Item Transitions(Reverse Chronological Order): </td>" + 
                                "</tr>" +
                                "<tr class='ddr-info-header'>" +
                                    "<table width='100%' cellspacing='0' cellpadding='0' align='center'>" +
                                        "<tr class='ddr-info-header-inner'>" +
                                            "<td width='5%' align='center'>Sl.</td>" +
                                            "<td width='30%' align='center'>From</td>" +
                                            "<td width='30%' align='center'>To</td>" +
                                            "<td width='20%' align='center'>Dispatched</td>" +
                                            "<td width='15%' align='center'>Received</td>" +
                                        "</tr>";
                        for(var i = obj[1].transinfo.length - 1; i>=0; i--){
                            if (obj[1].transinfo[i].editable == true) {
                                var htmlButton = '<a href="javascript:void(0);" class="aus-logger-edit" onclick="javascript:editData(' + obj[1].transinfo[i].id + ')">Edit</a>';
                            } else {
                                var htmlButton = '';
                            }
                            if (i % 2 == 0) {
                                htmlString +=  "<tr class='ddr-info-td-inner ddr-even'>" +
                                            "<td width='5%' valign='middle' align='center'>" + (i + 1) + "</td>" +
                                            "<td width='30%' align='center'>" + obj[1].transinfo[i].from + "</td>" +
                                            "<td width='30%' align='center'>" + obj[1].transinfo[i].to + "</td>" +
                                            "<td width='20%' align='center'>" + obj[1].transinfo[i].disp + "</td>" +
                                            "<td width='15%' align='center'>" + obj[1].transinfo[i].recv + "</td>" +
                                        "</tr>"
                            } else {
                                htmlString +=  "<tr class='ddr-info-td-inner ddr-odd'>" +
                                            "<td width='5%' valign='middle' align='center'>" + (i + 1) + "</td>" +
                                            "<td width='30%' align='center'>" + obj[1].transinfo[i].from + "</td>" +
                                            "<td width='30%' align='center'>" + obj[1].transinfo[i].to + "</td>" +
                                            "<td width='20%' align='center'>" + obj[1].transinfo[i].disp + "</td>" +
                                            "<td width='15%' align='center'>" + obj[1].transinfo[i].recv + "</td>" +
                                        "</tr>"
                            }
                        }
                            htmlString +="</table></tr>"
                            htmlString +=  "</tbody>" +
                       "</table>";
            $(".ddr-df-info").html(htmlString);
        },
        error : function(err){
            $("#err-message").dialog( "open" );
            $("#err").html(err.status + ":" + err.statusText);
            return;
        }
    });    
    $("#ddr-sub-details").dialog({
        autoOpen: false,
        modal: true,
        height: 200,
        width : 450
    });
}
function editData(slid) {
    window.location.href = './update?session=' + $("#ddr-sess-val").val() + '&id=' + slid;
}
function closeFile(dfid){
    $("#close-file").data('dfid',dfid).dialog( "open" );
    return;
}
function subjectPopup(ref){
    $(".ddr-sub-text").empty();
    var text = $(ref).html();
    $("#ddr-sub-details").dialog("open");
    $(".ddr-sub-text").html(text);
}
