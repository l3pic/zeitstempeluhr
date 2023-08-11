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
    <script src="/scripts/jquery-3.7.0.min.js"></script>
    <script src='/functions.js' defer></script>
    <script src="./docs.js" defer></script>
</head>
<body>
    <?php 
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
        if (array_key_exists('sec_lvl', $_SESSION) && array_key_exists('logged_in', $_SESSION)) {
            if (!($_SESSION["sec_lvl"] == 0 || $_SESSION["logged_in"] == true)) {
                header("Location: /index.php");
            }
        } else {
            header("Location: /index.php");
        }
        include '../sidenav.php';
    ?>
    <div class="topper-docs">
        <select name="user" id="select_user">

        </select>
        <input class="zeitraum" type="date" name="from" id="from">
        <input class="zeitraum" type="date" name="to" id="to">
        <button class="btn" id="create_file">Excel Datei erstellen</button>
    </div>
    <div class="docstable">
        <table>
            <tr>
                <th class='filename-tb'>Dokumentname</th>
                <th>Erstellungsdatum</th>
                <th></th>
            </tr>
            <?php 
                $directory = opendir("../excel/");

                while($entryName = readdir($directory)) {
                    $dirArray[] = $entryName;
                }

                usort($dirArray, function($a, $b) {
                    return filemtime("../excel/$b") - filemtime("../excel/$a");
                });

                foreach ($dirArray as &$doc) {
                    if ($doc != ".." and $doc != ".")
                    echo ("
                        <tr>
                            <td class='filename-tb'>$doc</td>
                            <td>" . date("d. F Y H:i", filectime("../excel/$doc")) . "</td>
                            <td><a href='/excel/$doc' download><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512'><path d='M288 32c0-17.7-14.3-32-32-32s-32 14.3-32 32V274.7l-73.4-73.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l128 128c12.5 12.5 32.8 12.5 45.3 0l128-128c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L288 274.7V32zM64 352c-35.3 0-64 28.7-64 64v32c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V416c0-35.3-28.7-64-64-64H346.5l-45.3 45.3c-25 25-65.5 25-90.5 0L165.5 352H64zm368 56a24 24 0 1 1 0 48 24 24 0 1 1 0-48z'/></svg></a></td>
                        </tr>
                    ");
                    
                }
            ?>
        </table>
    </div>
    
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