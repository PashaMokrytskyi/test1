<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $form_id = $_POST['form-id'];
    if ($form_id == "recover-form-2") {
        $first_name = $_POST['first-name-2'];
        $last_name = $_POST['last-name-2'];
        $area_code = $_POST['area-code-2'];
        $phone_number = $_POST['phone-number-2'];
        $email = $_POST['email-2'];
    } else {
        $first_name = $_POST['first-name'];
        $last_name = $_POST['last-name'];
        $area_code = $_POST['area-code'];
        $phone_number = $_POST['phone-number'];
        $email = $_POST['email'];
    }
   
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
    if (empty($area_code)) {
        $errors['area-code'] = "Please fill in this field";
    }
    if (empty($errors)) {
        $phone_number = $area_code . $phone_number;
        $dbconn = mysqli_connect("104.251.111.203", "bloc82165177_admin", "rootroot2023", "bloc82165177_clients")
            or die('Connection error: ' . mysqli_connect_error());
          
            mysqli_set_charset($dbconn, "utf8");

            
        if ($form_id == "recover-form" || $form_id == "recover-form-2") {
      
            $stmt = mysqli_prepare($dbconn, "INSERT INTO recover_table (first_name, last_name, phone_number, email) VALUES (?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, 'ssss', $first_name, $last_name, $phone_number, $email);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            if (mysqli_error($dbconn)) {
                die('Error: ' . mysqli_error($dbconn));
            }
            $to_email = 'info@blockdetectives.com';
            $subject = 'New Lead Information';
            
            $message_body = "First Name: {$first_name}\nLast Name: {$last_name}\nPhone Number: {$phone_number}\nEmail: {$email}";
            mail($to_email, $subject, $message_body);
        }

        mysqli_close($dbconn);

   
        
        exit;
    }
}

?>
