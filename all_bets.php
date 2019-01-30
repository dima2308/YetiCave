<?php
	require_once 'functions.php';
    require_once "vendor/autoload.php";
    
    session_start();
  
    // подключение к БД и получение данных о лоте
    
    $connect = mysqli_connect("localhost", "root", "", "yeticave");
    if ($connect == false) {
        print("Ошибка подключения: " . mysqli_connect_error());
    }
    
    $all_bets = "SELECT 
                 bet.data_bet, bet.price, bet.lot_id, users.name
                 FROM bet
                 INNER JOIN users ON bet.user_id = users.id
                 WHERE bet.lot_id = '$num'
                 ORDER BY data_bet DESC LIMIT 10";
                                 
    $result_bet = mysqli_query($connect, $all_bets); 
    
    $bets = mysqli_fetch_all($result_bet, MYSQLI_ASSOC); 
          
    $usid = $_SESSION['user_id'];

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
        'categories' => selectCategories($connect)]);
        
    print($layout_content);
    
    
    
    
