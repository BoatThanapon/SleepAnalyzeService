
<?php
    
    require_once 'user.php';

    $email = "";
    
    if(isset($_POST['email'])){
        $email = $_POST['email']; 
    }
    
    $userObject = new User();

    
    if(!empty($email)){
        $json_array = $userObject->forgetPassword($email);
        echo json_encode($json_array);
    }
    ?>
