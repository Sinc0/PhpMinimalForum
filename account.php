<!-- account.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- meta -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- page title -->
    <title>Account</title>
    
    <!--- imports -->
    <link rel="shortcut icon" href="/public/icon.ico" type="image/x-icon">
    <?php include "include-db.php" ?>
    <?php include "include-sidebar.php" ?>
    <?php include "include-backbutton.php" ?>

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
            
            // echo "<a href='/category?category=$category_title'><div id='sidebar-category#' class='sidebar-button'> · $category_title</div></a>";
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
                header("Location: /account");
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
                    header("Location: /account");
                    // echo "<p class='successfulMessage'>password change successful</p>";
                }
                
            }
            
        }
    ?>

    <!-- delete post by id -->
    <?php
        if(isset($_POST['deletePost']))
        {
            //variables
            $postId = $_POST['postId'];

            if($postId != null)
            {
                
                //sql query
                $query = "DELETE FROM posts WHERE post_id = '{$postId}'";
                // $query = "SELECT * FROM posts WHERE post_user_id = ''";

                //run query
                $qDeletePost = mysqli_query($db_connection, $query);
                
                //handle errors
                // if(!$qDeletePost) { die("database error" . mysqli_error($db_connection)); }
            }
        }
    ?>

    <!-- delete comment by id -->
    <?php
        if(isset($_POST['deleteComment']))
        {
            //variables
            $commentId = $_POST['commentId'];

            if($commentId != null)
            {
                
                //sql query
                $query = "DELETE FROM comments WHERE comment_id = '{$commentId}'";

                //run query
                $qDeleteComment = mysqli_query($db_connection, $query);
                
                //handle errors
                // if(!$qDeleteComment) { die("database error" . mysqli_error($db_connection)); }
            }
        }
    ?>

    <!-- delete account by id -->
    <?php
        if(isset($_POST['deleteAccountOnly']))
        {
            //variables
            $accountId = $_POST['accountId'];

            if($accountId != null)
            {
                
                //sql query
                $queryDeleteUser = "DELETE FROM users WHERE user_id = '{$accountId}'";

                //run query
                $qDeleteAccountUser = mysqli_query($db_connection, $queryDeleteUser);
                
                //handle errors
                if(!$qDeleteAccountUser) 
                { 
                    die("database error" . mysqli_error($db_connection)); 
                }
                else 
                { 
                    //handle session
                    session_start();
                    session_destroy();
                    
                    //redirect to index page
                    header('Location: /index');
                }

            }
        }
        
        else if(isset($_POST['deleteAccountPlusPosts']))
        {
            //variables
            $accountId = $_POST['accountId'];

            if($accountId != null)
            {
                
                //sql query
                $queryDeletePosts = "DELETE FROM posts WHERE post_user_id = '{$accountId}'";
                $queryDeleteUser = "DELETE FROM users WHERE user_id = '{$accountId}'";

                //run query
                $qDeleteAccountPosts = mysqli_query($db_connection, $queryDeletePosts);
                $qDeleteAccountUser = mysqli_query($db_connection, $queryDeleteUser);
                
                //handle errors
                if(!$qDeleteAccountUser) 
                { 
                    die("database error" . mysqli_error($db_connection)); 
                }
                else 
                { 
                    //handle session
                    session_start();
                    session_destroy();
                    
                    //redirect to index page
                    header('Location: /index');
                }

            }
        }

        else if(isset($_POST['deleteAccountPlusComments']))
        {
            //variables
            $accountId = $_POST['accountId'];

            if($accountId != null)
            {
                
                //sql query
                $queryDeleteComments = "DELETE FROM comments WHERE comment_user_id = '{$accountId}'";
                $queryDeleteUser = "DELETE FROM users WHERE user_id = '{$accountId}'";

                //run query
                $qDeleteAccountComments = mysqli_query($db_connection, $queryDeleteComments);
                $qDeleteAccountUser = mysqli_query($db_connection, $queryDeleteUser);
                
                //handle errors
                if(!$qDeleteAccountUser) 
                { 
                    die("database error" . mysqli_error($db_connection)); 
                }
                else 
                { 
                    //handle session
                    session_start();
                    session_destroy();
                    
                    //redirect to index page
                    header('Location: /index');
                }

            }
        }

        else if(isset($_POST['deleteAccountEverything']))
        {
            //variables
            $accountId = $_POST['accountId'];

            if($accountId != null)
            {
                
                //sql query
                $queryDeletePosts = "DELETE FROM posts WHERE post_user_id = '{$accountId}'";
                $queryDeleteComments = "DELETE FROM comments WHERE comment_user_id = '{$accountId}'";
                $queryDeleteUser = "DELETE FROM users WHERE user_id = '{$accountId}'";

                //run query
                $qDeleteAccountPosts = mysqli_query($db_connection, $queryDeletePosts);
                $qDeleteAccountComments = mysqli_query($db_connection, $queryDeleteComments);
                $qDeleteAccountUser = mysqli_query($db_connection, $queryDeleteUser);
                
                //handle errors
                if(!$qDeleteAccountUser) 
                { 
                    die("database error" . mysqli_error($db_connection)); 
                }
                else 
                { 
                    //handle session
                    session_start();
                    session_destroy();
                    
                    //redirect to index page
                    header('Location: /index');
                }

            }
        }
    ?>
    
    <!-- get all posts from db -->
    <?php
        $userId = $user_id;

        //sql query
        $query = "SELECT * FROM posts WHERE post_user_id = '{$userId}' ORDER BY post_id DESC";
        // $query = "SELECT * FROM posts WHERE post_user_id = ''";

        //run query
        $qLoadAllPosts = mysqli_query($db_connection, $query);
        $qLoadAllPostsLength = mysqli_num_rows($qLoadAllPosts);
        
        //handle errors
        if(!$qLoadAllPosts) { die("database error" . mysqli_error($db_connection)); }
    ?>
    
    <!-- get all comments from db -->
    <?php
        $userId = $user_id;

        //sql query
        $query = "SELECT * FROM comments WHERE comment_user_id = '{$userId}' ORDER BY comment_id DESC";
        // $query = "SELECT * FROM posts WHERE post_user_id = ''";

        //run query
        $qLoadAllComments = mysqli_query($db_connection, $query);
        $qLoadAllCommentsLength = mysqli_num_rows($qLoadAllComments);
        
        //handle errors
        if(!$qLoadAllComments) { die("database error" . mysqli_error($db_connection)); }
    ?>

