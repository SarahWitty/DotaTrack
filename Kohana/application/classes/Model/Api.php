<?php defined('SYSPATH') OR die('No Direct Script Access');

class Model_Api extends Model
{

///////////////////////////////////////REQUESTS////////////////////////////////////////////////////////////
	
	// Function: internal_get_match_data
	// Purpose: Will return the match details for a given match ID.
	//
	// Input:  int matchId, represents the required match ID
	// Output: matchDataHash, all the data from the requested match in a hash.
	//
	//
	// Request format:
	// https://api.steampowered.com/IDOTA2Match_570/GetMatchDetails/v001/ //Base URL
	//   ?key=448EF5FD8D44DDC1C6A6B07437D20FFE                            //Key
	//   &match_id=<MatchID>                                              //MatchID
	//
	public function internal_get_match_data($matchId) {
		$log = Log::instance();
		//die( print_r($matchId));
		//$matchId = "378075206";
		$log->add(Log::DEBUG, $matchId ."This is the matchId for Sarah");
		$requestAddress = "https://api.steampowered.com/IDOTA2Match_570/GetMatchDetails/v001/" . 
		"?key=448EF5FD8D44DDC1C6A6B07437D20FFE&match_id=" . $matchId;
		$matchDetails = json_decode(file_get_contents($requestAddress),true);
		return $this->parse_match_data($matchDetails['result']);
	}
	
	
	// Function: get_heroes
	// Purpose: Will return the names and IDs of every hero in the specified language.
	// Notes: Do we support other languages? If so, add $language to the parameters.
	//
	// Input:  none
	// Output: heroes, hash file that holds all the heroIDs and localized names
	//
	//
	// Request format:
	// https://api.steampowered.com/IEconDOTA2_570/GetHeroes/v0001/ //Base URL
	//   ?key=448EF5FD8D44DDC1C6A6B07437D20FFE                      //Key
	//   &language=<language>            default is: en_us          //Language for Hero Names
	//
	public function get_heroes() {
		
		$language = "en_us"; //Default value, clear if we need to support other languages.
		$requestAddress = "https://api.steampowered.com/IEconDOTA2_570/GetHeroes/v0001/" .
		"?key=448EF5FD8D44DDC1C6A6B07437D20FFE&language=" . $language;
		
		$heroes = json_decode(file_get_contents($requestAddress),true);
		return $this->parse_hero_data($heroes['result']);
	}
	
	// Function: get_player_summaries
	// Purpose: Will return public data from any number of steam users' profiles
	// Input:  32-bit int SteamID, the user's steamID
	// Output: playerSummary, the needed information from the player summary
	//
	//
	// Request format:
	// http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/ //Base URL
	//   ?key=448EF5FD8D44DDC1C6A6B07437D20FFE                          //Key
	//   &steamids=<steamID>                                            //SteamID
	//
	public function get_player_summaries($steamId) {
		
		$requestAddress = "http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/" .
		"?key=448EF5FD8D44DDC1C6A6B07437D20FFE&steamids=" . $steamId;
	
		$playerSummary = json_decode(file_get_contents($requestAddress),true);
		return $this->parse_player_summaries($playerSummary['response']);
	}
	
	
	// Function: resolve_vanity_url
	// Purpose: Will return 64-bit steamID for a given Vanity URL
	//
	// Input:  String vanityName, represents the vanity name of the given user
	// Output: 64-bit integer steamID64
	//
	//
	// Request format:
	// http://api.steampowered.com/ISteamUser/ResolveVanityURL/v0001/ //Base URL
	//   ?key=448EF5FD8D44DDC1C6A6B07437D20FFE                        //Key
	//   &vanityurl=<vanityName>                                      //Vanity Name
	//
	public function resolve_vanity_url($vanityName) {
		
		$requestAddress = "http://api.steampowered.com/ISteamUser/ResolveVanityURL/v0001/" .
		"?key=448EF5FD8D44DDC1C6A6B07437D20FFE&vanityurl=" . $vanityName;
		
		$SteamID64 = file_get_contents($requestAddress);
		return $SteamID64;
	}
	
	
	
