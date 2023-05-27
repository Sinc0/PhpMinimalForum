<div id="backbutton" onclick="history.back()">
    <p>❮</p>
    <!-- <p>⇠</p> -->
    <!-- <p>←</p> -->
    <!-- <p>⇦</p> -->
    <!-- <p>↩</p> -->
    <!-- <p>➦</p> -->
    <!-- <p><</p> -->
    <!-- <p>➤</p> -->
</div>

<style>
    /*** ids ***/
    #backbutton
    {
        position: fixed;
        display: block;
        bottom: 22px;
        right: 27vw;
        font-size: 40px;
        font-weight: bold;
        text-shadow: 1px 1px black;
        user-select: none;
        opacity: 0.4;
        z-index: 1;
        color: white;
    }
    #backbutton:active { opacity: 1; }

    /*** mobile ***/
    @media screen and (max-width: 1300px) {
        #backbutton { display: block; bottom: 14px; right: 16px; }
    }
</style>