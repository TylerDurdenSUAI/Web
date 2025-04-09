<?php
// Обработка формы регистрации
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login']);
    $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);
    $email = trim($_POST['email']);

    $conn = new mysqli('localhost', 'root', '', 'deti');
    $conn->set_charset('utf8');

    if ($conn->connect_error) {
        die("Ошибка подключения к базе данных: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE login = ?");
    $stmt->bind_param("s", $login);
    $stmt->execute();
    $stmt->bind_result($login_count);
    $stmt->fetch();
    $stmt->close();

    if ($login_count > 0) {
        $error = "Этот логин уже занят.";
    } else {
        $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($email_count);
        $stmt->fetch();
        $stmt->close();

        if ($email_count > 0) {
            $error = "Этот email уже зарегистрирован.";
        } else {
            $photo_name = '';
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                $upload_dir = 'uploads/';
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                $extension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
                $photo_name = uniqid('avatar_', true) . '.' . $extension;
                $full_path = $upload_dir . $photo_name;
                move_uploaded_file($_FILES['photo']['tmp_name'], $full_path);
            }

            $reg_date = date('Y-m-d');
            $stmt = $conn->prepare("INSERT INTO users (login, password, email, photo, reg_date) VALUES (?, ?, ?, ?, ?)");
            if ($stmt === false) {
                die('Ошибка подготовки запроса на добавление пользователя: ' . $conn->error);
            }
            $stmt->bind_param("sssss", $login, $password, $email, $photo_name, $reg_date);
            $stmt->execute();
            $stmt->close();

            header("Location: login.php");
            exit;
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
    <style>
        body {
            background-color: #121212;
            font-family: 'Helvetica Neue', Arial, sans-serif;
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
            margin: 10px 0;
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        nav ul li {
            margin: 0 10px;
        }

        nav ul li a {
            color: #fff;
            background-color: #ffa31a;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        nav ul li a:hover {
            background-color: #ff8000;
        }

        main {
            display: flex;
            justify-content: center;
            margin-top: 40px;
        }

        form {
            background-color: #1c1c1c;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(255, 163, 26, 0.3);
            width: 100%;
            max-width: 400px;
        }

        h2 {
            text-align: center;
            color: #ffa31a;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-top: 15px;
            color: #ffa31a;
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"],
        input[type="email"],
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #555;
            border-radius: 5px;
            background-color: #333;
            color: white;
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #ffa31a;
            color: black;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            margin-top: 20px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #ff8000;
        }

        .error {
            color: red;
            text-align: center;
            font-size: 16px;
        }

        footer {
            background-color: #111;
            color: #ffa31a;
            text-align: center;
            padding: 15px 0;
            margin-top: 40px;
        }

        footer p {
            margin: 0;
        }
    </style>
</head>
<body>

<header>
    <h1>Праздники в детских садах</h1>
    <nav>
        <ul>
            <li><a href="index.php">Главная</a></li>
            <li><a href="gallery.php">Галерея</a></li>
            <li><a href="register.php">Регистрация</a></li>
            <li><a href="login.php">Вход</a></li>
            <li><a href="events.php">Мероприятия</a></li>
            <li><a href="cart.php">Корзина</a></li>
            <li><a href="contacts.php">Контакты</a></li>
        </ul>
    </nav>
</header>

<main>
    <form method="post" enctype="multipart/form-data">
        <h2>Регистрация</h2>

        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>

        <label for="login">Логин:</label>
        <input type="text" name="login" id="login" required>

        <label for="password">Пароль:</label>
        <input type="password" name="password" id="password" required>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>

        <label for="photo">Фото (аватар):</label>
        <input type="file" name="photo" id="photo" accept="image/*">

        <input type="submit" value="Зарегистрироваться">
    </form>
</main>

<footer>
    <p>© 2025 Праздники в детских садах</p>
</footer>

</body>
</html>
