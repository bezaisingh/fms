<?php
error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE ^ E_DEPRECATED);
class ddr{
    public function get_designations(){
        try{            
            $this->dbCon();
            $sql = mysql_query("select id,designation from ddr_designations order by designation asc");
            $html = "";
            while($r = mysql_fetch_object($sql)){
                $id = $r->id;
                $desig = stripslashes($r->designation);
                $html.= "<option value='$id'>$desig</option>";
            }
            echo $html;
        }catch(Exception $ex){}
    }
    public function get_departents(){
        try{            
            $this->dbCon();
            $sql = mysql_query("select id,dept_name from tbl_departments order by dept_name asc");
            $html = "";
            while($r = mysql_fetch_object($sql)){
                $id = $r->id;
                $dept = stripslashes($r->dept_name);
                $html.= "<option value='$id'>$dept</option>";
            }
            echo $html;
        }catch(Exception $ex){}
    }
  
public function ddr_sign_in($user,$pass){
        try{            
            $this->dbCon();
            $user = urldecode(stripslashes($user));
            $pass = base64_encode(urldecode(stripslashes($pass)));
            $user = $user.'@aus.ac.in';
            $sql = "select user_id,screen_name,user_dept from ddr_users where user_email='$user' and user_pass='$pass'";
            $count = mysql_num_rows(mysql_query($sql));
            if($count > 0 && $count == 1){                
                $result = mysql_fetch_object(mysql_query($sql));
                session_start();
                $_SESSION['logged_id'] = $result->user_id;
                $_SESSION['screen_name'] = stripslashes($result->screen_name);
                $sess_encode_id = sha1(base64_encode(session_id()));
                $_SESSION['session'] = $sess_encode_id;
                $_SESSION['logger_dept_id'] = $result->user_dept;
                return json_encode(array("auth" => true,"session" => $sess_encode_id));
            } else {
                return json_encode(array("auth" => false, "message" => "Authentication Failed!<br/>Either username or password id incorrect!<br/>Try again!"));
            }
        } catch(Exception $err){}
    }