</head>

<body onload="selectedCategory('account')">
    <div id="main">
        <!-- title -->
        <h1 id="title">Account</h1>

        <!-- stats -->
        <h3 id="accountStatsTitle" class="sectionTitle">Stats</h3>
        <div id="accountStats">
            <p class="userDetail"><?php echo $qLoadAllPostsLength ?> Posts Made</p>
            <p class="userDetail"><?php echo $qLoadAllCommentsLength ?> Comments Made</p>
        </div>
        
        <!-- details -->
        <h3 id="accountDetailsTitle" class="sectionTitle">Details</h3>
        <div id="accountDetails">
            <!-- <p class="userDetail">Id: <?php echo $user_id ?></p> -->
            <p class="userDetail">Username: <?php echo $user_username ?></p>
            <p class="userDetail">Firstname: <?php echo $user_firstname ?></p>
            <p class="userDetail">Lastname: <?php echo $user_lastname ?></p>
            <p class="userDetail">Email: <?php echo $user_email ?></p>
            <!-- <p class="userDetail">Latest Post:</p> -->
            <!-- <p class="userDetail">Latest Comment:</p> -->
        </div>

        <!-- options -->
        <h3 id="accountOptionsTitle" class="sectionTitle">Options</h3>
        <div id="accountOptions">
            <button id="" class="" onclick="displayModal('changeDetails')">Change Details</button>
            <button id="" class="" onclick="displayModal('changePassword')">Change Password</button>
            <button id="" class="deleteButton" onclick="displayModal('deletePost')">Delete Post</button>
            <button id="" class="deleteButton" onclick="displayModal('deleteComment')">Delete Comment</button>
            <button id="" class="deleteButton" onclick="displayModal('deleteAccount')">Delete Account</button>
        </div>

        <!-- modals -->
        <div id="modalAccountDetails" class="modal">
            <form id="formAccountDetails" action="" method="POST">
                <input hidden type="text" name="details">
                <input hidden type="text" name="id" value="<?php echo $user_id ?>" placeholder='' />
                <input hidden type="text" name="username" value="<?php echo $user_username ?>" placeholder='username'/>
                <input id="inputDisabledUsername" title="username cannot be changed" disabled type="text" name="" value="<?php echo $user_username ?>" placeholder='username'/>
                <input type="text" name="firstname" title="firstname" value="<?php echo $user_firstname ?>" placeholder='first name' />
                <input type="text" name="lastname" title="lastname" value="<?php echo $user_lastname ?>" placeholder='last name' />
                <input type="text" name="email" title="email" value="<?php echo $user_email ?>" placeholder='email' />
                <button id="buttonUpdateDetails" type="submit" name="buttonUpdateDetails">Confirm</button>
            </form>
        </div>

        <div id="modalAccountChangePassword" class="modal">
            <form id="formAccountChangePassword" action="" method="POST">
                <input hidden type="text" name="password">
                <input hidden type="text" name="id" value="<?php echo $user_id ?>" placeholder='' />
                <input hidden value="<?php echo $user_id ?>" placeholder='' />
                <img id="imgShowPassword" src='/public/imgPasswordShow.png' onclick="showPassword()" />
                <img id="imgHidePassword" src='/public/imgPasswordHide.png' onclick="showPassword()" />
                <input id="oldPassword" required type="password" name="oldPassword" value="" placeholder='old password' />
                <input id="newPassword" required type="password" name="newPassword" value="" placeholder='new password' />
                <input id="newPasswordConfirm" required type="password" name="newPasswordConfirm" value="" placeholder='confirm new password' />
                <button id="buttonUpdatePassword" type="submit">Confirm</button>
            </form>
        </div>

        <div id="modalDeletePost" class="modal">
            <?php
                if($qLoadAllPostsLength == 0)
                {
                    echo "<input disabled id='postsMadeIsZero' type='text' value='0 Posts Made' />";
                }
                else if($qLoadAllPostsLength > 0)
                {
                    $counter = $qLoadAllPostsLength + 1;
                    
                    while($row = mysqli_fetch_assoc($qLoadAllPosts))
                    {
                        $counter--;
                        
                        //variables
                        $post_title = $row['post_title'];
                        $post_category = $row['post_category'];
                        $post_id = $row['post_id'];
                        $post_date = $row['post_date'];
                        
                        //post title
                        echo "<div class='post' onclick='selectPostForDeletion($post_id, $counter)'>#$counter · $post_title</div>";
                        // echo "<a href='/category?category=$post_title'><div id='sidebar-category#' class='sidebar-button'> · $post_title</div></a>";
                    }
                }
            ?>

            <form id="formDeletePost" action="" method="POST">
                <input hidden type="text" name="deletePost">
                <input hidden required id="postId" name="postId" type="text" value="" />
                <button disabled id="buttonDeletePostConfirm" type="submit">Delete Post</button>
            </form>
        </div>

        <div id="modalDeleteComment" class="modal">
            <?php
                if($qLoadAllCommentsLength == 0)
                {
                    echo "<input disabled id='commentsMadeIsZero' type='text' value='0 Comments Made' />";
                }
                else if($qLoadAllCommentsLength > 0)
                {
                    $counter = $qLoadAllCommentsLength + 1;
                    
                    while($row = mysqli_fetch_assoc($qLoadAllComments))
                    {
                        $counter--;
                        
                        //variables
                        $comment_id = $row['comment_id'];
                        $comment_content = $row['comment_content'];
                        $comment_author = $row['comment_author'];
                        
                        //post title
                        echo "<div class='post' onclick='selectCommentForDeletion($comment_id, $counter)'>#$counter · $comment_content</div>";
                        // echo "<a href='/category?category=$post_title'><div id='sidebar-category#' class='sidebar-button'> · $post_title</div></a>";
                    }
                }
            ?>
        
            <form id="formDeleteComment" action="" method="POST">
                <input hidden type="text" name="deleteComment">
                
                <input hidden required id="commentId" name="commentId" type="number" value="" />
                <button disabled id="buttonDeleteCommentConfirm" type="submit">Delete Comment</button>
            </form>
        </div>

        <div id="modalDeleteAccount" class="modal">
            <form id="formDeleteAccount" action="" method="POST">
                <input hidden id="deleteAccountType" type="text" name="">
                <input hidden required id="accountId" name="accountId" type="number" value="<?php echo $user_id ?>" />
                <input hidden required id="accountUsername" name="accountUsername" type="text" value="<?php echo $user_username ?>" />
                <input disabled id="accountConfirmDeletionText" name="accountId" type="text" value="Delete Account Options" />
                <!-- <input class="accountConfirmDeletionNo" name="accountId" type="button" value="No I changed my mind" onclick="undisplayModal()" /> -->
                <input class="accountConfirmDeletionYes" name="accountId" type="button" value="#1 · Delete Account Only" onclick="confirmAccountDeletion('1', '<?php echo $user_username ?>')" />
                <input class="accountConfirmDeletionYes" name="accountId" type="button" value="#2 · Delete Account + Posts " onclick="confirmAccountDeletion('2', '<?php echo $user_username ?>')" />
                <input class="accountConfirmDeletionYes" name="accountId" type="button" value="#3 · Delete Account + Comments" onclick="confirmAccountDeletion('3', '<?php echo $user_username ?>')" />
                <input class="accountConfirmDeletionYes" name="accountId" type="button" value="#4 · Delete Everything" onclick="confirmAccountDeletion('4', '<?php echo $user_username ?>')" />
                <button disabled id="buttonDeleteAccountConfirm" type="submit">Delete Account</button>
            </form>
        </div>

        <div id="modalUnderlay" onclick="undisplayModal()"></div>
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

    function selectedCategory(category)
    {
        //elements
        let selectedCategory = document.getElementById("sidebar-" + category)
        let posts = document.getElementById("sidebar-posts")
        let categories = document.getElementById("sidebar-categories")
        let account = document.getElementById("sidebar-account")
        let about = document.getElementById("sidebar-about")

        //update elements
        posts.style.opacity = "0.4"
        categories.style.opacity = "0.4"
        account.style.opacity = "0.4"
        about.style.opacity = "0.4"
        selectedCategory.style.opacity = "1"
    }

    function displayModal(type)
    {
        //elements
        let modalDeletePost = document.getElementById("modalDeletePost")
        let modalDeleteComment = document.getElementById("modalDeleteComment")
        let modalDeleteAccount = document.getElementById("modalDeleteAccount")
        let modalUnderlay = document.getElementById("modalUnderlay")
        let modalAccountDetails = document.getElementById("modalAccountDetails")
        let modalAccountChangePassword = document.getElementById("modalAccountChangePassword")

        //reset elements
        modalDeletePost.style.display = "none"
        modalDeleteComment.style.display = "none"
        modalDeleteAccount.style.display = "none"
        modalAccountDetails.style.display = "none"
        modalAccountChangePassword.style.display = "none"
        modalUnderlay.style.display = "block"

        //update elements
        if(type == "deletePost") { modalDeletePost.style.display = "block" }
        else if(type == "deleteComment") { modalDeleteComment.style.display = "block" }
        else if(type == "deleteAccount") { modalDeleteAccount.style.display = "block" }
        else if(type == "changeDetails") { modalAccountDetails.style.display = "block" }
        else if(type == "changePassword") { modalAccountChangePassword.style.display = "block" }
    }

    function undisplayModal()
    {
        //elements
        let modalDeletePost = document.getElementById("modalDeletePost")
        let modalDeleteComment = document.getElementById("modalDeleteComment")
        let modalDeleteAccount = document.getElementById("modalDeleteAccount")
        let modalUnderlay = document.getElementById("modalUnderlay")
        let modalAccountDetails = document.getElementById("modalAccountDetails")
        let modalAccountChangePassword = document.getElementById("modalAccountChangePassword")

        //update elements
        modalDeletePost.style.display = "none"
        modalDeleteComment.style.display = "none"
        modalDeleteAccount.style.display = "none"
        modalUnderlay.style.display = "none"
        modalAccountDetails.style.display = "none"
        modalAccountChangePassword.style.display = "none"
    }

    function selectPostForDeletion(id, counter)
    {
        //elements
        let inputPostId = document.getElementById("postId")
        let buttonDeletePostConfirm = document.getElementById("buttonDeletePostConfirm")

        //update elements
        inputPostId.value = id
        buttonDeletePostConfirm.innerText = "Delete Post #" + counter
        buttonDeletePostConfirm.disabled = false
    }

    function selectCommentForDeletion(id, counter)
    {
        //elements
        let inputCommentId = document.getElementById("commentId")
        let buttonDeleteCommentConfirm = document.getElementById("buttonDeleteCommentConfirm")

        //update elements
        inputCommentId.value = id
        buttonDeleteCommentConfirm.innerText = "Delete Comment #" + counter
        buttonDeleteCommentConfirm.disabled = false
    }

    function confirmAccountDeletion(option, username)
    {
        //elements
        let buttonDeleteAccountConfirm = document.getElementById("buttonDeleteAccountConfirm")
        let deleteAccountType = document.getElementById("deleteAccountType")

        //variables
        let text = ""
        
        //update elements
        if(option == 1) { text = "Delete Account Only"; deleteAccountType.name = "deleteAccountOnly" }
        else if(option == 2) { text = "Delete Account + Posts"; deleteAccountType.name = "deleteAccountPlusPosts" }
        else if(option == 3) { text = "Delete Account + Comments"; deleteAccountType.name = "deleteAccountPlusComments" }
        else if(option == 4) { text = "Delete Everything"; deleteAccountType.name = "deleteAccountEverything" }

        buttonDeleteAccountConfirm.innerText = text
        buttonDeleteAccountConfirm.disabled = false
    }
