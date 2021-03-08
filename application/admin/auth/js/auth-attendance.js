$(document).ready(function(){
    $("#err-message").dialog({
        autoOpen: false,
        modal: true,
        width:400,
        height:150,
        buttons: {
          Ok: function() {
            $( this ).dialog( "close" );
          }
        }
    });
    $("#las-register-dialog").dialog({
        autoOpen: false,
        modal: true,
        width:400,
        height:170,
        buttons: {
          Ok: function() {
            $( this ).dialog( "close" );
            location.reload();
          }
        }
    });
    $(".ui-do-auth").on("click",function(){
        var name = $(".las-screen-name").val();
        var dept = $(".las-user-dept").val();
        var email = $(".las-user-mail").val();
        if (!name) {
            $("#err-message").dialog( "open" );
            $("#err").html("Please enter applicant's full name !");
            return;
        }
        if (!dept) {
            $("#err-message").dialog( "open" );
            $("#err").html("Please select applicant's department !");
            return;
        }
        if (!email) {
            $("#err-message").dialog( "open" );
            $("#err").html("Please enter applicant's email !");
            return;
        } else {
            var arr = email.split("@");
            if (arr[1] != "aus.ac.in") {
                $("#err-message").dialog( "open" );
                $("#err").html("Please enter AUS email !");
                return;
            }
        }
        var name = encodeURIComponent(name);
        var dept = encodeURIComponent(dept);
        var email = encodeURIComponent(email);
        var jsonObj = {};
        jsonObj.reg = true;
        jsonObj.name = name;
        jsonObj.dept = dept;
        jsonObj.email = email;
        $.ajax({
            url : "../../../application/controller/control.php?" + new Date().getTime(),
            type : 'post',
            data : jsonObj,
            success : function(data){
                var obj = $.parseJSON(data);
                if (obj.err === true) {
                    $("#err-message").dialog( "open" );
                    $("#err").html(obj.message);
                    return;
                } else {
                    $("#las-register-dialog").dialog("open");
                    $(".ui-reg-form-container").html(obj.message);                    
                }
            },
            error : function(err){}
        });
    });
});