    public function get_pending_doc_file_info_count(){
        try{
            session_start();
            $this->dbCon();
            $dept_id = $_SESSION['logger_dept_id'];
            $sqlCount = mysql_num_rows(mysql_query("select c.dfid,c.isFile,c.d_f_no,a.ddr_subject,a.ddr_date,a.ddr_time,b.designation from ddr_data a,ddr_designations b,ddr_doc_file c where a.ddr_to=$dept_id and a.isReceived='N' and a.doc_file_no=c.dfid and a.ddr_from=b.id and c.isClosed='N' order by a.id desc"));
            return $sqlCount;
        }catch(Exception $err){}
    }
    public function get_pending_doc_file_info($i){
        try{
            session_start();
            $this->dbCon();
            $dept_id = $_SESSION['logger_dept_id'];
            $i = $i * 5;
            $sql = mysql_query("select a.id,c.dfid,c.isFile,c.d_f_no,c.matter_id,a.ddr_subject,a.ddr_date,a.ddr_time,b.designation from ddr_data a,ddr_designations b,ddr_doc_file c where a.ddr_to=$dept_id and a.doc_file_no=c.dfid and a.isReceived='N' and a.ddr_from=b.id and c.isClosed='N' order by a.id desc limit $i,5");
            $arr = array();
            while($r = mysql_fetch_object($sql)){
                $dfno = stripslashes($r->d_f_no);
                $subj = strip_tags(stripslashes($r->ddr_subject));
                if($r->isFile == "Y"){
                    $type = 1;
                } else {
                    $type = 0;   
                }
                $id = $r->id;
                $date = stripslashes($r->ddr_date);
                $time = stripslashes($r->ddr_time);
                $from = stripslashes($r->designation);
                $dispNo = stripslashes($r->matter_id);
                $dfid = $r->dfid;
                if($type == 0){
                    $type = "Document";
                    $class = "ui-doc";
                } else {
                    $type = "File";
                    $class = "ui-file";
                }
                array_push($arr, array("id" => $id,"dfid" =>$dfid,"dispNo" => $dispNo, "dftype" =>$type, "dfno" => $dfno,"subj" => $subj, "cls" => $class, "date" => $date, "time" => $time, "from" => $from));
            }
            return json_encode($arr);
        } catch(Exception $err){}
    }
    public function get_received_doc_file_info_count(){
        try{
            session_start();
            $this->dbCon();
            $dept_id = $_SESSION['logger_dept_id'];
            $sqlCount = mysql_num_rows(mysql_query("select c.dfid,c.isFile,c.d_f_no,a.ddr_subject,a.ddr_date,a.ddr_time,b.designation from ddr_data a,ddr_designations b,ddr_doc_file c where a.ddr_to=$dept_id and a.isReceived='Y' and a.receiver_dept_id=$dept_id and a.doc_file_no=c.dfid and a.ddr_from=b.id and c.isClosed='N' order by a.id desc"));
            return $sqlCount;
        }catch(Exception $err){}
    }
    public function get_received_doc_file_info($i){
        try{
            session_start();
            $this->dbCon();
            $dept_id = $_SESSION['logger_dept_id'];
            $i = $i * 5;
            $sql = mysql_query("select c.dfid,c.isFile,c.d_f_no,c.matter_id,a.ddr_subject,a.ddr_rcv_date,a.ddr_rcv_time,b.designation from ddr_data a,ddr_designations b,ddr_doc_file c where a.ddr_to=$dept_id and a.isReceived='Y' and a.receiver_dept_id=$dept_id and a.doc_file_no=c.dfid and a.ddr_from=b.id and c.isClosed='N' and a.ddr_from=b.id order by a.id desc limit $i,5");
            $arr = array();
            while($r = mysql_fetch_object($sql)){               
                $dfno = stripslashes($r->d_f_no);
                $subj = strip_tags(stripslashes($r->ddr_subject));
                if($r->isFile == "Y"){
                    $type = 1;
                } else {
                    $type = 0;
                }
                $date = stripslashes($r->ddr_rcv_date);
                $time = stripslashes($r->ddr_rcv_time);
                $from = stripslashes($r->designation);
                $dispNo = stripslashes($r->matter_id);
                $dfid = $r->dfid;
                if($type == 0){
                    $type = "Document";
                    $class = "ui-doc";
                } else {
                    $type = "File";
                    $class = "ui-file";
                }
                array_push($arr, array("dfid" =>$dfid,"dftype" =>$type,"dispNo" => $dispNo, "dfno" => $dfno,"subj" => $subj, "cls" => $class, "date" => $date, "time" => $time, "from" => $from));
            }
            return json_encode($arr);
        } catch(Exception $err){}
    }
    public function get_dispathced_doc_file_info_count(){
        try{
            session_start();
            $this->dbCon();
            $dept_id = $_SESSION['logger_dept_id'];
            $sqlCount = mysql_num_rows(mysql_query("select c.dfid,c.isFile,c.d_f_no,a.ddr_subject,a.ddr_date,a.ddr_time,b.designation from ddr_data a,ddr_designations b,ddr_doc_file c where a.ddr_from=$dept_id and a.logger_dept_id=$dept_id and a.doc_file_no=c.dfid and a.ddr_to=b.id and c.isClosed='N' order by a.id desc"));
            return $sqlCount;
        }catch(Exception $err){}
    }
    public function get_dispathced_doc_file_info($i){
        try{
            session_start();
            $this->dbCon();
            $dept_id = $_SESSION['logger_dept_id'];
            $i = $i * 5;
            $sql = mysql_query("select c.dfid,c.isFile,c.d_f_no,c.matter_id,a.ddr_subject,a.ddr_date,a.ddr_time,b.designation from ddr_data a,ddr_designations b,ddr_doc_file c where a.ddr_from=$dept_id and a.logger_dept_id=$dept_id and a.doc_file_no=c.dfid and a.ddr_to=b.id and c.isClosed='N' order by a.id desc limit $i,5");
            $arr = array();
            while($r = mysql_fetch_object($sql)){
                $dfno = stripslashes($r->d_f_no);
                $subj = strip_tags(stripslashes($r->ddr_subject));
                if($r->isFile == "Y"){
                    $type = 1;
                } else {
                    $type = 0;
                }
                $date = stripslashes($r->ddr_date);
                $time = stripslashes($r->ddr_time);
                $from = stripslashes($r->designation);
                $dispNo = stripslashes($r->matter_id);
                $dfid = $r->dfid;
                if($type == 0){
                    $type = "Document";
                    $class = "ui-doc";
                } else {
                    $type = "File";
                    $class = "ui-file";
                }
                array_push($arr, array("dfid" =>$dfid,"dftype" =>$type,"dispNo" => $dispNo,"dfno" => $dfno,"subj" => $subj, "cls" => $class, "date" => $date, "time" => $time, "from" => $from));
            }
            return json_encode($arr);
        } catch(Exception $err){}
    }
    public function get_closed_doc_file_info_count(){
        try{
            session_start();
            $this->dbCon();
            $dept_id = $_SESSION['logger_dept_id'];
            $sqlCount = mysql_num_rows(mysql_query("select dfid from ddr_doc_file where isClosed='Y' and des_id=$dept_id and isFile='Y'"));
            return $sqlCount;
        }catch(Exception $err){}
    }
    public function get_closed_doc_file_info($i){
        try{            
            session_start();
            $this->dbCon();
            $dept_id = $_SESSION['logger_dept_id'];
            $i = $i * 5;            
            $sql = mysql_query("select distinct b.dfid,b.d_f_no,b.isFile,b.matter_id,a.ddr_subject from ddr_data a,ddr_doc_file b where b.isClosed='Y' and b.des_id=$dept_id and a.doc_file_no=b.dfid group by b.d_f_no order by a.id desc limit $i,5");
            $arr = array();
            while($r = mysql_fetch_object($sql)){
                $dfid = $r->dfid;
                $dfno = stripslashes($r->d_f_no);
                $subj = stripslashes($r->ddr_subject);
                $dispNo = stripslashes($r->matter_id);
                array_push($arr, array("dfid" =>$dfid,"dfno" => $dfno,"subj" => $subj,"dispNo" => $dispNo));
            }
            return json_encode($arr);
        } catch(Exception $err){}
    }
    public function get_create_file_info_count(){
        try{
            session_start();
            $this->dbCon();
            $dept_id = $_SESSION['logger_dept_id'];
            $sqlCount = mysql_num_rows(mysql_query("select dfid from ddr_doc_file where des_id=$dept_id and isFile='Y'"));
            return $sqlCount;
        }catch(Exception $err){}
    }
    public function get_create_file_info($i){
        try{            
            session_start();
            $this->dbCon();
            $dept_id = $_SESSION['logger_dept_id'];
            $i = $i * 5;
            $sql = mysql_query("select d_f_no,matter_id,create_date_time from ddr_doc_file where des_id=$dept_id and isFile='Y' order by dfid desc limit $i,5");
            $arr = array();
            while($r = mysql_fetch_object($sql)){
                $dfno = stripslashes($r->d_f_no);
                $mid = stripslashes($r->matter_id);
                $ctime = stripslashes($r->create_date_time);
                array_push($arr, array("dfno" => $dfno,"mid"=>$mid,"ctime" => $ctime));
            }
            return json_encode($arr);
        } catch(Exception $err){}
    }
    public function get_department_wise_tags(){
        try{            
            $this->dbCon();
            $sql = mysql_query("select designation,tag from ddr_designations order by designation asc");
            $html = "";
            $i = 0;
            while($r = mysql_fetch_object($sql)){
                if($i%2 == 0){
                    $html.='<span class="ui-even">'.$r->designation.' - <i>'.$r->tag.'</i></span>';
                } else {
                    $html.='<span class="ui-odd">'.$r->designation.' - <i>'.$r->tag.'</i></span>';
                }
                $i++;
            }
            echo $html;
        } catch(Exception $er){}
    }
    public function get_logger_designation(){
        try{            
            $this->dbCon();
            $dept_id = $_SESSION['logger_dept_id'];
            $sql = mysql_fetch_object(mysql_query("select designation from ddr_designations where id=$dept_id"));
            return stripslashes($sql->designation);
        } catch(Exception $err){}
    }
    
