<?php defined('SYSPATH') or die('No direct script access.');

class Model_ORM_Item extends ORM
{
	protected $_table_name = 'items';
	protected $_primary_key = 'id';
	
	protected $_has_many = array(
		'Performance' => array(
			'model' => 'ORM_Performance',
			'foreign_key' => 'item0',
			'foreign_key' => 'item1',
			'foreign_key' => 'item2',
			'foreign_key' => 'item3',
			'foreign_key' => 'item4',
			'foreign_key' => 'item5',
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