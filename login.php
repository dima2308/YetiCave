<?php
require_once 'functions.php';
require_once 'userdata.php';
require_once "vendor/autoload.php";

session_start();

$connect = mysqli_connect("localhost", "root", "", "yeticave");

if ($connect == false) {
    print("Ошибка подключения: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $required_fields = ['email', 'password'];
    $info_login = $_POST;
    $errors = [];

    foreach ($required_fields as $field) {
        if (empty($info_login[$field])) {
            $errors[$field] = 'Поле не заполнено';
        }
    }

    if (!empty($info_login['email'])) {
        $email = $info_login['email'];
        $sql_email = "SELECT * FROM `users` WHERE `email` = '$email'";
        $email_result = mysqli_query($connect, $sql_email);

        $user = $email_result ? mysqli_fetch_array($email_result, MYSQLI_ASSOC) : null;

        if (!count($errors) && $user) {
            if (password_verify($info_login['password'], $user['password'])) {
                $_SESSION['user'] = $user;

                $sql_new_us = mysqli_query($connect, "SELECT `name`, `url`, `id` FROM `users` WHERE `email` = '$email'");
                $sql_new_fetch = mysqli_fetch_array($sql_new_us, MYSQLI_ASSOC);

                $user_name_ses = $sql_new_fetch['name'];
                $user_img_ses = $sql_new_fetch['url'];
                $user_id_ses = $sql_new_fetch['id'];
            } else {
                $errors['password'] = 'Неверный пароль';
            }
        } else $errors['email'] = 'Пользователь не найден';
    }

    $_SESSION['user_name'] = $user_name_ses;
    $_SESSION['user_img'] = $user_img_ses;
    $_SESSION['user_id'] = $user_id_ses;

    if (count($errors)) {
        $login_content = renderTemplate(
            'templates/login.php',
            [
                'info_login' => $info_login,
                'errors' => $errors
            ]
        );
    } else {
        header("Location: /example");
        exit();
    }
} else {
    $login_content = renderTemplate('templates/login.php', []);
}

$layout_content = renderTemplate('templates/layout.php', [
    'content' => $login_content,
    'title' => $lot_name,
    'username' => $user_name,
    'avatar' => $user_avatar,
    'categories' => selectCategories($connect)
]);

print($layout_content);
