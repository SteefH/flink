<?php
spl_autoload_register(function ($name) {
	if (substr($name, 0, 6) === 'Flink\\') {
		$file = dirname(__FILE__).'/'.str_replace('\\', '/', substr($name, 6)).'.php';
		if (is_file($file)) {
			include $file;
		}
	}
});