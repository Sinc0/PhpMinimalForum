<!-- index.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- meta -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- page title -->
    <title>Minimal Forum</title>
    
    <!-- imports -->
    <link rel="shortcut icon" href="/public/icon.ico" type="image/x-icon">
    <link rel="manifest" href="/public/pwa/manifest.json">
    <script src="/service-worker.js"></script>
    <?php include "include-db.php" ?>

    <!-- start browser session -->
    <?php session_start() ?>

    <!-- debugging -->
    <?php echo $_SERVER['REQUEST_URI'] ?>

    <!-- try login user -->
    <?php 
        if(isset($_POST['login']))
        {
            //variables
            $username = $_POST['username'];
            $password = $_POST['password'];

            
            //sql query
            $query = "SELECT * FROM users WHERE user_username = '{$username}'";
            
            //run query
            $qLoadAllUsers = mysqli_query($db_connection, $query);
            $qLength = mysqli_num_rows($qLoadAllUsers);

            //debugging
            //echo $username;
            //echo $password;
            //echo $qLength;

            //handle errors
            if(!$qLoadAllUsers) { die("database error" . mysqli_error($db_connection)); }
            
            //sort user data
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

            //check user credentials
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

                //redirect successful login to
                header("Location: /posts");
            }
            else
            {
                echo "<p id='loginErrorMessage' style='padding: 20px 0px 20px 0px; color: red;'><b> invalid name or password </b></p>";
            }
        }

        else if(isset($_POST['register']))
        {
            //variables
            $username = $_POST['username'];
            $password = $_POST['password'];

            //debugging
            //echo $username;
            //echo $password;

            //sql query
            $query = "SELECT * FROM users WHERE user_username = '{$username}'";

            //run query
            $qCheckIfUserExist = mysqli_query($db_connection, $query);
            $qLength = mysqli_num_rows($qCheckIfUserExist);

            //handle errors
            if($qLength > 0)
            {
                echo "<p id='registerErrorMessage' style='padding: 20px 0px 20px 0px; color: red;'><b> username $username is already taken</b></p>";
            }
            else
            {
                //sql query
                $query = "INSERT INTO users (user_id, user_username, user_password, user_firstname, user_lastname, 
                user_email, user_image, user_role, user_salt) 
                VALUES('0', '$username', '$password', '', '', '', '', '', '');";
                $qRegisterUser = mysqli_query($db_connection, $query);
                
                //handle query errors
                if(!$qRegisterUser) { die("database error" . mysqli_error($db_connection)); }
            }    
        }
    ?>
</head>


<body>
    <!-- select login or register -->
    <div id="selectLoginOrRegister">
        <button id="buttonSelectLogin" onclick="openLoginDiv()"><p>Login</p></button>
        <button id="buttonSelectRegister" onclick="openRegisterDiv()"><p>Register</p></button>
    </div>
    
    <!-- login box -->
    <div hidden id="login">
        <form action="" method="POST">
            <input hidden type="text" name="login">
            <input requried type="text" name="username" placeholder="username"><br />
            <input required type="password" name="password" placeholder="password"><br />
            <button id="loginButton" type="submit" name="loginForm"><p>Confirm</p></button>
        </form>
    </div>

    <!-- register box -->
    <div hidden id="register">
        <form action="" method="POST">
            <input hidden type="text" name="register">
            <input required type="text" name="username" placeholder="register username"><br />
            <input required type="password" name="password" placeholder="register password"><br />
            <!-- <input required type="date" name="date"><br /> -->
            <button id="registerButton" type="submit" name="loginForm"><p>Confirm</p></button>
        </form>
    </div>
</body>
</html>


