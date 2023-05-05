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

        <!-- info -->
        <div id="about" class="menuCategory">
            <p id="aboutText">This is a student project, made to learn about PHP</p>
        </div>

        <!-- privacy policy -->
        <h3 id="privacyPolicyTitle" class="menuCategoryTitle">Privacy Policy</h3>
        <div id="privacyPolicy" class="menuCategory">
            <p class="privacyPolicyItem">Collects Account Data: <span class="yes">Yes</span></p>
            <p class="privacyPolicyItem">Collects Personal Data: <span class="no">No</span></p>
            <p class="privacyPolicyItem">Collects Device Data: <span class="no">No</span></p>
            <p class="privacyPolicyItem">Collects Metrics Data: <span class="no">No</span></p>
            <p class="privacyPolicyItem">Collects Diagnostics Data: <span class="no">No</span></p>
            <p class="privacyPolicyItem">Collects Location Data: <span class="no">No</span></p>
            <p class="privacyPolicyItem">Collects Financial Data: <span class="no">No</span></p>
            <p class="privacyPolicyItem">Collects Messages Data: <span class="no">No</span></p>
            <p class="privacyPolicyItem">Collects Media Data: <span class="no">No</span></p>
            <p class="privacyPolicyItem">Uses Cookies: <span class="yes">Yes</span></p>
            <p class="privacyPolicyItem">Uses Local Storage: <span class="no">No</span></p>
            <p class="privacyPolicyItem">Links to Other Websites: <span class="no">No</span></p>
            <p class="privacyPolicyItem">Policy Might Change in the Future: <span class="yes">Yes</span></p>
        </div>

        <!-- contact -->
        <h3 id="contactTitle" class="menuCategoryTitle">Contact</h3>
        <div id="contact">
            <a href="mailto:sinco.developer@gmail.com" id="contactText">sinco.developer@gmail.com</a>
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
    #aboutText { margin: -10px 0px 0px 0px; text-align: center; }
    #contactText { text-align: center; font-weight: normal; color: white; }
    #contact { text-align: center; }
    #about { text-align: center; }

    /*** classes ***/
    .yes { color: lightgreen; }
    .no { color: red; }
    .privacyPolicyItem { margin: 0px; padding: 3px 0px 0px 0px; font-weight: normal; text-align: center; color: white; }
    .menuCategoryTitle { width: 100%; margin: auto; margin-top: 40px; padding: 0px; text-align: center; font-weight: bold; }
</style>