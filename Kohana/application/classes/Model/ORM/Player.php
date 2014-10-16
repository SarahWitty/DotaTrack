<?php defined('SYSPATH') or die('No direct script access.');

class Model_ORM_Player extends ORM
{
	protected $_table_name = 'player';
	protected $_primary_key = 'playerId';
	
	protected $_has_many = array(
		'Player_Performance' => array(
			'model' => 'ORM_Performance',
			'foreign_key' => 'playerId',
		),
	);
	
	protected $_table_columns = array(
		'playerId' =>  array('type'=>'int'),
	);
	
	public function rules(){
		return array(
			'playerId' => array(
				array('not_empty'),
			),
		);
	}
}

?>