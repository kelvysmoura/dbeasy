<?php 

namespace Core\Trace;

trait Helper{

	protected function WhatOperation($field){
		return strstr($field, '>=') ? $field : (
					strstr($field, '<=') ? $field : (
						strstr($field, '>') ? $field : (
							strstr($field, '<') ? $field : "$field ="
						)
					)
				);
	}
}