<?php
/*
IronChannel is licensed under the Apache License 2.0 license
https://github.com/TRP-Solutions/iron-channel/blob/main/LICENSE
*/
declare(strict_types=1);

function server_time() {
	try {
		if(true) {
			$auth = \TRP\IronChannel\BasicAuth::get();
			if($auth->id()!=='john') {
				throw new \Exception('Unknown id',403);
			}
			$auth->verify('Pa55w0rd');
		}

		if(empty($_GET['timezone'])) {
			throw new \Exception('No timezome',400);
		}
	}
	catch(\Exception $e) {
		http_response_code($e->getCode());
		echo $e->getMessage();
		exit;
	}

	sleep(2);
	date_default_timezone_set($_GET['timezone']);
	echo date('r');
}
