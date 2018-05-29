<?php

namespace Core\Crud;

use \Core\Connection;
use \Exception;
use \Core\Trace\Helper;

class Read{
	use Helper;

	private $tbname;
	
	private $fields = "*";

	private $query;

	private $binds = [];

	private $active = ['id' => false, 'wh' => false, 'andwh' => false, 'orwh' => false, 'limit' => false];

	public function __construct($tbname = "undefined"){
		$this->tbname = $tbname;
		$this->query = "SELECT {$this->fields} FROM {$this->tbname}";
	}

	public function fields($fields = "*", $run = false){
		$this->fields = $fields;
		$this->query = "SELECT {$this->fields} FROM {$this->tbname}";

		return (true === $run) ? $this->run() : $this;
	}

	public function id($id = null, $colname = 'id', $run = false){
		if(!is_null($id)){
			$this->query .= " WHERE {$colname} = ?";
			$this->active['id'] = true;
			array_push($this->binds, $id);
		}

		return (true === $run) ? $this->run() : $this;
	}

	public function wh($field = null, $val = null, $run = false){
		if(!is_null($field) && !is_null($val)){
			if($this->active['id'] === false){
				$field_operation = $this->WhatOperation($field);
				$this->query .= " WHERE {$field_operation} ?";
				$this->active['wh'] = true;
				array_push($this->binds, $val);
			}
		}

		return (true === $run) ? $this->run() : $this;
	}

	public function andwh($field = null, $val = null, $run = false){
		if(!is_null($field) && !is_null($val)){
			if($this->active['wh'] === true OR $this->active['id'] === true){
				$field_operation = $this->WhatOperation($field);
				$this->query .= " AND {$field_operation} ?";
				$this->active['andwh'] = true;
				array_push($this->binds, $val);
			}
		}

		return (true === $run) ? $this->run() : $this;
	}

	public function orwh($field = null, $val = null, $run = false){
		if(!is_null($field) && !is_null($val)){
			if($this->active['wh'] === true OR $this->active['id'] === true){
				$field_operation = $this->WhatOperation($field);
				$this->query .= " OR {$field_operation} ?";
				$this->active['orwh'] = true;
				array_push($this->binds, $val);
			}
		}

		return (true === $run) ? $this->run() : $this;
	}

	public function limit($limit = null, $run = false){
		if(!is_null($limit)){
			$this->query .= " LIMIT {$limit}";
			$this->active['limit'] = true;
		}
	
		return (true === $run) ? $this->run() : $this;
	}

	public function offset($off = null, $run = false){
		if(!is_null($off) && $this->active['limit'] === true){
			$this->query .= " OFFSET {$off}";
		}
		
		return (true === $run) ? $this->run() : $this;
	}

	public function orderBy($order = null, $run = false){
		if(!is_null($order)){
			$this->query .= " ORDER BY {$order}";
		}
		
		return (true === $run) ? $this->run() : $this;
	}

	public function asc($field = null, $run = false){
		return $this->orderBy("$field ASC", $run);
	}

	public function desc($field = null, $run = false){
		return $this->orderBy("$field DESC", $run);
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
		} catch (Exception $e) {
			$error = "<br>Não foi possivel executar a query <em><strong>{$this->query}</strong></em>.<br><br> <strong>PDO Message: </strong>{$e->getMessage()}";
			die($error);
		}
	}
}