<?php
    require_once("config.php");

    class History
    {
        public function getHistorySleepTimebyUserid($userID, $hours){
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
            
            return json_encode($rows);
    
        }
        public function getHistory($userID, $fromDateP, $toDateP){
            $fromDate = date("Y-m-d", strtotime($fromDateP)).' '.'00:00:00';
            $toDate = date("Y-m-d", strtotime($toDateP)).' '.'23:59:59';
            $sqldata = mysql_query("SELECT * FROM `node_data` WHERE user_Id = '$userID' and created_at between '$fromDate' and '$toDate'");
    
            $rows = array();
            while($r = mysql_fetch_assoc($sqldata)) {
                $rows[] = $r;
            }
            
            return json_encode($rows);
        }
    }
        
?>