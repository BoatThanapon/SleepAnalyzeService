
<?php
    
    require_once 'user.php';

    $password = "";
    $email = "";
    $name = "";
    $dateofBirth = "";
    
    
    if(isset($_POST['password'])){
        $password = $_POST['password']; 
    }
    if(isset($_POST['email'])){
        $email = $_POST['email']; 
    }
    if(isset($_POST['name'])){
        $name = $_POST['name']; 
    }
    if(isset($_POST['dateofBirth'])){
        $dateofBirth = $_POST['dateofBirth']; 
    }
    
    $userObject = new User();
    
    // Registration
    
    if(!empty($password) && !empty($email) && !empty($name) && !empty($dateofBirth)){
        
        // $hashed_password = md5($password);
        $hashed_password = $password;

        
        $json_registration = $userObject->createNewRegisterUser($email, $hashed_password, $name, $dateofBirth);
        
        echo json_encode($json_registration);
        
    }
    ?>
    
