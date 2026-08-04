<?php
/*
IronChannel is licensed under the Apache License 2.0 license
https://github.com/TRP-Solutions/iron-channel/blob/main/LICENSE
*/
declare(strict_types=1);
namespace TRP\IronChannel;

class RawString implements Data {
	private string $data;

	function __construct(string $data) {
		$this->data = $data;
	}

	public static function input() : string|array|object|null {
		return file_get_contents('php://input');
	}

	public function curl_header() : array {
		return [];
	}

	public function curl_setopt(\CurlHandle $ch) : void {
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $this->data);
	}
}
