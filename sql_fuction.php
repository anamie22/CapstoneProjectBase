<?php
    function sql_con(){
        $host="localhost";
        $user_db="root";
        $password_db="";
        $db_name="ui_idexpress";
        $db_connection=new mysqli($host,$user_db,$password_db,$db_name);
        return $db_connection;
    }

    function anti_sql($string){
        $db_connection=sql_con();
        return mysqli_real_escape_string($db_connection,$string);

    }

    function anti_xss($string){
        return htmlspecialchars($string);

    }


?>