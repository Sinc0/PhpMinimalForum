<!-- category.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- meta -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- page title -->
    <title><?php echo $category ?></title>
    
    <!-- imports -->
    <link rel="stylesheet" href="../styles.css">
    <?php include "includes/db.php" ?>
    <?php include "includes/sidebar.php" ?>
    <?php include "includes/backbutton.php" ?>

    <!-- get selected category data from db -->
    <?php
        if(isset($_GET['category']))
        {
            $category = $_GET['category'];
        }

        //sql query
        $query = "SELECT * FROM posts WHERE post_category = '{$category}' ORDER BY post_date DESC";

        //run query
        $qLoadAllPosts = mysqli_query($db_connection, $query);
        $qTotalPosts = mysqli_num_rows($qLoadAllPosts);
        
        //handle errors
        if(!$qLoadAllPosts) { die("database error" . mysqli_error($db_connection)); }
    ?>

    <!-- create post in db -->
    <?php
        if($_POST)
        {
            //variables
            $postUser = $_POST['postUser'];
            $postCategory = $_POST['postCategory'];
            $postTitle = $_POST['postTitle']; 
            $postText = $_POST['postText']; 
            $postDate = $_POST['postDate'];
            
            //format strings
            $postText = mysqli_real_escape_string($db_connection, $postText);
            $postTitle = mysqli_real_escape_string($db_connection, $postTitle);

            //sql query
            $query = "INSERT INTO posts (post_user, post_category, post_title, post_text, post_date, post_total_comments) 
            VALUES('$postUser', '$postCategory', '$postTitle', '$postText', '$postDate', '0');";
            
            //run query
            $qCreatePost = mysqli_query($db_connection, $query);
            
            //handle query errors
            if(!$qCreatePost) 
            { 
                die("database error" . mysqli_error($db_connection)); 
            }
            else
            {
                // echo "Post Created";

                //refresh page
                header('Location: ../category.php/?category=' . $category);
            } 
        }
    ?>
</head>


<body>
    <div id="main">
        <!-- load posts -->
        <?php echo "<h1 id='categoryTitle'>$category ($qTotalPosts)</h1>"; ?>

        <div id="posts">
        <?php    
            // echo "<h1 id='categoryTitle'>$category Posts</h1>";
            // echo "<h1>Posts</h1>";
                
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

                    // echo "<a href='../post.php/?post=$post_id'><div id='post#$post_id' class='category'>$post_title · $post_total_comments comments</div></a>";
                    echo "<a href='../post.php/?post=$post_id'><div id='post#$post_id' class='post'>#$counter · $post_title</div></a>";
                }
            }
            else
            {
                // echo "datebase error";
            }
        
        ?>
        </div>

        <!-- create post -->
        <h1 id="formCreatePostTitle" onclick="displayCreatePost()">Create Post</h1>
        <form id="formCreatePost" action="" method="POST"> 
            <input hidden name="postDate" value="<?php echo date("Y-m-d H:i:s") ?>"></input>
            <input hidden name="postCategory" value="<?php echo $category ?>"></input>
            <input required name="postTitle" placeholder="Title..." maxlength="100"></input>
            <input hidden name="postUser" value="<?php echo $_SESSION['username'] ?>" placeholder="post author" maxlength="100"></input>
            <textarea name="postText" maxlength="1000" placeholder="Text..."></textarea>
            <button id="buttonCreatePost" class="formButton" type="submit"><p>Confirm</p></button>
        </form>
    </div>
</body>
</html>


<script>
    function displayCreatePost()
    {
        //elements
        let formCreatePost = document.getElementById("formCreatePost")
        let posts = document.getElementById("posts")
        let formCreatePostTitle = document.getElementById("formCreatePostTitle")

        //update elements
        if(formCreatePost.style.display == "none" || formCreatePost.style.display == "")
        {
            formCreatePost.style.display = "block"
            posts.style.display = "none"

            formCreatePostTitle.innerText = "Cancel"
            formCreatePostTitle.style.marginTop = "8px"
        }
        else if(formCreatePost.style.display == "block")
        {
            formCreatePost.style.display = "none"
            posts.style.display = "block"

            formCreatePostTitle.innerText = "Create Post"
            formCreatePostTitle.style.marginTop = "-1px"
        }
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
        /* margin-top: 40px;  */
        /* margin-left: 24vw; */
        color: white; 
        font-family: Arial, Helvetica, sans-serif;
        border-left: 2px solid white; 
        border-right: 2px solid white; 
        background-color: black; 
    }
    input { width: 100%; margin-top: -1px; padding: 10px; font-family: Arial, Helvetica, sans-serif; font-size: 16px; }
    textarea
    {
        min-height: 100px;
        max-height: 100px;
        min-width: 100%;
        max-width: 100%;
        margin-top: -1px;
        padding: 11px;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 16px;
    }
    h1
    {
        margin: 0px;
        padding: 0px;
        font-size: 26px;
        user-select: none;
    }

    /*** ids ***/
    #main
    {
        position: relative;
        display: inline-block;
        height: auto;
        margin: 18px 0px 0px 4px;
        width: calc(33vw + 10px); /* calc(31vw + 4px) */
        vertical-align: top;
    }
    #categoryTitle
    {
        margin: 0px 0px 0px -1px;
        font-size: 26px;
        text-align: left;
    }
    #formCreatePost
    {
        display: none;
        width: calc(33vw - 11px);
        margin-left: -2px;
    }
    #formCreatePostTitle 
    { 
        width: auto;
        margin: -1px 0px 0px -1px; 
        padding: 10px;
        font-weight: bold;
        font-size: 18px;
        text-align: center;
        color: black;
        border-bottom: 1px solid black;
        background-color: white; 
    }
    #buttonCreatePost
    {
        width: calc(33vw + 12px);
        margin: -4px 0px 0px 1px;
        padding: 10px;
        font-size: 18px;
        font-weight: bold;
        border: 0px solid black;
        background-color: white;
    }
    #posts
    {
        max-height: 78vh;
        overflow-y: auto;
    }

    /*** classes ***/
    .post
    {
        width: auto; /* calc(31vw - 16px) */
        padding: 10px 10px 10px 0px;
        overflow-wrap: break-word;
        font-size: 18px;
        color: white;
        border-bottom: 1px solid white;
        background-color: black;
    }

    /*** mobile ***/
    @media screen and (max-width: 1300px) {
        .post::-webkit-scrollbar { height: 0px; width: 0px; }

        body { height: 98vh; width: 89vw; border: 0px; }
        input { width: -webkit-fill-available; }
        textarea { max-width: -webkit-fill-available; min-width: -webkit-fill-available; }

        #main { max-height: 92vh; width: 100%; margin: 0px; }
        #comments { max-height: 62vh; width: auto; }
        #title { margin-bottom: 2px; }
        #postTitle { margin-left: 0px; }
        #postText { margin-left: 0px; }
        #postAuthor { margin-left: 0px; }
        #formPostComment { width: 100%; }
        #buttonPostComment { width: 100%; }
        #categoryTitle { margin: 0px; text-align: center; }
        #buttonCreatePost { width: -webkit-fill-available; margin-top: -5px; }
        #formCreatePost { width: auto; }
        #posts { max-height: 76vh; }
        #formCreatePostTitle { width: calc(100% - 20px); margin: 0px 0px 0px -1px; }

        .post 
        { 
            width: auto; 
            white-space: nowrap; 
            overflow-x: auto; 
            color: white; 
            border-bottom: 1px solid #ffffff33; 
            background-color: black; 
        }
    }
</style>