	// Function: get_match_history
	// Purpose: Will return the most recent 500 matches for a given player ID.
	//
	// Input: criteria, an array of criteria in the form (type, operator, value)
	//											e.g. ((playerId,=,114233641),(matchId,>,884421153)
	//						    Note: The only supported criteria are of type playerId and matchId
	// Output: Complete match details for all the requested matches
	//          Note: This takes the following method:
	//				   * Record list of matchIDs for first 100 matches
	//				   * Get id of latest match
	//				   * Call request again with modifier &start_at_match_id=(<latestMatchId> - 1)
	//                 * Repeat until request returns empty (should be the 5th call unless player
	//				        has less than 500 matches)
	//				   * For all matches, run an internal_get_match_data
	//				   * Store all the match data results in a hash
	//				   * Return that metric ton of information and hope our server doesn't break
	//
	//
	// Request format:
	// https://api.steampowered.com/IDOTA2Match_570/GetMatchHistory/v001/ //Base URL
	//   ?key=448EF5FD8D44DDC1C6A6B07437D20FFE                            //Key
	//   &player_id=<playerId>                                            //PlayerID
	//	 &matches_requested=<num_matches>								  //Number of Matches requested
	public function get_match_history($criteria) {
		$log = Log::instance();
		
		// Variable instantiation
		$matchIds = array();     // The list of matches we need to grab
		$matchHistory = array(); // The eventual return. MASSIVE array :(
		$playerId;				 // The criteria for playerId
		$startingMatchId = -1;	 // The match ID at which to start the search Default: -1
		$latestMatch = -1;		 // The most recent match that is stored in the database. Ignore
								 //       all matches past this point. -1 if not necessary.
		$newIds = 1;			 // The return of each request. This will be sent to a search
								 // 	  function that will make sure that we need these ids
								 //		  Default: 1 so it passes into the while loop. This will
								 //		  be overwritten.
		$matchesRequested = -1;  // The number of matches we should ask for in each request
		
		//echo "start time: ";
		//echo date("D M d, Y G:i a");
		
		// Parse criteria
		foreach( $criteria as $value) {
			if ($value[0] == "playerId") {
				$playerId = $value[2];
			}
			if ($value[0] == "matchId") {
				$latestMatch = $value[2];
			}
			if ($value[0] == "matchesRequested") {
				$matchesRequested = $value[2];
			}
		}
		
		$log->add(Log::DEBUG, "API: Criteria loaded.");
		$log->write();
		
		while (!empty($newIds)) {
			//Get list of new IDs
			$newIds = $this->get_match_ids($playerId,$startingMatchId, $matchesRequested);
			
			$log->add(Log::DEBUG, "API: Just got a set of matchIds.");
			$log->write();
			
			//If we are updating the database and don't necessarily need all the match IDs
			if ($latestMatch != -1 && !empty($newIds)) {
				
				// Check if we need to trash anything from this set of values
				if ($newIds[0] < $latestMatch) { //if the beginning of the array is already an unneeded id (we've gone past the ones we need)
					break;
				}
				else if (end($newIds) < $latestMatch) { //otherwise, if we do need at least some of the IDs, drop the unneeded ones
					$newIds = $this->drop_useless_ids($newIds, $latestMatch);
				}
				//else, this set is fine
			}
			
			// If $newIds isn't empty after we pull the matches
			if (!empty($newIds)) {
				// Add the new IDs
				$matchIds = array_merge($matchIds, $newIds);
				// Set the search to look for all matches starting at the last match we found
				
				$newStartingId = array_pop($matchIds);
				
				$log->add(Log::DEBUG, "API: StartingID: " . $startingMatchId . " newStartingID: " . $newStartingId);
				$log->write();
				
				if ($startingMatchId != $newStartingId) {
					$startingMatchId = $newStartingId;
				}
				else {
					break;
				}
			}
			else {
			// Otherwise, break out of the for loop, we're done pulling matches
				break;
			}
		}
		
		// After we have all the match ids, request the data from them
		foreach ($matchIds as $value) {
			// this will be huge, ~500 matches
			array_push ($matchHistory, $this->internal_get_match_data($value));
		}
		
		//echo "   end time: ";
		//echo date("D M d, Y G:i a");
		return $matchHistory;
	}
	
	
///////////////////////////////////////PARSING API DATA////////////////////////////////////////////////////
	
	// Should call parse_player_performance 10 times (once for each player in the match)
	// Should grab the match specific data from the end of the JSON
	// Returns the results as an associative array to feed into the database
	private function parse_match_data(array $rawMatchData) {
		$parsedMatchData = array();
		$internalPlayers = array();
		
		$parsedMatchData["matchId"] = $rawMatchData['match_id'];
		$parsedMatchData["duration"] = $rawMatchData['duration'];
		if ($rawMatchData['radiant_win']) {
			$parsedMatchData["result"] = 1;
		}
		else {
			$parsedMatchData["result"] = 0;
		}		
		$parsedMatchData["gameMode"] = $rawMatchData['game_mode'];
		$parsedMatchData["date"] = $rawMatchData['start_time'];
		$parsedMatchData["matchType"] = $rawMatchData['lobby_type'];
		
		foreach($rawMatchData['players'] as $key => $value) {
			array_push ($internalPlayers, $this->parse_player_performance($value));
		}
		
		$parsedMatchData["playerPerformance"] = $internalPlayers;
		
		return $parsedMatchData;
	}
	
