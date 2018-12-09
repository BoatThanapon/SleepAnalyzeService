<?php
    require_once("config.php");
    $userID = $_GET['userID'];
    $sqldata = mysql_query("SELECT * FROM node_data Where user_id= '$userID'");

    $rows = array();
    while($r = mysql_fetch_assoc($sqldata)) {
        $rows[] = $r;
    }
    
    echo json_encode($rows);
?>