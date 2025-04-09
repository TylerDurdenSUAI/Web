<?php
session_start();

// Проверка, что данные пришли через POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получаем данные мероприятия
    $event_id = $_POST['event_id'] ?? null;
    $event_name = $_POST['event_name'] ?? '';
    $event_date = $_POST['event_date'] ?? '';
    $price = isset($_POST['price']) ? (float)$_POST['price'] : 0;
    $image = $_POST['image'] ?? '';

    // Проверка наличия обязательных полей
    if ($event_id && $event_name && $event_date) {
        // Создаём элемент мероприятия
        $event = [
            'event_id' => $event_id,
            'event_name' => $event_name,
            'event_date' => $event_date,
            'price' => $price,
            'image' => $image
        ];

        // Если корзина еще не создана — создаём
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Добавляем мероприятие в корзину, если его там ещё нет
        if (!isset($_SESSION['cart'][$event_id])) {
            $_SESSION['cart'][$event_id] = $event;
        }

        // Перенаправляем пользователя обратно в корзину
        header("Location: cart.php");
        exit;
    } else {
        echo "Ошибка: недостаточно данных для добавления в корзину.";
    }
} else {
    echo "Неверный метод запроса.";
}
?>
