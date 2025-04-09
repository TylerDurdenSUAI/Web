<?php
session_start();
require_once "db_connect.php";

$filter_name = isset($_POST['filter_name']) ? $_POST['filter_name'] : '';
$query = "SELECT * FROM events WHERE Event_Name LIKE ? ORDER BY Event_Date DESC";
$stmt = mysqli_prepare($conn, $query);
$filter_param = "%" . $filter_name . "%";
mysqli_stmt_bind_param($stmt, "s", $filter_param);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result) {
    die("Ошибка выполнения запроса: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Мероприятия - Праздники в детских садах</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
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
            box-shadow: 0 0 20px rgba(255, 163, 26, 0.2);
        }

        h2 {
            color: #ffa31a;
            border-bottom: 1px solid #333;
            padding-bottom: 5px;
        }

        .filter-form {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        .filter-form input[type="text"] {
            flex: 1;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ffa31a;
            background-color: #111;
            color: #fff;
        }

        .filter-form button {
            background-color: #ffa31a;
            color: #000;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
        }

        .filter-form button:hover {
            background-color: #ff8000;
        }

        .event-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .event {
            background-color: #2a2a2a;
            padding: 15px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 0 10px rgba(255, 163, 26, 0.2);
        }

        .event img {
            width: 100%;
            max-width: 300px; /* или 100% если хочешь адаптивно */
            height: 200px;
            object-fit: cover;
            border-radius: 5px;
             margin: 0 auto;
            display: block;
        }

        .event h3 {
            color: #ffa31a;
            margin-top: 10px;
        }

        .event p {
            color: #ccc;
            font-size: 14px;
        }

        .event a {
            display: inline-block;
            margin-top: 10px;
            background-color: #ffa31a;
            color: #121212;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }

        .event a:hover {
            background-color: #fb8c00;
        }

        footer {
            background-color: #111;
            color: white;
            text-align: center;
            padding: 15px 0;
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
    <h2>Наши мероприятия</h2>

    <form class="filter-form" method="POST" action="events.php">
        <input type="text" name="filter_name" placeholder="Поиск по названию мероприятия" value="<?= htmlspecialchars($_POST['filter_name'] ?? '') ?>">
        <button type="submit">Фильтровать</button>
    </form>

    <div class="event-container">
        <?php while ($event = mysqli_fetch_assoc($result)) { ?>
            <div class="event">
                <img src="uploads/<?= htmlspecialchars($event['image']) ?>" alt="<?= htmlspecialchars($event['Event_Name']) ?>">
                <h3><?= htmlspecialchars($event['Event_Name']) ?></h3>
                <p><strong>Дата:</strong> <?= htmlspecialchars($event['Event_Date']) ?></p>
                <a href="event_details.php?id_event=<?= $event['ID_event'] ?>">Подробнее</a>
            </div>
        <?php } ?>
    </div>
</main>

<footer>
    <p>&copy; 2025 Праздники в детских садах</p>
</footer>
</body>
</html>

<?php mysqli_close($conn); ?>
