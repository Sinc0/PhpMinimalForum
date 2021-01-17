<?php
    //prevent sql injection
    /* 
        function escape($string)
        {
            return mysqli_real_escape_string($db_connection, trim(strip_tags($string)));
        } 
    */

    $db['db_host'] = "localhost";
    $db['db_user'] = "root";
    $db['db_pass'] = "";
    $db['db_name'] = "forum";

    $db_connection = mysqli_connect('localhost', 'root', '', 'forum');

    /*
    if($db_connection)
    {
        echo "db connected successfully";
    }
    else
    {
        echo "db connection error";
    }
    */
?>