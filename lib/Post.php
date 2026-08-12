<?php
/*
IronChannel is licensed under the Apache License 2.0 license
https://github.com/TRP-Solutions/iron-channel/blob/main/LICENSE
*/
declare(strict_types=1);
namespace TRP\IronChannel;

class Post extends CurlOpt implements Data {
	private array $data = [];

	function file(string $key, string $filename, ?string $mime_type = null, ?string $posted_filename = null) {
		$this->data[$key] = new \CURLFile($filename,$mime_type,$posted_filename);
	}
	function filestring(string $key, string $data, string $postname, string $mime = 'application/octet-stream') {
		$this->data[$key] = new \CURLStringFile($data,$postname,$mime);
	}
	function value(string $key, string|int $value) {
		$this->data[$key] = $value;
	}

	public static function read(mixed $name = null) : mixed {
		Server::allowed();
		return $_POST[$name] ?? null;
	}

	public function curl_setopt(\CurlHandle $ch) : void {
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $this->data);
	}
}
