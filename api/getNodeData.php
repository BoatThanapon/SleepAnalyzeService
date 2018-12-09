<?php
    require_once("../get_node_data.php");


    $nodeDataObject = new Nodedata();



    if(isset($_GET['userID']))
    {
        $userID = $_GET['userID'];
        $json_array = $nodeDataObject->getNodeData($userID);
        echo $json_array;
    }
?>