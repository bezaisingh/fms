<script type="text/javascript">
    $(document).ready(function(){
        $("#ui-pending-page").paging(<?php echo $ddr->get_pending_doc_file_info_count(); ?>, {
            perpage : 5,
            format: '[< nncnn >]',
            onSelect: function (page) {
                $(".ui-pending-data").html('<center style="margin-left:-10%!important"><img src="./images/autoload.gif" width="16" height="16" border="0" /><br/>Loading.....</center>');
                setTimeout(function(){
                    var pageno = page - 1;                        
                    $.ajax({
                        url : "./sync?" + new Date().getTime(),
                        type : 'post',
                        data : {gpdfi:true,pn:pageno},
                        success : function(data){                            
                            $(".ui-pending-data").empty();
                            var obj = $.parseJSON(data);
                            var htmlData = "";
                            if (obj.length > 0) { 
                                for(var i=0; i<obj.length; i++){
                                    htmlData = htmlData + '<li><a href="javascript:void(0);" onclick="javascript:getAllData(' + obj[i].dfid + ',1,' + obj[i].id + ');" title="' + obj[i].subj + '" data-dno="'+ obj[i].dispNo + '">' + obj[i].dfno + '</a>&nbsp;<span class="ui-data-text">has been sent to you from <i>' + obj[i].from + '</i> on ' + obj[i].date + ' at ' + obj[i].time + ' with dispatched no <label style="vertical-align:top;font-style:italic">' + obj[i].dispNo + '</label></span>&nbsp;<span class="' + obj[i].cls + '">' + obj[i].dftype + '</span></li>'
                                }
                            }                               
                            $(".ui-pending-data").html(htmlData);
                        },
                        error : function(err){
                            $("#err-message").dialog( "open" );
                            $("#err").html(err.status + ":" + err.statusText);
                            $(that).attr("disabled",false);
                            return;
                        }
                    });
                },500);
            },
            onFormat: function (type) {
                switch (type) {
                case 'block': // n and c
                    if (!this.active)
                        return '<span class="disabled">' + this.value + '</span>';
                    else if (this.value != this.page)
                        return '<em><a href="#' + this.value + '">' + this.value + '</a></em>';
                    return '<em><span class="current">' + this.value + '</span>';
                case 'next': // >
                    return '<a>&gt;</a>';
                case 'prev': // <
                    return '<a>&lt;</a>';
                case 'first': // [
                    return '<a>first</a>';
                case 'last': // ]
                    return '<a>last</a>';
                }
            }
        });
        $("#ui-received-page").paging(<?php echo $ddr->get_received_doc_file_info_count(); ?>, {
            perpage : 5,
            format: '[< nncnn >]',
            onSelect: function (page) {
                $(".ui-received-data").html('<center style="margin-left:-10%!important"><img src="./images/autoload.gif" width="16" height="16" border="0" /><br/>Loading.....</center>');
                setTimeout(function(){
                    var pageno = page - 1;                        
                    $.ajax({
                        url : "./sync?" + new Date().getTime(),
                        type : 'post',
                        data : {grdfi:true,pn:pageno},
                        success : function(data){                            
                            $(".ui-received-data").empty();
                            var obj = $.parseJSON(data);
                            var htmlData = "";                                
                            if (obj.length > 0) { 
                                for(var i=0; i<obj.length; i++){
                                    htmlData = htmlData + '<li><a href="javascript:void(0);" onclick="javascript:getAllData(' + obj[i].dfid + ');" title="' + obj[i].subj + '">' + obj[i].dfno + '</a>&nbsp;<span class="ui-data-text">has been received from <i>' + obj[i].from + '</i> on ' + obj[i].date + ' at ' + obj[i].time + ' with dispatched no <label style="vertical-align:top;font-style:italic">' + obj[i].dispNo + '</label></span>&nbsp;<span class="' + obj[i].cls + '">' + obj[i].dftype + '</span></li>'
                                }
                            }                               
                            $(".ui-received-data").html(htmlData);                            
                        },
                        error : function(err){
                            $("#err-message").dialog( "open" );
                            $("#err").html(err.status + ":" + err.statusText);
                            $(that).attr("disabled",false);
                            return;
                        }
                    });
                },500);
            },
            onFormat: function (type) {
                switch (type) {
                case 'block': // n and c
                    if (!this.active)
                        return '<span class="disabled">' + this.value + '</span>';
                    else if (this.value != this.page)
                        return '<em><a href="#' + this.value + '">' + this.value + '</a></em>';
                    return '<em><span class="current">' + this.value + '</span>';
                case 'next': // >
                    return '<a>&gt;</a>';
                case 'prev': // <
                    return '<a>&lt;</a>';
                case 'first': // [
                    return '<a>first</a>';
                case 'last': // ]
                    return '<a>last</a>';
                }
            }
        });            
        $("#ui-dispatcehd-page").paging(<?php echo $ddr->get_dispathced_doc_file_info_count(); ?>, {
            perpage : 5,
            format: '[< nncnn >]',
            onSelect: function (page) {
                $(".ui-dispatcehd-data").html('<center style="margin-left:-10%!important"><img src="./images/autoload.gif" width="16" height="16" border="0" /><br/>Loading.....</center>');
                setTimeout(function(){
                    var pageno = page - 1;                        
                    $.ajax({
                        url : "./sync?" + new Date().getTime(),
                        type : 'post',
                        data : {gddfi:true,pn:pageno},
                        success : function(data){                            
                            $(".ui-dispatcehd-data").empty();
                            var obj = $.parseJSON(data);
                            var htmlData = "";                                
                            if (obj.length > 0) { 
                                for(var i=0; i<obj.length; i++){
                                    htmlData = htmlData + '<li><a href="javascript:void(0);" onclick="javascript:getAllData(' + obj[i].dfid + ');" title="' + obj[i].subj + '">' + obj[i].dfno + '</a>&nbsp;<span class="ui-data-text">has been dispatched to <i>' + obj[i].from + '</i> on ' + obj[i].date + ' at ' + obj[i].time + ' with dispatched no <label style="vertical-align:top;font-style:italic">' + obj[i].dispNo + '</label></span>&nbsp;<span class="' + obj[i].cls + '">' + obj[i].dftype + '</span></li>'
                                }
                            }                               
                            $(".ui-dispatcehd-data").html(htmlData);                            
                        },
                        error : function(err){
                            $("#err-message").dialog( "open" );
                            $("#err").html(err.status + ":" + err.statusText);
                            $(that).attr("disabled",false);
                            return;
                        }
                    });
                },500);
            },
            onFormat: function (type) {
                switch (type) {
                case 'block': // n and c
                    if (!this.active)
                        return '<span class="disabled">' + this.value + '</span>';
                    else if (this.value != this.page)
                        return '<em><a href="#' + this.value + '">' + this.value + '</a></em>';
                    return '<em><span class="current">' + this.value + '</span>';
                case 'next': // >
                    return '<a>&gt;</a>';
                case 'prev': // <
                    return '<a>&lt;</a>';
                case 'first': // [
                    return '<a>first</a>';
                case 'last': // ]
                    return '<a>last</a>';
                }
            }
        });
        $("#ui-closed-page").paging(<?php echo $ddr->get_closed_doc_file_info_count(); ?>, {
            perpage : 5,
            format: '[< nncnn >]',
            onSelect: function (page) {
                $(".ui-closed-data").html('<center style="margin-left:-10%!important"><img src="./images/autoload.gif" width="16" height="16" border="0" /><br/>Loading.....</center>');
                setTimeout(function(){
                    var pageno = page - 1;                        
                    $.ajax({
                        url : "./sync?" + new Date().getTime(),
                        type : 'post',
                        data : {gcdfi:true,pn:pageno},
                        success : function(data){                            
                            $(".ui-closed-data").empty();
                            var obj = $.parseJSON(data);
                            var htmlData = "";                                
                            if (obj.length > 0) { 
                                for(var i=0; i<obj.length; i++){
                                    htmlData = htmlData + '<li><a href="javascript:void(0);" onclick="javascript:getAllData(' + obj[i].dfid + ');" title="' + obj[i].subj + '">' + obj[i].dfno + '</a>&nbsp;<span class="ui-data-text">has been closed with the dispatched no <label style="vertical-align:top;font-style:italic">' + obj[i].dispNo + '</label></span></li>';
                                }
                            }
                            $(".ui-closed-data").html(htmlData);                            
                        },
                        error : function(err){
                            $("#err-message").dialog( "open" );
                            $("#err").html(err.status + ":" + err.statusText);
                            $(that).attr("disabled",false);
                            return;
                        }
                    });
                },500);
            },
            onFormat: function (type) {
                switch (type) {
                case 'block': // n and c
                    if (!this.active)
                        return '<span class="disabled">' + this.value + '</span>';
                    else if (this.value != this.page)
                        return '<em><a href="#' + this.value + '">' + this.value + '</a></em>';
                    return '<em><span class="current">' + this.value + '</span>';
                case 'next': // >
                    return '<a>&gt;</a>';
                case 'prev': // <
                    return '<a>&lt;</a>';
                case 'first': // [
                    return '<a>first</a>';
                case 'last': // ]
                    return '<a>last</a>';
                }
            }
        });
        $("#ui-created-page").paging(<?php echo $ddr->get_create_file_info_count(); ?>, {
            perpage : 5,
            format: '[< nncnn >]',
            onSelect: function (page) {
                $(".ui-create-data").html('<center style="margin-left:-10%!important"><img src="./images/autoload.gif" width="16" height="16" border="0" /><br/>Loading.....</center>');
                setTimeout(function(){
                    var pageno = page - 1;                        
                    $.ajax({
                        url : "./sync?" + new Date().getTime(),
                        type : 'post',
                        data : {gcfi:true,pn:pageno},
                        success : function(data){                            
                            $(".ui-create-data").empty();
                            var obj = $.parseJSON(data);
                            var htmlData = "";                                
                            if (obj.length > 0) { 
                                for(var i=0; i<obj.length; i++){
                                    htmlData = htmlData + '<li><a href="javascript:void(0);">' + obj[i].dfno + '</a>&nbsp;<span class="ui-data-text">has been created on ' + obj[i].ctime + ' with the matter id <label style="color:#009900;vertical-align:top">' + obj[i].mid + '</label></span></li>';
                                }
                            }
                            $(".ui-create-data").html(htmlData);                            
                        },
                        error : function(err){
                            $("#err-message").dialog( "open" );
                            $("#err").html(err.status + ":" + err.statusText);
                            $(that).attr("disabled",false);
                            return;
                        }
                    });
                },500);
            },
            onFormat: function (type) {
                switch (type) {
                case 'block': // n and c
                    if (!this.active)
                        return '<span class="disabled">' + this.value + '</span>';
                    else if (this.value != this.page)
                        return '<em><a href="#' + this.value + '">' + this.value + '</a></em>';
                    return '<em><span class="current">' + this.value + '</span>';
                case 'next': // >
                    return '<a>&gt;</a>';
                case 'prev': // <
                    return '<a>&lt;</a>';
                case 'first': // [
                    return '<a>first</a>';
                case 'last': // ]
                    return '<a>last</a>';
                }
            }
        });
        <?php
        if(isset($fno)){
            ?>
            $('#tabs a[href="#tabs-create-file"]').trigger('click');
            <?php
        }
        ?>
    });
</script>