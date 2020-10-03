<?php
	require_once 'functions.php';
    require_once "vendor/autoload.php";

    $connect = mysqli_connect("localhost", "root", "", "yeticave");
    if ($connect == false) {
        print("Ошибка подключения: " . mysqli_connect_error());
    }
    
    if (isset($_GET['num'])) {
        $num = $_GET['num'];
    }
    
    $lots_query = mysqli_query($connect, 'SELECT lot.id AS lot_id, lot.name, lot.start_price, bet.id AS bet_id, bet.user_id, users.name, users.email
                                            FROM lot
                                            LEFT JOIN bet ON bet.lot_id = lot.id AND bet.price = lot.start_price
                                            LEFT JOIN users ON users.id = bet.user_id
                                            WHERE lot.winner_id IS NULL 
                                            AND lot.data_stop <= NOW();');
    $lots_result = mysqli_fetch_all($lots_query, MYSQLI_ASSOC);
    
    $transport = new Swift_SmtpTransport('smtp.mail.ru', 465);
    $transport->setUsername("doingsdone@mail.com");
    $transport->setPassword("rds7BgcL");
    $transport->setEncryption('ssl');
    
    $mailer = new Swift_Mailer($transport);
        
    setupMailer();
   
    if ($lots_result) {
        foreach ($lots_result as $v) {
            $winner_id_us = $v['user_id'];
            $winner_id_lot = $v['lot_id'];
            $winner_name = $v['name'];
            $winner_mail = $v['email'];
            $winner_lot_name = $v['name'];
            
            $winners = "UPDATE lot SET winner_id = '$winner_id_us' WHERE lot.id = '$winner_id_lot'";
            $result_winner = mysqli_query($connect, $winners); 
            
            
            $content = renderTemplate('templates/email.php', [
                'name' => $winner_name,
                'email' => $winner_mail,
                'name' => $winner_lot_name]);
                
            $message = new Swift_Message('Ваша ставка победила!!!');
            $message->setFrom('doingsdone@mail.ru');
            $message->setTo([$winner_mail => $winner_name]);
            $message->setBody($content, 'Respect!');
            
            $mailer = new Swift_Mailer($transport);
            $mailer->send($message);
            
            sendMail($winner_name, $winner_mail, $winner_lot_name);
        }
    }