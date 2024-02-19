<?php
    require("sql_fuction.php");
    session_start();
    if (!$_SESSION["Active_student"]){
        echo "<h1 style='color:red;text-align:center;'>Forbidden 404</h1>";
        exit();
    }
    $json_data  = json_decode(file_get_contents("php://input"), true);
    $db_connection=sql_con();
    $sql=sprintf("SELECT first_name FROM student_auth WHERE id_num='%s';",$_SESSION['USER_id']);
    $result=mysqli_query($db_connection,$sql);
    $credentials=mysqli_fetch_all($result);
    $_SESSION['User_name']=$credentials[0][0];
    $sql=sprintf("SELECT email , user_pass, first_name, last_name, student_id , `address` , birthday FROM student_auth WHERE id_num='%s';",$_SESSION['USER_id']);
    $result=mysqli_query($db_connection,$sql);
    $student_info=mysqli_fetch_all($result);
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $selectedDate = $json_data['dateInput'];
        if(isset($_POST["Logout"])=="Logout"){
            $_SESSION["Active_student"]=false;
            header("Location: Index.html.");
            $_SESSION['error']="";
            exit();
     
        }elseif($selectedDate!=null){
            $selectedDate=$selectedDate;
            $sql=sprintf("SELECT limit_appointment ,COUNT(status_code='Active'),time_appointment FROM appointment WHERE date_appointment='%s' ;",anti_sql($selectedDate));
            $result=mysqli_query($db_connection,$sql);
            $credentials=mysqli_fetch_all($result);
            //print_r($credentials);
            $option=array("8:00am to 9:00am", "9:00am to 10:00am", "10:00am to 11:50am", "1:00pm to 2:00pm","2:00pm to 3:00pm", "3:00pm to 4:00pm");
            echo"<div class='form-group'>
            <label for='time'>Preferred Time:</label>
            <select id='time' name='time' class='form-control' required>";
                    foreach ($option as $option) {
                    if ($credentials[0][1]==0){    
                    echo "<option value='$option'>$option</option>";
                    }elseif($credentials[0][1]>=$credentials[0][0] && $option==$credentials[0][2]){
                    echo "<option value='$option' disabled>$option</option>";
                    }else{
                        echo "<option value='$option'>$option</option>";
                    }
                }
    
           echo" </select> </div>";
            exit();
        } elseif(isset($_POST["Reservation"])=="Reservation"){
            $name=anti_xss($_REQUEST["name"]);
            $email=anti_xss($_REQUEST["email"]);
            $std_num=anti_xss($_REQUEST["std_number"]);
            $address=anti_xss($_REQUEST["address"]);
            $bday=anti_xss($_REQUEST['bday']);
            $date=anti_xss($_REQUEST["date"]);
            $phone=anti_xss($_REQUEST['phone']);
            $time=anti_xss($_REQUEST['time']);
            $user_id=$_SESSION["USER_id"];
            $sql=sprintf("INSERT INTO appointment( user_id, status_code, limit_appointment, date_appointment, time_appointment) VALUES ('%s','%s','%s','%s','%s')",anti_sql($user_id),'Active',4,anti_sql($date),$time);
            $result =mysqli_query($db_connection,$sql);
            if ($result){
                $_SESSION['error']=error_message("Account has been successfully created",1);
                header("Location: student dashboard.html");
                exit();
            }else{
                $_SESSION['error']=error_message("Account creation failed",0);
                header("Location: student dashboard.html");
                exit();
            }
            
       
    }
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