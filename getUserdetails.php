
<?php
    
    require_once 'user.php';
    
    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }
    
    $userObject = new User();

    
    if(!empty($id)){
        $json_array = $userObject->getUserdetails($id);
        echo json_encode($json_array);
    }
    ?>
