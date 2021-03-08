<?php
require_once("ddr.control.class.php");
$ddr = new ddr();
if(isset($_POST['signin']) && $_POST['signin'] == true){
    echo $ddr->ddr_sign_in($_POST['uemail'],$_POST['upass']);
}
if(isset($_POST['ddrSave']) && $_POST['ddrSave'] == true){
    echo $ddr->ddr_save_data($_POST['ddrCat'],$_POST['ddrType'],$_POST['docFileNo'],$_POST['ddrFrom'],$_POST['ddrTo'],$_POST['ddrSub'],$_POST['despNo'],$_POST['actualId']);
}
if(isset($_POST['ddrUpdateRec']) && $_POST['ddrUpdateRec'] == true){
    echo $ddr->ddr_update_data($_POST['_despNo'],$_POST['_isRec']);
}
if(isset($_POST['signout']) && $_POST['signout'] == true){
    echo $ddr->ddr_sign_out();
}
/*if(isset($_POST['autoComplete']) && $_POST['autoComplete'] == true){
    echo $ddr->ddr_autocomplete($_POST['docFileNo']);
}*/
if(isset($_POST['getDocFileData']) && $_POST['getDocFileData'] == true){
    echo $ddr->ddr_doc_file_info($_POST['dfid']);
}
if(isset($_POST['searchPage']) && $_POST['searchPage'] == true){
    echo $ddr->ddr_relocate_search_page();
}
if(isset($_POST['srch']) && $_POST['srch'] == true){
    echo $ddr->ddr_search_result($_POST['srchData']);
}
if(isset($_POST['info']) && $_POST['info'] == true){
    echo $ddr->ddr_document_file_info($_POST['dfid']);
}
if(isset($_POST['ddrUpdate']) && $_POST['ddrUpdate'] == true){
    echo $ddr->ddr_update($_POST['id'],$_POST['ddrCat'],$_POST['ddrType'],$_POST['ddrDate'],$_POST['ddrFrom'],$_POST['ddrTo'],$_POST['ddrSub'],$_POST['despNo']);
}
if(isset($_POST['sdr']) && $_POST['sdr'] == true){
    echo $ddr->ddr_redirect_single_day_report();
}
if(isset($_POST['sdrgen']) && $_POST['sdrgen'] == true){
    echo $ddr->ddr_generate_single_day_report($_POST['sdate']);
}
if(isset($_POST['mdr']) && $_POST['mdr'] == true){
    echo $ddr->ddr_redirect_multi_day_report();
}
if(isset($_POST['mdrgen']) && $_POST['mdrgen'] == true){
    echo $ddr->ddr_generate_multiple_day_report($_POST['fdate'],$_POST['ldate']);
}
if(isset($_GET['term'])){
    echo $ddr->ddr_autocomplete($_GET['term']);
}
if(isset($_POST['accUpdt']) && $_POST['accUpdt'] == true){
    echo $ddr->ddr_update_password($_POST['psw']);
}
if(isset($_POST['reg']) && $_POST['reg'] == true){
    echo $ddr->ddr_register($_POST['name'],$_POST['dept'],$_POST['email']);
}
if(isset($_POST['gpdfi']) && $_POST['gpdfi'] == true){
    echo $ddr->get_pending_doc_file_info($_POST['pn']);
}
if(isset($_POST['grdfi']) && $_POST['grdfi'] == true){
    echo $ddr->get_received_doc_file_info($_POST['pn']);
}
if(isset($_POST['gddfi']) && $_POST['gddfi'] == true){
    echo $ddr->get_dispathced_doc_file_info($_POST['pn']);
}
if(isset($_POST['gcdfi']) && $_POST['gcdfi'] == true){
    echo $ddr->get_closed_doc_file_info($_POST['pn']);
}
if(isset($_POST['gcfi']) && $_POST['gcfi'] == true){
    echo $ddr->get_create_file_info($_POST['pn']);
}
if(isset($_POST['fclose']) && $_POST['fclose'] == true){
    echo $ddr->ddr_file_close($_POST['dfid']);
}
if(isset($_POST['chFile']) && $_POST['chFile'] == true){
    echo $ddr->chFile($_POST['file']);
}
if(isset($_POST['crFile']) && $_POST['crFile'] == true){
    echo $ddr->create_file($_POST['fname'],$_POST['ftitle']);
}
if(isset($_POST['getDFInfo']) && $_POST['getDFInfo'] == true){
    echo $ddr->get_auto_text_document_file_info($_POST['dfid']);
}
?>