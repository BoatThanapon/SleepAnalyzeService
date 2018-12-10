<?php
    require_once("config.php");

    class SleepingHours{
        public function addSleepingHours($userID, $hours){
            $json = array();
            $sql = "INSERT INTO user_sleeptime (quantity_hours, user_id) VALUES ('$hours', '$userID');";
            $sql_query = mysql_query($sql);
            if ($sql_query) {
                $json['success'] = true;
                $json['message'] = "Complete";
            } else {
                $json['success'] = false;
                $json['message'] = "Error";
            }
            return json_encode($json);
        }
    }
  
    
?>