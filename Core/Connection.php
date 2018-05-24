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

	private static $options = [];

	public function __construct($use = null){
		require_once 'config/db.php';
		$use = (is_null($use) || empty($use)) ? $db['use_now'] : $use;
		$dbconfig = $db[$use];

		$this->host = (isset($dbconfig['host']) && !empty($dbconfig['host'])) ? $dbconfig['host'] : 'undefined';
		$this->port = (isset($dbconfig['port'])) ? $dbconfig['port'] : '0000';
		$this->dbname = (isset($dbconfig['dbname']) && !empty($dbconfig['dbname'])) ? $dbconfig['dbname'] : 'undefined';
		self::$user = (isset($dbconfig['user']) && !empty($dbconfig['user'])) ? $dbconfig['user'] : 'undefined';
		self::$pass = isset($dbconfig['pass']) ? $dbconfig['pass'] : 'undefined';
		
		foreach($dbconfig['attr_options'] as $k => $v){
			if(!empty($v)){
				$k = strtoupper($k);
				$v = strtoupper($v);
				$k = constant("PDO::ATTR_{$k}");
				$v = constant("PDO::{$v}");
				self::$options[$k] = $v;
			}
		}

		self::$dns = "mysql:host={$this->host};dbname={$this->dbname};port={$this->port}";
	}

	public static function getInstance(){
		if(!isset(self::$instance)){
			try{
				self::$instance = new PDO(self::$dns, self::$user, self::$pass, self::$options);
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