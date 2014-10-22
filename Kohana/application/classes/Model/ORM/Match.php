<?php defined('SYSPATH') or die('No direct script access.');

class Model_ORM_Match extends ORM
{
	protected $_table_name = 'matches';
	protected $_primary_key = 'matchId';
	
	protected $_has_many = array(
		'Performances' => array(			
			'foreign_key' => 'matchId',
			'model' => 'ORM_Performance',
			'far_key' => 'performanceId'
		),
	);
	
	protected $_table_columns = array(
		'matchId' =>  array('type'=>'int'),
		'skillLevel' =>  array('type'=>'int'),
		'duration' =>  array('type'=>'int'),
		'result' =>  array('type'=>'tinyint'),
		'gameMode' =>  array('type'=>'int'),
		'region' =>  array('type'=>'int'),
		'date' =>  array('type'=>'date'),
		'matchType' =>  array('type'=>'int'),
	);
	
	public function rules(){
		return array(
			'matchId' => array(
				array('not_empty'),
			),
			/*'skillLevel' => array(
				array('not_empty'),
			),
			'duration' => array(
				array('not_empty'),
				array('min_length', array(':value', 1)),
			),
			'result' => array(
				array('not_empty'),
			),
			'gameMode' => array(
				array('not_empty'),
				array('min_length', array(':value', 1)),
				array('max_length', array(':value', 2)),
			),
			'region' => array(
				array('not_empty'),
			),
			'date' => array(
				array('not_empty'),
			),
			'matchType' => array(
				array('not_empty'),
			),*/			
		);
	}
}

?>