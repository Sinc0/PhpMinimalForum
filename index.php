<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum</title>
    <link rel="stylesheet" href="styles.css">

<?php include "includes/DbConnection.php" ?>

<?php session_start() ?>

<?php 
    if(isset($_POST['login']))
    {
        $username = $_POST['username'];
        $password = $_POST['password'];
        //echo $username;
        //echo $password;

        $query = "SELECT * FROM users WHERE user_username = '{$username}'";
        $qLoadAllUsers = mysqli_query($db_connection, $query);
        $qLength = mysqli_num_rows($qLoadAllUsers);
        //echo $qLength;

        if(!$qLoadAllUsers)
        {
            die("database error" . mysqli_error($db_connection));
        }
                
        while($row = mysqli_fetch_assoc($qLoadAllUsers))
        {
            $db_id = $row['user_id'];
            $db_email = $row['user_email'];
            $db_username = $row['user_username'];
            $db_password = $row['user_password'];
            $db_firstname = $row['user_firstname'];
            $db_lastname = $row['user_lastname'];
            $db_role = $row['user_role'];
        }

        if($username == $db_username && $db_password == $password)
        {
            $_SESSION['username'] = $db_username;
            $_SESSION['email'] = $db_email;
            $_SESSION['firstname'] = $db_firstname;
            $_SESSION['lastname'] = $db_lastname;
            
            echo $_SESSION['username'] . "<br />"; 
            echo $_SESSION['email'] . "<br />"; 
            echo $_SESSION['firstname'] . "<br />"; 
            echo $_SESSION['lastname'];

            header("Location: home.php");
        }
        else
        {
            echo "<p id='loginErrorMessage'><b> invalid name or password </b></p>";
        }
    }

    else if(isset($_POST['register']))
    {
        $username = $_POST['username'];
        $password = $_POST['password'];
        //echo $username;
        //echo $password;

        //create user
        $query = "SELECT * FROM users WHERE user_username = '{$username}'";
        $qCheckIfUserExist = mysqli_query($db_connection, $query);
        $qLength = mysqli_num_rows($qCheckIfUserExist);

        if($qLength > 0)
        {
            echo "<p id='registerErrorMessage'><b> user '$username' already exist </b></p>";
        }
        else
        {
            $query = "INSERT INTO users (user_username, user_password) VALUES('$username', '$password');";
            $qRegisterUser = mysqli_query($db_connection, $query);

            //redirect to home
            $query = "SELECT * FROM users WHERE user_username = '{$username}'";
            $qLoadUserByUsername = mysqli_query($db_connection, $query);
            $qLength = mysqli_num_rows($qLoadUserByUsername);

            while($row = mysqli_fetch_assoc($qLoadUserByUsername))
            {
                $db_id = $row['user_id'];
                $db_email = $row['user_email'];
                $db_username = $row['user_username'];
                $db_password = $row['user_password'];
                $db_firstname = $row['user_firstname'];
                $db_lastname = $row['user_lastname'];
                $db_role = $row['user_role'];
                }

                if($username == $db_username && $db_password == $password)
                {
                    $_SESSION['username'] = $db_username;
                    $_SESSION['email'] = $db_email;
                    $_SESSION['firstname'] = $db_firstname;
                    $_SESSION['lastname'] = $db_lastname;
                    
                    echo $_SESSION['username'] . "<br />"; 
                    echo $_SESSION['email'] . "<br />"; 
                    echo $_SESSION['firstname'] . "<br />"; 
                    echo $_SESSION['lastname'];

                    header("Location: home.php");
                }
            else
            {
                echo "<br /> invalid name or password";
            }
        }
        
    }
?>
</head>
<body>
    <script>
        function openLoginDiv()
        {
            document.getElementById("login").hidden = false;
            document.getElementById("register").hidden = true;
        }

        function openRegisterDiv()
        {
            document.getElementById("login").hidden = true;
            document.getElementById("register").hidden = false;
        }
    </script>

    <div id="selectLoginOrRegister">
        <button onclick="openLoginDiv()"><p>Login</p></button>
        <button onclick="openRegisterDiv()"><p>Register</p></button>
    </div>
    
    <div hidden id="login">
        <p><b>Login</b></p>
        
        <form action="" method="POST">
            <input hidden type="text" name="login">
            <input requried type="text" name="username" placeholder="username"><br />
            <input required type="text" name="password" placeholder="password"><br />
            <button id="loginButton" type="submit" name="loginForm"><p>Login</p></button>
        </form>
    </div>

    <div hidden id="register">
        <p><b>Register</b></p>

        <form action="" method="POST">
            <input hidden type="text" name="register">
            <input required type="text" name="username" placeholder="username"><br />
            <input required type="password" name="password" placeholder="password"><br />
            <button id="registerButton" type="submit" name="loginForm"><p>Register</p></button>
        </form>
    </div>
</body>
</html>