<!-- home.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About</title>

    <!-- imports -->
    <link rel="stylesheet" href="./styles.css">
    <?php include "includes/db.php" ?>
    <?php include "includes/sidebar.php" ?>
</head>

<body>
    <div id="main">
        <!-- title -->
        <h3 id="title">About</h3>

        <!-- categories -->
        <p>#1</p>
        <p>#2</p>
        <p>#3</p>
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
</style>