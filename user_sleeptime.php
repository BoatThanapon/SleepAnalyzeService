<?php
    require_once("config.php");
    $userID = $_GET['userID'];
    $hours = $_GET['hours'];
    $sql = "INSERT INTO user_sleeptime (quantity_hours, user_id) VALUES ('$hours', '$userID');";
    $sql_query = mysql_query($sql);
    if ($sql_query) {
        echo "Complete";
    } else {
        echo "Error";
    }
?>