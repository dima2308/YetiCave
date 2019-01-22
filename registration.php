<?php
	require_once 'functions.php';
	require_once 'my_lots.php';
    require_once "variables.php";
    
    $connect = mysqli_connect("localhost", "root", "", "yeticave");
    
    if ($connect == false) {
        print("Ошибка подключения: " . mysqli_connect_error());
    } /*
    else {
        print("Соединение установлено");
    } */
    
    //$record = "INSERT INTO users SET email = $reg['email'], password = password_hash($reg['password'], PASSWORD_DEFAULT), name = $reg['name'], contact = $reg['contacts']";
    
    
    
   if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $required_fields = ['email', 'password', 'name', 'contacts'];
        $reg = $_POST;
        $errors = [];
        
        foreach ($required_fields as $field) {
            if (empty ($reg[$field])) {
                $errors[$field] = 'Заполните поле';
            }
        }

        if (count($errors)) {
            $reg_content = renderTemplate('templates/registration.php', [
                'reg' => $reg,
                'errors' => $errors,
                'categories' => $categories]); 
        }
        else {
            $email = $reg['email'];
            $password = password_hash($reg['password'], PASSWORD_DEFAULT);
            $name = $reg['name'];
            $contact = $reg['contacts'];
            
            $record = "INSERT INTO `users` (`data_reg`, `email`, `password`, `name`, `contact`, `url`) VALUES ('2017-01-20', '$email', '$password', '$name', '$contact', '1')";
            $result = mysqli_query($connect, $record);
               
            if (!$result) {
                $error = mysqli_error($connect);
                print("Ошибка MySQL: " . $error);
            }
            else {
                header('Location: /example');
            }
   }
   }
   else {
        $reg_content = renderTemplate('templates/registration.php', []); 
   }
   
     
    $layout_content = renderTemplate('templates/layout.php', [
        'content' => $reg_content,
        'title' => "Регистрация",
        'auth' => $is_auth, 
        'username' => $user_name,
        'avatar' => $user_avatar,
        'categories' => $categories]);
        
    print($layout_content);
