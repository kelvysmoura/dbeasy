<?php 

namespace Core\Crud;

use \Core\Connection;

class Update{
	
	private $tbname;

	private $query;

	private $binds = [];

	private $active = ['id' => false, 'wh' => false, 'andwh' => false, 'orwh' => false];

	public function __construct($table = 'undefined'){
		$this->tbname = $table;
		$this->query = "UPDATE {$table}";
		return $this;
	}

	public function set($datas = []){
		$cols = implode('=?,',array_keys($datas)).'=?';
		$vals = array_values($datas);
		$this->binds = $vals;
		$this->query .= " SET {$cols}";
		return $this;
	}

	public function id($id = null, $colname = 'id'){
		if(!is_null($id)){
			$this->query .= " WHERE {$colname} = ?";
			$this->active['id'] = true;
			array_push($this->binds, $id);
		}
		return $this;
	}

	public function wh($col = null, $val = null, $op = "="){
		if(!is_null($col) && !is_null($val)){
			if($this->active['id'] === false){
				$this->query .= " WHERE {$col} {$op} ?";
				$this->active['wh'] = true;
				array_push($this->binds, $val);
			}
		}
		return $this;
	}

	public function andwh($col = null, $val = null, $op = "="){
		if(!is_null($col) && !is_null($val)){
			if($this->active['wh'] === true OR $this->active['id'] === true){
				$this->query .= " AND {$col} {$op} ?";
				$this->active['andwh'] = true;
				array_push($this->binds, $val);
			}
		}
		return $this;
	}

	public function orwh($col = null, $val = null, $op = "="){
		if(!is_null($col) && !is_null($val)){
			if($this->active['wh'] === true OR $this->active['id'] === true){
				$this->query .= " OR {$col} {$op} ?";
				$this->active['orwh'] = true;
				array_push($this->binds, $val);
			}
		}		
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