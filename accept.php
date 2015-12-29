<?php

	require_once('./vendor/rsa.class.php');


	if($_POST['data']) {
		//JS->PHP传输RSA加密解密测试
		$data = $_POST['data'];
		$key = base64_encode(pack("H*", $data));
		echo Rsa::privDecrypt($key,true);
        //inner_test('hello!');
	}

    /*
     * 内部加密解密测试
     */
    function inner_test($string) {
        echo '<br/><br/>data:'.$string;
        $string = Rsa::encrypt($string);
        echo '<br/><br/>encode:'.$string;
        $string = Rsa::privDecrypt($string);
        echo '<br/><br/>decode:'.$string;
    }




?>