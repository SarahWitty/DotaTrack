<?php defined('SYSPATH') or die('No direct script access.');

class Model_DotaTrackDatabase extends Model_DotaTrack
{
	private $ambiguousFields = array('matchId');

	//join to performance table through matchId
	protected function internal_get_match_data($matchId)
	{
		$match = ORM::factory ('ORM_Match', $matchId);
		$performances = $match->Performances->find_all()->as_array();
		$performances_array = array();
		foreach($performances as $performance){
			array_push($performances_array, $performance->as_array());
		}
		$match_array = $match->as_array();
		$match_array['playerPerformance'] = $performances_array;

		return $match_array;
	}

	protected function internal_get_hero_data($heroId)
	{
		$hero = ORM::factory('ORM_Hero', $heroId);
		$hero_array = array();
		$hero_array = $hero->as_array();

		return $hero_array;
	}

	protected function internal_get_mode_data($modeId)
	{
		$mode = ORM::factory('ORM_Mode', $modeId);
		$mode_array = array();
		$mode_array = $mode->as_array();

		return $mode_array;
	}

	protected function internal_get_lobby_data($lobbyId)
	{
		$lobby = ORM::factory('ORM_Lobby', $lobbyId);
		$lobby_array = array();
		$lobby_array = $lobby->as_array();

		return $lobby_array;
	}

	protected function internal_get_item_data($itemId)
	{
		$item = ORM::factory('ORM_Item', $itemId);
		$item_array = array();
		$item_array = $item->as_array();

		return $item_array;
	}
	
	protected function internal_get_match_list($criteria)
	{
		$query = DB::select()->from('matches')
			->join('performance')->on('matches.matchId', '=', 'performance.matchId' );
		foreach($criteria as $requirementArray) {
			$field = $requirementArray[0];
			$operand = $requirementArray[1];
			$value = $requirementArray[2];
	
			if(in_array($field, $this->ambiguousFields))
			{
				$field = "matches.$field";
			}

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
			$performance['slot'] = $result['slot'];

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
	protected function internal_get_statistics($projection, $criteria)
	{
		$query = DB::select()->from('matches')
			->join('performance')->on('matches.matchId', '=', 'performance.matchId' );
		foreach($criteria as $requirementArray) {
			$field = $requirementArray[0];
			$operand = $requirementArray[1];
			$value = $requirementArray[2];

			if(in_array($field, $this->ambiguousFields))
			{
				$field = "matches.$field";
			}

			$query = $query->where($field, $operand, $value);
		}

		foreach($projection as $selected => $order){
			if($order != 'Not')
				$query->order_by($selected, $order);
		}

		$results = $query->execute()->as_array();
		$results_array = array();

		foreach($results as $result) {
			$record_array = array();
			foreach($projection as $selected => $order){
				$record_array[$selected] = $result[$selected];
				//array_push($record_array, $result[$selected]);
			}
			array_push($results_array, $record_array);
		}
		return $results_array;
	}

	protected function internal_get_player_data($criteria)
	{
		$query = DB::select()->from('player');
		foreach($criteria as $requirementArray) {
			$field = $requirementArray[0];
			$operand = $requirementArray[1];
			$value = $requirementArray[2];

			$query = $query->where($field, $operand, $value);
		}
		$results = $query->execute()->as_array();

		return $results;
	}

	protected function internal_add_match_list($matchList){
		$log = Log::instance();
		foreach($matchList as $match){
			$log->add(Log::DEBUG, "Sarah: Adding match (".$match['matchId'].")");
			$matches = ORM::factory('ORM_Match',$match['matchId']);
			if(!$matches->loaded())
			{
				$matches
					->values($match, array('matchId','skillLevel','duration','result','gameMode','region','date','matchType'))
					->create();
				foreach($match['playerPerformance'] as $perform){
					$performance = ORM::factory('ORM_Performance');
					$player = ORM::factory('ORM_Player', $perform['playerId']);

					$performance->matchId = $matches->matchId;

					$performance
						->values($perform)->create();

					// if(!$player->loaded())
					// {
						// $player->playerId = $perform['playerId'];
						// $player->save();
						// $player->values($perform)->create();
					// }
				}
			}
		}
		return true;
	}

	protected function internal_update_match_data($matchId, $matchData){
		//takes $critera is the matchId and matchData is an array of things that need updated.
		foreach($matchData as $matchInfo){
			$matches = ORM::factory('ORM_Match')->where('matchId', '=', $matchId)->find();//, $matchId);
			if($matchInfo == 'playerPerformance'){
				foreach($matchData['playerPerformance'] as $selectedPerformance){
					$performance = ORM::factory('ORM_Performance', $selectedPerformance['performanceId']);
					if($performance->loaded()){
						$performance->matchId = $matchId;
						$performance
							->values($selectedPerformance);
						$performance->update();
					} else {
						Debug::vars('performance update failed');

					}
				}
			}else{
				if($matches->loaded()){
					$matches->values($matchData);
					$matches->update();
				} else {
					Debug::vars('match update fail');
				}
			}
		}
		return true;
	}
	protected function internal_update_player_data($playerId, $playerData){
		//takes $critera is the playerId and playerData is an array of things(the playerId) that need updated.
		foreach($playerData as $playerInfo){
			$player = ORM::factory('ORM_Player')->where('playerId', '=', $playerId)->find();
			if($player->loaded()){
				$player->values($playerData);
				//$player->playerId = $playerInfo['playerId'];
				$player->update();
			}else {
					Debug::vars('match update fail');
			}
		}
		return true;
	}
}

?>
