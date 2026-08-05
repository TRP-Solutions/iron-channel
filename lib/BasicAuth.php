<?php
/*
IronChannel is licensed under the Apache License 2.0 license
https://github.com/TRP-Solutions/iron-channel/blob/main/LICENSE
*/
declare(strict_types=1);
namespace TRP\IronChannel;

class BasicAuth implements Auth {
	private string $id;
	private string $password;

	function __construct(string $id,#[\SensitiveParameter] string $password) {
		$this->id = $id;
		$this->password = $password;
	}

	public static function get() : BasicAuth {
		if(empty($_SERVER['PHP_AUTH_USER']) || empty($_SERVER['PHP_AUTH_PW'])) {
			throw new \Exception('BasicAuth unauthorized',401);
		}
		return new self($_SERVER['PHP_AUTH_USER'],$_SERVER['PHP_AUTH_PW']);
	}

	public function id() : string {
		return $this->id;
	}
	public function match(#[\SensitiveParameter] string $password) : bool {
		return hash_equals($this->password,$password);
	}
	public function verify(#[\SensitiveParameter] string $password) : true {
		if(!$this->match($password)) {
			throw new \Exception('BasicAuth wrong password',403);
		}
		return true;
	}
	public function curl_header() : array {
		return [];
	}
	public function curl_setopt(\CurlHandle $ch) : void {
		curl_setopt($ch,CURLOPT_USERPWD, $this->id.':'.$this->password);
	}
}
