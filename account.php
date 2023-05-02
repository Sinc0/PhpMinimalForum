<!-- home.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account</title>
    
    <!--- imports -->
    <link rel="stylesheet" href="./styles.css">
    <?php include "includes/db.php" ?>
    <?php include "includes/sidebar.php" ?>

    <!--- get username data from db -->
    <?php
        //sql query   
        $query = "SELECT * FROM users WHERE user_username = '{$_SESSION['username']}'";

        //run query
        $qLoadAllCategories = mysqli_query($db_connection, $query);
        // $qLength = mysqli_num_rows($qLoadAllCategories);
        
        //handle query errors
        if(!$qLoadAllCategories) { die("database error" . mysqli_error($db_connection)); }
    ?>

    <!--- sort categories data -->
    <?php
        $counter = 0;
        
        while($row = mysqli_fetch_assoc($qLoadAllCategories))
        {
            $counter++;
            
            $user_username = $row['user_username'];
            $user_password = $row['user_password'];
            $user_firstname = $row['user_firstname'];
            $user_lastname = $row['user_lastname'];
            $user_id = $row['user_id'];
            $user_email = $row['user_email'];
            
            // echo "<a href='/category.php/?category=$category_title'><div id='sidebar-category#' class='sidebar-button'> · $category_title</div></a>";
        }
    ?>
</head>

<body>
    <div id="main">
        <!-- title -->
        <h1 id="title">Account</h1>

        <!-- user details -->
        <h3 id="accountDetailsTitle" class="sectionTitle">Details</h3>
        <div id="accountDetails" class="section">
            <form id="formAccountDetails">
                <input hidden value="<?php echo $user_id ?>" placeholder='' />
                <input value="<?php echo $user_username ?> " placeholder='username'/>
                <input value="<?php echo $user_firstname ?>" placeholder='first name' />
                <input value="<?php echo $user_lastname ?>" placeholder='last name' />
                <input value="<?php echo $user_email ?>" placeholder='email' />
                <button>Update</button>
            </form>
        </div>
        
        <!-- change password -->
        <h3 id="accountChangePasswordTitle" class="sectionTitle">Password</h3>
        <div id="accountChangePassword" class="section">
            <form id="formAccountChangePassword">
                <input hidden value="<?php echo $user_id ?>" placeholder='' />
                <input required value="" placeholder='old password' />
                <input required value="" placeholder='new password' />
                <button>Update</button>
            </form>
        </div>
    </div>
</body>
</html>

<style>
    /*** elements ***/
    html { background-color: black; }
    body 
    { 
        height: 100vh; 
        width: 60vw; 
        margin: auto;
        padding: 0px; 
        font-family: Arial, Helvetica, sans-serif;
        color: white;
        border-left: 2px solid white;
        border-right: 2px solid white;
        background-color: black; 
    }
    input
    {
        width: 378px;
        margin: 0px;
        padding: 10px;
        font-size: 18px;
        font-family: Arial, Helvetica, sans-serif;
        color: white;
        border: 0px solid white;
        border-bottom: 1px solid gray;
        color: black;
        background-color: white;
    }
    h3 { margin: 0px; padding: 0px; }
    button 
    { 
        width: 398px;
        margin: -4px 0px 0px 0px;
        padding: 10px;
        font-size: 18px;
        font-weight: bold;
        border: 0px solid black;
        border-top: 1px solid gray;
        background-color: white;
    }

    /*** ids ***/
    #main
    {
        position: relative;
        display: inline-block;
        height: auto;
        width: calc(31vw + 4px);
        margin: 40px 0px 0px -4px;
        text-align: center;
        vertical-align: top;
    }
    #title { margin: 0px 0px 0px -1px; font-size: 26px; text-align: center; }
    #accountChangePasswordTitle { margin-top: 40px; }

    /*** classes ***/
    .sectionTitle { margin: 20px 0px 0px 0px; text-align: center; user-select: none; }
</style>