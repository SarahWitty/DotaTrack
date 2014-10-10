<?php defined('SYSPATH') or die('No direct script access.');

class Model_ORM_Performance extends ORM
{
	protected $_table_name = 'performance';
	protected $_primary_key = 'matchId';
	
	protected $_table_columns = array(
		'matchId' =>  array('type'=>'int'),
		'level' =>  array('type'=>'int'),
		'hero' =>  array('type'=>'int'),
		'kills' =>  array('type'=>'int'),
		'deaths' =>  array('type'=>'int'),
		'assists' =>  array('type'=>'int'),
		'lastHits' =>  array('type'=>'int'),
		'denies' =>  array('type'=>'int'),
		'xpm' =>  array('type'=>'int'),
		'gpm' =>  array('type'=>'int'),
		'heroDamage' =>  array('type'=>'int'),
		'towerDamage' =>  array('type'=>'int'),
		'item0' =>  array('type'=>'int'),
		'item1' =>  array('type'=>'int'),
		'item2' =>  array('type'=>'int'),
		'item3' =>  array('type'=>'int'),
		'item4' =>  array('type'=>'int'),
		'item5' =>  array('type'=>'int'),
	);
	
	public function rules(){
		return array(
			'matchId' => array(
				array('not_empty'),
				array('min_length', array(':value', 1)),
				array('max_length', array(':value', 10)),
			),
			'level' => array(
				array('not_empty'),
				array('length', array(':value', 1)),
			),
			'hero' => array(
				array('not_empty'),
			),
			'kills' => array(
				array('not_empty'),
			),
			'deaths' => array(
				array('not_empty'),
			),
			'assists' => array(
				array('not_empty'),
			),
			'lastHits' => array(
				array('not_empty'),
			),
			'denies' => array(
				array('not_empty'),
			),	
			'xpm' => array(
				array('not_empty'),
			),
			'gpm' => array(
				array('not_empty'),
			),
			'heroDamage' => array(
				array('not_empty'),
			),
			'towerDamage' => array(
				array('not_empty'),
			),
			'item0' => array(
				array('not_empty'),
			),
			'item1' => array(
				array('not_empty'),
			),	
			'item2' => array(
				array('not_empty'),
			),	
			'item3' => array(
				array('not_empty'),
			),	
			'item4' => array(
				array('not_empty'),
			),
			'item5' => array(
				array('not_empty'),
			),				
		);
	}
}

?>