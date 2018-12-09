<?php
    require_once("config.php");
    $userID = $_GET['userID'];
    $humidity = $_GET['humidity'];
    $temperature = $_GET['temperature'];
    $vibration = $_GET['vibration'];
    $sql = "INSERT INTO node_data (humidity, temperature, vibration, user_id) VALUES ('$humidity', '$temperature', '$vibration', '$userID');";
    $sql_query = mysql_query($sql);
    if ($sql_query) {
        echo "Complete";
    } else {
        echo "Error";
    }
?>