class player extends ORM
{
	Database::$default = 'dotatrack';
	
	protected $_table_name = 'player';
	protected $_primary_key = 'playerId';
	
	public function rules(){
		return array(
			'playerId' => array(
				array('not_empty'),
			),
		);
	}
}