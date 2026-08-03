<?php
/*
IronChannel is licensed under the Apache License 2.0 license
https://github.com/TRP-Solutions/iron-channel/blob/main/LICENSE
*/
declare(strict_types=1);
namespace TRP\IronChannel;

class JWTVerify {
	private string $signature;
	private string $header;
	private string $payload;

	private array $jwt_header = [];
	private array $jwt_payload = [];

	function __construct() {
		$jwt = \TRP\IronChannel\Bearer::get()->token();
		[$this->header, $this->payload, $signature] = explode('.', $jwt);

		$this->signature = self::jwt_decode($signature);
		$this->jwt_header = json_decode(self::jwt_decode($this->header),true);
		$this->jwt_payload = json_decode(self::jwt_decode($this->payload),true);

		if(empty($this->jwt_header['typ'])) {
			throw new \Exception('JWT header:typ not found',400);
		}
		if($this->jwt_header['typ'] !== 'JWT') {
			throw new \Exception('JWT header:typ != JWT not supported',400);
		}
		if(empty($this->jwt_header['alg'])) {
			throw new \Exception('JWT header:alg not found',400);
		}
		if($this->jwt_header['alg'] !== 'HS256') {
			throw new \Exception('JWT header:alg != HS256',400);
		}
		if(empty($this->jwt_payload['exp']) || !is_numeric($this->jwt_payload['exp'])) {
			throw new \Exception('JWT payload:exp not found',401);
		}
		if(time() >= $this->jwt_payload['exp']) {
			throw new \Exception('JWT payload:exp expired',401);
		}
	}

	public function verify(#[\SensitiveParameter] string $secret) : true {
		$expected = hash_hmac('sha256',$this->header.'.'.$this->payload,$secret,true);
		if(!hash_equals($expected, $this->signature)) {
			throw new \Exception('JWT invalid signature',401);
		}
		return true;
	}

	public function payload(string $key) : string|int {
		return $this->jwt_payload[$key];
	}

	private static function jwt_decode(string $part) : string {
		$part .= str_repeat('=', (4 - strlen($part) % 4) % 4);
		$part = strtr($part, '-_', '+/');
		return base64_decode($part);
	}
}
