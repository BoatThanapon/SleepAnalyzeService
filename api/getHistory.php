<?php
    require_once("../get_history.php");

    $userID = $_GET['userID'];
    $hours = null;

    $historyObject = new History();



    if(isset($_GET['hours']))
    {
        $hours = $_GET['hours'];
        $json_array = $historyObject->getHistorySleepTimebyUserid($userID, $hours);
        echo $json_array;
    }
    else {
        $fromDate = $_GET['fromDate'];
        $toDate = $_GET['toDate'];
        $json_array = $historyObject->getHistory($userID, $fromDate, $toDate);
        echo $json_array;
        
    }
?>