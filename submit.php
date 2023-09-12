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

        $dbconn = mysqli_connect("104.251.111.203", "bloc82165177_admin", "rootroot2023", "bloc82165177_clients")
            or die('Connection error: ' . mysqli_connect_error());
            
        if ($form_id == "recover-form") {
      
            $stmt = mysqli_prepare($dbconn, "INSERT INTO recover_table (first_name, last_name, phone_number, email) VALUES (?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, 'ssss', $first_name, $last_name, $phone_number, $email);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            
        } else {
      
            if ($form_id == "survey-form") {
            
                $stmt = mysqli_prepare($dbconn, "INSERT INTO survey (first_name, last_name, phone_number, email, amount, platform, details) VALUES (?, ?, ?, ?, ?, ?, ?)");
                mysqli_stmt_bind_param($stmt, 'sssssss', $first_name, $last_name, $phone_number, $email, $amount, $platform, $details);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
                
            }
            
        }

        mysqli_close($dbconn);

   
        header("Location: success.html");
        exit;
    }
}

?>
