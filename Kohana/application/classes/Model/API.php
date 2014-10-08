<?php defined('SYSPATH') OR die('No Direct Script Access');

class Model_API extends Model
{

	// Unused at the moment.
    public function do_stuff()
    {
        // This is where you do domain logic...
    }
 
 
	// Unused at the moment.
    public function get_stuff()
    {
        // Get stuff from the database:
        //return $this->db->query(...);
    }
	
	
	// Will return the match details for a given match ID.
	public function get_match_details($matchId) {
	
		//https://api.steampowered.com/IDOTA2Match_570/GetMatchDetails/v001/ //Base URL
		//?key=448EF5FD8D44DDC1C6A6B07437D20FFE                              //Key
		//&match_id=<MatchID>                                                //MatchID
		
		$requestAddress = "https://api.steampowered.com/IDOTA2Match_570/GetMatchDetails/v001" .
		"/?key=448EF5FD8D44DDC1C6A6B07437D20FFE&match_id=" . $matchId;
		
		//$matchDetails = Request::factory($requestAddress);
		$matchDetails = file_get_contents($requestAddress);
		return $matchDetails;
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
	
	
	// Will return the names and IDs of every hero in the specified language.
	// Do we support other languages? If so, add $language to the parameters.
	public function get_heroes() {
	
		//https://api.steampowered.com/IEconDOTA2_570/GetHeroes/v0001/ //Base URL
		//?key=448EF5FD8D44DDC1C6A6B07437D20FFE                        //Key
		//&language=<language>            default is: en_us            //Language for Hero Names
		
		$language = "en_us"; //Default, clear if we need to support other languages.
		$requestAddress = "https://api.steampowered.com/IEconDOTA2_570/GetHeroes/v0001/" .
		"?key=448EF5FD8D44DDC1C6A6B07437D20FFE&language=" . $language;
		
		//$heroes = Request::factory($requestAddress);
		$heroes = file_get_contents($requestAddress);
		return $heroes;
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
	public function get_player_summaries($steamId) {
	
		//http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/ //Base URL
		//?key=448EF5FD8D44DDC1C6A6B07437D20FFE                            //Key
		//&steamids=<steamID>,<steamID>(,<steamID>)*                       //SteamID
		
		$requestAddress = "http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/" .
		"?key=448EF5FD8D44DDC1C6A6B07437D20FFE&steamids=";
		foreach ($steamId as &$id) {
		$requestAddress .= $id);
		}
	
		//$playerSummary = Request::factory($requestAddress);
		$playerSummary = file_get_contents($requestAddress);
		return $playerSummary;
	}
	
	// Will return 64-bit steamID for a given Vanity URL
	public function resolve_vanity_url($vanityName) {
		
		//http://api.steampowered.com/ISteamUser/ResolveVanityURL/v0001/ //Base URL
		//?key=448EF5FD8D44DDC1C6A6B07437D20FFE                          //Key
		//&vanityurl=<vanityName>                                         //Vanity Name
		
		$requestAddress = "http://api.steampowered.com/ISteamUser/ResolveVanityURL/v0001/" .
		"?key=448EF5FD8D44DDC1C6A6B07437D20FFE&vanityurl=" . $vanityName;
		
		//$vanityURL = Request::factory($requestAddress);
		$vanityURL = file_get_contents($requestAddress);
		return $vanityURL;
	}
}

?>