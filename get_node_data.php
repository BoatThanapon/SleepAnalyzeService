<?php
    require_once("config.php");

    class Nodedata{

        public function getNodeData($userID){
            $sqldata = mysql_query("SELECT * FROM node_data Where user_id= '$userID'");

            $rows = array();
            while($r = mysql_fetch_assoc($sqldata)) {
                $rows[] = $r;
            }
            
            return json_encode($rows);

        }

    }
    
?>