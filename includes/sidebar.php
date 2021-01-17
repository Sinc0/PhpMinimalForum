<?php session_start() ?>

<?php
    if($_SESSION['username'] == null)
    {
        header('Location: /phpForum/index.php');
    }
?>

<?php   
    $query = "SELECT * FROM categories";
    $qLoadAllCategories = mysqli_query($db_connection, $query);
    $qLength = mysqli_num_rows($qLoadAllCategories);
    
    if(!$qLoadAllCategories)
    {
        die("database error" . mysqli_error($db_connection));
    }
?>

<div id="sidebar">
    <a href="/phpForum/logout.php"><div id="sidebar-logout" class="sidebar-button">Logout <?php echo $_SESSION['username'] ?> </div></a>
    <div id="sidebar-filler" class="sidebar-button">&#8192</div>
    <a href="/phpForum/home.php"><div id="sidebar-home" class="sidebar-button">Home</div></a>
    <div id="sidebar-filler" class="sidebar-button">&#8192</div>
    <!-- <div id="sidebar-filler" class="sidebar-button"><b>Categories</b></div> -->
    
    <?php
        $counter = 0;

        while($row = mysqli_fetch_assoc($qLoadAllCategories))
        {
            $counter++;

            $category_title = $row['category_title'];

            echo "<a href='/phpForum/category.php/?category=$category_title'><div id='sidebar-category#' class='sidebar-button'>$category_title</div></a>";
        }
    ?>

</div>