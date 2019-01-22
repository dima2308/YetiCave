<?php
	require_once 'functions.php';
	require_once 'my_lots.php';
    require_once "variables.php";
    
    if (isset($_COOKIE['history'])) {
        $history_lots = json_decode($_COOKIE['history']);
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
                category.cat_name FROM lot
                LEFT JOIN category on lot.category_id = category.id"
                ;
                
    $result_lot = mysqli_query($connect, $all_lots); 

    $lot = mysqli_fetch_all($result_lot, MYSQLI_ASSOC);
   
    $history_content = renderTemplate('templates/history.php', [
        'history_lots' => $history_lots,
        'lot' => $lot,
        'current_date' => $current_hour,
        'new_date' => $new_date]);
        
    $layout_content = renderTemplate('templates/layout.php', [
        'content' => $history_content,
        'title' => $lot_name,
        'auth' => $is_auth, 
        'username' => $user_name,
        'avatar' => $user_avatar,
        'categories' => $categories]);
        
    print($layout_content);
?>
