<?php
/*
IronChannel is licensed under the Apache License 2.0 license
https://github.com/TRP-Solutions/iron-channel/blob/main/LICENSE
*/
declare(strict_types=1);

function server_filedrop() {
	try {
		if(true) {
			$bearer = \TRP\IronChannel\Bearer::get();
			$bearer->verify('_TopSecret!*');
		}

		echo '<xml>'.PHP_EOL;
		echo ' <eventname>'.htmlspecialchars($_POST['eventname']).'</eventname>'.PHP_EOL;
		echo ' <file>'.htmlspecialchars($_FILES['file']['name']).'</file>'.PHP_EOL;
		echo ' <file2>'.htmlspecialchars($_FILES['file2']['name']).'</file2>'.PHP_EOL;
		echo '</xml>'.PHP_EOL;
	}
	catch(\Exception $e) {
		http_response_code($e->getCode());
		echo $e->getMessage();
		exit;
	}
}
