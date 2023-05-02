<div id="sidebar">
    <!-- start session -->
    <?php session_start() ?>

    <!-- null check -->
    <?php
        if($_SESSION['username'] == null) { header('Location: /index.php'); }
    ?>

    <!-- get categories data from db -->
    <?php   
        //sql query
        $query = "SELECT * FROM categories";

        //run query
        $qLoadAllCategories = mysqli_query($db_connection, $query);
        $qLength = mysqli_num_rows($qLoadAllCategories);

        //handle query errors
        if(!$qLoadAllCategories) { die("database error" . mysqli_error($db_connection)); }
    ?>
    
    <!-- links -->
    <a href="/posts.php"><div id="sidebar-home" class="sidebar-button">Posts</div></a>
    <a href="/categories.php"><div id="sidebar-home" class="sidebar-button">Categories</div></a>
    <a href="/account.php"><div id="sidebar-home" class="sidebar-button">Account</div></a>
    <a href="/about.php"><div id="sidebar-home" class="sidebar-button">About</div></a>
    <div id="sidebar-filler" class="sidebar-button">&#8192</div>
    <a href="/logout.php"><div id="sidebar-logout" class="sidebar-button">Logout</div></a>
    <!-- <a href="/logout.php"><div id="sidebar-logout" class="sidebar-button">Logout <?php echo $_SESSION['username'] ?> </div></a> -->
</div>

<style>
    /*** scrollbar ***/
    ::-webkit-scrollbar { height: 0px; width: 0px; }

    /*** ids ***/
    #sidebar-logout { /* background-color: red; */ }
    #sidebar
    {
        position: block;
        display: inline-block;
        height: auto;
        width: auto;
        top: 0;
        left: 0;
        margin: 10px calc(8vw + 6px) 20px 30px;
        overflow-y: scroll;
        overflow-x: hidden;
        white-space: nowrap;
        background-color: black;
        /* border: 1px solid white; */
    }

    /*** classes ***/
    .sidebar-button
    {
        width: auto;
        margin: 14px 0px 0px 0px;
        padding: 0px;
        font-size: 18px;
        color: white;
        user-select: none;
        overflow-x: auto;
        /* background-color: black; */
    }
    .sidebar-button:hover { color: rgb(243, 243, 0); /* color: rgb(0, 247, 0); */ }
</style>