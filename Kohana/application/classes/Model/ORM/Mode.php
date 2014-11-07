<?php defined('SYSPATH') or die('No direct script access.');

class Model_ORM_Mode extends ORM
{
	protected $_table_name = 'mode';
	protected $_primary_key = 'id';
	
	protected $_has_many = array(
		'Matches' => array(
			'model' => 'ORM_Match',
			'foreign_key' => 'gameMode',
		),
	);
	
	protected $_table_columns = array(
		'id' =>  array('type'=>'int'),
		'name' =>  array('type'=>'varchar'),
	);
	
	public function rules(){
		return array(
			'id' => array(
				array('not_empty'),
			),
			'name' => array(
				array('not_empty'),
			),
		);
	}
}

?>