class performance extends ORM
{
	Database::$default = 'dotatrack';
	
	protected $_table_name = 'performance';
	protected $_primary_key = 'matchId';
	
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
			'kill' => array(
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