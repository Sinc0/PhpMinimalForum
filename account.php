<!-- account.php -->
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

    <!-- change account details -->
    <?php
        if(isset($_POST['details']))
        {
            //variables
            $id = $_POST['id'];
            $username = $_POST['username'];
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $email = $_POST['email'];
            // $password = $_POST['password'];
            
            //sql query
            // $query = "INSERT INTO users (user_id, user_username, user_password, user_firstname, user_lastname, 
            // user_email, user_image, user_role, user_salt) 
            // VALUES('0', '$username', '$password', 'null', 'null', 'null', 'null', 'null', 'null');";
            $query = "UPDATE users 
            SET user_username = '{$username}', user_email = '{$email}', user_firstname = '{$firstname}', 
            user_lastname = '{$lastname}', user_email = '{$email}' 
            WHERE user_id = '{$id}'";
            $qRegisterUser = mysqli_query($db_connection, $query);
            
            //handle query errors
            if(!$qRegisterUser) 
            { 
                die("database error" . mysqli_error($db_connection)); 
                echo "<p class='errorMessage'>db connection error</p>";
            }
            else 
            {
                header("Location: account.php");
            }
        }
    ?>
        
    <!-- change account password -->
    <?php 
        if(isset($_POST['password']))
        {
            //variables
            $id = $_POST['id'];
            $oldPassword = $_POST['oldPassword'];
            $newPassword = $_POST['newPassword'];
            $newPasswordConfirm = $_POST['newPasswordConfirm'];

            if($oldPassword != $user_password)
            {
                echo "<p class='errorMessage'>old password incorrect</p>";
            }
            else if($newPassword != $newPasswordConfirm)
            {
                echo "<p class='errorMessage'>new passwords do not match</p>";
            }
            else if($newPassword == $newPasswordConfirm)
            {
                
                $query = "UPDATE users 
                SET user_password = '{$newPassword}'
                WHERE user_id = '{$id}'";
                $qRegisterUser = mysqli_query($db_connection, $query);
                
                //handle query errors
                if(!$qRegisterUser) 
                { 
                    die("database error" . mysqli_error($db_connection));
                    echo "<p class='errorMessage'>db connection error</p>"; 
                }
                else 
                {
                    header("Location: account.php");
                    // echo "<p class='successfulMessage'>password change successful</p>";
                }
                
            }
            
        }
    ?>
</head>

<body>
    <div id="main">
        <!-- title -->
        <h1 id="title">Account</h1>

        <!-- change account details -->
        <h3 id="accountDetailsTitle" class="sectionTitle">Details</h3>
        <div id="accountDetails" class="section">
            <form id="formAccountDetails" action="" method="POST">
                <input hidden type="text" name="details">
                <input hidden type="text" name="id" value="<?php echo $user_id ?>" placeholder='' />
                <input hidden type="text" name="username" value="<?php echo $user_username ?>" placeholder='username'/>
                <input id="inputDisabledUsername" title="username cannot be changed" disabled type="text" name="" value="<?php echo $user_username ?>" placeholder='username'/>
                <input type="text" name="firstname" title="firstname" value="<?php echo $user_firstname ?>" placeholder='first name' />
                <input type="text" name="lastname" title="lastname" value="<?php echo $user_lastname ?>" placeholder='last name' />
                <input type="text" name="email" title="email" value="<?php echo $user_email ?>" placeholder='email' />
                <button id="buttonUpdateDetails" type="submit" name="buttonUpdateDetails">Update</button>
            </form>
        </div>
        
        <!-- change account password -->
        <h3 id="accountChangePasswordTitle" class="sectionTitle">Password</h3>
        <div id="accountChangePassword" class="section">
            <form id="formAccountChangePassword" action="" method="POST">
                <input hidden type="text" name="id" value="<?php echo $user_id ?>" placeholder='' />
                <input hidden type="text" name="password">
                <input hidden value="<?php echo $user_id ?>" placeholder='' />
                <img id="imgShowPassword" src='/imgPasswordShow.png' onclick="showPassword()" />
                <img id="imgHidePassword" src='/imgPasswordHide.png' onclick="showPassword()" />
                <input id="oldPassword" required type="password" name="oldPassword" value="<?php echo $user_password ?>" title="old password" placeholder='old password' />
                <input id="newPassword" required type="password" name="newPassword" value="" title="new password" placeholder='new password' />
                <input id="newPasswordConfirm" required type="password" name="newPasswordConfirm" value="" title="new password confirm" placeholder='new password confirm' />
                <button id="buttonUpdatePassword" type="submit">Update</button>
            </form>
        </div>
    </div>
