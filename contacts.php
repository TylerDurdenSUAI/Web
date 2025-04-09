<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Контакты - Праздники в детских садах</title>
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

        main {
            max-width: 900px;
            margin: 30px auto;
            padding: 20px;
            background-color: #1a1a1a;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(255, 163, 26, 0.2);
        }

        h2 {
            color: #ffa31a;
            border-bottom: 1px solid #333;
            padding-bottom: 5px;
        }

        .contact-info {
            margin-top: 20px;
        }

        .contact-info p {
            font-size: 16px;
            color: #bbb;
        }

        .contact-info strong {
            color: #ffa31a;
        }

        .contact-form label {
            display: block;
            margin: 10px 0 5px;
            color: #ffa31a;
        }

        .contact-form input, .contact-form textarea {
            width: 100%;
            padding: 10px;
            margin: 5px 0 15px;
            border: 1px solid #555;
            border-radius: 5px;
            background-color: #333;
            color: white;
        }

        .contact-form input[type="submit"] {
            background-color: #ffa31a;
            color: black;
            cursor: pointer;
        }

        .contact-form input[type="submit"]:hover {
            background-color: #ff8000;
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
    <h2>Контакты</h2>
    <div class="contact-info">
        <p><strong>Адрес:</strong> ул. Примерная, дом 1, город Москва, Россия</p>
        <p><strong>Телефон:</strong> +7 (999) 123-45-67</p>
        <p><strong>Email:</strong> alex200309@mail.ru</p>
        <p><strong>Время работы:</strong> Пн-Пт с 9:00 до 18:00</p>
    </div>

    <h2>Напишите нам</h2>
    <form class="contact-form" method="post">
        <label for="name">Ваше имя:</label>
        <input type="text" id="name" name="name" required>

        <label for="email">Ваш email:</label>
        <input type="email" id="email" name="email" required>

        <label for="message">Ваше сообщение:</label>
        <textarea id="message" name="message" rows="5" required></textarea>

        <input type="submit" value="Отправить сообщение">
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = htmlspecialchars(trim($_POST['name']));
        $email = htmlspecialchars(trim($_POST['email']));
        $message = htmlspecialchars(trim($_POST['message']));

        // Параметры почты
        $to = "alex200309@mail.ru"; // Адрес, на который отправляется сообщение
        $subject = "Сообщение с сайта Праздники в детских садах";
        $body = "Имя: $name\nEmail: $email\n\nСообщение:\n$message";
        $headers = "From: $email";

        // Отправка сообщения
        if (mail($to, $subject, $body, $headers)) {
            echo "<p>Ваше сообщение отправлено успешно!</p>";
        } else {
            echo "<p>Произошла ошибка при отправке сообщения, попробуйте позже.</p>";
        }
    }
    ?>
</main>

<footer>
    <p>&copy; 2025 Праздники в детских садах</p>
</footer>

</body>
</html>
