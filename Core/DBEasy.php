<?php

namespace Core;

class DBEasy extends Connection{

	public function __construct($dbconfig = []){
		return parent::__construct($dbconfig);
	}

	public function Create($tbname = 'undefined'){
		return new Crud\Create($tbname);
	}

	public function Read($tbname = 'undefined'){
		return new Crud\Read($tbname);
	}

	public function Update($tbname = 'undefined'){
		return new Crud\Update($tbname);
	}

	public function Delete($tbname = 'undefined'){
		return new Crud\Delete($tbname);
	}
}