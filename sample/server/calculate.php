<?php
/*
IronChannel is licensed under the Apache License 2.0 license
https://github.com/TRP-Solutions/iron-channel/blob/main/LICENSE
*/
declare(strict_types=1);

function server_calculate($operation) {
	if(!in_array($operation,['add','multiply'],true)) {
		\TRP\IronChannel\JSON::error('Unknown operation',401);
	}

	try {
		if(true) {
			$jwt = \TRP\IronChannel\JWTVerify::process('findsecret');
			\TRP\IronChannel\Server::confirm($jwt);
		}
		elseif(false) {
			$jwt = \TRP\IronChannel\JWTVerify::get();
			$jwt->validate('hasta-la-vista-human');
			\TRP\IronChannel\Server::confirm($jwt);
		}

		$json = \TRP\IronChannel\JSON::read();
		if(!is_numeric($json->a ?? null) || !is_numeric($json->b ?? null)) {
			\TRP\IronChannel\JSON::error('Not numbers',400);
		}
		$reply = ['system' => 'base-10'];
		$reply['result'] = match($operation) {
			'add' => $json->a + $json->b,
			'multiply' => $json->a * $json->b,
		};
		$reply['success'] = true;
	}
	catch(\Exception $e) {
		\TRP\IronChannel\JSON::error($e->getMessage(),$e->getCode());
	}

	\TRP\IronChannel\JSON::output($reply,201);
}

function findsecret(\TRP\IronChannel\JWTVerify $jwt) : string {
	if($jwt->payload('app_id')==='skynet') {
		return 'hasta-la-vista-human';
	}
	throw new \Exception('Human found',403);
}
