<?php
    require_once("config.php");

    class Nodedata{

        public function getNodeData($userID){
            date_default_timezone_set('Asia/Bangkok');
            $now = date('Y-m-d H:i:s');
            $fromDate = date("Y-m-d H:i:s", strtotime('-30 minutes'));
            echo $fromDate;
            $sqldata = mysql_query("SELECT * FROM node_data Where user_id= '$userID' and created_at between '$fromDate' and '$now'");

            $rows = array();
            while($r = mysql_fetch_assoc($sqldata)) {
                $rows[] = $r;
            }
            
            return json_encode($rows);
        }

    }
    
?>