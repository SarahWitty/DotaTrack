<?php defined('SYSPATH') OR die('No Direct Script Access');

class Model_API extends Model
{
	//
    public function do_stuff()
    {
        // This is where you do domain logic...
    }
 
    public function get_stuff()
    {
        // Get stuff from the database:
        //return $this->db->query(...);
    }
	
	public function get_match_details($matchId) {
		//https://api.steampowered.com/IDOTA2Match_570/GetMatchDetails/v001/
		//?key=448EF5FD8D44DDC1C6A6B07437D20FFE //Key
		//&match_id=<MatchID> //MatchID
		
		$requestAddress = "https://api.steampowered.com/IDOTA2Match_570/GetMatchDetails/v001" .
		"/?key=448EF5FD8D44DDC1C6A6B07437D20FFE&match_id=" . $matchID;
		$matchDetails = Request::factory($requestAddress);
	}
}

?>