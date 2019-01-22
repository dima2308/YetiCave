<?php
    require_once "functions.php";
    require_once "my_lots.php";
    require_once "variables.php";
    
    session_start();
    
    date_default_timezone_set('Europe/Moscow');
    
    $connect = mysqli_connect("localhost", "root", "", "yeticave");
    if ($connect == false) {
        print("Ошибка подключения: " . mysqli_connect_error());
    }
    
    echo $_SESSION['user_name'];
    
    $categories_db = "SELECT * FROM category";
    
    $all_lots = "SELECT
                lot.id,
                lot.name,
                lot.start_price,
                lot.url,
                lot.data_create,
                lot.data_stop,
                count(bet.lot_id) AS count_bet,
                IFNULL(MAX(bet.price), lot.start_price) AS current_price,
                category.cat_name FROM lot
                LEFT JOIN bet on lot.id = bet.lot_id
                LEFT JOIN category on lot.category_id = category.id
                GROUP BY lot.id
                ORDER BY lot.data_create DESC LIMIT 6";
                
    $result_cat = mysqli_query($connect, $categories_db);
    $result_lots = mysqli_query($connect, $all_lots);
    
    $cat = mysqli_fetch_all($result_cat, MYSQLI_ASSOC);
    $lots = mysqli_fetch_all($result_lots, MYSQLI_ASSOC);
    
    
  
    $page_content = renderTemplate('templates/index.php', [
        'categories_db' => $cat,
        'current_date' => $current_hour,
        'new_date' => $new_date,
        'lots' => $lots]);
        
    $layout_content = renderTemplate('templates/layout.php', [
        'content' => $page_content,
        'title' => $title,
        'auth' => $is_auth, 
        'username' => $user_name,
        'avatar' => $user_avatar,
        'categories' => $categories]);
        
    print($layout_content);
?>

