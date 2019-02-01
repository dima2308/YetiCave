<?php
	require_once 'functions.php';
    require_once "vendor/autoload.php";
    
    $connect = mysqli_connect("localhost", "root", "", "yeticave");
    
    if ($connect == false) {
        print("Ошибка подключения: " . mysqli_connect_error());
    }
    
   if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $required_fields = ['email', 'password', 'name', 'contacts'];
        $reg = $_POST;
        $errors = [];
        $email = $reg['email'];
        
        $sql_mail = "SELECT email FROM users WHERE email='$email'";
        $record = mysqli_query($connect, $sql_mail);
             
        foreach ($required_fields as $field) {
            if (empty ($reg[$field])) {
                $errors[$field] = 'Заполните поле';
            }
        }
        
        if (isset($_FILES['filename']['name'])) {  
            $real_name = $_FILES['filename']['name'];
            $tmp_name = $_FILES['filename']['tmp_name'];
            
            move_uploaded_file($tmp_name, 'img/avatars/' . $real_name);  
        }
        
        if (mysqli_num_rows($record)) {
            $errors['email'] = 'Пользователь с данным email уже зарегистрирован';
        }

        if (count($errors)) {
            $reg_content = renderTemplate('templates/registration.php', [
                'reg' => $reg,
                'errors' => $errors,
                'categories' => $categories]); 
        }
        
      else {
            $email = htmlspecialchars($reg['email']);
            $password = password_hash($reg['password'], PASSWORD_DEFAULT);
            $name = htmlspecialchars($reg['name']);
            $contact = htmlspecialchars($reg['contacts']);
            $url = htmlspecialchars($_FILES['filename']['name']);
            
            $record = "INSERT INTO `users` (`data_reg`, `email`, `password`, `name`, `contact`, `url`) VALUES ('2017-01-20', '$email', '$password', '$name', '$contact', 'img/avatars/$url')";
            $result = mysqli_query($connect, $record);
               
            if (!$result) {
                $error = mysqli_error($connect);
                print("Ошибка MySQL: " . $error);
            }
            else {
                header('Location: /login');
            }
   }
   }
   else {
        $reg_content = renderTemplate('templates/registration.php', []); 
   }
  
    $layout_content = renderTemplate('templates/layout.php', [
        'content' => $reg_content,
        'title' => "Регистрация",
        'username' => $user_name,
        'avatar' => $user_avatar,
        'categories' => selectCategories($connect)]);
        
    print($layout_content);
