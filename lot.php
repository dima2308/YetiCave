<?php
	require_once 'functions.php';
	require_once 'my_lots.php';
    require_once "variables.php";
    
    session_start();
  
    if (isset($_GET['num'])) {
        $num = $_GET['num'];
    }
    
    
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
                category.cat_name FROM lot
                LEFT JOIN category on lot.category_id = category.id
                WHERE lot.id = '$num'";
                
    $result_lot = mysqli_query($connect, $all_lots); 

    if (mysqli_num_rows($result_lot)) {
        $lot = mysqli_fetch_all($result_lot, MYSQLI_ASSOC);
        $lot_content = renderTemplate('templates/lot.php', [
            'lot' => $lot,
            'current_date' => $current_hour,
            'new_date' => $new_date
        ]);
    }
    else {
        http_response_code(404);
        header('Location: http://localhost/example/404.html');
    };
    

    // установка cookies
    if (isset($_COOKIE['history'])) {
        $history_lots = json_decode($_COOKIE['history']);
        if (!in_array($num, $history_lots)) {
            array_push($history_lots, $num); 
        }         
    }
    else {
        $history_lots = [];
        array_push($history_lots, $num);
    }
    
    $ser_hist = json_encode($history_lots); // сериализация массива
  
    $name = "history";
    $value = $ser_hist;
    $path = "/";  
        
    setcookie($name, $value, $expire, $path);
    
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $bet = $_POST;
        $errors = [];

        if (empty($bet['cost'])) {
            $errors[] = 'Заполните поле';
        }
        
        //echo (count($errors));



  
        if (count($errors)) {
            //echo 'error';        
                //print_r($lot[0]);
                $lot_content = renderTemplate('templates/lot.php', [
                    
                    'lot' => $lot[0],
                    'current_date' => $current_hour,
                    'new_date' => $new_date
                ]);
    }
    else {
        http_response_code(404);
        header('Location: http://localhost/example/404.html');
    };
        
        
    
    }
   

        
    $layout_content = renderTemplate('templates/layout.php', [
        'content' => $lot_content,
        'title' => $lot_name,
        'auth' => $is_auth, 
        'username' => $user_name,
        'avatar' => $user_avatar,
        'categories' => $categories]);
        
    print($layout_content);
