<!-- post.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- meta -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- imports -->
    <link rel="shortcut icon" href="/icon.ico" type="image/x-icon">
    <?php include "includes/db.php" ?>
    <?php include "includes/sidebar.php" ?>
    <?php include "includes/backbutton.php" ?>
    
    <!-- get selected post text from db -->
    <?php
        if(isset($_GET['post']))
        {
            //variables
            $postId = $_GET['post'];

            //sql query
            $query = "SELECT * FROM posts WHERE post_id = '{$postId}'";

            //run query
            $qLoadPostById = mysqli_query($db_connection, $query);
            $qLength = mysqli_num_rows($qLoadPostById);
            
            //handle errors
            // if(!$qLoadPostById) { die("database error" . mysqli_error($db_connection)); }
        }
        else
        {
            echo "database error";
        }
    ?>

    <!-- get selected post comments from db -->
    <?php 
        if(isset($_GET['post']))
        {
            //sql query
            $query = "SELECT * FROM comments WHERE comment_post_id = '{$postId}' ORDER BY comment_date DESC;";

            //run sql query
            $qLoadCommentsByPostId = mysqli_query($db_connection, $query);
            $qTotalComments = mysqli_num_rows($qLoadCommentsByPostId);
            
            //handle errors
            // if(!$qLoadCommentsByPostId) { die("database error" . mysqli_error($db_connection)); }
        }
        else
        {
            echo "database error";
        }
    ?>
    
    <!-- create post comment in db -->
    <?php
        if($_POST)
        {
            //variables
            $id = $_POST['commentPost'];
            $category = $_POST['commentPostCategory'];
            $user = $_POST['commentUser'];
            $comment = $_POST['commentText']; 
            $date = $_POST['commentDate'];
            $email = $_POST['commentEmail'];
            $status = $_POST['commentStatus'];

            //clean string
            $comment = mysqli_real_escape_string($db_connection, $comment);

            //sql query
            $query = "INSERT INTO comments (comment_post_id, comment_author, comment_content, comment_date, comment_email, comment_status) 
            VALUES('$id', '$user', '$comment', '$date', '$email', '$status');";
            // $query = "UPDATE posts SET post_total_comments = post_total_comments + 1 WHERE post_id = '$postId'";
            
            //run sql query
            $qPostComment = mysqli_query($db_connection, $query);
            // $qPostCommentCounter = mysqli_query($db_connection, $query);
            
            //handle error
            if(!$qPostComment)
            {
                die("database error" . mysqli_error($db_connection));
            }
            else
            {
                //print status
                // echo "Comment Posted";

                //refresh page
                header('Location: ../post.php/?post=' . $postId);
            } 
        }
    ?>
    
    <!-- set page title -->
    <title><?php echo "Post#" . $postId ?></title>
</head>


<body>
    <div id="main">
        <!-- post header -->
        <?php              
            echo "<div id='postHeader'>";

            //post
            if($qLength != 0)
            {
                $counter = 0;
                
                while($row = mysqli_fetch_assoc($qLoadPostById))
                {
                    $counter++;

                    //variables
                    $post_id = $row['post_id'];
                    $post_category = $row['post_category'];
                    $post_title = $row['post_title'];
                    $post_user = $row['post_user'];
                    $post_date = $row['post_date'];
                    $post_text = $row['post_text'];

                    //post title
                    echo "<h3 id='postTitle'> $post_title </h3>";

                    //post text
                    if($post_text != null) { echo "<p id='postText'>$post_text</p>"; }
                    
                    echo "<p id='postAuthor'>Created: $post_date · In: $post_category · By: $post_user</p>";
                }
            }
            else
            {
                echo "</br> database error";
            }
            
            echo "</div>";
        ?>

        <!-- reply to post -->
        <h1 id="formPostCommentTitle" onclick="displayPostComment()">Reply</h1>
        <form id="formPostComment" action="" method="POST">
            <input hidden name="commentDate" value="<?php echo date("Y-m-d H:i:s") ?>"></input>
            <input hidden name="commentPost" value="<?php echo $postId ?>"></input>
            <input hidden name="commentPostCategory" value="<?php echo $post_category ?>"></input>
            <input hidden name="commentUser" value="<?php echo $_SESSION['username'] ?>"></input>
            <input hidden name="commentEmail" value="test@email.com"></input>
            <input hidden name="commentStatus" value="test"></input>
            <textarea required name="commentText" placeholder="comment..." maxlength="1000"></textarea>
            <button id="buttonPostComment" class="formButton" type="submit"><p>Confirm</p></button>
        </form>

        <!-- post comments -->
        <?php 
            echo "<h1 id='commentsTitle' onclick='displayComments()'>Comments ($qTotalComments) </h1>";

            if($qTotalComments != null)
            {
                $counter = $qTotalComments + 1;
                
                echo "<div id='comments'>";
                while($row = mysqli_fetch_assoc($qLoadCommentsByPostId))
                {
                    $counter--;

                    //variables
                    $comment_author = $row['comment_author'];
                    $comment_content = $row['comment_content'];
                    $comment_date = $row['comment_date'];

                    //comment text
                    echo "<div id='comment#$counter' class='comment'>";
                    echo "<p id='commentAuthor'>#$counter · $comment_author · $comment_date </p>";
                    echo "<p id='commentText'> $comment_content <p>";
                    echo "</div>";
                }
                echo "</div>";
            }
            else
            {
                echo "<div id='comments'>";
                echo "</div>";
            }
        ?>
    </div>
</body>
</html>


