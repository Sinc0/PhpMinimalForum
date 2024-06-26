<!-- posts.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- meta -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- page title -->
    <title>Posts</title>
    
    <!-- imports -->
    <link rel="shortcut icon" href="/public/icon.ico" type="image/x-icon">
    <link rel="manifest" href="/public/pwa/manifest.json">
    <script src="/service-worker.js"></script>
    <?php include "include-db.php" ?>
    <?php include "include-sidebar.php" ?>
    <?php include "include-backbutton.php" ?>

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


<body onload="selectedCategory('posts')">
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
                echo "<a href='/post?post=$post_id'><div class='post'>$post_title</div></a>";
                // echo "<a href='/category?category=$post_title'><div id='sidebar-category#' class='sidebar-button'> · $post_title</div></a>";
            }
        ?>
        </div>
    </div>
</body>
</html>


<script>
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
</script>


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
        width: 49vw; 
        margin: auto;
        padding: 0px; 
        font-family: Arial, Helvetica, sans-serif;
        color: white;
        border-left: 2px solid white;
        border-right: 2px solid white;
        background-color: black; 
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
        margin: 11px 0px 0px -4px; 
        width: calc(34vw + 10px); 
        vertical-align: top;
        user-select: none;
        -webkit-user-select: none;
    }
    #title { display: none; margin: 0px 0px 2px -1px; font-size: 26px; text-align: center; }
    #posts { max-height: 86vh; overflow-y: auto; overflow-x: hidden; text-align: left; user-select: none; -webkit-user-select: none; }

    /*** classes ***/
    .post 
    {
        width: auto; /* calc(31vw - 16px) */
        padding: 12px 12px 12px 0px;
        overflow-wrap: break-word;
        font-size: 18px;
        color: white;
        border-bottom: 1px solid #ffffff33;
        background-color: black;
    }

    /*** mobile ***/
    @media screen and (max-width: 1300px) {
        .post::-webkit-scrollbar { height: 0px; width: 0px; }

        body { height: 98vh; width: 89vw; border: 0px; }

        #main { width: 100%; margin: 0px 0px 0px 1px; }
        #posts { max-height: 88vh; margin-top: -8px; }
        #title { display: none; margin-bottom: 2px; }

        .post { width: auto; white-space: nowrap; overflow-x: auto; }
    }
</style>