</body>
</html>

<script>
    function showPassword()
    {
        //elements
        let oldPassword = document.getElementById("oldPassword")
        let newPassword = document.getElementById("newPassword")
        let newPasswordConfirm = document.getElementById("newPasswordConfirm")
        let imgHidePassword = document.getElementById("imgHidePassword")
        let imgShowPassword = document.getElementById("imgShowPassword")

        //update elements
        if(oldPassword.type == "password")
        {
            oldPassword.type = "text"
            newPassword.type = "text"
            newPasswordConfirm.type = "text"
            imgHidePassword.style.display = "block"
            imgShowPassword.style.display = "none"
        }
        else if(oldPassword.type == "text")
        {
            oldPassword.type = "password"
            newPassword.type = "password"
            newPasswordConfirm.type = "password"
            imgHidePassword.style.display = "none"
            imgShowPassword.style.display = "block"
        }
    }
</script>

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
        margin: 40px 0px 0px 0px;
        text-align: center;
        vertical-align: top;
    }
    #title { margin: 0px 0px 0px -1px; font-size: 26px; text-align: center; }
    #accountChangePasswordTitle { margin-top: 40px; }
    #inputDisabledUsername { background-color: gray; }
    #imgShowPassword { display: block; position: absolute; height: 27px; width: 40px; margin: 7px 0px 0px 349px; user-select: none; }
    #imgHidePassword { display: none; position: absolute; height: 27px; width: 40px; margin: 7px 0px 0px 349px; user-select: none; }
    #formAccountDetails { width: 400px; margin: auto; }
    #formAccountChangePassword { width: 400px; margin: auto; }
    #accountDetailsTitle { margin-top: 20px; }

    /*** classes ***/
    .sectionTitle { width: 400px; margin: auto; text-align: left; user-select: none; }
    .errorMessage 
    { 
        display: block; 
        position: absolute;
        width: 60vw; 
        margin: 0px 0px 0px 34px;
        padding: 10px 0px 10px 0px;
        font-weight: bold;
        text-align: center; 
        color: red;
    }
    .successfulMessage 
    { 
        display: block; 
        position: absolute; 
        width: 60vw; 
        margin: 0px 0px 0px 34px;
        padding: 10px 0px 10px 0px;
        font-weight: bold;
        text-align: center; 
        color: lightgreen; 
    }

    /*** mobile ***/
    @media screen and (max-width: 1300px) {
        .post::-webkit-scrollbar { height: 0px; width: 0px; }

        body { height: 98vh; width: 89vw; border: 0px; }
        input { width: -webkit-fill-available; }

        #main { max-height: 90vh; width: 100%; margin: 0px; text-align: left; overflow-x: hidden; }
        #comments { max-height: 62vh; width: auto; }
        #title { display: none; margin-bottom: 2px; }
        #postTitle { margin-left: 0px; }
        #postText { margin-left: 0px; }
        #postAuthor { margin-left: 0px; }
        #formPostComment { width: 100%; }
        #buttonPostComment { width: 100%; }
        #categoryTitle { text-align: center; }
        #buttonUpdateDetails { width: -webkit-fill-available; }
        #buttonUpdatePassword { width: -webkit-fill-available; }
        #formAccountDetails { width: auto; }
        #formAccountChangePassword { width: auto; }
        #imgShowPassword { position: absolute; right: 10px; margin-left: 290px; }
        #imgHidePassword {position: absolute; right: 10px; margin-left: 290px; }
        #accountDetailsTitle { margin-top: 12px; }

        .post { width: auto; white-space: nowrap; overflow-x: auto; }
        .sectionTitle { width: auto; text-align: center; }
    }
</style>