<script>
    function displayPostComment()
    {
        //elements
        let formPostComment = document.getElementById("formPostComment")
        let formPostCommentTitle = document.getElementById("formPostCommentTitle")
        let comments = document.getElementById("comments")
        let commentsTitle = document.getElementById("commentsTitle")

        //update elements
        if(formPostComment.style.display == "none" || formPostComment.style.display == "")
        {
            formPostComment.style.display = "inline-block"
            formPostCommentTitle.innerText = "Cancel"
            formPostCommentTitle.style.width = "-webkit-fill-available"
            comments.style.display = "none"
            commentsTitle.style.display = "none"
        }
        else if(formPostComment.style.display == "inline-block")
        {
            formPostComment.style.display = "none"
            formPostCommentTitle.style.width = "44%"
            formPostCommentTitle.innerText = "Reply"
            comments.style.display = "block"
            commentsTitle.style.display = "inline-block"
        }
    }

    function displayComments()
    {
        //elements
        let comments = document.getElementById("comments")

        //update elements
        if(comments.style.display == "none" || comments.style.display == "")
        {
            comments.style.display = "block"
        }
        else if(comments.style.display == "block")
        {
            comments.style.display = "none"
        }
    }
</script>


<style>
    /*** scrollbar ***/
    #comments::-webkit-scrollbar { height: 10px; width: 3px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { background: gray; }
    /* ::-webkit-scrollbar-thumb:hover { background: #600; } */

    /*** elements ***/
    html { background-color: black; }
    body 
    { 
        height: 100vh;
        width: 49vw; 
        margin: auto; 
        font-family: Arial, Helvetica, sans-serif;
        border-left: 1px solid white;
        border-right: 1px solid white;
        background-color: black; 
    }
    input { width: 100%; padding: 10px; font-size: 16px; }
    textarea 
    { 
        min-height: 100px;
        max-height: 100px;
        min-width: 100%;
        max-width: 100%;
        padding: 11px;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 16px; 
    }
    h1 { margin: 0px; font-size: 26px; user-select: none; }
    h3 { margin: 0px; }
    p { margin-top: 0px; margin-bottom: 0px; }
    a { text-decoration: none; font-weight: bold; color: black; }
    a:active { color: black; }


    /*** ids ***/
    #main
    {
        position: relative;
        display: inline-block;
        height: auto;
        width: calc(33vw + 10px); /* calc(31vw + 4px) */
        margin: 18px 0px 0px 4px;
        vertical-align: top;
        overflow-y: scroll;
        overflow-x: hidden;
    }
    #postHeader { margin: 0px; padding: 0px; color: white; }
    #buttonPostComment
    {
        width: -webkit-fill-available; /* calc(34vw + 20px) */
        margin: -4px 0px 0px 1px;
        padding: 10px;
        font-size: 18px;
        font-weight: bold;
        border: 0px solid black;
        background-color: white;
    }
    #formPostComment { display: none; width: -webkit-fill-available; margin-left: -1px; }
    #comments 
    {
        width: calc(96% - 8px); /* calc(34vw + 10px) */ /* calc(31vw + 4px) */
        display: block;
        max-height: 72vh;
        /* margin: 0px 0px 20px 0px; */
        overflow-y: scroll;
    }
    #commentAuthor { opacity: 0.4; white-space: nowrap; overflow-x: auto; }
    #commentText { margin: 0px; padding: 4px 0px 0px 0px; overflow-wrap: break-word; font-weight: bold; }
    #commentsTitle 
    { 
        display: inline-block;
        width: 44%;
        margin: 0px 0px 0px -4px;
        padding: 10px;
        font-size: 18px;
        text-align: center;
        white-space: nowrap;
        color: black;
        border-top: 1px solid black;
        border-bottom: 1px solid black;
        border-left: 1px solid black;
        background-color: white;
    }
    #postAuthor 
    { 
        margin-left: 0px; 
        padding: 0px 0px 10px 0px; 
        opacity: 0.4;
        white-space: nowrap;
        overflow-x: auto;
        color: white; 
        background-color: black; 
    }
    #postText { margin-left: 0px; padding: 4px 0px 6px 0px; font-weight: normal; overflow-y: scroll; color: white; background-color: black; }
    #postTitle
    {
        margin: 0px;
        margin-left: 0px;
        font-weight: bold;
        overflow-wrap: break-word;
        font-size: 26px;
        text-align: left;
    }
    #postHeader { /* height: 78vh; */ }
    #formPostCommentTitle 
    { 
        display: inline-block;
        width: 44%;
        margin: 0px;
        margin-top: -1px;
        padding: 10px;
        font-size: 18px;
        text-align: center;
        color: black;
        border-top: 1px solid black;
        background-color: white; 
    }

    /*** classes ***/
    .comment
    {
        width: auto;
        margin: 0px;
        padding: 20px 12px 20px 4px;
        font-size: 16px;
        /* box-shadow: 0px 0px 3px; */
        border-bottom: 1px solid gray;
        color: white;
        background-color: black;
    }

    /*** mobile ***/
    @media screen and (max-width: 1300px) {
        .post::-webkit-scrollbar { height: 0px; width: 0px; }

        body { height: 98vh; width: 89vw; border: 0px; }

        #main { max-height: 92vh; width: 100%; margin: 0px; }
        #comments { max-height: 62vh; width: calc(98% + 2px); }
        #title { margin-bottom: 2px; }
        #postTitle { margin-left: 0px; margin-top: -4px; white-space: nowrap; overflow-x: auto; }
        #postText { margin-left: 0px; }
        #postAuthor { margin-left: 0px; }
        #formPostComment { width: 100%; }
        #buttonPostComment { width: 100%; margin-top: -5px; }
        #commentsTitle { margin-left: -8px; }

        .commment { width: auto; white-space: nowrap; overflow-x: auto; }
    }
</style>