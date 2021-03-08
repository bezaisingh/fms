<?php
require_once("../controller/ddr.control.class.php");
$ddr = new ddr();
?>
<html lang="en">
    <head>
      
        <link rel="shortcut icon" href="images/favicon.ico" />
        <link type="text/css" rel="stylesheet" href="css/ddr.css" />
        <style type="text/css">
            .ui-table{
                margin-top:5%;                
            }
            .ui-table thead{
                background-color: #fff;
                color: #000;
                font-family:arial,tahoma;
                font-size:13px;
                font-weight:bold;
            }
            .ui-table tbody td{
                color: #fff;
                font-family:arial,tahoma;
                font-size:13px;
            }
        </style>
    </head>
    <body>
        <header class="dds-header"></header>
        <table width="60%" cellpadding="5" cellspacing="5" align="center" class="ui-table">
            <thead>
                <td>Sl. No.</td>
                <td>Designation</td>
                <td>Username</td>
                
            </thead>
            <tbody>
            <?php
            echo $ddr->user_pass_list();
            ?>
            </tbody>
        </table>
    </body>
</html>