    public function get_dispatch_no(){
        try{
            $this->dbCon();
            $logger_dept_id = $_SESSION['logger_dept_id'];
            $sql_desp_no = mysql_num_rows(mysql_query("select id from ddr_data where logger_dept_id=$logger_dept_id"));
            $sql_dept_tag = mysql_fetch_object(mysql_query("select tag from ddr_designations where id=$logger_dept_id"));
            $disp_no = stripslashes($sql_dept_tag->tag).'-'.($sql_desp_no + 1);
            return $disp_no;
        } catch(Exception $err){}
    }
    public function ddr_save_data($ddrCat,$ddrType,$docFileNo,$ddrFrom,$ddrTo,$ddrSub,$despNo,$actualId){
        try{
            session_start();
            $this->dbCon();
            $docFileNo = addslashes(urldecode($docFileNo));
            if($ddrType == 0){
                $isNewDocFileSql = mysql_query("select dfid from ddr_doc_file where d_f_no='$docFileNo' and isFile='N'");
                if(mysql_num_rows($isNewDocFileSql) == 0){
                    mysql_query("insert into ddr_doc_file(d_f_no) values('$docFileNo')");
                    $actualId = mysql_insert_id();
                }
            }
            $q = mysql_fetch_object(mysql_query("select count(id) as cnt from ddr_data where doc_file_no=$actualId"));
            if($q->cnt == 0){
                $q = mysql_fetch_object(mysql_query("select max(doc_file_id) as maxid from ddr_data"));
                $max = $q->maxid + 1;                
            } else {
                $q = mysql_fetch_object(mysql_query("select doc_file_id from ddr_data where doc_file_no=$actualId"));
                $max = $q->doc_file_id;                
            }
            date_default_timezone_set("Asia/Kolkata");
            $ddrDate = date("d/m/Y",time());
            $ddrSub = addslashes(urldecode($ddrSub));
            $despNo = addslashes(urldecode($despNo));
            $dfid = $max;
            $userId = $_SESSION['logged_id'];
            $logger_dept_id = $_SESSION['logger_dept_id'];
            $sql = mysql_query("insert into ddr_data(doc_file_id,ddr_catagory,doc_file_no,ddr_date,ddr_time,ddr_from,ddr_to,ddr_subject,accessed_by,logger_dept_id) values($dfid,$ddrCat,$actualId,'$ddrDate',CURTIME(),$logger_dept_id,$ddrTo,'$ddrSub',$userId,$logger_dept_id)");
            if($sql){
                return json_encode(array("err" => false,"message" => "You Have Dispatched Successfully !<br/>Thank you!"));
            } else {
                return json_encode(array("err" => true,"message" => mysql_error()/*"Some problem had occured!<br/>Please try again!<br/>Thank you!"*/));
            }
        } catch(Exception $ex){}
    }
    public function ddr_update_data($despNo,$isRec){
        try{
            session_start();
            $this->dbCon();
            $userId = $_SESSION['logged_id'];
            $logger_dept_id = $_SESSION['logger_dept_id'];
            date_default_timezone_set("Asia/Kolkata");
            $date = date("d/m/Y",time());
            $sql = mysql_query("update ddr_data set isReceived='Y',ddr_rcv_date='$date',ddr_rcv_time=CURTIME(),receiver_dept_id=$logger_dept_id,accessby_receiver_id=$userId where id='$despNo' and isReceived='$isRec'");
            if($sql){
                return json_encode(array("err" => false,"message" => "You Have Received Successfully !<br/>Thank you!"));
            } else {
                return json_encode(array("err" => true,"message" => mysql_error()/*"Some problem had occured!<br/>Please try again!<br/>Thank you!"*/));
            }
        } catch(Exception $ex){}
    }
    public function ddr_autocomplete($autoText){
        try{
            session_start();
            $this->dbCon();
            $userId = $_SESSION['logged_id'];
            $autoText = urldecode($autoText);
            $sql = mysql_query("select dfid,d_f_no from ddr_doc_file where d_f_no like '%$autoText%' and isClosed='N' or matter_id like '%$autoText%' and isClosed='N'");
            $data_arr = array();
            while($r = mysql_fetch_object($sql)){
                $dfid =  $r->dfid; //actual d/f id
                $dfno = stripslashes($r->d_f_no);
                $inner_array = array("dfid" => $dfid, "dfno" => $dfno, "label" => $dfno);
                array_push($data_arr,$inner_array);                                     
            }
            return json_encode($data_arr);
        } catch(Exception $ex){}
    }
    public function ddr_doc_file_info($id){
        try{
            session_start();
            $this->dbCon();
            $sql = mysql_fetch_object(mysql_query("select ddr_subject from ddr_data where doc_file_id=$id"));
            $sub = stripslashes($sql->ddr_subject);
            return json_encode(array("subject" => $sub));
        } catch(Exception $ex){}
    }
    public function ddr_sign_out(){
        try{
            session_start();
            if(session_destroy()){
                return json_encode(array("signout" => true));
            } else {
                return json_encode(array("signout" => false, "message" => "Unable to logout.<br/>Try again."));
            }
        } catch(Exception $ex){}
    }
    public function is_session_set(){
        if(!isset($_SESSION['session'])){
            $_SESSION['session'] = sha1(base64_encode(session_id()));
        }
    }
    public function ddr_relocate_search_page(){
        session_start();
        $_SESSION['session'] = sha1(base64_encode(session_id()));
        return true;
    }
    public function ddr_search_result($txt){
        try{
            session_start();
            $this->dbCon();
            $userId = $_SESSION['logged_id'];
            $txt = stripslashes(urldecode($txt));
            $sql = mysql_query("select distinct a.doc_file_no from ddr_data a where a.doc_file_no in (select dfid from ddr_doc_file where d_f_no like '%$txt%' or matter_id like '%$txt%') or (a.ddr_subject like '%$txt%') group by a.doc_file_no order by a.id desc") or die(mysql_error());
            $dfarray = array();
            while($r = mysql_fetch_object($sql)){
                $dfid = stripslashes($r->doc_file_no);
                $r = mysql_fetch_object(mysql_query("select d_f_no,isFile,isClosed from ddr_doc_file where dfid=$dfid and isFile='Y'"));
                $dfno = stripslashes($r->d_f_no);
                $isFile = $r->isFile;
                $isClosed = $r->isClosed;
                array_push($dfarray,json_encode(array("dfid" => $dfid, "dfno" => $dfno, "typeid" => $isFile, "isClosed" => $isClosed)));
            }      
            return json_encode($dfarray);
        } catch(Exception $ex){}
    }
    public function ddr_document_file_info($dfid){
        try{
            session_start();
            $this->is_session_set();
            $this->dbCon();
            $logger_dept_id = $_SESSION['logger_dept_id'];
            if(isset($_SESSION['logger_dept_id'])){
                $sqlOriginator = mysql_fetch_object(mysql_query("select des_id from ddr_doc_file where dfid=$dfid and isFile='Y' and isClosed='N'"));
                if($logger_dept_id == $sqlOriginator->des_id){
                    $close = "<div class='ui-closed-file' title='Close this file' data-id='$dfid' onclick='javascript:closeFile($dfid)'></div>";
                } else {
                    $close = "";
                }
            } else {
                $close = "";
            }
            $sql = mysql_query("select b.isFile,b.d_f_no,b.file_title,a.ddr_date,a.ddr_time,a.ddr_from,a.ddr_to,a.ddr_subject,a.accessed_by,a.isReceived,a.ddr_rcv_date,a.ddr_rcv_time,b.isClosed from ddr_data a,ddr_doc_file b where a.doc_file_no = $dfid and a.doc_file_no=b.dfid order by a.id asc") or die(mysql_error());
            $dfarray = array();
            $transinfo = array();
            while($r = mysql_fetch_object($sql)){
                $info = array();                
                if($r->isFile == 'N'){
                    $type = "Document";
                } else {
                    $type = "File"; 
                }                
                $id = $r->id;
                $dfno = stripslashes($r->d_f_no);
                $title = stripslashes($r->file_title);
                $dfdate_disp = $r->ddr_date;
                $dftime_disp = $r->ddr_time;
                $dfdate_rec = $r->ddr_rcv_date;
                $dftime_rec = $r->ddr_rcv_time;
                $fromid = stripslashes($r->ddr_from);
                $toid = stripslashes($r->ddr_to);
                $sub = stripslashes($r->ddr_subject);
                $accessed_id = $r->accessed_by;
                $isReceived = $r->isReceived;
                $isClosed = $r->isClosed;
                $disp = "<div class='ui-disp-y' title='Dispatched on $dfdate_disp at $dftime_disp'></div>";
                if($r->isReceived == 'Y'){                    
                    $recv = "<div class='ui-rec-y' title='Received on $dfdate_rec at $dftime_rec'></div>";
                } else {
                    $recv = "<div class='ui-rec-n' title='Not yet received'></div>";
                }
                if($isClosed == "Y"){
                    $closeText = "<span class='ui-closed'>Closed</span>";
                } else {
                    $closeText = "<span class='ui-running'>Running</span>";
                }
                if($accessed_id == $_SESSION['logged_id']){
                    $editable = true;
                } else {
                    $editable = false;
                }
                $fromsql = mysql_fetch_object(mysql_query("select designation from ddr_designations where id=$fromid"));
                $from = stripslashes($fromsql->designation);
                $tosql = mysql_fetch_object(mysql_query("select designation from ddr_designations where id=$toid"));
                $to = stripslashes($tosql->designation);
                $info = array("type" => $type,"dfno" => $dfno,"ftitle" => $title, "subject" => $sub,"isClosed" => $closeText,"close" => $close);
                array_push($transinfo,array("id" => $id,"from" => $from, "to" => $to,"recv" => $recv,"disp" => $disp));
            }
            array_push($dfarray,array("basicinfo" => $info));
            array_push($dfarray,array("transinfo" => $transinfo));
            return json_encode($dfarray);
        } catch(Exception $ex){}
    }

/*
    public function get_editable_data($id){
        try{            
            $this->dbCon();
            $r = mysql_fetch_object(mysql_query("select ddr_catagory,ddr_type,doc_file_no,ddr_date,ddr_from,ddr_to,ddr_subject,ddr_despatch_no from ddr_data where id=$id"));
            return json_encode(array("cat" => $r->ddr_catagory,"type"=>$r->ddr_type,"dfno"=>$r->doc_file_no,"date"=>$r->ddr_date,"from"=>$r->ddr_from,"to"=>$r->ddr_to,"subject"=>$r->ddr_subject,"despno"=>$r->ddr_despatch_no));
        } catch(Exception $ex){}
    }
    public function ddr_update($id,$ddrCat,$ddrType,$ddrDate,$ddrFrom,$ddrTo,$ddrSub,$despNo){
        try{            
            $this->dbCon();
            $ddrDate = urldecode($ddrDate);
            $ddrSub = urldecode($ddrSub);
            $despNo = urldecode($despNo);
            if(mysql_query("update ddr_data set ddr_catagory='$ddrCat',ddr_type='$ddrType',ddr_date='$ddrDate',ddr_from='$ddrFrom',ddr_to='$ddrTo',ddr_subject='$ddrSub',ddr_despatch_no='$despNo' where id=$id")){
                return json_encode(array("err" => false,"message" => "Successfully Updated"));
            } else {
                return json_encode(array("err" => true,"message" => "Unable to update.<br/>Please try again!"));
            }
        } catch(Exception $ex){}
    } 

*/