	// Parses the raw match data for all the required information about each player's performance
	// Returns them in an associative array
	private function parse_player_performance($rawPlayerData) {
		$parsedPlayerData = array();
		
		$parsedPlayerData["slot"] = $rawPlayerData["player_slot"];
		if (array_key_exists ('account_id', $rawPlayerData)) {
		$parsedPlayerData["playerId"] = $rawPlayerData["account_id"];
		} else {
		$parsedPlayerData["playerId"] = 0;
		}
		$parsedPlayerData["level"] = $rawPlayerData["level"];
		$parsedPlayerData["hero"] = $rawPlayerData["hero_id"];
		$parsedPlayerData["kills"] = $rawPlayerData["kills"];
		$parsedPlayerData["deaths"] = $rawPlayerData["deaths"];
		$parsedPlayerData["assists"] = $rawPlayerData["assists"];
		$parsedPlayerData["lastHits"] = $rawPlayerData["last_hits"];
		$parsedPlayerData["denies"] = $rawPlayerData["denies"];
		$parsedPlayerData["xpm"] = $rawPlayerData["xp_per_min"];
		$parsedPlayerData["gpm"] = $rawPlayerData["gold_per_min"];
		$parsedPlayerData["heroDamage"] = $rawPlayerData["hero_damage"];
		$parsedPlayerData["towerDamage"] = $rawPlayerData["tower_damage"];
		$parsedPlayerData["item0"] = $rawPlayerData["item_0"];
		$parsedPlayerData["item1"] = $rawPlayerData["item_1"];
		$parsedPlayerData["item2"] = $rawPlayerData["item_2"];
		$parsedPlayerData["item3"] = $rawPlayerData["item_3"];
		$parsedPlayerData["item4"] = $rawPlayerData["item_4"];
		$parsedPlayerData["item5"] = $rawPlayerData["item_5"];
		
		return $parsedPlayerData;
	}
	
	// Calls parse_hero for each hero in the raw hero data from the API
	// Stores the parsed information to send to the database (NOT IMPLEMENTED YET)
	private function parse_hero_data($rawHeroData) {
		$parsedHeroData = array();
		
		foreach($rawHeroData['heroes'] as $key => $value) {
			array_push ($parsedHeroData, $this->parse_hero($value));
		}
		
		return $parsedHeroData;
	}
	
	// Parses the data and returns it to the calling function
	private function parse_hero($heroData) {
		$heroInfo = array();
		
		$heroInfo["heroId"] = $heroData["id"];
		$heroInfo["heroName"] = $heroData["localized_name"];
		
		return $heroInfo;
	}
	
	// Takes a json file of player summaries, gets them parsed, and then returns them
	private function parse_player_summaries($rawPlayerSummaries) {
		$playerData = array();
		
		foreach ($rawPlayerSummaries["players"] as $player) {
			$playerData['nickname'] = $player['personaname'];
			$playerData['avatar'] = $player['avatar'];
		}
		
		return $playerData;
	}
	
	// Parses each player summary and returns the player's name and avatar address
	private function parse_summary($rawPlayerData) {
		$playerSummary = array();
		
		
		return $playerSummary;
	}
	
	
	private function get_match_ids($playerId, $startingMatchId, $matchesRequested) {
		$log = Log::instance();
		$ids = array();
	
		// Set Request address
		$requestAddress = "https://api.steampowered.com/IDOTA2Match_570/GetMatchHistory/V001/?key=448EF5FD8D44DDC1C6A6B07437D20FFE&account_id=" . $playerId;
		// Add the option for finding matches past the first page if necessary
		if ($startingMatchId != -1) {
			$requestAddress = $requestAddress . "&start_at_match_id=$startingMatchId";
		}
		if ($matchesRequested != -1) {
			$requestAddress = $requestAddress . "&matches_requested=$matchesRequested";
		}
		
		$log->add(Log::DEBUG, "API: Request Address Set:" . $requestAddress);
		$log->write();
		
		// Send request to parser
		$rawData = json_decode(file_get_contents($requestAddress),true);
		
		$log->add(Log::DEBUG, "API: rawData loaded.");
		$log->write();
		
		$ids = $this->parse_ids($rawData['result']);
		
		$log->add(Log::DEBUG, "API: rawData parsed.");
		$log->write();
		
		return $ids;
	}
	
	
	private function parse_ids($rawData) {
		$idList = array();
		
		// Grab the ids from the raw data
		foreach($rawData['matches'] as $match) {
			array_push ($idList, $match["match_id"]);
		}
		
		return $idList;
	}
	
	private function drop_useless_ids($idList, $latest) {
	
		//$lastGoodIdIndex = $this->find_last_good_id($idList, floor((count($idList)/2)), $latest); //more efficient but throws server errors.
		
		$lastGoodIdIndex = array_search($latest, $idList);
		$idList = array_slice($idList, 0, $lastGoodIdIndex + 1);
		
		return $idList;
	}
	
	//NOTE: This function currently throws a server error for some reason. Am I not allowed to make recursive
	//       functions? I'll come back to this later.
	private function find_last_good_id($ids, $spot, $latest) {
		
		if ($ids[$spot] > $latest) {
			echo " right " . $spot . "| ";
			return $this->find_last_good_id($ids, floor((count($ids) - $spot)/2) + $spot, $latest);
		}
		else if ($ids[$spot] < $latest) {
			echo " left " . $spot . "| ";
			return $this->find_last_good_id($ids, floor((count($ids) - $spot)/2), $latest);
		}
		else {
			echo "correct";
			return $spot;
		}
	}
}
?>