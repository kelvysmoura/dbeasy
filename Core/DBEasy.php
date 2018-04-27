<?php

namespace Core;

class DBEasy extends Connection{

	private $setQuery;

	public function __construct($dbconfig = []){
		return parent::__construct($dbconfig);
	}

	public function read($tbname = 'undefined'){
		return new Crud\Read($tbname);
	}

	public function Create($tbname = 'undefined'){
		return new Crud\Create($tbname);
	}
}