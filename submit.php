<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $form_id = $_POST['form-id'];
    $first_name = $_POST['first-name'];
    $last_name = $_POST['last-name'];
    $phone_number = $_POST['phone-number'];
    $email = $_POST['email'];

    $errors = array();
    if (empty($first_name)) {
        $errors['first-name'] = "Please fill in this field";
    }
    if (empty($last_name)) {
        $errors['last-name'] = "Please fill in this field";
    }
    if (empty($phone_number)) {
        $errors['phone-number'] = "Please fill in this field";
    }
    if (empty($email)) {
        $errors['email'] = "Please fill in this field";
    }

    if ($form_id == "survey-form") {
        $amount = $_POST['amount'];
        $platform = $_POST['platform'];
        $details = $_POST['details'];

        if (empty($amount)) {
            $errors['amount'] = "Please fill in this field";
        }
        if (empty($platform)) {
            $errors['platform'] = "Please fill in this field";
        }
        if (empty($details)) {
            $errors['details'] = "Please fill in this field";
        }
    }

    if (empty($errors)) {

        $dbconn = pg_connect("host=localhost port=5432 dbname=web user=postgres password=rootroot")
            or die('Connection error: ' . pg_last_error());
            if (!$dbconn) {
                die("Connection error: " . pg_last_error());
            }
            
        if ($form_id == "recover-form") {
      
            $query = "INSERT INTO recover_table (first_name, last_name, phone_number, email) VALUES ($1, $2, $3, $4)";
            $result = pg_query_params($dbconn, $query, array($first_name, $last_name, $phone_number, $email))
                or die('Request error: ' . pg_last_error());
        } else {
      
            if ($form_id == "survey-form") {
            
                $query = "INSERT INTO survey (first_name, last_name, phone_number, email, amount, platform, details) VALUES ($1, $2, $3, $4, $5, $6, $7)";
                $result = pg_query_params($dbconn, $query, array($first_name, $last_name, $phone_number, $email, $amount, $platform, $details))
                    or die('Request error: ' . pg_last_error());
            }
            
        }

        pg_close($dbconn);

   
        header("Location: success.html");
        exit;
    }
}

?>
