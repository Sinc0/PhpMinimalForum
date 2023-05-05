<!-- posts.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts</title>
    
    <!-- imports -->
    <link rel="stylesheet" href="./styles.css">
    <?php include "includes/db.php" ?>
    <?php include "includes/sidebar.php" ?>

    <!-- get all posts from db -->
    <?php   
        //sql query
        $query = "SELECT * FROM posts";

        //run query
        $qLoadAllPosts = mysqli_query($db_connection, $query);
        $qLength = mysqli_num_rows($qLoadAllPosts);
        
        //handle errors
        if(!$qLoadAllPosts) { die("database error" . mysqli_error($db_connection)); }
    ?>
</head>

<body>
    <div id="main">
        <!-- title -->
        <h3 id="title">Posts</h3>

        <!-- posts -->
        <div id="posts">
        <?php
            $counter = 0;
            
            while($row = mysqli_fetch_assoc($qLoadAllPosts))
            {
                $counter++;
                
                //variables
                $post_title = $row['post_title'];
                $post_category = $row['post_category'];
                $post_id = $row['post_id'];
                $post_date = $row['post_date'];
                
                //post title
                echo "<a href='/post.php/?post=$post_id'><div class='post'>$post_title</div></a>";
                // echo "<a href='/category.php/?category=$post_title'><div id='sidebar-category#' class='sidebar-button'> · $post_title</div></a>";
            }
        ?>
        </div>
    </div>
</body>
</html>

<style>
    /*** scrollbar ***/
    ::-webkit-scrollbar { height: 10px; width: 3px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { background: gray; }
    /* ::-webkit-scrollbar-thumb:hover { background: #600; } */

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

    /*** ids ***/
    #main { position: relative; display: inline-block; height: auto; margin: 40px 0px 0px -4px; width: calc(31vw + 4px); vertical-align: top; }
    #title { margin: 0px 0px 10px -1px; font-size: 26px; text-align: center; }
    #posts { max-height: 86vh; overflow-y: auto; overflow-x: hidden; text-align: left; }

    /*** classes ***/
    .post 
    {
        width: calc(31vw - 16px);
        padding: 10px;
        overflow-wrap: break-word;
        font-size: 18px;
        border-bottom: 1px solid black;
        background-color: white;
    }

    /*** mobile ***/
    @media screen and (max-width: 1300px) {
        .post::-webkit-scrollbar { height: 0px; width: 0px; }

        body { height: 98vh; width: 89vw; border: 0px; }

        #main { width: 100%; margin: 0px; }
        #posts { max-height: 90vh; }
        #title { display: none; margin-bottom: 2px; }

        .post { width: auto; white-space: nowrap; overflow-x: auto; }
    }
</style>