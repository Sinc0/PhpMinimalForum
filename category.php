<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles.css">
    
<?php include "includes/DbConnection.php" ?>

<?php include "includes/sidebar.php" ?>

<?php
    if(isset($_GET['category']))
    {
        $category = $_GET['category'];
    }

    //load category posts
    $query = "SELECT * FROM posts WHERE post_category = '{$category}' ORDER BY post_date DESC";
    $qLoadAllPosts = mysqli_query($db_connection, $query);
    $qTotalPosts = mysqli_num_rows($qLoadAllPosts);
    
    if(!$qLoadAllPosts)
    {
        die("database error" . mysqli_error($db_connection));
    }
?>

<?php
    if($_POST)
    {
        $postUser = $_POST['postUser'];
        $postCategory = $_POST['postCategory'];
        $postTitle = $_POST['postTitle']; $postTitle = mysqli_real_escape_string($db_connection, $postTitle);
        $postText = $_POST['postText']; $postText = mysqli_real_escape_string($db_connection, $postText);
        $postDate = $_POST['postDate'];

        $query = "INSERT INTO posts (post_user, post_category, post_title, post_text, post_date) VALUES('$postUser', '$postCategory', '$postTitle', '$postText', '$postDate');";
        $qCreatePost = mysqli_query($db_connection, $query);
        
        if(!$qCreatePost)
        {
            die("database error" . mysqli_error($db_connection));
        }
        else
        {
            echo "Post Created";
            header('Location: ../category.php/?category=' . $category);
        } 
    }
?>
    <title><?php echo $category ?></title>
</head>

<body>
<div id="main">

    <!-- create post -->
    <form action="" method="POST">
        <input hidden name="postDate" value="<?php echo date("Y-m-d H:i:s") ?>"></input>
        <input hidden name="postCategory" value="<?php echo $category ?>"></input>
        <input required name="postUser" value="<?php echo $_SESSION['username'] ?>" placeholder="post author"></input><br />
        <input required name="postTitle" placeholder="post title" maxlength=65></input><br />
        <textarea name="postText" placeholder="post text"></textarea><br />
        <button class="formButton" type="submit"><p>Create Post</p></button>
    </form>

    <!-- load posts -->
    <?php    
        echo "<h1 id='categoryTitle'>$category</h1>";
            
        if($qTotalPosts != 0)
        {
            $counter = 0;
            
            while($row = mysqli_fetch_assoc($qLoadAllPosts))
            {
                $counter++;

                $post_id = $row['post_id'];
                $post_title = $row['post_title'];
                $post_user = $row['post_user'];
                $post_date = $row['post_date'];
                $post_total_comments = $row['post_total_comments'];

                echo "<a href='../post.php/?post=$post_id'><div id='post#$post_id' class='category'>$post_total_comments comments - $post_title - $post_user</div></a>";
            }
        }
        else
        {
            echo "datebase error";
        }
    
    ?>
</div>
</body>
</html>