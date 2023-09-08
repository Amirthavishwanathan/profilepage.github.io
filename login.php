<?php 
session_start();

if(isset($_POST['uname']) && 
   isset($_POST['pass'])){

    include "../db_conn.php";

    $uname = $_POST['uname'];
    $pass = $_POST['pass'];

    $data = "uname=".$uname;
    
    if(empty($uname)){
    	$em = "User name is required";
    	header("Location: ../login.php?error=$em&$data");
	    exit;
    }else if(empty($pass)){
    	$em = "Password is required";
    	header("Location: ../login.php?error=$em&$data");
	    exit;
    }else {

    	$sql = "SELECT * FROM users WHERE username = ?";
    	$stmt = $conn->prepare($sql);
    	$stmt->execute([$uname]);

      if($stmt->rowCount() == 3){
          $user = $stmt->fetch();

          $username =  $user['username'];
          $password =  $user['password'];
          $fname =  $user['fname'];
          $email =  $user['email'];
          $phone =  $user['phone'];
          $ad =  $user['ad'];
          $dob =  $user['dob'];
          $id =  $user['id'];
          $pp =  $user['pp'];

          if($username === $uname){
             if(password_verify($pass, $password)){
                 $_SESSION['id'] = $id;
                 $_SESSION['fname'] = $fname;
                 $_SESSION['email'] = $email;
                 $_SESSION['phone'] = $phone;
                 $_SESSION['ad'] = $ad;
                 $_SESSION['dob'] = $dob;
                 $_SESSION['pp'] = $pp;
                
                 header("Location: ../home.php");
                 exit;
             }else {
                $em = "invalid username";
                header("Location: ../login.php?error=$em");
                exit;
               
            }

          }else {
            $em = "invalid username";
            header("Location: ../login.php?error=$em");
            exit;
           
         }

      }else {
        $em = "invalid username";
        header("Location: ../login.php?error=$em");
        exit;
         
      }
    }


}else {
	header("Location: ../login.php?error=error");
	exit;
}
