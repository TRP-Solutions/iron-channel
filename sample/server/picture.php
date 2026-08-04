<?php
/*
IronChannel is licensed under the Apache License 2.0 license
https://github.com/TRP-Solutions/iron-channel/blob/main/LICENSE
*/
declare(strict_types=1);

function server_picture() {
	$input = \TRP\IronChannel\RawString::input();
	echo $_GET['filename'].': '.$input;
}
