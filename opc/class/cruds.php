<?php
/**
 * User: Hansz
 * Date: 1/4/2016
 * Time: 16:37
 */
class CM extends Crud{
	protected  $table;
	protected  $pk;
	public function __construct($table,$id)
	{
		$this->table = $table;
		$this->pk = $id;
		parent::__construct();
	}
}