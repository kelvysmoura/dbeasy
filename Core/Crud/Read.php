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

	public function Fields($fields = "*", $run = false){
		$this->fields = $fields;
		$this->query = "SELECT {$this->fields} FROM {$this->tbname}";

		return (true === $run) ? $this->Run() : $this;
	}

	public function Id($id = null, $colname = 'id', $run = false){
		if(!is_null($id)){
			$this->query .= " WHERE {$colname} = ?";
			$this->active['id'] = true;
			array_push($this->binds, $id);
		}

		return (true === $run) ? $this->Run() : $this;
	}

	public function Wh($field = null, $val = null, $run = false){
		if(!is_null($field) && !is_null($val)){
			if($this->active['id'] === false){
				$field_operation = $this->WhatOperation($field);
				$this->query .= " WHERE {$field_operation} ?";
				$this->active['wh'] = true;
				array_push($this->binds, $val);
			}
		}

		return (true === $run) ? $this->Run() : $this;
	}

	public function Andwh($field = null, $val = null, $run = false){
		if(!is_null($field) && !is_null($val)){
			if($this->active['wh'] === true OR $this->active['id'] === true){
				$field_operation = $this->WhatOperation($field);
				$this->query .= " AND {$field_operation} ?";
				$this->active['andwh'] = true;
				array_push($this->binds, $val);
			}
		}

		return (true === $run) ? $this->Run() : $this;
	}

	public function Orwh($field = null, $val = null, $run = false){
		if(!is_null($field) && !is_null($val)){
			if($this->active['wh'] === true OR $this->active['id'] === true){
				$field_operation = $this->WhatOperation($field);
				$this->query .= " OR {$field_operation} ?";
				$this->active['orwh'] = true;
				array_push($this->binds, $val);
			}
		}

		return (true === $run) ? $this->Run() : $this;
	}

	public function Limit($limit = null, $run = false){
		if(!is_null($limit)){
			$this->query .= " LIMIT {$limit}";
			$this->active['limit'] = true;
		}
	
		return (true === $run) ? $this->Run() : $this;
	}

	public function Offset($off = null, $run = false){
		if(!is_null($off) && $this->active['limit'] === true){
			$this->query .= " OFFSET {$off}";
		}
		
		return (true === $run) ? $this->Run() : $this;
	}

	public function OrderBy($order = null, $run = false){
		if(!is_null($order)){
			$this->query .= " ORDER BY {$order}";
		}
		
		return (true === $run) ? $this->Run() : $this;
	}

	public function Asc($field = null, $run = false){
		return $this->orderBy("$field ASC", $run);
	}

	public function Desc($field = null, $run = false){
		return $this->orderBy("$field DESC", $run);
	}

	public function Run(){
		try {
			$run = Connection::Prepare($this->query);
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