<?php 
    session_start();
    require("sql_fuction.php");
    
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $email=$_POST["email"];
        $password=$_POST["password"];

        $db_connection=sql_con();
        if(!$db_connection){
            $_SESSION["error"]= "Connection loss:".mysqli_connect_error();
            header("Location: login.php");
            exit();
        }

        if(empty($email) && empty($password)){
            $_SESSION['error']=error_message("Alert Empty both flied is Empty",1);
            header("Location: login.php");
            exit();
        }elseif(empty($password)){
            $_SESSION['error']=error_message("Alert Empty Password",1);
            header("Location: login.php");
            exit();
        }elseif(empty($email)){
            $_SESSION['error']=error_message("Alert Empty Email",1);
            header("Location: login.php");
            exit();
        }
        else{
            htmlspecialchars($password);
            htmlspecialchars($email);
            
            $sql=sprintf("SELECT * FROM student_auth  WHERE  email='%s' And user_pass='%s';",anti_sql($email),anti_sql($password));
            //$sql="SELECT * FROM student_auth  WHERE  email='$email' And user_pass='$password';"; can be sql injection
            $result=mysqli_query($db_connection,$sql);
            $credentials=mysqli_fetch_all($result);
            //print_r($credentials); to see sql

            if(mysqli_num_rows($result)==1 && $credentials[0][1]==$email && $credentials[0][2]==$password){
                $_SESSION["USER_id"]=$credentials[0][0];
                $_SESSION["Active_student"]=true;
                header("Location: student dashboard.html");
                $_SESSION['error']="";
                exit();
            }else{
                $_SESSION['error']=error_message("Invalid email and password",0);
                header("Location: login.php");
            }
        }

        /*if($email=="herold@gmail.com" && $password=="herold"){
            header("Location: student dashboard.html");
            exit();
        }else{
            
            $_SESSION['error']=error_message("Invalid email and password",0);
            header("Location: login.php");
            exit();
        }*/
        
    }

    function error_message($message,$color){
        if($color==1){
            $error="<div class='alert alert-primary' role='alert'> $message </div>";
        }elseif($color==0){
            $error="<div class='alert alert-danger' role='alert'> $message </div>";
        }
        return $error;
    }  
?>