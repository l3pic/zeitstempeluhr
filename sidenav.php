<?php
    if (session_status() !== PHP_SESSION_ACTIVE) session_start();
    echo ("
        <div class='sidenav'>
            <a href='/zeiten/zeiten.php' id='zeiten'>Zeiten</a>
    ");
    if ($_SESSION["sec_lvl"] == 0) {
        echo ("
            <a href='/user/user.php' id='user'>Nutzerverwaltung</a>
            <a href='/docs.php' id='docs'>Zeitprotokolle</a>
        ");
    }
    echo (" <a href='/logout.php' id='logout_btn'>Abmelden</a> ");
    echo (
            "<div class='user-info'>
                <span class='user-info-h'>Nutzername: </span>
                <span class='user-info-t' id='username'>" . $_SESSION["username"] . "</span>
                <span class='user-info-h'>NFC-UID: </span>
                <span class='user-info-t' id='nfc_uid'>" . $_SESSION["nfc_uid"] . "</span>
            </div>
            <script src='/sidenav.js'></script>
        </div>
    "); 
?>