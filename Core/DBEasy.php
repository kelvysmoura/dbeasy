<?php

namespace Core;

class DBEasy extends Connection{

	public function __construct($dbconfig = null){		
		return parent::__construct($dbconfig);
	}

	public function Create($tbname = 'undefined'){
		return new Crud\Create($tbname);
	}

	public function Read($tbname = 'undefined', $run = false){
		$read = new Crud\Read($tbname);
		if(true === $run){
			return $read->run();
		}
		else{
			return $read;
		}
	}

	public function Update($tbname = 'undefined'){
		return new Crud\Update($tbname);
	}

	public function Delete($tbname = 'undefined'){
		return new Crud\Delete($tbname);
	}
}