<?php
require_once 'functions.php';
require_once "vendor/autoload.php";

session_start();

if (isset($_GET['num'])) {
    $num = $_GET['num'];
}

// подключение к БД и получение данных о лоте

$connect = mysqli_connect("localhost", "root", "", "yeticave");
if ($connect == false) {
    print("Ошибка подключения: " . mysqli_connect_error());
}

$all_lots = "SELECT
                lot.id,
                lot.name,
                lot.start_price,
                lot.url,
                lot.description,
                lot.bet_step,
                lot.data_create,
                lot.data_stop,
                lot.author_id,
                category.cat_name FROM lot
                LEFT JOIN category on lot.category_id = category.id
                WHERE lot.id = '$num'";

$result_lot = mysqli_query($connect, $all_lots);

$all_bets = "SELECT 
                 bet.data_bet, bet.price, bet.lot_id, users.name
                 FROM bet
                 INNER JOIN users ON bet.user_id = users.id
                 WHERE bet.lot_id = '$num'
                 ORDER BY data_bet DESC LIMIT 10";

$result_bet = mysqli_query($connect, $all_bets);

$bets = mysqli_fetch_all($result_bet, MYSQLI_ASSOC);

// если метод GET (только зашли, но ничего не отправили)
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (mysqli_num_rows($result_lot)) {
        $lot = mysqli_fetch_all($result_lot, MYSQLI_ASSOC);
        $lot_content = renderTemplate('templates/lot.php', [
            'lot' => $lot,
            'current_date' => $current_hour,
            'new_date' => $new_date,
            'bets' => $bets
        ]);
    } else {
        http_response_code(404);
        header('Location: http://localhost/example/404.html');
    };
}

// установка cookies
if (isset($_COOKIE['history'])) {
    $history_lots = json_decode($_COOKIE['history']);
    if (!in_array($num, $history_lots)) {
        array_push($history_lots, $num);
    }
} else {
    $history_lots = [];
    array_push($history_lots, $num);
}

$ser_hist = json_encode($history_lots); // сериализация массива

$name = "history";
$value = $ser_hist;
$path = "/";

setcookie($name, $value, $expire, $path);

// если метод POST (данные отправили)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bet = $_POST;
    $errors = [];

    if (mysqli_num_rows($result_lot)) {
        $lot = mysqli_fetch_all($result_lot, MYSQLI_ASSOC);
    }

    $usid = $_SESSION['user_id'];

    $sql_author_lot = mysqli_query($connect, "SELECT id, author_id FROM lot WHERE author_id = '$usid'");
    $res_author_lot = mysqli_fetch_all($sql_author_lot, MYSQLI_ASSOC);

    foreach ($res_author_lot as $res) {
        if ($res['id'] == $lot[0]['id']) {
            $errors['cost'] = 'Вы не можете ставить на свой лот';
            break;
        }
    }

    if (empty($bet['cost'])) {
        $errors['cost'] = 'Заполните поле';
    }

    $min_price = $lot[0]['start_price'] + $lot[0]['bet_step'];

    if (!empty($bet['cost']) && ($bet['cost'] < $min_price)) {
        $errors['cost'] = 'Ставка должна быть не меньше минимальной';
    }

    if (!is_numeric($bet['cost'])) {
        $errors['cost'] = 'Введите число';
    }

    if (count($errors)) {
        $lot_content = renderTemplate('templates/lot.php', [
            'lot' => $lot,
            'current_date' => $current_hour,
            'new_date' => $new_date,
            'errors' => $errors,
            'bets' => $bets
        ]);
    } else {
        $user_bet = htmlspecialchars($bet['cost']);

        $record = "INSERT INTO `bet` (`data_bet`, `price`, `user_id`, `lot_id`) VALUES (NOW(), '$user_bet', '$usid', '$num')";
        $result = mysqli_query($connect, $record);

        $result_bet = mysqli_query($connect, $all_bets);
        $bets = mysqli_fetch_all($result_bet, MYSQLI_ASSOC);

        // транзакция, для получения новой цены
        mysqli_begin_transaction($connect, MYSQLI_TRANS_START_READ_WRITE);

        mysqli_query($connect, "SELECT @max_price:=MAX(bet.price), bet.lot_id, lot.id, lot.name
                                     FROM bet
                                     INNER JOIN lot ON lot.id = bet.lot_id
                                     WHERE bet.lot_id = '$num';");
        mysqli_query($connect, "UPDATE lot SET start_price = @max_price WHERE lot.id = '$num';");
        mysqli_commit($connect);

        $lot_content = renderTemplate('templates/lot.php', [
            'lot' => $lot,
            'current_date' => $current_hour,
            'new_date' => $new_date,
            'bets' => $bets
        ]);

        header("Location: " . $_SERVER["REQUEST_URI"]);
    }
}

$layout_content = renderTemplate('templates/layout.php', [
    'content' => $lot_content,
    'title' => $lot_name,
    'username' => $_SESSION['user_name'],
    'avatar' => $_SESSION['user_img'],
    'categories' => selectCategories($connect)
]);

print($layout_content);
