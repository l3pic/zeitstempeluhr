<?php
    $servername = "localhost";
    $username = "pi";
    $password = "asperin";
    $dbname = "zeitstempeluhr";

    $operation = $_POST['operation'];
    

    //Connect to DB
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection to DB failed: " . $conn->connect_error);
    }

    if($operation == "insert") {
        $datetime = $_POST['datetime'];
        $nfc_uid = $_POST['nfc_uid'];
        $nfc_tag = $_POST['nfc_tag'];
        $int_datetime = $_POST['int_datetime'];
        $sql = "INSERT INTO zeiten (datetime, nfc_uid, nfc_tag, int_datetime) VALUES ('$datetime', $nfc_uid, '$nfc_tag', $int_datetime)";
        if ($conn->query($sql) === TRUE) {
            $success = TRUE;
        } else {
            $success = FALSE;
        }
        $return = array('success' => $success, 'sql_error' => $conn->error,);
    } else if($operation == "get") {
        $sql = "SELECT * FROM user";

        $result = $conn->query($sql);

        $return = array();

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $return[$row['id']] = array('id' => $row['id'], 'username' => $row['username'], 'nfc_uid' => $row['nfc_uid']);
            }
        }

    }
    $conn->close();
    echo json_encode($return); 
?>