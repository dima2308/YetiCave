<?php
require_once 'functions.php';
require_once "vendor/autoload.php";

session_start();

$connect = mysqli_connect("localhost", "root", "", "yeticave");

if ($connect == false) {
    print("Ошибка подключения: " . mysqli_connect_error());
}

if (!isset($_SESSION['user'])) {
    http_response_code(403);
    header('Location: 403new.html');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $required_fields = ['lot-name', 'category', 'message', 'lot-rate', 'lot-step', 'lot-date'];
    $info_lot = $_POST;
    $errors = [];

    $error_descr = [
        'lot-name' => 'Укажите название',
        'category' => 'Укажите категорию лота',
        'message' => 'Заполните описание',
        'lot-rate' => 'Укажите начальную цену',
        'lot-step' => 'Укажите шаг ставки',
        'lot-date' => 'Укажите корректную дату завершения лота'
    ];


    foreach ($required_fields as $field) {
        if (empty($info_lot[$field])) {
            $errors[$field] = 'Поле не заполнено';
        }
    }

    if (!is_numeric($info_lot['lot-rate']) || $info_lot['lot-rate'] <= 0) {
        $errors['lot-rate'] = 'Заполните поле корректными данными';
    }
    if (!is_numeric($info_lot['lot-step']) || $info_lot['lot-step'] <= 0) {
        $errors['lot-step'] = 'Заполните поле корректными данными';
    }

    if ($info_lot['lot-date'] < date('Y-m-d H:i:s')) {
        $errors['lot-date'] = 'Введите корректную дату';
    }

    if ($info_lot['category'] == 'Выберите категорию') {
        $errors['category'] = 'Категория не выбрана';
    }

    if (isset($_FILES['filename']['name'])) {
        $real_name = $_FILES['filename']['name'];
        $tmp_name = $_FILES['filename']['tmp_name'];

        move_uploaded_file($tmp_name, 'img/' . $real_name);
    } else {
        $errors['filename'] = 'Файл не загружен';
    }

    if (count($errors)) {
        $add_lot_content = renderTemplate('templates/add_lot.php', [
            'errors' => $errors,
            'error_descr' => $error_descr,
            'info_lot' => $info_lot,
            'categories' => selectCategories($connect)
        ]);
    } else {
        $lot_cat = htmlspecialchars($info_lot['category']);
        $lot_cat = (string)$lot_cat;
        $sql_cat = mysqli_query($connect, "SELECT id, cat_name FROM category");
        $res_cat = mysqli_fetch_all($sql_cat, MYSQLI_ASSOC);
        foreach ($res_cat as $res) {
            if (($lot_cat) == ($res['cat_name'])) {
                $lot_cat = $res['id'];
            }
        }

        $lot_name = htmlspecialchars($info_lot['lot-name']);
        $lot_descr = htmlspecialchars($info_lot['message']);
        $lot_url = htmlspecialchars($_FILES['filename']['name']);
        $lot_price = htmlspecialchars($info_lot['lot-rate']);
        $lot_step = htmlspecialchars($info_lot['lot-step']);
        $lot_data_stop = htmlspecialchars($info_lot['lot-date']);
        $usid = $_SESSION['user_id'];


        $record = "INSERT INTO lot (data_create, name, description, url, start_price, data_stop, bet_step, likes, author_id, winner_id, category_id)
                              VALUES   (NOW(), '$lot_name', '$lot_descr', 'img/$lot_url', '$lot_price', '$lot_data_stop',
                                        '$lot_step', 0, '$usid', NULL, '$lot_cat')";

        $result = mysqli_query($connect, $record);

        if (!$result) {
            $error = mysqli_error($connect);
            print("Ошибка MySQL: " . $error);
        } else {
            $lot_id = mysqli_insert_id($connect);
            header("Location: lot.php?num=" . $lot_id);
        }
    }
} else {
    $add_lot_content = renderTemplate('templates/add_lot.php', [
        'info' => $info,
        'categories' => selectCategories($connect)
    ]);
}

$layout_content = renderTemplate('templates/layout.php', [
    'content' => $add_lot_content,
    'title' => "Добавление лота",
    'username' => $_SESSION['user_name'],
    'avatar' => $_SESSION['user_img'],
    'categories' => selectCategories($connect)
]);

print($layout_content);