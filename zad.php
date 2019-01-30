<?php
    /*
	function printNumber ($num) {
		if (($num % 10 == 1) && ($num % 100 != 11)) 
			return 'программист';
		else if (($num % 10 >= 2) && ($num % 10 <= 4) && ($num % 100 < 10 || $num % 100 > 20))
			return 'программиста';
		else return 'программистов';
	}
	
	for ($i = 0; $i < 100; $i++) {
		echo $i . ' ' . printNumber($i) . "<br>";
	}
    */
    

    $arr = [1, 2, 3, 4, 5, 6, 7, 8];
    
    $flag = true;
    $count = 0;
    $i = 0;
    
    while ($flag) {
        if (isset($arr[$i])) {
            $flag = true;
            $count++;
            $i++;
        }
        else $flag = false;
    }
    
    echo $count;
            
