<?php
    require_once("config.php");

    class SleepingHours{
        public function addSleepingHours($userID, $hours){
            $sql = "INSERT INTO user_sleeptime (quantity_hours, user_id) VALUES ('$hours', '$userID');";
            $sql_query = mysql_query($sql);
            if ($sql_query) {
                return "Complete";
            } else {
                return "Error";
            }
        }
    }
  
    
?>