<?php
    require_once("../user_sleeptime.php");

    $sleepObject = new SleepingHours();

    if(isset($_POST['userID']) && isset($_POST['hours']))
    {
        $userID = $_POST['userID'];
        $hours = $_POST['hours'];        
        $json_array = $sleepObject->addSleepingHours($userID, $hours);
        echo $json_array;
    }
?>