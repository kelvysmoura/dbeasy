<?php

function debug(){
	array_map(function($d){
		echo "<pre>";
			print_r($d);
		echo "</pre><hr>";
	}, func_get_args());
}


function __autoload($class){

	$class = str_replace('\\', '/', $class).'.php';

	$file = __DIR__.DIRECTORY_SEPARATOR.$class;

	if(file_exists($file)){
		require_once $class;
	}
	else{
		echo "Não foi possivel carregar a classe {$class}";
	}

}