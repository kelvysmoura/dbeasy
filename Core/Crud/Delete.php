<?php 

namespace Core\Crud;

use \Core\Connection;


class Delete{
	
	private $tbname;

	private $query;

	private $binds = [];

	private $active = ['id' => false, 'wh' => false, 'andwh' => false, 'orwh' => false, 'all' => false];

	public function __construct($table){
		$this->tbname = $table;
		$this->query = "DELETE FROM {$table}";
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
		debug($this->query);
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

	public function all(){
		$this->active['all'] = true;
		return $this;
	}

	public function run($conn = null){
		if($this->active['id'] OR $this->active['wh'] OR $this->active['andwh'] OR $this->active['orwh'] OR $this->active['all']){
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
}