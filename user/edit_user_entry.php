<?php
    $entry_id = $_POST["id"];

    $servername = "localhost";
    $username = "pi";
    $password = "asperin";
    $dbname = "zeitstempeluhr";

    //Connect to DB
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection to DB failed: " . $conn->connect_error);
    }

    $user_name = $_POST['username'];
    $sec_lvl = $_POST['sec_lvl'];
    $nfc_uid = $_POST['nfc_uid'];
    $passwd = $_POST['passwd'];

    $sql = "UPDATE user SET username = '$user_name', sec_lvl = $sec_lvl, nfc_uid = $nfc_uid, passwd = '$passwd' WHERE id = $entry_id";

    if ($conn->query($sql) === TRUE) {
        $success = TRUE;
    } else {
        $success = FALSE;
    }

    $result = array('success' => $success, 'sql_error' => $conn->error,);

    $conn->close();
    echo json_encode($result); 
?>