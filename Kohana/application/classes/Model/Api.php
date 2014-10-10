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
	
		$requestAddress = "https://api.steampowered.com/IDOTA2Match_570/GetMatchDetails/v001" .
		"/?key=448EF5FD8D44DDC1C6A6B07437D20FFE&match_id=" . $matchId;
		
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
	

///////////////////////////////////////PARSING API DATA////////////////////////////////////////////////////
	
	// Should call parse_player_performance 10 times (once for each player in the match)
	// Should grab the match specific data from the end of the JSON
	// Returns the results as an associative array to feed into the database
	private function parse_match_data(array $rawMatchData) {
		$parsedMatchData = array();
		$internalPlayers = array();
		
		$parsedMatchData["matchId"] = $rawMatchData['match_id'];
		$parsedMatchData["duration"] = $rawMatchData['duration'];
		$parsedMatchData["result"] = $rawMatchData['radiant_win'];
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
		
		$parsedPlayerData["playerSlot"] = $rawPlayerData["player_slot"];
		$parsedPlayerData["playerId"] = $rawPlayerData["account_id"];
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
	
	// Will return the most recent 25 matches for a given player ID.
	public function get_match_history($playerId) {
	
		//https://api.steampowered.com/IDOTA2Match_570/GetMatchHistory/v001/ //Base URL
		//?key=448EF5FD8D44DDC1C6A6B07437D20FFE                              //Key
		//&player_id=<playerId>                                              //PlayerID
		
		$requestAddress = "https://api.steampowered.com/IDOTA2Match_570/GetMatchHistory/v001/" .
		"?key=448EF5FD8D44DDC1C6A6B07437D20FFE&player_id=" . $playerId;
		
		//$matchHistory = Request::factory($requestAddress);
		$matchHistory = file_get_contents($requestAddress);
		return $matchHistory;
	}	
	
	// Will return public data from a single steam user's profile
	public function get_player_summaries($steamId) {
	
		//http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/ //Base URL
		//?key=448EF5FD8D44DDC1C6A6B07437D20FFE                            //Key
		//&steamids=<steamID>                                              //SteamID
		
		$requestAddress = "http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/" .
		"?key=448EF5FD8D44DDC1C6A6B07437D20FFE&steamids=" . $steamId;
	
		//$playerSummary = Request::factory($requestAddress);
		$playerSummary = file_get_contents($requestAddress);
		return $playerSummary;
	}
	
	// Overloads get_player_summaries and will return public data from a given list of steam IDs
	public function get_multiple_player_summaries($steamId) {
	
		//http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/ //Base URL
		//?key=448EF5FD8D44DDC1C6A6B07437D20FFE                            //Key
		//&steamids=<steamID>,<steamID>(,<steamID>)*                       //SteamID
		
		$requestAddress = "http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/" .
		"?key=448EF5FD8D44DDC1C6A6B07437D20FFE&steamids=";
		foreach ($steamId as &$id) {
		$requestAddress .= $id;
		}
	
		//$playerSummary = Request::factory($requestAddress);
		$playerSummary = file_get_contents($requestAddress);
		return $playerSummary;
	}
}

?>