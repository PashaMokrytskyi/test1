<?php
session_start();
$dbconn = pg_connect("host=localhost port=5432 dbname=web user=postgres password=rootroot");

if (!$dbconn) {
    die("Connection failed");
}


if (isset($_POST['username']) && isset($_POST['password'])) {
 
    $username = $_POST['username'];
    $password = $_POST['password'];


    $result = pg_query_params($dbconn, 'SELECT * FROM users WHERE username = $1', array($username));

    if ($result && pg_num_rows($result) > 0) {

        $user = pg_fetch_assoc($result);

   
        if (password_verify($password, $user['password'])) {
  
            session_start();
            $_SESSION['authenticated'] = true;

            header('Location: db.php');
            exit;
        } else {
       
            $error = 'Invalid username or password';
        }
    } else {
    
        $error = 'Invalid username or password';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>

    <?php if (isset($error)): ?>
        <p><?= $error ?></p>
    <?php endif; ?>

    <form method="post">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br>

        <input type="submit" value="Login">
    </form>
</body>
</html>
