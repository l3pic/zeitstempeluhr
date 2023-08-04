<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arbeitszeiten</title>
    <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Chakra+Petch&family=Kanit&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
    <script src="https://kit.fontawesome.com/d2f6aa7ce4.js" crossorigin="anonymous"></script>
    <script src="http://192.168.0.103/scripts/jquery-3.7.0.min.js"></script>
    <script src='/functions.js' defer></script>
    <script src="/docs.js" defer></script>
</head>
<body>
    <?php include './sidenav.php'; ?>
    <div class="topper-docs">
        <select name="user" id="select_user">

        </select>
        <input class="zeitraum" type="date" name="from" id="from">
        <input class="zeitraum" type="date" name="to" id="to">
        <button class="btn" id="create_file">Excel Datei erstellen</button>
    </div>
    
    <?php 
        $directory = opendir("./excel/");

        while($entryName = readdir($directory)) {
            $dirArray[] = $entryName;
        }

        $dirArray = json_encode($dirArray);

        echo ("<script>console.log($dirArray)</script>");
    ?>
    <div class="backdrop hide" id="backdrop"></div>
    <div class="confirm-alert hide" id="confirm_alert">
        <span class="confirm-alert-text" id="confirm_alert_text">bliblablullals</span>
        <div>
            <button id="alert_submit" class="alert-btn">Senden</button>
            <button id="alert_cancel" class="alert-btn">Abbrechen</button>
        </div>
    </div>
    <div class="notification-alert hide" id="notification_alert">
        <span class="notification-title" id="notification_title"></span>
        <span class="notification-text" id="notification_text"></span>
        <progress max="100" value="50" id="notification_alert_pbar"></progress>
    </div>
</body>
</html>