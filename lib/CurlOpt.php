<?php
/*
IronChannel is licensed under the Apache License 2.0 license
https://github.com/TRP-Solutions/iron-channel/blob/main/LICENSE
*/
declare(strict_types=1);
namespace TRP\IronChannel;

class CurlOpt {
	public function curl_header() : array {
		return [];
	}
	public function curl_setopt(\CurlHandle $ch) : void {}
	public function curl_hash(string $algo) : string {
		throw new \Exception(get_class($this).' function curl_hash not implemented but is required by Auth',501);
	}
}
