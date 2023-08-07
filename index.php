<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Chakra+Petch&family=Kanit&display=swap" rel="stylesheet">
    <script src="./clock.js" defer></script>
</head>
<body>
    <div class="notification-alert hide" id="notification_alert">
        <span class="notification-title" id="notification_title"></span>
        <span class="notification-text" id="notification_text"></span>
        <progress max="100" value="50" id="notification_alert_pbar"></progress>
    </div>
    <?php
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();

        if (array_key_exists("logged_in", $_SESSION)) {
            if ($_SESSION["logged_in"] === true) {
                header("Location: ./zeiten/zeiten.php");
            } else if ($_SESSION["logged_in"] == false && array_key_exists("login_error", $_SESSION)) {
                echo ("<script src='./functions.js'></script><script defer>notificationAlert('Fehler', '" . $_SESSION["login_error"] . "', 5);</script>");
                session_destroy();
            }
        }
    ?>
    <div class="main-login">
        <div id="clockDisplay" class="time" onload="showTime();"></div>
        <div id="dateDisplay" class="date" onload="showDate();"></div>

        <form action="login.php" method="post" class="login-form">
            <input type="text" name="username" placeholder="Nutzername" autocomplete="off">
            <input type="password" name="passwd" placeholder="Passwort" autocomplete="off">
            <input type="submit" value="Anmelden">
        </form>
    </div>
</body>
</html>