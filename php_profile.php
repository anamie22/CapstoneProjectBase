<?php 
    require("sql_fuction.php");
    session_start();
    if (!$_SESSION["Active_student"]){
        echo "<h1 style='color:red;text-align:center;'>Forbidden 404</h1>";
        exit();
    }

    $db_connection=sql_con();
    $sql=sprintf("SELECT email , user_pass, first_name, last_name, student_id , `address` , birthday FROM student_auth WHERE id_num='%s';",$_SESSION['USER_id']);
    $result=mysqli_query($db_connection,$sql);
    $credentials=mysqli_fetch_all($result);
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if(isset($_POST["UpdateProfile"])=="UpdateProfile"){
            $first_name=anti_xss($_REQUEST["first_name"]);
            $last_name=anti_xss($_REQUEST["last_name"]);
            $email=anti_xss($_REQUEST["email"]);
            $std_num=anti_xss($_REQUEST["std_number"]);
            $address=anti_xss($_REQUEST["address"]);
            $bday=anti_xss($_REQUEST['profile_date']);
            $sql=sprintf("UPDATE student_auth SET email='%s',first_name='%s',last_name='%s', student_id ='%s',`address`='%s',birthday='%s'
            WHERE id_num ='%s';",anti_sql($email),anti_sql($first_name),anti_sql($last_name),anti_sql($std_num),
            anti_sql($address),anti_sql($bday),$_SESSION['USER_id']);
            $result=mysqli_query($db_connection,$sql);
            header("Location: Profile.html");
            exit();

        }
        
    }
?>