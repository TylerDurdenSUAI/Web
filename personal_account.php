<?php
session_start();
require_once "db_connect.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Получение данных пользователя
$query = "SELECT login, email, reg_date, photo FROM users WHERE ID_user = ?";
$stmt = mysqli_prepare($conn, $query);
if (!$stmt) {
    die("Ошибка подготовки запроса: " . mysqli_error($conn));
}
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

// Получение заказов
$orders = [];
$query = "SELECT o.order_id AS id, o.order_date, o.total_price, o.status,
                 e.Event_Name, e.Event_Date, e.price
          FROM orders o
          JOIN order_events oe ON o.order_id = oe.order_id
          JOIN events e ON oe.event_id = e.ID_event
          WHERE o.user_id = ?
          ORDER BY o.order_date DESC";
$stmt = mysqli_prepare($conn, $query);
if (!$stmt) {
    die("Ошибка подготовки запроса заказов: " . mysqli_error($conn));
}
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

while ($row = mysqli_fetch_assoc($result)) {
    $orders[$row['id']]['order_date'] = $row['order_date'];
    $orders[$row['id']]['total_price'] = $row['total_price'];
    $orders[$row['id']]['status'] = $row['status'];
    $orders[$row['id']]['items'][] = [
        'name' => $row['Event_Name'],
        'date' => $row['Event_Date'],
        'price' => $row['price']
    ];
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Личный кабинет</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { background: #000; color: #fff; font-family: Arial, sans-serif; margin: 0; }
        header { background: #111; padding: 20px 0; text-align: center; }
        nav ul { list-style: none; display: flex; justify-content: center; gap: 10px; padding: 0; }
        nav ul li a { background: #ffa31a; color: #fff; padding: 10px 15px; text-decoration: none; border-radius: 5px; font-weight: bold; }
        nav ul li a:hover { background: #ff8000; }
        main { max-width: 900px; margin: 30px auto; background: #1a1a1a; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(255,163,26,0.2); }
        .profile { text-align: center; margin-bottom: 30px; }
        .profile img { border-radius: 50%; width: 100px; height: 100px; object-fit: cover; border: 3px solid #ffa31a; }
        .orders { margin-top: 20px; }
        .order { border: 1px solid #333; padding: 15px; margin-bottom: 15px; border-radius: 5px; background: #2a2a2a; }
        .order h4 { margin: 0 0 10px; color: #ffa31a; }
        .order-item { margin-left: 15px; }
        footer { text-align: center; padding: 20px; background: #111; margin-top: 40px; color: #fff; }
    </style>
</head>
<body>
<header>
    <h1>Праздники в детских садах</h1>
    <nav>
        <ul>
            <li><a href="index.php">Главная</a></li>
            <li><a href="events.php">Мероприятия</a></li>
            <li><a href="cart.php">Корзина</a></li>
            <li><a href="logout.php">Выход</a></li>
        </ul>
    </nav>
</header>
<main>
    <div class="profile">
        <img src="uploads/<?= htmlspecialchars($user['photo']) ?>" alt="Аватар">
        <h2 style="color: #ffa31a;"><?= htmlspecialchars($user['login']) ?></h2>
        <p>Email: <?= htmlspecialchars($user['email']) ?></p>
        <p>Дата регистрации: <?= htmlspecialchars($user['reg_date']) ?></p>
    </div>
    <div class="orders">
        <h3 style="color: #ffa31a;">Ваши заказы</h3>
        <?php if (!empty($orders)): ?>
            <?php foreach ($orders as $id => $order): ?>
                <div class="order">
                    <h4>Заказ №<?= $id ?> — <?= $order['order_date'] ?></h4>
                    <p>Статус: <?= htmlspecialchars($order['status']) ?> | Сумма: <?= $order['total_price'] ?> руб.</p>
                    <?php foreach ($order['items'] as $item): ?>
                        <div class="order-item">
                            <p>- <?= htmlspecialchars($item['name']) ?> (<?= $item['date'] ?>): <?= $item['price'] ?> руб.</p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>У вас пока нет заказов.</p>
        <?php endif; ?>
    </div>
</main>
<footer>
    <p>&copy; 2025 Праздники в детских садах</p>
</footer>
</body>
</html>
