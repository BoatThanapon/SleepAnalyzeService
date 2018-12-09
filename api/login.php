
<?php
    
    require_once '../user.php';
        
    $password = "";
    
    $email = "";
    
    
    if(isset($_POST['password'])){
        
        $password = $_POST['password'];
        
    }
    
    if(isset($_POST['email'])){
        
        $email = $_POST['email'];
        
    }
    
    $userObject = new User();

    
    if(!empty($password) && !empty($email)){
        
        // $hashed_password = md5($password);

        $hashed_password = $password;

        
        $json_array = $userObject->loginUsers($email, $hashed_password);
        echo json_encode($json_array);
    }
    ?>
