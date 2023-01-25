<?php

require 'config/connection.php';
include ("config/database.php");

session_start();

$errors = array();
$username = '';
$email = '';

//if user clicks on the signup button
if (isset($_POST['signup-btn'])){
    
    $username       = $_POST['username'];
    $email          = $_POST['email'];
    $password       = $_POST['password'];
    $passwordConf   = $_POST['passwordConf'];
    $upper          = preg_match('@[A-Z]@', $password);
    $lower          = preg_match('@[a-z]@', $password);
    $number         = preg_match('@[0-9]@', $password);
    $specialChars   = preg_match('@[^\w]@', $password);
    
    //$_SESSION variables
    //$_SESSION["username"] = $_POST['username'];
    //$_SESSION["email"] = $_POST['email'];

    
    $_SESSION["username"] = $username;
    $_SESSION["email"] = $email;
    $_SESSION["verified"] = "";
    $_SESSION["message"] = "";
    $_SESSION["alert-class"] = "";

    //validation
    if (empty($username) && empty($email) && empty($password) && empty($passwordconf)){
        $errors['all'] = "Empty fields, fill all field";
    }else{
        if (empty($username)){
            $errors['username'] = "Username required";
        }elseif(!preg_match("/^[a-zA-Z0-9]*$/",$username)){
            $errors['username'] = "Invalid Username";
        }
        if (empty($email)){
            $errors['email'] = "Email required";
        }elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errors['email'] = "Email address in invalid";
        }
        if (empty($password)){
            $errors['password'] = "Password required";
        }elseif(!$upper || !$lower || !$number || !$specialChars || strlen($password) < 8) {
            $errors['password'] = "Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.";
        }elseif($password !== $passwordConf){
            $errors['password'] = "Passwords do not match";
        }
    }
    
    //validation - checking if username already exists
    $conn = connection();
    $usernameQ = "SELECT * FROM users WHERE username=:username LIMIT 1";
    $stmt = $conn->prepare($usernameQ);
    $stmt->execute(array(":username"=>$username));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //print_r($row[0]);
    
    if ($stmt->rowCount() > 0){
        $errors['username'] = "Username already exists";
    }
    
    //validation - checking if email already exists
    $conn = connection();
    $emailQ = "SELECT * FROM users WHERE email=:email LIMIT 1";
    $stmt = $conn->prepare($emailQ);
    $stmt->execute(array(":email"=>$email));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($stmt->rowCount() > 0){
        $errors['email'] = "Email already exists";
    }
    
    //if validation is a success
    if (count($errors) === 0){
        $conn = new PDO("mysql:host=localhost;dbname=joosell", $DB_USER, $DB_PASS);
        $password = md5($password);
        $token = bin2hex(random_bytes(10));
        $verified = 0;
        
        echo "Email Not Sent";
        //send email
        $to      = $email;
        $subject = 'Verify Your Email';
        $message = "
        Please click on the link below:        
        http://localhost:8080/camagru_backup/confirm.php?email=$email&token=$token";
        $headers =  'From: Camagru' . "\r\n"
        .'X-Mailer: PHP/' . phpversion();
        
        if (mail($to, $subject, $message, $headers)){
            echo "Email Sent";
        }else{
            echo "Email Not Sent";
        }
        
        //insert data to database
        $sql = "INSERT INTO users (username, email, verified, token, password) VALUES(:username, :email, :verified, :token, :password)";
        $ex = $conn->prepare($sql);
        
        
        try {
            $ex->execute(['username'=>$username, 'email'=>$email,'verified'=>$verified,'token'=>$token, 'password'=>$password]);
            header("location: index.php");
            exit();
        } catch (Exception $e){
            echo  $e;
        }
        
    }
}

//if user clicks on the SIGN IN button
if (isset($_POST['signin-btn'])){
    //session_start();
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $username;
    
    //validation
    if (empty($username)){
        $errors['username'] = "Username/E-mail required";
    }
    if (empty($password)){
        $errors['password'] = "Password required";
    }else{
        $password = md5($password);
        //validation - checking if email or username already exists
        $conn = connection();
        $userQ = "SELECT * FROM users WHERE email=:email OR username=:username AND password=:password LIMIT 1";
        $stmt = $conn->prepare($userQ);
        $stmt->execute(array(':email'=>$email,':username'=>$username, ':password'=>$password));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        //echo "HERE";
        foreach ($row as $row){
            $user_id = $row['user_id'];
        }
        // echo "ID: ".$user_id."<br>";
        if (($stmt->rowCount() > 0)){
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            $_SESSION['receive_email'] = $receive_email;

            // echo $_SESSION['user_id'];
            header("location: home.php");
        }else{
            $errors['invalid'] = "Invalid Credentials";
        }
    }
}


// if (isset($_POST['update-btn']))
// {
//     session_start();
//     if (!$_SESSION['user_name'] && !$_SESSION['user_id'] && !$_SESSION['user_email'] )
//     {
//         header('Location:index.php');
//     }
//     $username = $_POST['username'];
//     $email = $_POST['email'];
//     // $mail = $_POST['receive_email'];
//     $user_id = $_SESSION['user_id'];
//     try{
//         $conn = new PDO("mysql:host=$servername;dbname=camagru", $dbusername, $dbpassword);
//         $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//         $query = "UPDATE `users` SET `user_name` = '$username',
//         email ='$email' WHERE user_id = ?";
//         $sql = $conn->prepare($query);
//         $sql->bindParam(1, $user_id);
//         $sql->execute();
//         if ($sql->rowCount())
//             header("Location: userprofile.php");
//         if (!$sql)
//         {
//             print_r ($conn->errorInfo());
//         }
//         else
//         {
//                 echo "Profile Updated";
//         }
//     }
//     catch(PDOException $e)
//     {
//         echo " Error".$e->getMessage();
//     }
// }
?>
