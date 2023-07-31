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
    <script src='../functions.js' defer></script>
    <script src='./edit_entry.js' defer></script>
    <script src='./add_entry.js' defer></script> 
</head>
<body>
    <?php include '../sidenav.php'; ?>

    <div class="topper">
        <form action="zeiten.php" method="GET" class="topper-zeiten">
            <button class="btn" id="clear_datefilters">Zeitfilter entfernen</button>
            <div class="zeitraum">
                <span>VON:</span>
                <input type="date" name="from" id="date_form_1">
            </div>
            <div class="zeitraum">
                <span>BIS:</span>
                <input type="date" name="to" id="date_form_2">
            </div>
            <input type="submit" value="Daten abrufen" />
        </form>
        <?php
            if (session_status() !== PHP_SESSION_ACTIVE) session_start();
            if ($_SESSION["sec_lvl"] == 0) {
                echo ("
                <div class='topper-editmode'>
                    <span>BEARBEITEN:</span>
                    <label class='switch'>
                        <input type='checkbox' id='btn_editmode'>
                        <span class='slider round'></span>
                    </label>
                </div>

                <div class='topper-add'>
                    <span>HINZUFÜGEN:</span>
                    <button class='btn-add' id='btn_add'><i class='fa-solid fa-plus'></i></button>
                </div>
                <script src='../toggle_edit.js'></script>
                ");
            }
            
        ?>
    </div>

    <div class="main">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Zeit</th>
                    <th>NFC-UID</th>
                    <th class="tb-edit hide"></th>
                    <th class="tb-del hide"></th>
                </tr>
            </thead>
            <?php
                if (session_status() !== PHP_SESSION_ACTIVE) session_start();

                if ($_SESSION["logged_in"] != true) header("Location: ./index.php");

                if (array_key_exists('from', $_GET) && array_key_exists('to', $_GET)) {
                    $start = (int)(str_replace("-", "", $_GET['from']) . "0000");
                    $end = (int)(str_replace("-", "", $_GET['to']) . "2359");
                    echo ("
                        <script>
                            let date_1 = '" . $_GET['from'] . "';
                            let date_2 = '" . $_GET['to'] . "';

                            document.getElementById('date_form_1').value = date_1;
                            document.getElementById('date_form_2').value = date_2;
                        </script>
                    ");
                }

                $servername = "localhost";
                $username = "pi";
                $password = "asperin";
                $dbname = "zeitstempeluhr";

                //Connect to DB
                $conn = new mysqli($servername, $username, $password, $dbname);
                if ($conn->connect_error) {
                    die("Connection to DB failed: " . $conn->connect_error);
                }

                if (isset($start) && isset($end) && $start != 0 && $end != 0) {
                    if ($_SESSION["sec_lvl"] == 0) {
                        $sql = "SELECT * FROM zeiten WHERE int_datetime >= $start AND int_datetime <= $end ORDER BY int_datetime";
                    } else {
                        $sql = "SELECT * FROM zeiten WHERE int_datetime >= $start AND int_datetime <= $end AND nfc_uid = " . $_SESSION['nfc_uid'] . " ORDER BY int_datetime";
                    }
                } else {
                    if ($_SESSION["sec_lvl"] == 0) {
                        $sql = "SELECT * FROM zeiten ORDER BY int_datetime";
                    } else {
                        $sql = "SELECT * FROM zeiten WHERE nfc_uid = " . $_SESSION['nfc_uid'] . " ORDER BY int_datetime";
                    }
                }

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo ("
                            <tr>
                                <td class='tb-name'>" . $row["nfc_tag"] . "</td>
                                <td class='tb-datetime'>" . $row["datetime"] . "</td>
                                <td class='tb-nfc-uid'>" . $row["nfc_uid"] . "</td>
                                <td class='tb-edit hide' id='" . $row["id"] . "'><img src='../images/edit.png' class='tb-btn-edit' /></td>
                                <td class='tb-del hide' id='" . $row["id"] . "'><img src='../images/del.png' class='tb-btn-edit' /></td>
                            </tr>
                        ");
                    }
                } else {
                    echo ("<tr><td colspan='3'>No Results found</td></tr>");
                }
                $conn->close();
            ?>
        </table>
    </div>

    <div class="backdrop hide" id="backdrop"></div>

    <div class="edit-form hide" id="edit_form">
        <input type="text" id="edit_name" placeholder="Name"></input>
        <input type="datetime-local" id="edit_date"></input>
        <input type="text" disabled placeholder="formatiertes Datum" id="formatted_date"></input>
        <input type="text" id="edit_nfc_uid" placeholder="NFC-UID"></input>
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