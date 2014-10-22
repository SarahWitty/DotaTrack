<?php defined('SYSPATH') or die('No direct script access.');

class Model_DotaTrackDatabase extends Model
{
	//join to performance table through matchId
	protected function internalGetMatchData($matchId)
	{
		$match = ORM::factory ('ORM_Match', $matchId);
		$performances = $match->Performances->find_all()->as_array();
		$performances_array = array();
		foreach($performances as $performance){
			array_push($performances_array, $performance->as_array());
		}
		$match_array = $match->as_array();
		$match_array['performances'] = $performances_array;

		return $match_array;
	}
	
	public static function internalGetMatchList($criteria)
	{
		$query = DB::select()->from('matches')
			->join('performance')->on('matches.matchId', '=', 'performance.matchId' );
		foreach($criteria as $requirementArray) {
			$field = $requirementArray[0];
			$operand = $requirementArray[1];
			$value = $requirementArray[2];

			$query = $query->where($field, $operand, $value);
		}
		$results = $query->execute()->as_array();
		$matches_array = array();

		foreach($results as $result) {
			$performance = array();
			$performance['performanceId'] = $result['performanceId'];
			$performance['playerId'] = $result['playerId'];
			$performance['level'] = $result['level'];
			$performance['hero'] = $result['hero'];
			$performance['kills'] = $result['kills'];
			$performance['deaths'] = $result['deaths'];
			$performance['assists'] = $result['assists'];
			$performance['lastHits'] = $result['lastHits'];
			$performance['denies'] = $result['denies'];
			$performance['xpm'] = $result['xpm'];
			$performance['gpm'] = $result['gpm'];
			$performance['heroDamage'] = $result['heroDamage'];
			$performance['towerDamage'] = $result['towerDamage'];
			$performance['item0'] = $result['item0'];
			$performance['item1'] = $result['item1'];
			$performance['item2'] = $result['item2'];
			$performance['item3'] = $result['item3'];
			$performance['item4'] = $result['item4'];

			if(array_key_exists($result['matchId'], $matches_array)){
				$resultMatchId = $result['matchId'];
				if(!isset($matches_array[$resultMatchId])){
					$matches_array[$result['matchId']] = array();
				}
				array_push($matches_array[$result['matchId']]['playerPerformance'], $performance);
			} else {
				$match = array();
				$match['matchId'] = $result['matchId'];
				$match['skillLevel'] = $result['skillLevel'];
				$match['duration'] = $result['duration'];
				$match['result'] = $result['result'];
				$match['gameMode'] = $result['gameMode'];
				$match['region'] = $result['region'];
				$match['date'] = $result['date'];
				$match['matchType'] = $result['matchType'];
				$matches_array[$result['matchId']] = $match;

				$matches_array[$result['matchId']]['playerPerformance'] = array();
				array_push($matches_array[$result['matchId']]['playerPerformance'], $performance);
			}
		}
		return $matches_array;
	}

	//join Perfmance and matches on the id and filter results based on critera
	protected function internalGetStatistics($projection, $criteria)
	{
		$query = DB::select()->from('matches')
			->join('performance')->on('matches.matchId', '=', 'performance.matchId' );
		foreach($criteria as $requirementArray) {
			$field = $requirementArray[0];
			$operand = $requirementArray[1];
			$value = $requirementArray[2];

			$query = $query->where($field, $operand, $value);
		}
		
		foreach($projection as $selected => $order){
			$query->order_by($selected, $order);
		}
		
		$results = $query->execute()->as_array();
		$results_array = array();
		
		foreach($results as $result) {
			$record_array = array();
			foreach($projection as $selected => $order){
				//$record_array[$selected] = $result[$selected];
				array_push($record_array, $result[$selected]);
			}
			array_push($results_array, $record_array);
		}
		return $results_array;
	}

	protected function internalSetMatchList($matchList){
			foreach($matchList as $match){
			$matches = ORM::factory('ORM_Match');
			$matches
				->values($match, array('matchId','skillLevel','duration','result','gameMode','region','date','matchType'))
				->create();
			foreach($match['playerPerformance'] as $perform){	
				$performance = ORM::factory('ORM_Performance');
				$player = ORM::factory('ORM_Player');				
				
				$performance
					->values($perform)->create();
				$player->playerId = $perform['playerId'];
				$player->save();
			}
		}
	}
}

?>
