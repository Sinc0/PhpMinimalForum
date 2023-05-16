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
    <a href="/posts.php" onclick="test()">
        <div id="sidebar-posts" class="sidebar-button">Posts</div>
    </a>
    
    <span class="mobile-sidebar-filler"> · </span>
    
    <a href="/categories.php">
        <div id="sidebar-categories" class="sidebar-button">Categories</div>
    </a>
    
    <span class="mobile-sidebar-filler"> · </span>
    
    <a href="/account.php">
        <div id="sidebar-account" class="sidebar-button">Account</div>
    </a>

    <span class="mobile-sidebar-filler"> · </span>
    
    <a href="/about.php">
        <div id="sidebar-about" class="sidebar-button">About</div>
    </a>
    
    <span class="mobile-sidebar-filler"> · </span>
    <div id="sidebar-filler" class="sidebar-button">&#8192</div>
    
    <a href="/logout.php">
        <div id="sidebar-logout" class="sidebar-button">Logout</div>
    </a>
    <!-- <a href="/logout.php"><div id="sidebar-logout" class="sidebar-button">Logout <?php echo $_SESSION['username'] ?> </div></a> -->
</div>

<style>
    /*** scrollbar ***/
    ::-webkit-scrollbar { height: 0px; width: 0px; }

    /*** ids ***/
    #sidebar-logout { opacity: 0.4; }
    #sidebar-logout:active { opacity: 1; }
    #sidebar
    {
        position: block;
        display: inline-block;
        height: auto;
        width: auto;
        top: 0;
        left: 0;
        margin: 10px calc(2vw + 14px) 20px calc(2vw + 10px);
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
        font-size: 20px;
        color: white;
        user-select: none;
        overflow-x: auto;
        /* background-color: black; */
    }
    .mobile-sidebar-filler { display: none; }


    /*** mobile ***/
    @media screen and (max-width: 1300px) {
        #sidebar::-webkit-scrollbar { height: 0px; width: 0px; }

        #sidebar 
        { 
            display: flex; 
            flex-direction: row; 
            width: 100%; 
            margin: 0px; 
            padding: 10px 0px 9px 0px; 
            overflow-y: hidden; 
            overflow-x: auto; 
        }
        #sidebar-filler { display: none; }

        .sidebar-button { display: block; margin: 0px; opacity: 0.4; }
        .mobile-sidebar-filler { display: block; margin: 3px 6px 0px 6px; font-weight: bold; opacity: 0.4; color: white; }
    }
</style>