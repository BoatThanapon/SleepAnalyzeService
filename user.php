
<?php

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require './vendor/phpmailer/phpmailer/src/Exception.php';
    require './vendor/phpmailer/phpmailer/src/PHPMailer.php';
    require './vendor/phpmailer/phpmailer/src/SMTP.php';

    require './vendor/autoload.php';
    
    include_once 'db-connect.php';
    
    
    class User{
        
        private $db;
        
        private $db_table = "users";
        
        public function __construct(){
            $this->db = new DbConnect();
        }
        
        public function isLoginExist($email, $password){
            
            $query = "select * from ".$this->db_table." where email = '$email' AND password = '$password' Limit 1";
            
            $result = mysqli_query($this->db->getDb(), $query);
            
            if(mysqli_num_rows($result) > 0){
                
                mysqli_close($this->db->getDb());
                
                
                return true;
                
            }
            
            mysqli_close($this->db->getDb());
            
            return false;
            
        }
        
        public function isEmailUsernameExist($email){
            
            $query = "select * from ".$this->db_table." where email = '$email'";
            
            $result = mysqli_query($this->db->getDb(), $query);
            
            if(mysqli_num_rows($result) > 0){
                
                mysqli_close($this->db->getDb());
                
                return true;
                
            }
               
            return false;
            
        }
        
        public function isValidEmail($email){
            return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
        }
        
        public function createNewRegisterUser($email, $password, $name, $dateofBirth){
              
            $isExisting = $this->isEmailUsernameExist($email);
            
            if($isExisting){
                
                $json['success'] = false;
                $json['message'] = "Error in registering. the email already exists";
            }
            
            else{
                
            $isValid = $this->isValidEmail($email);
                
                if($isValid)
                {
                $from = new DateTime($dateofBirth);
                $dateofBirthTime = $from->format('Y-m-d H:i:s');
                $query = "insert into ".$this->db_table." (email, password, name, dateofBirth, created_at, updated_at) values ('$email', '$password', '$name', '$dateofBirthTime', NOW(), NOW())";
                
                $inserted = mysqli_query($this->db->getDb(), $query);
                
                if($inserted == 1){
                    
                    $json['success'] = true;
                    $json['message'] = "Successfully registered the user";
                    
                }else{
                    
                    $json['success'] = false;
                    $json['message'] = "Error in registering. the email already exists";
                    
                }
                
                mysqli_close($this->db->getDb());
                }
                else{
                    $json['success'] = false;
                    $json['message'] = "Error in registering. Email Address is not valid";
                }
                
            }
            
            return $json;
            
        }
        
        public function loginUsers($email, $password){
            
            $json = array();
            
            $canUserLogin = $this->isLoginExist($email, $password);
            
            if($canUserLogin){
                
                $json['success'] = true;
                $json['message'] = "Successfully logged in";
                
            }else{
                $json['success'] = false;
                $json['message'] = "Incorrect details";
            }
            return $json;
        }

        public function getUserdetails($id){
            $id = (int)$id;
            $json = array();
            $query = "select * from ".$this->db_table." where user_id = '$id' Limit 1";
            
            $result = mysqli_query($this->db->getDb(), $query);
            

            if(mysqli_num_rows($result) > 0){
                $resultArray = [];
                    while ($row = $result->fetch_array()) {
                        $from = new DateTime($row['dateofBirth']);
                        $to   = new DateTime('today');
                        $age = $from->diff($to)->y;
                        $resultArray['id'] = $row['user_id'];
                        $resultArray['name'] = $row['name'];
                        $resultArray['age'] = $age;
                        $resultArray['dateofBirth'] = $row['dateofBirth'];

                    }

                $json['success'] = true;
                $json['data'] = $resultArray;
                mysqli_close($this->db->getDb());
                
            }else {
                $json['success'] = false;
                $json['message'] = "User not found";
            }

            return $json;

        }

        public function updateUserdetail($id, $password, $name, $dateofBirth){
            $id = (int)$id;
            $json = array();
            $queryCheck = "select * from ".$this->db_table." where user_id = '$id' Limit 1";
            
            $checkUser = mysqli_query($this->db->getDb(), $queryCheck);

            if(mysqli_num_rows($checkUser) > 0){
                    $from = new DateTime($dateofBirth);
                    $dateofBirthTime = $from->format('Y-m-d H:i:s');
                    $query = "UPDATE ".$this->db_table." SET name='$name', password='$password', dateofBirth='$dateofBirthTime' WHERE user_id='$id'";
                    
                    $result = mysqli_query($this->db->getDb(), $query);
    
                    $json['success'] = true;
                    $json['message'] = ['id' => $id];
            }else {
                $json['success'] = false;
                $json['message'] = "User not found";
            }

            
            return $json;

        }

        function RandomString()
        {
            $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $randstring = '';
            for ($i = 0; $i < 10; $i++) {
                $randstring .= $characters[rand(0, strlen($characters))];
            }
            return $randstring;
        }

        public function forgetPassword($email){
            
            $json = array();
            $queryCheck = "select * from ".$this->db_table." where email = '$email' Limit 1";
            
            $checkUser = mysqli_query($this->db->getDb(), $queryCheck);
            $newpassword = $this->RandomString();

            if(mysqli_num_rows($checkUser) > 0){

                $queryresetPassword = "UPDATE ".$this->db_table." SET password='$newpassword' WHERE email='$email'"; 
                $resultReset = mysqli_query($this->db->getDb(), $queryresetPassword);

                    $strMessage = "";
                    $strMessage .= "Your password of ".$email." has been reset<br>";
                    $strMessage .= "Your new password is: ".$newpassword."<br><br>";
                    $strMessage .= "=================================<br>";
                    $strMessage .= "Sleep Analyzer Application<br>";
                    $Correo = new PHPMailer();
                    $Correo->IsSMTP();
                    $Correo->SMTPAuth = true;
                    $Correo->SMTPSecure = "tls";
                    $Correo->Host = "smtp.gmail.com";
                    $Correo->Port = 587;
                    $Correo->Username = "sleepanalysproject@gmail.com";
                    $Correo->Password = "as741852";
                    $Correo->SetFrom("sleepanalysproject@gmail.com");
                    $Correo->FromName = "Reset Password";
                    $Correo->AddAddress($email);
                    $Correo->Subject = "Your password has been reset";
                    $Correo->Body = $strMessage;
                    $Correo->IsHTML (true);
                    if (!$Correo->Send())
                    {
                        $json['success'] = false;
                        $json['message'] = "Cannot send an Email";
                    }
                    else
                    {
                        $json['success'] = true;
                        $json['message'] = "Email has been send";
                    }
                


               
            }else{
                $json['success'] = false;
                $json['message'] = "User not found";
            }
            return $json;
        }

       
    }
    ?>
