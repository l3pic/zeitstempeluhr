<?php
    $nfc_uid = $_POST['nfc_uid'];
    $from = $_POST['from'];
    $to = $_POST['to'];
    $str_from = $_POST['str_from'];
    $str_to = $_POST['str_to'];
    try {
        $return = exec("python3 /var/py/create_excel.py $nfc_uid $from $to $str_from $str_to");
        echo json_encode($return);
    }catch (Exception $e) {
        echo json_encode("Fehler" . $e->getMessage());
    }
    //$return = exec("python3 /var/py/test.py");
    //$return = array($nfc_uid, $from, $to, $str_from, $str_to);
    
?>