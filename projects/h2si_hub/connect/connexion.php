<?php
 $db_name='mysql:host=127.0.0.1;dbname=bd_h2si1';
	$db_user="root";
    $db_password='';

	$con=new PDO($db_name,$db_user,$db_password);

    if($con)
		echo"";
	
    function unique_id() {
        $str = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $rand = array();
        $length = strlen($str) - 1;
        for ($i = 0; $i < 20; $i++) {
            $n = mt_rand(0, $length);
            $rand[] = $str[$n];
        }
        return implode($rand);
     }
    ?>


    