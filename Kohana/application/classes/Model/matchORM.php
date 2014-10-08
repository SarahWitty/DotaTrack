class match extends ORM
{
	Database::$default = 'dotatrack';
	
	protected $_table_name = 'match';
	protected $_primary_key = 'matchId';
	
	public function rules(){
		return array(
			'matchId' => array(
				array('not_empty'),
				array('min_length', array(':value', 1)),
				array('max_length', array(':value', 10)),
			),
			'skillLevel' => array(
				array('not_empty'),
				array('length', array(':value', 1)),
			),
			'duration' => array(
				array('not_empty'),
				array('min_length', array(':value', 1)),
			),
			'result' => array(
				array('not_empty'),
				array('length', array(':value', 1)),
			),
			'gameMode' => array(
				array('not_empty'),
				array('min_length', array(':value', 1)),
				array('max_length', array(':value', 2)),
			),
			'region' => array(
				array('not_empty'),
				array('length', array(':value', 3)),
			),
			'date' => array(
				array('not_empty'),
			),
			'matchType' => array(
				array('not_empty'),
				array('length', array(':value', 1)),
			),			
		);
	}
}