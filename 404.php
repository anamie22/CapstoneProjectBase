<?php
    session_start();
    if(!$_SESSION["Active_student"]){
        header("Location: Index.html");
        echo "heloo";

        exit();
    }else{
        header("Location: student dashboard.html");
        exit();
    }
?>