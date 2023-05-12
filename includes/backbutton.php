<div id="backbutton" onclick="window.history.back()">
    <p>➦</p>
    <!-- <p><</p> -->
    <!-- <p>➤</p> -->
</div>

<style>
    /*** ids ***/
    #backbutton
    {
        display: block;
        position: fixed;
        bottom: 4px;
        right: 27vw;
        font-size: 40px;
        font-weight: bold;
        text-shadow: 1px 1px black;
        rotate: 180deg;
        cursor: default;
        z-index: 1;
        color: white;
    }

    /*** mobile ***/
    @media screen and (max-width: 1300px) {
        #backbutton { display: block; right: 16px; }
    }
</style>