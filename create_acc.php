<?php 
    session_start();
    $host="localhost";
    $user_db="root";
    $password_db="";
    $db_name="ui_idexpress";
     if($_SERVER["REQUEST_METHOD"] == "POST"){
        $first_name=$_POST['F_name'];
        $last_name=$_POST["L_name"];
        $email=$_POST["email"];
        $password_raw=$_POST["first_pass"];
        $password=$_POST["second_pass"];
        
        if($password_raw!=$password){
            $_SESSION["error"]="<div class='alert alert-warning' role='alert'>Passwords do NOT match</div> ";
            header("Location: register.html");
            exit();
     }

     //Php connection checker
     $db_connection=new mysqli($host,$user_db,$password_db,$db_name);
     if(!$db_connection){
        $_SESSION["error"]= "Connection loss:".mysqli_connect_error();
        echo $_SESSION["error"];
     }

     //to check duplicate
     $sql="SELECT * FROM student_auth  WHERE  email='$email'";
     $result=mysqli_query($db_connection,$sql);
     if(mysqli_num_rows($result)>0){
      $_SESSION["error"]="<div class='alert alert-warning' role='alert'>User name is already taken try agian</div> ";
      header("Location: register.html");
      exit();
     }else{
     $sql="INSERT INTO student_auth(email, user_pass, first_name, last_name) VALUES ('$email','$password','$first_name','$last_name');";
     $result =mysqli_query($db_connection,$sql);
     if ($result){
        $_SESSION["error"]= "Account has been successfully created";
        header("Location: register.html");
     }else{
        $_SESSION["error"]="Account creation failed";
        header("Location: register.html");
     }
    }


   }

?>