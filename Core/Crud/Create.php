<?php 

namespace Core\Crud;

use \Core\Connection;

class Create{

	private $tbname;

	private $query;

	private $binds = [];

	public function __construct($table = 'undefined'){
		$this->tbname = $table;
		$this->query = "INSERT INTO {$table}";
		return $this;
	}

	public function set($datas = []){
		$cols = implode(',', array_keys($datas));
		$vals = array_values($datas);
		$this->binds = $vals;
		$mark = implode(',', array_filter(explode(',', str_repeat('?,', count($vals)))));
		$this->query .= "({$cols}) VALUES({$mark})";
		return $this;
	}

	public function run(){
		try {
			$run = Connection::prepare($this->query);
			if(!empty($this->binds)){
				foreach($this->binds as $k => $b){
					$run->bindValue($k+1, $b);
				}
			}
			$run->execute();
			return $run;	
		} catch (\Exception $e) {
			$error = "<br>Não foi possivel executar a query <em><strong>{$this->query}</strong></em>.<br><br> <strong>PDO Message: </strong>{$e->getMessage()}";
			die($error);
		}
	}
}