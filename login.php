<?php
session_start();
require_once "db_connect.php"; // Убедитесь, что подключение к базе данных правильное

// Проверка, если пользователь уже авторизован
if (isset($_SESSION["user_id"])) {
    header("Location: personal_account.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $login = trim($_POST["login"]);
    $password = trim($_POST["password"]);

    // Запрос к базе данных для получения данных о пользователе
    $query = "SELECT ID_user, password FROM users WHERE login = ?";
    $stmt = mysqli_prepare($conn, $query);

    // Проверка на успешную подготовку запроса
    if (!$stmt) {
        die('Ошибка при подготовке запроса: ' . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "s", $login);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        $user = mysqli_fetch_assoc($result);

        // Если пользователь найден, проверяем пароль
        if ($user && password_verify($password, $user['password'])) {
            // Успешный вход - создаём сессию
            $_SESSION["user_id"] = $user['ID_user'];
            header("Location: personal_account.php");
            exit;
        } else {
            $error = "Неверный логин или пароль.";
        }
    } else {
        // Ошибка при выполнении запроса
        $error = "Ошибка при выполнении запроса: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background-color: #000;
            color: #fff;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #111;
            padding: 20px 0;
            text-align: center;
        }

        header h1 {
            font-size: 32px;
            font-weight: bold;
            color: #fff;
        }

        nav ul {
            list-style-type: none;
            padding: 0;
            margin: 15px 0;
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 10px;
        }

        nav ul li {
            margin: 0 10px;
        }

        nav ul li a {
            color: #fff;
            background-color: #ffa31a;
            text-decoration: none;
            padding: 10px 18px;
            border-radius: 4px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        nav ul li a:hover {
            background-color: #ff8000;
        }

        form {
            max-width: 400px;
            margin: 30px auto;
            padding: 20px;
            background-color: #1a1a1a;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        label {
            display: block;
            margin: 10px 0 5px;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        input[type="submit"] {
            margin-top: 15px;
            background-color: #f57f17;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 5px;
        }

        input[type="submit"]:hover {
            background-color: #ef6c00;
        }

        .error { 
            color: red;
        }

        footer {
            background-color: #111;
            color: white;
            text-align: center;
            padding: 20px 0;
            font-size: 14px;
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Проведение праздников в детских садах</h1>
        <nav>
            <ul>
                <li><a href="index.php">Главная</a></li>
                <li><a href="events.php">Мероприятия</a></li>
                <li><a href="gallery.php">Галерея</a></li>
                <li><a href="contacts.php">Контакты</a></li>
                
            </ul>
        </nav>
    </header>

    <form action="login.php" method="post">
        <h2>Вход</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <label for="login">Логин:</label>
        <input type="text" name="login" required>

        <label for="password">Пароль:</label>
        <input type="password" name="password" required>

        <input type="submit" value="Войти">
    </form>

    <footer>
        <p>&copy; 2025 Праздники в детских садах</p>
    </footer>
</body>
</html>
