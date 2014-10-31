<?php defined('SYSPATH') or die('No direct script access.');

class Model_ORM_Hero extends ORM
{
	protected $_table_name = 'hero';
	protected $_primary_key = 'heroId';
	
	protected $_has_many = array(
		'Player_Performance' => array(
			'model' => 'ORM_Performance',
			'foreign_key' => 'hero',
		),
	);
	
	protected $_table_columns = array(
		'heroId' =>  array('type'=>'int'),
		'heroName' =>  array('type'=>'varchar'),
	);
	
	public function rules(){
		return array(
			'heroId' => array(
				array('not_empty'),
			),
			'heroName' => array(
				array('not_empty'),
			),
		);
	}
}

?>