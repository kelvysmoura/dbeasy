<?php

namespace Core;

use \PDO;
use \PDOException;

abstract class Connection{
	
	private $host;
	
	private $port;
	
	private $dbname;
	
	private static $user;
	
	private static $pass;

	private static $dns;

	private static $instance;

	public function __construct($dbconfig){
		$this->host = (isset($dbconfig['host']) && !empty($dbconfig['host'])) ? $dbconfig['host'] : 'localhost';
		$this->port = (isset($dbconfig['port']) && !empty($dbconfig['port'])) ? $dbconfig['port'] : '';
		$this->dbname = (isset($dbconfig['dbname']) && !empty($dbconfig['dbname'])) ? $dbconfig['dbname'] : 'undefined';
		self::$user = (isset($dbconfig['user']) && !empty($dbconfig['user'])) ? $dbconfig['user'] : 'root';
		self::$pass = (isset($dbconfig['pass']) && !empty($dbconfig['pass'])) ? $dbconfig['pass'] : '';

		self::$dns = "mysql:host={$this->host};dbname={$this->dbname};port={$this->port}";
	}

	public static function getInstance(){
		if(!isset(self::$instance)){
			try{
				self::$instance = new PDO(self::$dns, self::$user, self::$pass);
				self::$instance->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
				self::$instance->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
			}
			catch(PDOException $e){
				debug($e);
				die();
			}
		}
		return self::$instance;
	}

	public static function prepare($sql){
		return self::getInstance()->prepare($sql);
	}
}