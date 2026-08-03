<?php
/*
IronChannel is licensed under the Apache License 2.0 license
https://github.com/TRP-Solutions/iron-channel/blob/main/LICENSE
*/
declare(strict_types=1);

function server_time() {
	sleep(2);

	try {
		if(true) {
			$auth = \TRP\IronChannel\BasicAuth::get();
			if($auth->id()!=='john') {
				throw new \Exception('Forbidden',403);
			}
			if(!$auth->match('Pa55w0rd')) {
				throw new \Exception('Forbidden',403);
			}
		}

		if(empty($_GET['timezone'])) {
			throw new \Exception('No timezome',400);
		}
		date_default_timezone_set($_GET['timezone']);
		echo date('r');
	}
	catch(\Exception $e) {
		http_response_code($e->getCode());
		echo $e->getMessage();
		exit;
	}
}
