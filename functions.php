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
    function setTime($current_hour, $new_time) {
        $now = new DateTime($current_hour);
        $b = $now->diff(new DateTime($new_time))->format('%d:%h:%i');
        return $b;
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
    
?>
