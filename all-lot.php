<?php
require_once 'functions.php';
require_once "vendor/autoload.php";

session_start();

$connect = mysqli_connect("localhost", "root", "", "yeticave");
if ($connect == false) {
    print("Ошибка подключения: " . mysqli_connect_error());
}

$search = $_GET['category'] ?? '';

mysqli_query($connect, 'CREATE FULLTEXT INDEX name_descr ON category(cat_name)');

if ($search) {
    $sql = "SELECT
                lot.id,
                lot.name,
                lot.start_price,
                lot.url,
                lot.description,
                lot.bet_step,
                lot.data_create,
                lot.data_stop,
                category.cat_name FROM lot
                LEFT JOIN category on lot.category_id = category.id WHERE MATCH (category.cat_name) AGAINST('$search')";

    $result = mysqli_query($connect, $sql);

    if (mysqli_num_rows($result)) {
        $lots = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else $search = null;
}

$search_content = renderTemplate('templates/all-lot.php', [
    'lot' => $lots,
    'search' => $search
]);

$layout_content = renderTemplate('templates/layout.php', [
    'content' => $search_content,
    'title' => $lot_name,
    'username' => $_SESSION['user_name'],
    'avatar' => $_SESSION['user_img'],
    'categories' => selectCategories($connect)
]);

print($layout_content);
