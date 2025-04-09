<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Галерея праздников</title>
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
            color: #fff;
            text-align: center;
            padding: 20px 0;
        }

        header h1 {
            font-size: 32px;
            font-weight: bold;
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
            max-width: 1000px;
            margin: 30px auto;
            padding: 20px;
            background-color: #1a1a1a;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(255, 163, 26, 0.15);
        }

        h2, h3 {
            color: #ffa31a;
            border-bottom: 1px solid #333;
            padding-bottom: 5px;
        }

        .gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 15px;
        }

        .gallery img {
            width: 100%;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(255, 163, 26, 0.2);
            transition: transform 0.3s;
        }

        .gallery img:hover {
            transform: scale(1.05);
        }

        footer {
            background-color: #111;
            color: #fff;
            text-align: center;
            padding: 15px 0;
            margin-top: 40px;
        }

        p {
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <header>
        <h1>Галерея праздников</h1>
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
        <h2>Фотографии с прошедших мероприятий</h2>
        <div class="gallery">
            <img src="images/holiday1.jpg" alt="Праздник №1">
            <img src="images/holiday2.jpg" alt="Праздник №2">
            <img src="images/holiday3.jpg" alt="Праздник №3">
            <img src="images/holiday4.jpg" alt="Праздник №4">
            <img src="images/holiday5.jpg" alt="Праздник №5">
        </div>
    </main>

    <footer>
        <p>&copy; 2025 Праздники в детских садах</p>
    </footer>
</body>
</html>
