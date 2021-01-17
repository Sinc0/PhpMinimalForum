<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles.css">

<?php include "includes/DbConnection.php" ?>

<?php include "includes/sidebar.php" ?>

<?php
    if(isset($_GET['post']))
    {
        //load post
        $postId = $_GET['post'];

        $query = "SELECT * FROM posts WHERE post_id = '{$postId}'";
        $qLoadPostById = mysqli_query($db_connection, $query);
        $qLength = mysqli_num_rows($qLoadPostById);
        
        if(!$qLoadPostById)
        {
            die("database error" . mysqli_error($db_connection));
        }

        //load comments
        $query = "SELECT * FROM comments WHERE comment_post_id = '{$postId}' ORDER BY comment_date DESC;";
        $qLoadCommentsByPostId = mysqli_query($db_connection, $query);
        $qTotalComments = mysqli_num_rows($qLoadCommentsByPostId);
        
        if(!$qLoadCommentsByPostId)
        {
            die("database error" . mysqli_error($db_connection));
        }
    }
    else
    {
        echo "database error";
    }
?>

<?php
    if($_POST)
    {
        $id = $_POST['commentPost'];
        $category = $_POST['commentPostCategory'];
        $user = $_POST['commentUser'];
        $comment = $_POST['commentText']; $comment = mysqli_real_escape_string($db_connection, $comment);
        $date = $_POST['commentDate'];

        $query = "INSERT INTO comments (comment_post_id, comment_author, comment_content, comment_date) VALUES('$id', '$user', '$comment', '$date');";
        $qPostComment = mysqli_query($db_connection, $query);

        $query = "UPDATE posts SET post_total_comments = post_total_comments + 1 WHERE post_id = '$postId'";
        $qPostCommentCounter = mysqli_query($db_connection, $query);
        
        if(!$qPostComment)
        {
            die("database error" . mysqli_error($db_connection));
        }
        else
        {
            echo "Comment Posted";
            header('Location: ../post.php/?post=' . $postId);
        } 
    }
?>
    <title><?php echo "Post#" . $postId ?></title>
</head>
<body>
<div id="main">
    <div id="postHeader">
        <?php              
            //load post
            if($qLength != 0)
            {
                $counter = 0;
                
                while($row = mysqli_fetch_assoc($qLoadPostById))
                {
                    $counter++;

                    $post_id = $row['post_id'];
                    $post_category = $row['post_category'];
                    $post_title = $row['post_title'];
                    $post_user = $row['post_user'];
                    $post_date = $row['post_date'];
                    $post_text = $row['post_text'];

                    echo "<p id='postAuthor'>$post_date - user: $post_user</p>";
                    echo "<h3 id='postTitle'> $post_title </h3>";
                    echo "<br />";
                    echo "<p id='postText'>$post_text</p>";
                }
            }
            else
            {
                echo "</br> database error";
            }
        ?>
    </div>
    
    <form action="" method="POST">
        <input hidden name="commentDate" value="<?php echo date("Y-m-d H:i:s") ?>"></input>
        <input hidden name="commentPost" value="<?php echo $postId ?>"></input>
        <input hidden name="commentPostCategory" value="<?php echo $post_category ?>"></input>
        <input required name="commentUser" value="<?php echo $_SESSION['username'] ?>" placeholder="comment author"></input><br />
        <textarea required name="commentText" placeholder="comment text" maxlength=750></textarea>
        <button class="formButton" type="submit"><p>Post Comment</p></button>
    </form>

    <?php 
        //load comments
        if($qTotalComments != 0)
        {
            $counter = $qTotalComments + 1;

            
            echo "<div id='commentFeed'>";
                echo "<h3>$qTotalComments Comments </h3>";
                while($row = mysqli_fetch_assoc($qLoadCommentsByPostId))
                {
                    $counter--;

                    $comment_author = $row['comment_author'];
                    $comment_content = $row['comment_content'];
                    $comment_date = $row['comment_date'];

                    
                    echo "<div id='comment#$counter' class='comment'>";
                    echo "<p id='commentAuthor'>$comment_date - user: $comment_author </p>";
                    echo "<p id='commentText'> $comment_content <p>";
                    echo "</div>";
                    
                }
            echo "</div>";
        }
        else
        {
            //echo "database error";
        }
    ?>
</div>
</body>
</html>