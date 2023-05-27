<!-- categories.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- meta -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- page title -->
    <title>Categories</title>
    
    <!-- imports -->
    <link rel="shortcut icon" href="/public/icon.ico" type="image/x-icon">
    <?php include "include-db.php" ?>
    <?php include "include-sidebar.php" ?>
    <?php include "include-backbutton.php" ?>

    <!-- get categories data from db -->
    <?php
        //sql query   
        $query = "SELECT * FROM categories";

        //run sql query
        $qLoadAllCategories = mysqli_query($db_connection, $query);
        $qLength = mysqli_num_rows($qLoadAllCategories);
        
        //handle query errors
        // if(!$qLoadAllCategories) { die("database error" . mysqli_error($db_connection)); }
    ?>
</head>


<body onload="selectedCategory('categories')">
    <div id="main">
        <!-- title -->
        <h3 id="title">Categories</h3>

        <!-- categories -->
        <div id="categories">
            <?php
                $counter = 0;
                
                //sort categories from db
                while($row = mysqli_fetch_assoc($qLoadAllCategories))
                {
                    $counter++;
                    
                    $category_title = $row['category_title'];
                    
                    echo "<a href='/category?category=$category_title'><div class='category'> $category_title</div></a>";
                    // echo "<a href='/category?category=$category_title'><div id='sidebar-category#' class='sidebar-button'> · $category_title</div></a>";
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
    /* ::-webkit-scrollbar { height: 10px; width: 3px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { background: gray; } */
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
        margin: 4px 0px 0px -4px;
        width: calc(34vw + 10px); /* calc(31vw + 4px) */
        vertical-align: top;
        user-select: none;
    }
    #title { display: none; margin: 0px 0px 10px -1px; font-size: 26px; text-align: center; }
    #categories { max-height: 86vh; overflow-y: auto; overflow-x: hidden; text-align: center; user-select: none; }

    /*** classes ***/
    .category
    {
        width: auto;
        padding: 22px;
        overflow-wrap: break-word;
        font-size: 18px;
        margin: auto;
        color: white;
        border-bottom: 1px solid #ffffff33;
        background-color: black;
    }

    /*** mobile ***/
    @media screen and (max-width: 1300px) {
        .post::-webkit-scrollbar { height: 0px; width: 0px; }

        body { height: 98vh; width: 89vw; border: 0px; }

        #main { max-height: 92vh; width: 100%; margin: 0px 0px 0px 1px; }
        #comments { max-height: 62vh; width: auto; }
        #title { display: none; margin-bottom: 2px; }
        #postTitle { margin-left: 0px; }
        #postText { margin-left: 0px; }
        #postAuthor { margin-left: 0px; }
        #formPostComment { width: 100%; }
        #buttonPostComment { width: 100%; }
        #categories { max-height: 88vh; margin-top: -10px; }

        .category { width: -webkit-fill-available; white-space: nowrap; overflow-x: auto; }
    }
</style>