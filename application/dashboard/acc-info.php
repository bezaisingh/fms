<?php
if(isset($_SESSION['logger_dept_id'])){
    ?>
    <div class="ddr-acc-info">
        <div class="ui-logo"></div>
        <ul>
            <li>Welcome!</li>
            <li><i><?php echo $ddr->get_logger_designation(); ?></i></li>
            <li>Today's Date - <?php echo date("d/m/Y"); ?></li>
        </ul>
    </div>
    <?php
}
?>
<div class="scrollbar" id="ex3">
    <div class="ui-tags">Dispatch Tags List</div>
    <div class="content">
        <?php $ddr->get_department_wise_tags(); ?>
    </div>
</div>
<footer><div>&copy;&nbsp;Computer Center, Assam University</div></footer>