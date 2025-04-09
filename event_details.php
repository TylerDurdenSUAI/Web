<?php
session_start();
require_once "db_connect.php";

if (isset($_GET['id_event'])) {
    $event_id = (int) $_GET['id_event'];

    // Получаем информацию о мероприятии
    $query = "SELECT * FROM events WHERE ID_event = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $event_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if (mysqli_num_rows($result) > 0) {
        $event = mysqli_fetch_assoc($result);
    } else {
        die("Мероприятие не найдено.");
    }

    // Обработка отправки комментария от авторизованного пользователя
    if (isset($_POST['submit_comment']) && isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $comment = htmlspecialchars($_POST['comment']);
        if (!empty($comment)) {
            $insert = "INSERT INTO event_comments (event_id, user_id, comment) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($conn, $insert);
            mysqli_stmt_bind_param($stmt, "iis", $event_id, $user_id, $comment);
            mysqli_stmt_execute($stmt);
        }
    }

    // Получаем комментарии вместе с логином и фото
    $comments = [];
    $comment_query = "SELECT ec.comment, ec.created_at, u.login, u.photo 
                      FROM event_comments ec 
                      JOIN users u ON ec.user_id = u.ID_user 
                      WHERE ec.event_id = ? 
                      ORDER BY ec.created_at DESC";
    $stmt = mysqli_prepare($conn, $comment_query);
    mysqli_stmt_bind_param($stmt, "i", $event_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($result)) {
        $comments[] = $row;
    }
} else {
    die("Неверный запрос.");
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($event['Event_Name']) ?></title>
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
            <li><a href="events.php">Мероприятия</a></li>
            <li><a href="cart.php">Корзина</a></li>
        </ul>
    </nav>
</header>
<main>
    <h2 style="color: #ffa31a;"><?= htmlspecialchars($event['Event_Name']) ?></h2>
    <p><strong>Дата мероприятия:</strong> <?= $event['Event_Date'] ?></p>
    <p><strong>Цена:</strong> <?= $event['price'] ?> руб.</p>
    <img src="uploads/<?= $event['image'] ?>" alt="<?= htmlspecialchars($event['Event_Name']) ?>" style="max-width: 100%; border-radius: 5px; margin-top: 10px;">

    <form action="add_to_cart.php" method="POST" style="margin-top: 20px;">
        <input type="hidden" name="event_id" value="<?= $event['ID_event'] ?>">
        <input type="hidden" name="event_name" value="<?= htmlspecialchars($event['Event_Name']) ?>">
        <input type="hidden" name="event_date" value="<?= $event['Event_Date'] ?>">
        <input type="hidden" name="price" value="<?= $event['price'] ?>">
        <input type="hidden" name="image" value="<?= $event['image'] ?>">
        <button type="submit" style="background-color: #ffa31a; color: white; padding: 10px 20px; border: none; border-radius: 5px; font-weight: bold; margin-top: 10px; cursor: pointer;">
            Добавить в корзину
        </button>
    </form>

    <h3 style="color: #ffa31a; margin-top: 40px;">Оставить комментарий</h3>
    <?php if (isset($_SESSION['user_id'])): ?>
    <form method="post">
        <textarea name="comment" placeholder="Ваш комментарий" required style="width: 100%; height: 100px; padding: 10px; border-radius: 5px; border: none;"></textarea>
        <button type="submit" name="submit_comment" style="background-color: #4caf50; color: white; padding: 10px 20px; border: none; border-radius: 5px; font-weight: bold; margin-top: 10px;">Отправить</button>
    </form>
    <?php else: ?>
    <p>Для добавления комментария необходимо <a href="login.php" style="color: #ffa31a; text-decoration: underline;">войти</a>.</p>
    <?php endif; ?>

    <h3 style="margin-top: 30px; color: #ffa31a;">Комментарии</h3>
    <?php if (!empty($comments)): ?>
        <?php foreach ($comments as $c): ?>
            <div style="background-color: #2a2a2a; padding: 10px 15px; margin-bottom: 10px; border-radius: 5px; display: flex; gap: 15px; align-items: flex-start;">
                <?php
                    $avatarPath = 'uploads/' . ($c['photo'] ?? 'avatars/default.png');
                    if (!file_exists($avatarPath)) {
                        $avatarPath = 'uploads/avatars/default.png';
                    }
                ?>
                <img src="<?= htmlspecialchars($avatarPath) ?>" alt="Фото пользователя" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover; border: 2px solid #ffa31a;">
                <div>
                    <p><strong><?= htmlspecialchars($c['login']) ?>:</strong></p>
                    <p><?= nl2br(htmlspecialchars($c['comment'])) ?></p>
                    <small style="color: #aaa;"><?= $c['created_at'] ?></small>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Комментариев пока нет.</p>
    <?php endif; ?>
</main>
<footer>
    <p>&copy; 2025 Праздники в детских садах</p>
</footer>
</body>
</html>