</script>


<style>
    /*** elements ***/
    html { background-color: black; }
    body 
    { 
        height: 100vh; 
        width: 49vw; 
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
        margin: 0px; /* margin: -4px 0px 0px 0px; */
        padding: 10px;
        font-size: 18px;
        font-weight: bold;
        user-select: none;
        -webkit-user-select: none;
        color: black;
        border: 1px solid black;
        background-color: white;
    }
    p { margin-top: 0px; margin-bottom: 0px; }
    a { text-decoration: none; font-weight: bold; color: black; }
    a:active { color: black; }


    /*** ids ***/
    #main
    {
        position: relative;
        display: inline-block;
        height: auto;
        width: calc(34vw + 10px); /* calc(31vw + 4px) */
        margin: 0px 0px 0px -4px;
        text-align: center;
        vertical-align: top;
        user-select: none;
        -webkit-user-select: none;
    }
    #title { display: none; margin: 0px 0px 0px -1px; font-size: 26px; text-align: center; }
    #inputDisabledUsername { background-color: gray; }
    #imgShowPassword 
    { 
        display: block; 
        position: absolute; 
        height: 27px; 
        width: 40px; 
        margin: 7px 0px 0px 349px; 
        user-select: none;
        -webkit-user-select: none;
    }
    #imgHidePassword 
    { 
        display: none; 
        position: absolute; 
        height: 27px; 
        width: 40px; 
        margin: 7px 0px 0px 349px; 
        user-select: none;
        -webkit-user-select: none;
    }
    #formAccountDetails { width: 400px; margin: auto; }
    #formAccountChangePassword { width: 400px; margin: auto; }
    #accountStatsTitle { margin-top: 20px; }
    #accountDetailsTitle { margin-top: 40px; }
    #accountOptionsTitle { margin-top: 40px; margin-bottom: 3px; }
    #modalUnderlay
    {
        display: none;
        position: fixed;
        height: 100vh;
        width: 100vw;
        top: 0px;
        left: 0px;
        opacity: 0.9;
        z-index: 1;
        background-color: black;
    }
    #buttonDeletePostConfirm { margin-top: 0px; background-color: red; }
    #buttonDeleteCommentConfirm { margin-top: 0px; background-color: red; }
    #buttonDeleteAccountConfirm { margin-top: 0px; background-color: red; }
    #accountDetails { width: 400px; margin: auto; text-align: left; }
    #accountStats { width: 400px; margin: auto; text-align: left; }
    #accountConfirmDeletionText 
    { 
        width: -webkit-fill-available; 
        font-weight: bold; 
        text-align: center;
        overflow-x: auto;
        color: white;
        background-color: black; 
    }
    #commentsMadeIsZero { text-align: center; font-weight: bold; color: white; background-color: black; }
    #postsMadeIsZero { text-align: center; font-weight: bold; color: white; background-color: black; }

    /*** classes ***/
    .sectionTitle { width: 400px; margin: auto; margin-bottom: 2px; text-align: left; user-select: none; -webkit-user-select: none; }
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
    .deleteButton { background-color: red; }
    .post { width: auto; margin: 10px 0px 10px 10px; font-weight: bold; white-space: nowrap; overflow-x: auto; color: white; }
    .userDetail { font-size: 18px; font-weight: normal; color: white; }
    .modal
    {
        display: none;
        position: fixed;
        max-height: 93vh;
        width: 396px; 
        top: 30px;
        margin-left: calc(7vw - 2px);
        text-align: left;
        overflow-y: auto;
        z-index: 2;
        border: 1px solid #ffffffb3; 
        background-color: black; 
    }
    .accountConfirmDeletionYes 
    { 
        width: -webkit-fill-available;
        font-weight: bold; 
        text-align: left; 
        overflow-x: auto;
        font-size: 16px;
        color: white; 
        background-color: black; 
    }
    .accountConfirmDeletionNo 
    { 
        width: -webkit-fill-available; 
        font-weight: bold; 
        text-align: center;
        overflow-x: auto;
        color: black; 
        background-color: lightgreen; 
    }

    /*** mobile ***/
    @media screen and (max-width: 1300px) {
        .post::-webkit-scrollbar { height: 0px; width: 0px; }

        body { height: 98vh; width: 89vw; border: 0px; }
        input { width: -webkit-fill-available; }
        button { width: -webkit-fill-available; }

        #main { max-height: 90vh; width: 100%; margin: 0px 0px 0px 1px; text-align: left; overflow-x: hidden; }
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
        #accountDetailsTitle { margin-top: 40px; }
        #modalUnderlay
        {
            position: fixed;
            height: 100vh;
            width: 100vw;
            top: 0px;
            opacity: 0.9;
            z-index: 1;
            background-color: black;
        }
        #accountOptionsTitle { margin-top: 40px; }
        #accountStatsTitle { margin-top: 12px; }
        #accountDetails { width: auto; margin: auto; }
        #accountStats { width: auto; margin: auto; }

        .sectionTitle { width: auto; text-align: left; }
        .errorMessage { position: relative; margin: auto; }
        .successfulMessage { position: relative; margin: auto; }
        .modal 
        { 
            display: none;
            position: fixed;
            max-height: 93vh;
            width: 88vw; 
            top: 20px;
            margin-left: 0px;
            text-align: left;
            overflow-y: auto;
            z-index: 2;
            border: 1px solid #ffffffb3; 
            background-color: black; 
        }
    }
</style>