<?php
    $entry_id = $_POST["id"];
    $operation = $_POST["operation"];

    $servername = "localhost";
    $username = "pi";
    $password = "asperin";
    $dbname = "zeitstempeluhr";

    //Connect to DB
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection to DB failed: " . $conn->connect_error);
    }

    if ($operation == "del") {
        $sql = "DELETE FROM zeiten WHERE id = $entry_id";

        if ($conn->query($sql) === TRUE) {
            $success = TRUE;
        } else {
            $success = FALSE;
        }
    } else if ($operation == "edit") {
        $datetime = $_POST['datetime'];
        $nfc_uid = $_POST['nfc_uid'];
        $nfc_tag = $_POST['nfc_tag'];
        $int_datetime = $_POST['int_datetime'];
        
        $sql = "UPDATE zeiten SET datetime = '$datetime', nfc_uid = $nfc_uid, nfc_tag = '$nfc_tag', int_datetime = $int_datetime WHERE id = $entry_id";
        
        if ($conn->query($sql) === TRUE) {
            $success = TRUE;
        } else {
            $success = FALSE;
        }
    }

    $result = array('success' => $success, 'sql_error' => $conn->error,);

    $conn->close();
    echo json_encode($result); 
?>