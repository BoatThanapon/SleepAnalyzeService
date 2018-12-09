<?php
    require_once("config.php");
    $userID = $_GET['userID'];
    $hours = null;
    if(isset($_GET['hours']))
    {
        $hours = $_GET['hours'];
        date_default_timezone_set('Asia/Bangkok');
        $now = date('Y-m-d H:i:s');
        $fromDate = date("Y-m-d H:i:s", strtotime('-'.$hours.' hours'));
        
        // echo $fromDate.' - ';
        // echo $now;

        $sqldata = mysql_query("SELECT * FROM `node_data` WHERE user_Id = '$userID' and created_at between '$fromDate' and '$now'");
        $rows = array();
        while($r = mysql_fetch_assoc($sqldata)) {
            $rows[] = $r;
        }
        
        echo json_encode($rows);
    }
    else {
        $fromDate = $_GET['fromDate'];
        $toDate = $_GET['toDate'];
        $fromDate = date("Y-m-d", strtotime($_GET['fromDate'])).' '.'00:00:00';
        $toDate = date("Y-m-d", strtotime($_GET['toDate'])).' '.'23:59:59';
        $sqldata = mysql_query("SELECT * FROM `node_data` WHERE user_Id = '$userID' and created_at between '$fromDate' and '$toDate'");

        $rows = array();
        while($r = mysql_fetch_assoc($sqldata)) {
            $rows[] = $r;
        }
        
        echo json_encode($rows);
    }
?>