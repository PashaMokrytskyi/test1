<?php
session_start();
$dbconn = mysqli_connect("104.251.111.203", "bloc82165177_admin", "rootroot2023", "bloc82165177_clients");


if (!$dbconn) {
    die("Connection failed: " . mysqli_connect_error());
}


if (isset($_POST['username']) && isset($_POST['password'])) {
 
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Создаем подготовленное выражение
    $stmt = mysqli_prepare($dbconn, 'SELECT * FROM users WHERE username=?');
    
    // Привязываем параметры
    mysqli_stmt_bind_param($stmt,'s',$username);
    
    // Выполняем запрос
    mysqli_stmt_execute($stmt);
    
    // Получаем результаты
    $result=mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {

        // Извлекаем данные пользователя
        $user = mysqli_fetch_assoc($result);

   
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
        <p><?= htmlspecialchars($error) ?></p>
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
