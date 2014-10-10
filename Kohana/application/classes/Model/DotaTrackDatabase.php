<?php defined('SYSPATH') or die('No direct script access.');

class Model_DotaTrackDatabaseModel extends Model
{
	Database::$default = 'dotatrack';	
	
	protected function internalGetMatchData($matchId)
	{
		return ORM::factory('ORM_Match', $matchId)->as_array();
	}
	
	protected function internalGetMatchList($criteria)
	{
		$query = $Performance;
		foreach($criteria as $field => $value) {
			$query = $query->where($field,'>',$value);
		}
		
		$results = $query->find_all();
		$results_array = array();
		foreach($results as $result) {
			array_push($results_array, $result->as_array());
		}
		$this->template->output = $results_array;
	}

	protected function internalGetStatistics($projection, $criteria, $ordering)
	{
		return array( array() );
	}
}

?>