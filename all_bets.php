<?php
require_once 'functions.php';
require_once "vendor/autoload.php";

session_start();

// подключение к БД и получение данных о лоте

$connect = mysqli_connect("localhost", "root", "", "yeticave");
if ($connect == false) {
    print("Ошибка подключения: " . mysqli_connect_error());
}

$usid = $_SESSION['user_id'];

$all_bets = "SELECT lot.name, lot.id, lot.url, lot.category_id, lot.data_stop, lot.winner_id, category.cat_name, users.contact, bet.lot_id, MAX(bet.price) AS max_price, bet.user_id, MAX(bet.data_bet) AS max_date
                FROM lot
                LEFT JOIN bet ON lot.id = bet.lot_id
                LEFT JOIN category ON lot.category_id = category.id
                LEFT JOIN users on lot.winner_id = users.id
                WHERE bet.user_id = '$usid'
                GROUP BY lot.id
                ORDER BY max_date
                DESC LIMIT 10";

$result_bet = mysqli_query($connect, $all_bets);

$bets = mysqli_fetch_all($result_bet, MYSQLI_ASSOC);

$lot_content = renderTemplate('templates/all-bets.php', [
    'lot' => $lot,
    'current_date' => $current_hour,
    'new_date' => $new_date,
    'errors' => $errors,
    'bets' => $bets
]);

$layout_content = renderTemplate('templates/layout.php', [
    'content' => $lot_content,
    'title' => $lot_name,
    'username' => $_SESSION['user_name'],
    'avatar' => $_SESSION['user_img'],
    'categories' => selectCategories($connect)
]);

print($layout_content);
