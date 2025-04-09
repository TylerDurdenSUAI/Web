<?php
session_start();
require_once "db_connect.php";

// Проверка авторизации
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Удаление мероприятия из корзины
if (isset($_GET['remove']) && isset($_SESSION['cart'])) {
    $remove_id = $_GET['remove'];
    unset($_SESSION['cart'][$remove_id]);
    header("Location: cart.php");
    exit;
}

// Оформление заказа
if (isset($_POST['checkout']) && !empty($_SESSION['cart'])) {
    $user_id = $_SESSION['user_id'];
    $order_date = date("Y-m-d H:i:s");
    $status = 'Ожидает подтверждения';

    $total_price = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total_price += isset($item['price']) ? (float)$item['price'] : 0;
    }

    $query = "INSERT INTO orders (user_id, order_date, total_price, status) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "isis", $user_id, $order_date, $total_price, $status);

    if (mysqli_stmt_execute($stmt)) {
        $order_id = mysqli_insert_id($conn);
        $stmt_event = mysqli_prepare($conn, "INSERT INTO order_events (order_id, event_id) VALUES (?, ?)");

        foreach ($_SESSION['cart'] as $item) {
            mysqli_stmt_bind_param($stmt_event, "ii", $order_id, $item['event_id']);
            mysqli_stmt_execute($stmt_event);
        }

        $message = "Спасибо за заказ! Мы свяжемся с вами для подтверждения.";
        $_SESSION['cart'] = [];
    } else {
        $message = "Ошибка при оформлении заказа.";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Корзина</title>
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
            list-style: none;
            display: flex;
            justify-content: center;
            gap: 10px;
            padding: 0;
            margin: 0;
        }
        nav ul li a {
            background: #ffa31a;
            color: #fff;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        nav ul li a:hover {
            background: #ff8000;
        }
        main {
            max-width: 900px;
            margin: 30px auto;
            padding: 20px;
            background-color: #1a1a1a;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(255, 163, 26, 0.2);
        }
        .event {
            border-bottom: 1px solid #333;
            padding: 15px 0;
        }
        .event:last-child {
            border-bottom: none;
        }
        .event h3 {
            margin: 0 0 10px;
            color: #ffa31a;
        }
        .event img {
            max-width: 200px;
            border-radius: 5px;
            display: block;
            margin-top: 10px;
        }
        .remove-link {
            color: red;
            text-decoration: none;
            font-size: 14px;
        }
        .checkout-btn, .back-btn {
            padding: 10px 20px;
            border: none;
            margin-top: 20px;
            border-radius: 5px;
            cursor: pointer;
            display: inline-block;
            text-decoration: none;
        }
        .checkout-btn {
            background-color: #4caf50;
            color: #fff;
        }
        .back-btn {
            background-color: #ffa31a;
            color: #fff;
        }
        .message {
            color: #4caf50;
            font-weight: bold;
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
    <h1>Корзина</h1>
    <nav>
        <ul>
            <li><a href="index.php">Главная</a></li>
            <li><a href="events.php">Мероприятия</a></li>
            <li><a href="gallery.php">Галерея</a></li>
            <li><a href="contacts.php">Контакты</a></li>
        </ul>
    </nav>
</header>

<main>
    <h2>Ваш заказ</h2>

    <?php if (isset($message)): ?>
        <p class="message"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <?php if (!empty($_SESSION['cart'])): ?>
        <?php 
        $total_price = 0; 
        foreach ($_SESSION['cart'] as $item): 
            $item_price = isset($item['price']) ? (float)$item['price'] : 0;
            $total_price += $item_price;
        ?>
            <div class="event">
                <h3><?= htmlspecialchars($item['event_name']) ?></h3>
                <p><strong>Дата:</strong> <?= htmlspecialchars($item['event_date']) ?></p>
                <p><strong>Цена:</strong> <?= $item_price ?> руб.</p>
                <img src="uploads/<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['event_name']) ?>">
                <p><a class="remove-link" href="cart.php?remove=<?= $item['event_id'] ?>" onclick="return confirm('Удалить мероприятие из корзины?')">Удалить</a></p>
            </div>
        <?php endforeach; ?>

        <h3>Итого: <?= $total_price ?> руб.</h3>

        <form method="post">
            <button type="submit" name="checkout" class="checkout-btn">Оформить заказ</button>
        </form>

        <a href="events.php" class="back-btn">Вернуться к мероприятиям</a>
    <?php else: ?>
        <p>Ваша корзина пуста.</p>
    <?php endif; ?>
</main>

<footer>
    <p>&copy; 2025 Праздники в детских садах</p>
</footer>
</body>
</html>

<?php mysqli_close($conn); ?>