    public function ddr_redirect_single_day_report(){
        session_start();
        $_SESSION['session'] = sha1(base64_encode(session_id()));
        return true;
    }
    public function ddr_generate_single_day_report($sdate){
        try{
            session_start();
            $this->dbCon();
            $logger_dept_id = $_SESSION['logger_dept_id'];
            $sdate = urldecode($sdate);
            $sql = mysql_query("select distinct doc_file_no from ddr_data where ddr_date='$sdate' and ddr_to='$logger_dept_id' order by id desc") or die(mysql_error());
            $dfarray1 = array();
            while($r = mysql_fetch_object($sql)){
                $dfid = $r->doc_file_no;
                $r = mysql_fetch_object(mysql_query("select d_f_no,isFile from ddr_doc_file where dfid=$dfid"));
                $dfno = stripslashes($r->d_f_no);
                $isFile = $r->isFile;
                array_push($dfarray1,json_encode(array("dfid" => $dfid, "dfno" => $dfno, "typeid" => $isFile)));
            }
            $sql = mysql_query("select distinct doc_file_no from ddr_data where ddr_date='$sdate' and ddr_from='$logger_dept_id' order by id desc") or die(mysql_error());
            $dfarray2 = array();
            while($r = mysql_fetch_object($sql)){
                $dfid = $r->doc_file_no;
                $r = mysql_fetch_object(mysql_query("select d_f_no,isFile from ddr_doc_file where dfid=$dfid"));
                $dfno = stripslashes($r->d_f_no);
                $isFile = $r->isFile;
                array_push($dfarray2,json_encode(array("dfid" => $dfid, "dfno" => $dfno, "typeid" => $isFile)));
            }
            $arr = array_values(array_unique(array_merge($dfarray1,$dfarray2)));
            return json_encode($arr);
        } catch(Exception $ex){}
    }
    public function ddr_redirect_multi_day_report(){
        session_start();
        $_SESSION['session'] = sha1(base64_encode(session_id()));
        return true;
    }
    public function ddr_generate_multiple_day_report($fdate,$ldate){
        try{
            session_start();
            $this->dbCon();
            $logger_dept_id = $_SESSION['logger_dept_id'];
            $fdate = urldecode($fdate);
            $ldate = urldecode($ldate);
            $sql1 = mysql_query("select distinct doc_file_no from ddr_data where ddr_date >= '$fdate' and ddr_date <= '$ldate' and ddr_to='$logger_dept_id' order by id desc") or die(mysql_error());
            $dfarray1 = array();
            while($r = mysql_fetch_object($sql1)){
                $dfid = $r->doc_file_no;
                $r = mysql_fetch_object(mysql_query("select d_f_no,isFile from ddr_doc_file where dfid=$dfid"));
                if($r->d_f_no){
                    $dfno = stripslashes($r->d_f_no);
                    $isFile = $r->isFile;
                    array_push($dfarray1,json_encode(array("dfid" => $dfid, "dfno" => $dfno, "typeid" => $isFile)));
                }
            }
            $sql2 = mysql_query("select distinct doc_file_no from ddr_data where ddr_date >= '$fdate' and ddr_date <= '$ldate' and ddr_from='$logger_dept_id' order by id desc") or die(mysql_error());
            $dfarray2 = array();
            while($r = mysql_fetch_object($sql2)){
                $dfid = $r->doc_file_no;
                $r = mysql_fetch_object(mysql_query("select d_f_no,isFile from ddr_doc_file where dfid=$dfid"));
                if($r->d_f_no){
                    $dfno = stripslashes($r->d_f_no);
                    $isFile = $r->isFile;
                    array_push($dfarray2,json_encode(array("dfid" => $dfid, "dfno" => $dfno, "typeid" => $isFile)));
                }
            }
            $arr = array_values(array_unique(array_merge($dfarray1,$dfarray2)));
            return json_encode($arr);
        } catch(Exception $ex){}
    }
    public function ddr_update_password($pass){
        try{
            session_start();
            $this->dbCon();
            $userId = $_SESSION['logged_id'];
            $pass = base64_encode(stripslashes(urldecode($pass)));
            $upsql = mysql_query("update ddr_users set user_pass='$pass' where user_id=$userId");
            if($upsql){
                return json_encode(array("update" => true));
            } else {
                return json_encode(array("update" => false,"message" => "Unable to update password.<br/>Please try again!"));
            }
        } catch(Exception $ex){}
    }
    public function ddr_register($name,$dept,$email){
        try{
            $this->dbCon();
            $name = addslashes(urldecode($name));
            $dept = urldecode($dept);
            $email = addslashes(urldecode($email));
            $pass = base64_encode("123456");
            $decoded_pass = base64_decode($pass);
            $sql_exist = "select user_id from ddr_users where user_email='$email'";
            if(mysql_num_rows(mysql_query($sql_exist)) > 0){
                return json_encode(array("err" => true,"message" => "Email <strong><i>$email</i></strong> is already registered<br/>Please use different one"));
            } else {
                $sql = "insert into ddr_users(screen_name,user_dept,user_email,user_pass) values('$name','$dept','$email','$pass')";
                if(mysql_query($sql)){            
                    /*$sub = "Authentication for DFMS";
                    $body = "$name, please find your password ($decoded_pass) for Online Document Monitoring System. This password is for your login purpose";
                    if(mail($email,$sub,$body)){*/
                        return json_encode(array("err" => false,"message" => "Registration process is successful<br/><br/>An Email has been sent to <strong>$name</strong> with the system generated password"));
                    /*} else {
                        return json_encode(array("err" => true,"message" => "Registered <strong><i>but</i></strong> unable to send email to <strong><i>$email</i></strong>. Please take help from your administrator to retrive the password"));
                    }*/
                }
            }
            $this->closeDbConn();
        } catch(Exception $err){
            return $err->getMessage();
            $this->closeDbConn();
        }
    }
    public function ddr_file_close($dfid){
        try{
            session_start();
            $this->dbCon();
            $logger_dept_id = $_SESSION['logger_dept_id'];            
            $file_close_sql = mysql_query("update ddr_doc_file set isClosed='Y' where dfid=$dfid and des_id=$logger_dept_id");
            if($file_close_sql){
                return json_encode(array("status" => true));
            } else {
                return json_encode(array("status" => false, "message" => "Unable to close this file.<br/>Please try again."));
            }
        } catch(Exception $er){}
    }
    public function chFile($file_name){
        try{
            session_start();
            $this->dbCon();
            $logger_dept_id = $_SESSION['logger_dept_id'];
            $file_name = urldecode($file_name);
            $sql = mysql_query("select dfid from ddr_doc_file where d_f_no='$file_name'");
            $ch_sql_count = mysql_num_rows($sql);
            if($ch_sql_count == 0){
                return json_encode(array("isNew" => true,"fno" =>$file_name, "message" => "We could not find <b><i>$file_name</i></b> in our database.<br/>Please create this file before dispatching.<br/><br/>Do you want to create?"));
            } else {
                $sql = mysql_fetch_object($sql);
                return json_encode(array("isNew" => false,"id" => $sql->dfid));
            }
        } catch(Exception $err){}
    }
    public function create_file($file_name,$file_title){
        try{
            session_start();
            $this->dbCon();
            $logger_dept_id = $_SESSION['logger_dept_id'];
            $file_name = addslashes(urldecode($file_name));
            $file_title = addslashes(urldecode($file_title));
            $sql = mysql_query("select dfid from ddr_doc_file where d_f_no='$file_name' and isClosed='N'");
            $ch_sql_count = mysql_num_rows($sql);
            if($ch_sql_count == 0){
                date_default_timezone_set("Asia/Kolkata");
                $date = date("d/m/Y H:i:s",time());
                $year = date('Y');
                $file_count = mysql_num_rows(mysql_query("select dfid from ddr_doc_file where des_id=$logger_dept_id and create_year=$year")) + 1;
                $tag = mysql_fetch_object(mysql_query("select tag from ddr_designations where id=$logger_dept_id"));
                $matter_id = stripslashes($tag->tag).'-'.$year.'-'.$file_count;
                $sql = mysql_query("insert into ddr_doc_file(d_f_no,file_title,matter_id,isFile,des_id,create_date_time,create_year) values('$file_name','$file_title','$matter_id','Y',$logger_dept_id,'$date','$year')");
                if($sql){
                    return json_encode(array("isNew" => true,"message" => '<strong><i>'.$file_name.'</i></strong> has been created successfully.'));
                }
            } else {
                $sql = mysql_fetch_object($sql);
                $midsql = mysql_fetch_object(mysql_query("select matter_id from ddr_doc_file where d_f_no='$file_name' and isClosed='N'"));
                $matter_id = stripslashes($midsql->matter_id);
                return json_encode(array("isNew" => false,"message" => 'Can not create this file.<br/><br/><strong><i>'.$file_name.'</i></strong> already exists in our system with the matter id <strong><i>'.$matter_id.'</i></strong><br/><br/>Please close this file with this matter id and reopen the file with new matter<br/><br/>Thank you'));
            }
        } catch(Exception $err){}
    }
    public function get_auto_text_document_file_info($dfid){
        try{
            session_start();
            $this->dbCon();
            $logger_dept_id = $_SESSION['logger_dept_id'];
            $id = $dfid;
            $sqlMax = mysql_fetch_object(mysql_query("select max(id) as mxid from ddr_data where doc_file_no=$id"));
            $maxid = $sqlMax->mxid;
            $sql = mysql_query("select a.id, a.doc_file_id,a.ddr_catagory,b.isFile,b.file_title,a.ddr_from,a.ddr_to,a.ddr_subject,a.isReceived,a.logger_dept_id,a.receiver_dept_id from ddr_data a,ddr_doc_file b where a.id=$maxid and a.doc_file_no=b.dfid");
            if(mysql_num_rows($sql) > 0){
                $r = mysql_fetch_object($sql);
                $ddr_cat = $r->ddr_catagory;
                if($r->isFile == 'Y'){
                    $ddr_type = 1;
                } else {
                    $ddr_type = 0;
                }
                $tr_is = $r->id;
                $ddr_from = $r->ddr_from;
                $ddr_to = $r->ddr_to;
                $ddr_subj = stripslashes($r->ddr_subject);
                $sql_matter_id = mysql_fetch_object(mysql_query("select matter_id from ddr_doc_file where dfid=$id and isClosed='N'"));
                $ddr_disp_no = stripslashes($sql_matter_id->matter_id); //dispatch no = matter id
                $isRcv = $r->isReceived;
                $deptId = $r->logger_dept_id;
                $file_title = stripslashes($r->file_title);
                $receiver_id = $r->receiver_dept_id;
            } else {
                $r = mysql_fetch_object(mysql_query("select isFile,matter_id,file_title from ddr_doc_file where dfid=$id and isClosed='N'"));
                if($r->isFile == 'Y'){
                    $ddr_type = 1;
                } else {
                    $ddr_type = 0;
                }
                $ddr_disp_no = stripslashes($r->matter_id);
                $file_title = stripslashes($r->file_title);
            }
            $inner_array = array("loggerId" => $logger_dept_id, "transid"=>$tr_is,"dcat" => $ddr_cat,"dtype" => $ddr_type,"from" => $ddr_from,"to" => $ddr_to,"subj" => $ddr_subj,"dispno" => $ddr_disp_no,"isRec" => $isRcv,"deptId" => $deptId,"actualid" => $id,"ftit" => $file_title, "recvrId" => $receiver_id);
            return json_encode($inner_array);
        } catch(Exception $err){}
    }


