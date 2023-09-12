<?php
session_start();

if (!isset($_SESSION['authenticated']) || !$_SESSION['authenticated']) {
    header('Location: login.php');
    exit;
}

$dbconn = mysqli_connect("104.251.111.203", "bloc82165177_admin", "rootroot2023", "bloc82165177_clients");


if (!$dbconn) {
    die("Connection failed: " . mysqli_connect_error());
}

$result1 = mysqli_query($dbconn, "SELECT * FROM recover_table");
if (!$result1) {
    die("An error occurred while retrieving data from recover_table: " . mysqli_error($dbconn));
}

$result2 = mysqli_query($dbconn, "SELECT * FROM survey");
if (!$result2) {
    die("An error occurred while retrieving data from survey: " . mysqli_error($dbconn));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Database Tables</title>
</head>
<body>
    <h1>Database Tables</h1>

    <h2>Recover Table</h2>
    <table border="1">
        <tr>
            <?php
                while ($fieldinfo = mysqli_fetch_field($result1)) {
                    echo '<th>' . $fieldinfo->name . '</th>';
                }
            ?>
        </tr>
        <?php
            // Вывод данных таблицы
            while ($row = mysqli_fetch_row($result1)) {
                echo '<tr>';
                foreach ($row as $data) {
                    echo '<td>' . $data . '</td>';
                }
                echo '</tr>';
            }
        ?>
    </table>

    <h2>Survey Table</h2>
    <table border="1">
        <tr>
            <?php
                while ($fieldinfo = mysqli_fetch_field($result2)) {
                    echo '<th>' . $fieldinfo->name . '</th>';
                }
            ?>
        </tr>
        <?php
            while ($row = mysqli_fetch_row($result2)) {
                echo '<tr>';
                foreach ($row as $data) {
                    echo '<td>' . $data . '</td>';
                }
                echo '</tr>';
            }
        ?>
    </table>

</body>
</html>
