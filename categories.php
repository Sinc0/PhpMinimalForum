<!-- home.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories</title>
    
    <!-- imports -->
    <link rel="stylesheet" href="./styles.css">
    <?php include "includes/db.php" ?>
    <?php include "includes/sidebar.php" ?>

    <!-- get categories data from db -->
    <?php
        //sql query   
        $query = "SELECT * FROM categories";

        //run sql query
        $qLoadAllCategories = mysqli_query($db_connection, $query);
        $qLength = mysqli_num_rows($qLoadAllCategories);
        
        //handle query errors
        if(!$qLoadAllCategories) { die("database error" . mysqli_error($db_connection)); }
    ?>
</head>

<body>
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
                    
                    // echo "<a href='/category.php/?category=$category_title'><div id='sidebar-category#' class='sidebar-button'> · $category_title</div></a>";
                    echo "<a href='/category.php/?category=$category_title'><div class='category'> $category_title</div></a>";
                }
            ?>
        </div>
    </div>
</body>
</html>

<style>
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
    #main
    {
        position: relative;
        display: inline-block;
        height: auto;
        margin: 40px 0px 0px -4px;
        width: calc(31vw + 4px);
        vertical-align: top;
    }
    #title { margin: 0px 0px 10px -1px; font-size: 26px; text-align: center; }
    #categories { text-align: center; }

    .category
    {
        width: 20vw;
        padding: 10px;
        overflow-wrap: break-word;
        font-size: 18px;
        margin: auto;
        border-bottom: 1px solid black;
        background-color: white;
    }
</style>