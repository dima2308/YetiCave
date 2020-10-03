<?php
        // функция - шаблонизатор
	function renderTemplate($template_path, $template_data)
	{
		ob_start();
		if (file_exists($template_path)) {
			require_once "$template_path";
		} else {
			return "Файл $template_path не найден";
		}
		$content = ob_get_clean();
		return $content;
	}
    
        // функция, определяющая время окончания лота 
    function setTime($current_time, $new_time) {
        $now = new DateTime($current_time);
        $b = $now->diff(new DateTime($new_time))->format('%d:%h:%i');
        return $b; 
    }
    
    function setTime1($now, $old) {
        $now = strtotime($now);
        $old = strtotime($old);
        if ($now < $old) {
            $time = $old - $now;
            $day = ($time / 86400) % 24;
            $hour = ($time / 3600) % 24;
            $minute = ($time / 60) % 60;
            $rez = $day . 'д. ' . $hour . 'ч. ' . $minute . 'м.';
        }
        else $rez = 'Время истекло';
        return $rez;
    }
    
    
        // функция, форматитурующая цену
    function format_number($num) {
        $num = ceil($num);
        if ($num < 1000)
            { 
                $num = $num;
            }  
        else 
            {
                 $num = number_format($num);
            }
        return ($num . " &#8381;");
    }
        // функция, которая ищет email по массиву
        // для БД не нужна
    function searchUserByEmail($email, $users) {
        $result = null;
        foreach ($users as $user) {
            if ($user["email"] == $email) {
                $result = $user;
                break;
            }
        }
        return $result;
    }
    
        // функция, выбирающая категории из БД
    function selectCategories ($con) {
        $categories_db = "SELECT * FROM category";
        $result_cat = mysqli_query($con, $categories_db);
        $cat = mysqli_fetch_all($result_cat, MYSQLI_ASSOC);
        return $cat;
    }
    
    function setupMailer() {
        $transport = new Swift_SmtpTransport('smtp.mail.ru', 465);
        $transport->setUsername("doingsdone@mail.com");
        $transport->setPassword("rds7BgcL");
        $transport->setEncryption('ssl');
        
        $mailer = new Swift_Mailer($transport);
    }
    
    function sendMail ($user_name, $user_mail, $lot_name) {
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
    }