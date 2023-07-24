<?php
session_start();

if (!isset($_SESSION['authenticated']) || !$_SESSION['authenticated']) {

    header('Location: login.php');
    exit;
}

$dbconn = pg_connect("host=localhost port=5432 dbname=web user=postgres password=rootroot");

if (!$dbconn) {
    die("Connection failed");
}


$result1 = pg_query($dbconn, "SELECT * FROM recover_table");
if (!$result1) {
    die("An error occurred while retrieving data from recover_table");
}

$result2 = pg_query($dbconn, "SELECT * FROM survey");
if (!$result2) {
    die("An error occurred while retrieving data from survey");
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
           
                $i = 0;
                while ($i < pg_num_fields($result1)) {
                    $fieldName = pg_field_name($result1, $i);
                    echo '<th>' . $fieldName . '</th>';
                    $i++;
                }
            ?>
        </tr>
        <?php
            // Вывод данных таблицы
            while ($row = pg_fetch_row($result1)) {
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
                
                $i = 0;
                while ($i < pg_num_fields($result2)) {
                    $fieldName = pg_field_name($result2, $i);
                    echo '<th>' . $fieldName . '</th>';
                    $i++;
                }
            ?>
        </tr>
        <?php
            
            while ($row = pg_fetch_row($result2)) {
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