    public function user_pass_list(){
        try{
            $this->dbCon();
            $sql = mysql_query("select a.designation,b.user_email from ddr_designations a,ddr_users b where b.user_dept=a.id order by a.designation asc");
            $count = 0;
            $html = "";
            while($r = mysql_fetch_object($sql)){
                $count++;
                $designation = stripslashes($r->designation);
                $mail = stripslashes($r->user_email);
                $html.= "<tr>
                            <td>$count</td>
                            <td>$designation</td>
                            <td>$mail</td>
                            <td>12345</td> 
                        </tr>";
/*
the below commented code is the original one the above is modified on 04032021 by Bijay Singh at 03:00PM

$html.= "<tr>
                            <td>$count</td>
                            <td>$designation</td>
                            <td>$mail</td>
                           <td>12345</td> 
                        </tr>";
*/
            }
            return $html;
        } catch(Exception $er){}
    }


    public function dbCon(){
        $this->pdbCon();
    }
    private function pdbCon(){
        try{
            mysql_connect("localhost","userddr","ausdb123!@#");
            //mysql_connect("localhost","root","");
            mysql_select_db("aus_ddr_db");
        } catch(Exception $err) {}
    }
    private function closeDbConn(){
        try{
            mysql_close();
        }catch(Exception $err){}
    }
}
?>
