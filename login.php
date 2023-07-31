<?php
    $username_post = str_replace(array("*", ";", "'"), '', filter_var($_POST["username"], FILTER_SANITIZE_STRING));
    $passwd = str_replace(array("*", ";", "'"), '', filter_var($_POST["passwd"], FILTER_SANITIZE_STRING));

    $servername = "localhost";
    $username = "pi";
    $password = "asperin";
    $dbname = "zeitstempeluhr";

    //Connect to DB
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection to DB failed: " . $conn->connect_error);
    }

    $sql = "SELECT passwd, sec_lvl, nfc_uid FROM user WHERE username = '$username_post'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            if ($passwd != $row["passwd"]) {
                echo("Falsches Passwort!");
            } else {
                session_start();
                $_SESSION["logged_in"] = true;
                $_SESSION["username"] = $username_post;
                $_SESSION["sec_lvl"] = $row["sec_lvl"];
                $_SESSION["nfc_uid"] = $row["nfc_uid"];
            }
        }
    } else {
        echo("Falscher Username!");
    }

    $conn->close();

    if ($_SESSION["logged_in"] == true) header("Location: ./zeiten/zeiten.php");
?>