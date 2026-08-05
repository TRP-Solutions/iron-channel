<?php
/*
IronChannel is licensed under the Apache License 2.0 license
https://github.com/TRP-Solutions/iron-channel/blob/main/LICENSE
*/
declare(strict_types=1);
namespace TRP\IronChannel;

class Bearer implements Auth {
	private string $token;

	function __construct(#[\SensitiveParameter] string $token) {
		$this->token = $token;
	}

	public static function get() : Bearer {
		$headers = getallheaders();
		if(empty($headers['Authorization'])) {
			throw new \Exception('Bearer missing Authorization header',401);
		}
		if(preg_match('/^Bearer\s+(\S+)$/i', $headers['Authorization'], $matches)!==1) {
			throw new \Exception('Bearer missing token',401);
		}
		return new self($matches[1]);
	}

	public function token() : string {
		return $this->token;
	}
	public function match(#[\SensitiveParameter] string $token) : bool {
		return hash_equals($this->token,$token);
	}
	public function verify(#[\SensitiveParameter] string $token) : true {
		if(!$this->match($token)) {
			throw new \Exception('Bearer wrong token',403);
		}
		return true;
	}
	public function curl_header() : array {
		return ['Authorization: Bearer '.$this->token];
	}
	public function curl_setopt(\CurlHandle $ch) : void {
		// NOP
	}
}
