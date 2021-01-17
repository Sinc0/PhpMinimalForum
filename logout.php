<?php 
    session_start();
    session_destroy(); 
    header('Location: /phpForum/index.php');
?>
