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
    <script src="https://kit.fontawesome.com/d2f6aa7ce4.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../style.css">
    <script src="http://192.168.0.103/scripts/jquery-3.7.0.min.js"></script>
    <script src="../functions.js" defer></script>
    <script src="./toggle_switches.js" defer></script>
    <script src="./edit_entry.js" defer></script>
    <script src="./add_entry.js" defer></script>
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

    <div class="topper">
        <div class='topper-editmode'>
            <span>BEARBEITEN:</span>
            <label class='switch'>
                <input type='checkbox' id='btn_editmode'>
                <span class='slider round'></span>
            </label>
        </div>
    </div>

    <div class="main">
        <table>
            <thead>
                <tr>
                    <th>Nutzername</th>
                    <th>Security Level</th>
                    <th>NFC-UID</th>
                    <th>Passwort</th>
                    <th class="tb-edit hide"></th>
                </tr>
            </thead>
            <?php
                $servername = "localhost";
                $username = "pi";
                $password = "asperin";
                $dbname = "zeitstempeluhr";

                //Connect to DB
                $conn = new mysqli($servername, $username, $password, $dbname);
                if ($conn->connect_error) {
                    die("Connection to DB failed: " . $conn->connect_error);
                }

                $sql = "SELECT * FROM user";

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo ("
                            <tr>
                                <td class='tb-username'>" . $row["username"] . "</td>
                                <td class='tb-sec-lvl'>" . $row["sec_lvl"] . "</td>
                                <td class='tb-nfc-uid'>" . $row["nfc_uid"] . "</td>
                                <td class='tb-passwd blur-text'>" . $row["passwd"] . "</td>
                                <td class='tb-edit hide' id='" . $row["id"] . "'><img src='../images/edit.png' class='tb-btn-edit' /></td>
                            </tr>
                        ");
                    }
                } else {
                    echo ("<tr><td colspan='4'>No Results found</td></tr>");
                }
                $conn->close();
            ?>
        </table>
    </div>

    <div class="backdrop hide" id="backdrop"></div>

    <div class="edit-form hide" id="edit_form">
        <input type="text" id="edit_username" placeholder="Name"></input>
        <input type="number" id="edit_sec_lvl"></input>
        <input type="text" id="edit_nfc_uid"></input>
        <input type="text" id="edit_passwd"></input>
        <button id="edit_submit_btn">Ändern</button>
    </div>

    <div class="add-form hide" id="add_form">
        <select name="user" id="select_user"></select>
        <input type="datetime-local" id="add_date"></input>
        <input type="text" disabled placeholder="formatiertes Datum" id="formatted_add_date"></input>
        <input type="text" disabled placeholder="NFC-UID" id="add_nfc_uid"></input>
        <button id="add_submit_btn">Erstellen</button>
    </div>

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