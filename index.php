<?php
    require_once "functions.php";
    require_once "getwinner.php";
    require_once "vendor/autoload.php";
    
    session_start();
   
    date_default_timezone_set('Europe/Samara');
    
    $connect = mysqli_connect("localhost", "root", "", "yeticave");
    if ($connect == false) {
        print("Ошибка подключения: " . mysqli_connect_error());
    }
    
    $user_name = $_SESSION['user_name'];
    
    $categories_db = "SELECT * FROM category";
       
    // пагинация 
    if (isset($_GET['page'])){
        $page = $_GET['page'];
    }
    else $page = 1;
    
    $kol = 6;
    $art = ($page * $kol) - $kol;
       
    $res = mysqli_query($connect, "SELECT COUNT(id) FROM lot");
    $row = mysqli_fetch_Row($res);
    
    $total = ceil($row[0] / $kol);
     
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
                ORDER BY lot.data_create DESC LIMIT $art, $kol";
                
    $result_cat = mysqli_query($connect, $categories_db);
    $result_lots = mysqli_query($connect, $all_lots);
    
    $cat = mysqli_fetch_all($result_cat, MYSQLI_ASSOC);
    $lots = mysqli_fetch_all($result_lots, MYSQLI_ASSOC);
       
    $page_content = renderTemplate('templates/index.php', [
        'categories_db' => $cat,
        'current_date' => $current_hour,
        'new_date' => $new_date,
        'lots' => $lots,
        'total' => $total]);
        
    $layout_content = renderTemplate('templates/layout.php', [
        'content' => $page_content,
        'title' => 'YetiCave - Главная',
        'username' => $_SESSION['user_name'],
        'avatar' => $_SESSION['user_img'],
        'categories' => selectCategories($connect)]);
        
    print($layout_content);

