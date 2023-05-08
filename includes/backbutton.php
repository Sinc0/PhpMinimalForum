<div id="backbutton" onclick="window.history.back()">
    <p>➦</p>
    <!-- <p><</p> -->
    <!-- <p>➤</p> -->
</div>

<style>
    /*** ids ***/
    #backbutton
    {
        display: none;
        position: fixed;
        bottom: 4px;
        right: calc(22vw - 12px);
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