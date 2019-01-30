<?php
    require_once 'functions.php';
    require_once "vendor/autoload.php";
    
    session_start();
    
    $connect = mysqli_connect("localhost", "root", "", "yeticave");
    if ($connect == false) {
        print("Ошибка подключения: " . mysqli_connect_error());
    }
 
    $search = $_GET['search'] ?? '';
    
    mysqli_query($connect, 'CREATE FULLTEXT INDEX name_descr ON lot(name, description)');
    
    if ($search) {
		$sql = "SELECT
                lot.id,
                lot.name,
                lot.start_price,
                lot.url,
                lot.description,
                lot.bet_step,
                lot.data_create,
                lot.data_stop,
                category.cat_name FROM lot
                LEFT JOIN category on lot.category_id = category.id WHERE MATCH (name, description) AGAINST('$search')";

		$result = mysqli_query($connect, $sql);
        
		$lots = mysqli_fetch_all($result, MYSQLI_ASSOC);
	}
    
    
    $search_content = renderTemplate('templates/search.php', [
        'lot' => $lots,
        'search' => $search,
        'total' => $total]);

    $layout_content = renderTemplate('templates/layout.php', [
        'content' => $search_content,
        'title' => $lot_name,
        'username' => $_SESSION['user_name'],
        'avatar' => $user_avatar,
        'categories' => selectCategories($connect)]);
        
    print($layout_content);
        