<script>
    //debugging
    console.log("path: " + <?= json_encode($_SERVER['REQUEST_URI']) ?>)
    
    function openLoginDiv()
    {
        //elements
        let login = document.getElementById("login")
        let register = document.getElementById("register")
        let buttonSelectLogin = document.getElementById("buttonSelectLogin")
        let buttonSelectRegister = document.getElementById("buttonSelectRegister")
        
        //update elements
        login.hidden = false;
        register.hidden = true;
        buttonSelectLogin.style.opacity = "1"
        buttonSelectRegister.style.opacity = "0.4"
    }

    function openRegisterDiv()
    {
        //elements
        let login = document.getElementById("login")
        let register = document.getElementById("register")
        let buttonSelectLogin = document.getElementById("buttonSelectLogin")
        let buttonSelectRegister = document.getElementById("buttonSelectRegister")
        
        //update elements
        login.hidden = true;
        register.hidden = false;
        buttonSelectLogin.style.opacity = "0.4"
        buttonSelectRegister.style.opacity = "1"
    }
</script>


<style>
    /*** elements ***/
    html 
    { 
        height: 100vh;
        width: 100vw;
        /* background-image: url('https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2F33.media.tumblr.com%2Fbccb82903389786a4a8e73091300ba04%2Ftumblr_npubntd6Hs1ts4htvo1_500.gif&f=1&nofb=1&ipt=2d386eb4b0f747615b3d85156079c51a1b155bff8cfa2d4b6ede6baa806389d6&ipo=images'); */
        /* background-size: cover; */
        /* background-repeat: no-repeat; */
        background-color: black;
    }
    body { margin-top: 28vh; font-family: Arial, Helvetica, sans-serif; }
    form { margin: auto; margin-top: 30px; margin-bottom: 30px; border: 1px solid black; background-color: gray; }
    h1 { font-family: Arial, Helvetica, sans-serif; } 
    h2 { font-family: Arial, Helvetica, sans-serif; } 
    h3 { font-family: Arial, Helvetica, sans-serif; } 
    p { font-family: Arial, Helvetica, sans-serif; } 
    b { font-family: Arial, Helvetica, sans-serif; } 
    button { font-family: Arial, Helvetica, sans-serif; }
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
        background-color: black;
    }
    p { margin-top: 0px; margin-bottom: 0px; }
    a { text-decoration: none; font-weight: bold; color: black; }
    a:active { color: black; }


    /*** ids ***/
    #login { width: 400px; margin: auto; }
    #register { width: 400px; margin: auto; }
    #login form { margin: 0px; }
    #register form { margin: 0px; }
    #loginButton 
    { 
        width: 397px; 
        height: 40px;
        margin: 0px;
        margin-left: 1px;
        margin-top: -1px;
        padding: 10px;
        user-select: none; 
        font-weight: bold; 
        font-size: 18px;
        border: 0px solid white;
        background-color: white; 
    }
    #registerButton 
    { 
        width: 397px; 
        height: 40px;
        margin: 0px;
        margin-left: 1px;
        margin-top: -1px;
        padding: 10px;
        user-select: none; 
        font-weight: bold; 
        font-size: 18px;
        border: 0px solid white;
        background-color: white;
    }
    #selectLoginOrRegister 
    { 
        display: flex; 
        width: 400px; 
        margin: auto; 
        margin-bottom: -1px;
        text-align: center; 
    }
    #selectLoginOrRegister button 
    { 
        width: 200px; 
        padding: 10px; 
        font-weight: bold;
        font-size: 18px;
        border: 1px solid black; 
        background-color: white;
    }
    #loginErrorMessage { color: red; text-align: center; }
    #registerErrorMessage { text-align: center; }

    /*** mobile ***/
    @media screen and (max-width: 1300px) {
        html { height: 90vh; width: 89vw; margin: auto; }
        body { height: auto; width: 89vw; margin: 31vh 0px 0px 0px; padding: 0px; overflow-x: hidden; overflow-y: hidden; }
        input { width: -webkit-fill-available; }

        #selectLoginOrRegister { width: 90vw; }
        #login { width: 100%; }
        #register { width: 100%; }
        #loginButton { width: -webkit-fill-available; }
        #registerButton { width: -webkit-fill-available; }

    }
</style>
