<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="./styles.css">

<?php include "includes/DbConnection.php" ?>
    
<?php include "includes/sidebar.php" ?>

</head>

<body>
<div id="main">
    <h3 id="welcomeMessage"> Hi <?php echo $_SESSION['username'] ?></h3>
    <p id="welcomeText">Welcome to minimal PHP Forum, categories are listed on the sidebar.</p>
</div>
</body>
</html>