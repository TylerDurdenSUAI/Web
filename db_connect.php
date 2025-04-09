<?php
$host = "localhost";
$user = "root";
$password = ""; // укажи пароль, если есть
$database = "deti";

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Ошибка подключения: " . mysqli_connect_error());
}
?>
