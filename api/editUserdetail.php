
<?php
    
    require_once '../user.php';
    
    if(isset($_POST['id'])){
        $id = $_POST['id'];
    }
    if(isset($_POST['name'])){
        $name = $_POST['name']; 
    }
    if(isset($_POST['password'])){
        $password = $_POST['password']; 
    }
    if(isset($_POST['dateofBirth'])){
        $dateofBirth = $_POST['dateofBirth']; 
    }
    
    $userObject = new User();

    
    if(!empty($id)){
        $json_array = $userObject->updateUserdetail($id, $password, $name, $dateofBirth);
        echo json_encode($json_array);
    }
    ?>
