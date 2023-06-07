<!-- about.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- meta -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- page title -->
    <title>About</title>

    <!-- imports -->
    <link rel="shortcut icon" href="/public/icon.ico" type="image/x-icon">
    <?php include "include-backbutton.php" ?>
</head>

<body>
    <div id="main">
        <!-- title -->
        <h3 id="title">About</h3>

        <!-- info -->
        <h3 id="whyTitle" class="menuCategoryTitle">Why</h3>
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
            <p class="privacyPolicyItem">Collects Messages Data: <span class="yes">Yes</span></p>
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
        width: 100vw; 
        margin: auto;
        padding: 0px; 
        font-family: Arial, Helvetica, sans-serif;
        color: white;
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
        width: 100%;
        margin: auto;
        vertical-align: top;
        user-select: none;
        -webkit-user-select: none;
    }
    #title { display: none; margin: 0px 0px 10px -1px; font-size: 26px; text-align: center; }
    #aboutText { margin: -2px 0px 0px 0px; text-align: center; }
    #contactText { text-align: center; font-weight: normal; color: white; }
    #contact { text-align: center; }
    #about { text-align: center; }
    #whyTitle { margin-top: 60px; }
    #backbutton { display: none; } 

    /*** classes ***/
    .yes { color: lightgreen; }
    .no { color: red; }
    .privacyPolicyItem { margin: 0px; padding: 3px 0px 0px 0px; font-weight: normal; text-align: center; color: white; }
    .menuCategoryTitle { width: 100%; margin: auto; margin-top: 40px; padding: 0px; text-align: center; font-weight: bold; }

    /*** mobile ***/
    @media screen and (max-width: 1300px) {
        .post::-webkit-scrollbar { height: 0px; width: 0px; }

        body { height: 98vh; width: 89vw; border: 0px; overflow-y: hidden; overflow-x: hidden; }
        input { width: 317px; }

        #main { max-height: 90vh; width: 100%; margin: 0px; text-align: left; overflow-x: hidden; }
        #comments { max-height: 62vh; width: auto; }
        #title { display: none; margin-bottom: 2px; }
        #postTitle { margin-left: 0px; }
        #postText { margin-left: 0px; }
        #postAuthor { margin-left: 0px; }
        #formPostComment { width: 100%; }
        #buttonPostComment { width: 100%; }
        #categoryTitle { text-align: center; }
        #aboutText { width: 80%; margin: auto; margin-top: -2px; }
        #backbutton { display: block; }

        .post { width: auto; white-space: nowrap; overflow-x: auto; }
        .sectionTitle { width: auto; }
        .privacyPolicyItem { padding: 0px 0px 3px 0px; }
    }
</style>