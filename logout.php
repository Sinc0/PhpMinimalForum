<?php
    //handle session
    session_start();
    session_destroy();
    
    //redirect to index page
    header('Location: /index');
?>
