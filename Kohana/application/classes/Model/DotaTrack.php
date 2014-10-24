<?php defined('SYSPATH') or die('No direct script access.');

class Model_DotaTrack extends Model {

	protected $matchListCriteriaWhitelist;
	protected $matchDataWhitelist;
	protected $performanceWhitelist;
	protected $statisticsProjectionWhitelist;
	protected $statisticsCriteriaWhitelist;
	protected $playerCriteriaWhitelist;
	protected $playerDataWhitelist;

	/**
	 * Gets all the data for a single match.
	 *
	 * DON'T OVERRIDE THIS. Use the internal_get_match_data() function instead.
	 * That will allow us to do security checking in these functions so you
	 * don't have to worry about it.
	 *
	 * @param $matchId The integer ID of the match which should be returned.
	 * Note that this might be zero.
	 *
	 * @return An associative array containing all the information about this
	 * single match. The information that should be included here is indicated
	 * in SRS 2.1.1.
	 */
	public function get_match_data($matchId)
	{
		return $this->internal_get_match_data($matchId);
	}

	/**
	 * Gets all the data for a list of matches meeting the given criteria.
	 *
	 * DON'T OVERRIDE THIS. Use the internal_get_match_data() function instead.
	 * That will allow us to do security checking in these functions so you
	 * don't have to worry about it.
	 *
	 * @param $criteria An associative array containing field names as the keys
	 * and filtering values as the values. We may need to add an operand value
	 * to perform more complex queries of the model. Note, the criteria list
	 * may not be safe from SQL injection attacks; code defensively.
	 *
	 * @return An array of associative arrays containing all the information
	 * about each single match. The information included for each match is
	 * indicated in SRS 2.1.1.
	 */
	public function get_match_list($criteria)
	{
		$sanitizedCriteria = $this->whitelist_match_list_criteria($criteria);

		return $this->internal_get_match_list($sanitizedCriteria);
	}

	/**
	 * Gets indicated statistics for a projection meeting the given criteria.
	 *
	 * Basically allows us to query specific statistics with specific criteria
	 * without having to pass around massive amounts of excess data.
	 *
	 * DON'T OVERRIDE THIS. Use the internal_get_match_data() function instead.
	 * That will allow us to do security checking in these functions so you
	 * don't have to worry about it.
	 *
	 * @param $projection An array that contains a list of field names which
	 * should be included in each row.
	 *
	 * @param $criteria An associative array containing field names as the keys
	 * and filtering values as the values. We may need to add an operand value
	 * to perform more complex queries of the model. Note, the criteria list
	 * may not be safe from SQL injection attacks; code defensively.
	 *
	 * @param $ordering An associative array containing a list of field names
	 * and the corresponding sort criteria (ascending, descending) prioritized
	 * by the order given in the array.
	 *
	 * @return An array of associative arrays containing all the information
	 * specified by the projection array in the order specified by the ordering
	 * array.
	 */
	public function get_statistics($projection, $criteria)
	{
		$sanitizedProjection = $this->whitelist_statistic_projection($projection);
		$sanitizedCriteria = $this->whitelist_statistic_criteria($criteria);

		return $this->internal_get_statistics(
			$sanitizedProjection, $sanitizedCriteria);
	}

	/**
	 * Gets all information about the specified player.
	 *
	 * This function gets all available player data associated with the player
	 * matching the given criteria. In general, this function should be expected to
	 * return no more than one player.
	 *
	 * @param $criteria An array of arrays containing criteria used to identify the
	 * player whose data should be returned. The array takes the standard criteria
	 * format similar to array(array("key", "operator", "value"), etc... ).
	 *
	 * @return An associative array of player information containing all the
	 * information available about the player specified by the criteria.
	 */
	public function get_player_data($criteria)
	{
		$sanitizedCriteria = $this->whitelist_player_criteria($criteria);

		return $this->internal_get_player_data($sanitizedCriteria);
	}

	/**
	 * Adds all information specified in the given match list.
	 *
	 * This function inserts data into the given model. This is only applicable to
	 * models which are writeable. The given match list does not have to specify
	 * all possible match data, but it must at least provide the match id and the
	 * player ids for any given performance data.
	 *
	 * @param $matchList An array of associative arrays containing match data. This
	 * datastructure essentially looks like the return structure of get_match_list().
	 *
	 * @return A boolean indicating if the data was successfully inserted.
	 */
	public function add_match_list($matchList)
	{
		$sanitizedMatchList = $this->whitelist_match_list($matchList);

		return $this->internal_add_match_list($sanitizedMatchList);
	}

	/**
	 * Adds all information specified to the player list.
	 *
	 * This function inserts data into the given model. It is only applicable to
	 * models which are writeable. The given player data should describe a single
	 * player.
	 *
	 * @param $playerData An associative array containing player data. This
	 * datastructure essentially looks like the return structure of
	 * get_player_data().
	 *
	 * @return A boolean indicating if the data was successfully inserted.
	 */
	public function add_player_data($playerData)
	{
		$sanitizedPlayerData = $this->whitelist_player_data($playerData);

		return $this->internal_add_player_data($sanitizedPlayerData);
	}

	/**
	 * Updates a specific match with the given data.
	 *
	 * This function updates a match with the given data. Like addMatchList(), this
	 * function may only be used on models that are writeable.
	 *
	 * @param $matchId The id of the match which should be updated.
	 *
	 * @return A boolean indicating if the data was successfully updated.
	 */
	public function update_match_data($matchId, $matchData)
	{
		$sanitizedMatchData = $this->whitelist_match_data($matchData);

		return $this->internal_update_match_data($matchId, $sanitizedMatchData);
	}

	/**
	 * Updates a specific player with the given data.
	 *
	 * This function updates a player with the given data. Like addPlayerData(),
	 * this function may only be used on models that are writeable. In general,
	 * this function should specify criteria that selects only one player so that
	 * the update will not have unexpected results.
	 *
	 * @param $criteria An array of arrays containing criteria used to identify the player
	 * which should be updated with the given information.
	 *
	 * @return A boolean indicating if the data was successfully updated.
	 */
	public function update_player_data($criteria, $playerData)
	{
		$sanitizedCriteria = $this->whitelist_player_criteria($criteria);
		$sanitizedPlayerData = $this->whitelist_player_data($playerData);

		return $this->internal_update_player_data($sanitizedCriteria, $sanitizedPlayerData);
	}

	/**
	 * Whitelists criteria to prevent injection of invalid criteria into
	 * queries.
	 *
	 * @param $criteria The raw associative array containing field names and
	 * values which will be filtered for harmful input.
	 *
	 * @return A refined version of the criteria containing only valid field
	 * names and values.
	 */
	private function whitelist_match_list_criteria($criteria)
	{
		$sanitizedCriteria = array();

		$sanitizedCriteria = $this->whitelist_general_criteria($criteria, $this->$matchListCriteriaWhitelist);

		return $sanitizedCriteria;
	}

	/**
	 * Whitelists criteria to prevent injection of invalid criteria into
	 * queries.
	 *
	 * If this function ends up duplicating whitelist_match_list_criteria() too
	 * much, we should combine them.
	 *
	 * @param $criteria The raw associative array containing field names and
	 * values which will be filtered for harmful input.
	 *
	 * @return A refined version of the criteria containing only valid field
	 * names and values.
	 */
	private function whitelist_statistic_criteria($criteria)
	{
		$sanitizedCriteria = array();

		$sanitizedCriteria = $this->whitelist_general_criteria($criteria, $this->$statisticsCriteriaWhitelist);

		return $sanitizedCriteria;
	}

	/**
	 * Whitelists the projection array to prevent injection of invalid criteria
	 * into queries.
	 *
	 * @param $projection The raw array containing field names which will be
	 * filtered for harmful input.
	 *
	 * @return A refined version of the projection array containing only valid
	 * field names.
	 */
	private function whitelist_statistic_projection($projection)
	{
		$sanitizedProjection = array();

		$sanitizedProjection = $this->whitelist_general($projection, $this->$statisticsProjectionWhitelist);

		return $sanitizedProjection;
	}

	/**
	 * Whitelists the player criteria to prevent injection of invalid criteria into
	 * queries.
	 *
	 * @param $criteria The raw array containing field names, avlues, and ordering
	 * criteria which will be filtered for harmful input.
	 *
	 * @return A refined version of the ordering array containing only valid
	 * field names, values and ordering criteria.
	 */
	private function whitelist_player_criteria($criteria)
	{
		$sanitizedCriteria = array();

		$sanitizedCriteria = $this->whitelist_general_criteria($criteria, playerCriteriaWhitelist);

		return $sanitizedCriteria;
	}

	/**
	 * Whitelists the match list to prevent injection of invalid data into
	 * queries.
	 *
	 * @param $matchList The raw array of arrays containing field names and corresponding values
	 * which will be filtered for harmful input.
	 *
	 * @return A refined version of the match list array containing only valid
	 * field names and corresponding values.
	 */
	private function whitelist_match_list($matchList)
	{
		$sanitizedMatchList = array();

		foreach($matchList as $match)
		{
			array_push($sanitizedMatchList, $this->whitelist_match_data($match));
		}

		return $sanitizedMatchList;
	}

	/**
	 * Whitelists match data to prevent injection of invalid data into queries.
	 *
	 * @param $matchData The raw associative array containing field names and corresponding values
	 * which will be filtered for harmful input.
	 *
	 * @return A refined version of the match data containing only valid field names
	 * and corresponding values.
	 */
	private function whitelist_match_data($matchData)
	{
		$sanitizedMatchData = array();

		// If the match data contains player performance information
		if(array_key_exists('playerPerformance', $matchData))
		{
			$sanitizedMatchData['playerPerformance'] = array();

			// Iterate through each performance record
			foreach($matchData['playerPerformance'] as $performance)
			{
				// And add the sanitized version to the match data
				array_push($sanitizedMatchData['playerPerformance'], $this->whitelist_general($performance, $this->$performanceWhitelist));
			}
		}

		$sanitizedMatchData = $this->whitelist_general($matchData, $this->$matchDataWhitelist);

		return $sanitizedMatchData;
	}

	/**
	 * Whitelists the player data to prevent injection of invalid data into
	 * queries.
	 *
	 * @param $criteria The raw array containing field names and corresponding values
	 * which will be filtered for harmful input.
	 *
	 * @return A refined version of the ordering array containing only valid
	 * field names and corresponding values.
	 */
	private function whitelist_player_data($playerData)
	{
		$sanitizedPlayerData = array();

		$sanitizedPlayerData = $this->whitelist_general($playerData, $this->$playerDataWhitelist);

		return $sanitizedPlayerData;
	}

	/**
	 * General whitelist function which filters input based on the given whitelist.
	 *
	 * @param $input The input array to be filtered by the whitelist. An associative array.
	 *
	 * @param $whiteList The whitelist array that will filter the input. Given as
	 * an associative array mapping fieldnames to an optional regex to verify input.
	 *
	 * @return A sanitized input array as an associative array.
	 */
	private function whitelist_general($input, $whitelist)
	{
		$sanitizedInput = array();

		foreach($input as $key=>$value)
		{
			// Make sure the key is in the whitelist
			if(array_key_exists($whitelist[$key]))
			{
				// Make sure the value matches the whitelist criteria (if there is any)
				if(isset($whitelist[$key]) && $whitelist[$key] != '' && preg_match($whitelist[$key], $value))
				{
					// Add the value to the sanitized input
					$sanitizedInput[$key] = $value;
				}
				// Value failed to meet input criteria
				else
				{
					Log::instance()->add(Log::DEBUG, "Input value does not match whitelist criteria ('$key' => '$value').");
				}
			}
			// Key is not a valid input
			else
			{
				Log::instance()->add(Log::DEBUG, "Input key does not exist in the whitelist ('$key' => '$value').");
			}
		}

		return $sanitizedInput;
	}

	/**
	* General whitelist function which filters criteria based on the given whitelist.
	*
	* @param $criteria The criteria array to be filtered by the whitelist. An array of arrays.
	*
	* @param $whiteList The whitelist array that will filter the input. Given as
	* an associative array mapping fieldnames to an optional regex to verify input.
	*
	* @return A sanitized input array as an associative array.
	*/
	private function whitelist_general_criteria($criteria, $whitelist)
	{
		$sanitizedCriteria = array();

		// Make sure the key is in the whitelist
		foreach($criteria as $tuple)
		{
			// Used for code understandability
			$field = $tuple[0];
			$comparator = $tuple[1];
			$value = $tuple[2];

			// Make sure the key is in the whitelist
			if(array_key_exists($whitelist[$field]))
			{
				// Make sure the value matches the whitelist criteria (if there is any)
				if(isset($whitelist[$field]) && $whitelist[$field] != '' && preg_match($whitelist[$field]) == 1)
				{
					// Add the value to the sanitized input
					array_push($sanitizedCriteria, $tuple);
				}
				// Value failed to meet input criteria
				else
				{
					Log::instance()->add(Log::DEBUG, "Criteria value does not match whitelist criteria ('$key' => '$value').");
				}
			}
			// Key is not a valid input
			else
			{
				Log::instance()->add(Log::DEBUG, "Criteria key does not exist in the whitelist ('$key' => '$value').");
			}
		}

		return $sanitizedCriteria;
	}

	/**
	 * Gets all the data for a single match.
	 *
	 * OVERRIDE THIS. This function should be implemented however is appropriate
	 * for the implementing Model in order to return the correctly formatted
	 * results. (Tests and examples for the correct structure pending.)
	 *
	 * @param $matchId The integer ID of the match which should be returned.
	 * Note that this might be zero.
	 *
	 * @return An associative array containing all the information about this
	 * single match. The information that should be included here is indicated
	 * in SRS 2.1.1.
	 */
	protected function internal_get_match_data($matchid)
	{
	return array("matchId" => "378075206",
				"skillLevel" => "0",
				"duration" => "2593",
				"result" => "1", // Boolean
				"gameMode" => "1",
				"region" => "0",
				"date" => "2013-11-10 00:00:00", // Date
				"matchType" => "0",
				"playerPerformance" => array(
					array("performanceId" => 1,
						"matchId" => 378075206,
						"playerId" => 2147483647,
						"level" => 25,
						"hero" => 39,
						"kills" => 15,
						"deaths" => 2,
						"assists" => 17,
						"lastHits" => 89,
						"denies" => 11,
						"xpm" => 751,
						"gpm" => 527,
						"heroDamage" => 21050,
						"towerDamage" => 829,
						"item0" => 46,
						"item1" => 96,
						"item2" => 108,
						"item3" => 63,
						"item4" => 123,
						"item5" => 36),
					array("performanceId" => 2,
						"matchId" => 378075206,
						"playerId" => 2147483647,
						"level" => 22,
						"hero" => 9,
						"kills" => 9,
						"deaths" => 4,
						"assists" => 17,
						"lastHits" => 135,
						"denies" => 11,
						"xpm" => 612,
						"gpm" => 559,
						"heroDamage" => 16326,
						"towerDamage" => 4311,
						"item0" => 212,
						"item1" => 147,
						"item2" => 149,
						"item3" => 168,
						"item4" => 46,
						"item5" => 50),
					array("performanceId" => 3,
						"matchId" => 378075206,
						"playerId" => 2147483647,
						"level" => 17,
						"hero" => 5,
						"kills" => 7,
						"deaths" => 6,
						"assists" => 6,
						"lastHits" => 65,
						"denies" => 1,
						"xpm" => 375,
						"gpm" => 363,
						"heroDamage" => 6701,
						"towerDamage" => 892,
						"item0" => 48,
						"item1" => 152,
						"item2" => 108,
						"item3" => 13,
						"item4" => 69,
						"item5" => 0),
					array("performanceId" => 4,
						"matchId" => 378075206,
						"playerId" => 2147483647,
						"level" => 4,
						"hero" => 70,
						"kills" => 0,
						"deaths" => 0,
						"assists" => 1,
						"lastHits" => 4,
						"denies" => 0,
						"xpm" => 24,
						"gpm" => 185,
						"heroDamage" => 269,
						"towerDamage" => 0,
						"item0" => 0,
						"item1" => 0,
						"item2" => 0,
						"item3" => 0,
						"item4" => 0,
						"item5" => 0),
					array("performanceId" => 5,
						"matchId" => 378075206,
						"playerId" => 83414088,
						"level" => 25,
						"hero" => 56,
						"kills" => 22,
						"deaths" => 3,
						"assists" => 6,
						"lastHits" => 118,
						"denies" => 3,
						"xpm" => 750,
						"gpm" => 561,
						"heroDamage" => 25591,
						"towerDamage" => 2035,
						"item0" => 0,
						"item1" => 63,
						"item2" => 141,
						"item3" => 98,
						"item4" => 116,
						"item5" => 135),
					array("performanceId" => 6,
						"matchId" => 378075206,
						"playerId" => 2147483647,
						"level" => 15,
						"hero" => 32,
						"kills" => 7,
						"deaths" => 11,
						"assists" => 3,
						"lastHits" => 38,
						"denies" => 1,
						"xpm" => 302,
						"gpm" => 221,
						"heroDamage" => 17306,
						"towerDamage" => 0,
						"item0" => 71,
						"item1" => 3,
						"item2" => 44,
						"item3" => 63,
						"item4" => 46,
						"item5" => 170),
					array(
						"performanceId" => 7,
						"matchId" => 378075206,
						"playerId" => 2147483647,
						"level" => 14,
						"hero" => 15,
						"kills" => 2,
						"deaths" => 12,
						"assists" => 5,
						"lastHits" => 110,
						"denies" => 9,
						"xpm" => 260,
						"gpm" => 283,
						"heroDamage" => 7460,
						"towerDamage" => 365,
						"item0" => 212,
						"item1" => 63,
						"item2" => 125,
						"item3" => 154,
						"item4" => 0,
						"item5" => 0),
					array("performanceId" => 8,
						"matchId" => 378075206,
						"playerId" => 85595353,
						"level" => 14,
						"hero" => 102,
						"kills" => 0,
						"deaths" => 11,
						"assists" => 5,
						"lastHits" => 60,
						"denies" => 9,
						"xpm" => 241,
						"gpm" => 209,
						"heroDamage" => 2133,
						"towerDamage" => 339,
						"item0" => 50,
						"item1" => 46,
						"item2" => 38,
						"item3" => 166,
						"item4" => 0,
						"item5" => 0),
					array("performanceId" => 9,
						"matchId" => 378075206,
						"playerId" => 2147483647,
						"level" => 13,
						"hero" => 35,
						"kills" => 2,
						"deaths" => 12,
						"assists" => 2,
						"lastHits" => 56,
						"denies" => 0,
						"xpm" => 216,
						"gpm" => 242,
						"heroDamage" => 6784,
						"towerDamage" => 626,
						"item0" => 29,
						"item1" => 36,
						"item2" => 164,
						"item3" => 212,
						"item4" => 24,
						"item5" => 170),
					array("performanceId" => 10,
						"matchId" => 378075206,
						"playerId" => 106977695,
						"level" => 17,
						"hero" => 58,
						"kills" => 3,
						"deaths" => 9,
						"assists" => 2,
						"lastHits" => 92,
						"denies" => 0,
						"xpm" => 389,
						"gpm" => 261,
						"heroDamage" => 3452,
						"towerDamage" => 623,
						"item0" => 121,
						"item1" => 63,
						"item2" => 40,
						"item3" => 23,
						"item4" => 0,
						"item5" => 42)
					)
				);
	}

	/**
	 * Gets all the data for a list of matches meeting the given criteria.
	 *
	 * OVERRIDE THIS. This function should be implemented however is appropriate
	 * for the implementing Model in order to return the correctly formatted
	 * results. (Tests and examples for the correct structure pending.)
	 *
	 * @param $criteria An associative array containing field names as the keys
	 * and filtering values as the values. We may need to add an operand value
	 * to perform more complex queries of the model. While the criteria should
	 * be sanitized, code defensively.
	 *
	 * @return An array of associative arrays containing all the information
	 * about each single match. The information included for each match is
	 * indicated in SRS 2.1.1.
	 */
	protected function internal_get_match_list($criteria)
	{
		return array(
			array("matchId" => "378075206",
						"skillLevel" => "0",
						"duration" => "2593",
						"result" => "1", // Boolean
						"gameMode" => "1",
						"region" => "0",
						"date" => "2013-11-10 00:00:00", // Date
						"matchType" => "0",
						"playerPerformance" => array(
							array("performanceId" => 1,
								"matchId" => 378075206,
								"playerId" => 2147483647,
								"level" => 25,
								"hero" => 39,
								"kills" => 15,
								"deaths" => 2,
								"assists" => 17,
								"lastHits" => 89,
								"denies" => 11,
								"xpm" => 751,
								"gpm" => 527,
								"heroDamage" => 21050,
								"towerDamage" => 829,
								"item0" => 46,
								"item1" => 96,
								"item2" => 108,
								"item3" => 63,
								"item4" => 123,
								"item5" => 36),
							array("performanceId" => 2,
								"matchId" => 378075206,
								"playerId" => 2147483647,
								"level" => 22,
								"hero" => 9,
								"kills" => 9,
								"deaths" => 4,
								"assists" => 17,
								"lastHits" => 135,
								"denies" => 11,
								"xpm" => 612,
								"gpm" => 559,
								"heroDamage" => 16326,
								"towerDamage" => 4311,
								"item0" => 212,
								"item1" => 147,
								"item2" => 149,
								"item3" => 168,
								"item4" => 46,
								"item5" => 50),
							array("performanceId" => 3,
								"matchId" => 378075206,
								"playerId" => 2147483647,
								"level" => 17,
								"hero" => 5,
								"kills" => 7,
								"deaths" => 6,
								"assists" => 6,
								"lastHits" => 65,
								"denies" => 1,
								"xpm" => 375,
								"gpm" => 363,
								"heroDamage" => 6701,
								"towerDamage" => 892,
								"item0" => 48,
								"item1" => 152,
								"item2" => 108,
								"item3" => 13,
								"item4" => 69,
								"item5" => 0),
							array("performanceId" => 4,
								"matchId" => 378075206,
								"playerId" => 2147483647,
								"level" => 4,
								"hero" => 70,
								"kills" => 0,
								"deaths" => 0,
								"assists" => 1,
								"lastHits" => 4,
								"denies" => 0,
								"xpm" => 24,
								"gpm" => 185,
								"heroDamage" => 269,
								"towerDamage" => 0,
								"item0" => 0,
								"item1" => 0,
								"item2" => 0,
								"item3" => 0,
								"item4" => 0,
								"item5" => 0),
							array("performanceId" => 5,
								"matchId" => 378075206,
								"playerId" => 83414088,
								"level" => 25,
								"hero" => 56,
								"kills" => 22,
								"deaths" => 3,
								"assists" => 6,
								"lastHits" => 118,
								"denies" => 3,
								"xpm" => 750,
								"gpm" => 561,
								"heroDamage" => 25591,
								"towerDamage" => 2035,
								"item0" => 0,
								"item1" => 63,
								"item2" => 141,
								"item3" => 98,
								"item4" => 116,
								"item5" => 135),
							array("performanceId" => 6,
								"matchId" => 378075206,
								"playerId" => 2147483647,
								"level" => 15,
								"hero" => 32,
								"kills" => 7,
								"deaths" => 11,
								"assists" => 3,
								"lastHits" => 38,
								"denies" => 1,
								"xpm" => 302,
								"gpm" => 221,
								"heroDamage" => 17306,
								"towerDamage" => 0,
								"item0" => 71,
								"item1" => 3,
								"item2" => 44,
								"item3" => 63,
								"item4" => 46,
								"item5" => 170),
							array(
								"performanceId" => 7,
								"matchId" => 378075206,
								"playerId" => 2147483647,
								"level" => 14,
								"hero" => 15,
								"kills" => 2,
								"deaths" => 12,
								"assists" => 5,
								"lastHits" => 110,
								"denies" => 9,
								"xpm" => 260,
								"gpm" => 283,
								"heroDamage" => 7460,
								"towerDamage" => 365,
								"item0" => 212,
								"item1" => 63,
								"item2" => 125,
								"item3" => 154,
								"item4" => 0,
								"item5" => 0),
							array("performanceId" => 8,
								"matchId" => 378075206,
								"playerId" => 85595353,
								"level" => 14,
								"hero" => 102,
								"kills" => 0,
								"deaths" => 11,
								"assists" => 5,
								"lastHits" => 60,
								"denies" => 9,
								"xpm" => 241,
								"gpm" => 209,
								"heroDamage" => 2133,
								"towerDamage" => 339,
								"item0" => 50,
								"item1" => 46,
								"item2" => 38,
								"item3" => 166,
								"item4" => 0,
								"item5" => 0),
							array("performanceId" => 9,
								"matchId" => 378075206,
								"playerId" => 2147483647,
								"level" => 13,
								"hero" => 35,
								"kills" => 2,
								"deaths" => 12,
								"assists" => 2,
								"lastHits" => 56,
								"denies" => 0,
								"xpm" => 216,
								"gpm" => 242,
								"heroDamage" => 6784,
								"towerDamage" => 626,
								"item0" => 29,
								"item1" => 36,
								"item2" => 164,
								"item3" => 212,
								"item4" => 24,
								"item5" => 170),
							array("performanceId" => 10,
								"matchId" => 378075206,
								"playerId" => 106977695,
								"level" => 17,
								"hero" => 58,
								"kills" => 3,
								"deaths" => 9,
								"assists" => 2,
								"lastHits" => 92,
								"denies" => 0,
								"xpm" => 389,
								"gpm" => 261,
								"heroDamage" => 3452,
								"towerDamage" => 623,
								"item0" => 121,
								"item1" => 63,
								"item2" => 40,
								"item3" => 23,
								"item4" => 0,
								"item5" => 42)
							)
						),
			array("matchId" => "378075206",
						"skillLevel" => "0",
						"duration" => "2593",
						"result" => "1", // Boolean
						"gameMode" => "1",
						"region" => "0",
						"date" => "2013-11-10 00:00:00", // Date
						"matchType" => "0",
						"playerPerformance" => array(
							array("performanceId" => 1,
								"matchId" => 378075206,
								"playerId" => 2147483647,
								"level" => 25,
								"hero" => 39,
								"kills" => 15,
								"deaths" => 2,
								"assists" => 17,
								"lastHits" => 89,
								"denies" => 11,
								"xpm" => 751,
								"gpm" => 527,
								"heroDamage" => 21050,
								"towerDamage" => 829,
								"item0" => 46,
								"item1" => 96,
								"item2" => 108,
								"item3" => 63,
								"item4" => 123,
								"item5" => 36),
							array("performanceId" => 2,
								"matchId" => 378075206,
								"playerId" => 2147483647,
								"level" => 22,
								"hero" => 9,
								"kills" => 9,
								"deaths" => 4,
								"assists" => 17,
								"lastHits" => 135,
								"denies" => 11,
								"xpm" => 612,
								"gpm" => 559,
								"heroDamage" => 16326,
								"towerDamage" => 4311,
								"item0" => 212,
								"item1" => 147,
								"item2" => 149,
								"item3" => 168,
								"item4" => 46,
								"item5" => 50),
							array("performanceId" => 3,
								"matchId" => 378075206,
								"playerId" => 2147483647,
								"level" => 17,
								"hero" => 5,
								"kills" => 7,
								"deaths" => 6,
								"assists" => 6,
								"lastHits" => 65,
								"denies" => 1,
								"xpm" => 375,
								"gpm" => 363,
								"heroDamage" => 6701,
								"towerDamage" => 892,
								"item0" => 48,
								"item1" => 152,
								"item2" => 108,
								"item3" => 13,
								"item4" => 69,
								"item5" => 0),
							array("performanceId" => 4,
								"matchId" => 378075206,
								"playerId" => 2147483647,
								"level" => 4,
								"hero" => 70,
								"kills" => 0,
								"deaths" => 0,
								"assists" => 1,
								"lastHits" => 4,
								"denies" => 0,
								"xpm" => 24,
								"gpm" => 185,
								"heroDamage" => 269,
								"towerDamage" => 0,
								"item0" => 0,
								"item1" => 0,
								"item2" => 0,
								"item3" => 0,
								"item4" => 0,
								"item5" => 0),
							array("performanceId" => 5,
								"matchId" => 378075206,
								"playerId" => 83414088,
								"level" => 25,
								"hero" => 56,
								"kills" => 22,
								"deaths" => 3,
								"assists" => 6,
								"lastHits" => 118,
								"denies" => 3,
								"xpm" => 750,
								"gpm" => 561,
								"heroDamage" => 25591,
								"towerDamage" => 2035,
								"item0" => 0,
								"item1" => 63,
								"item2" => 141,
								"item3" => 98,
								"item4" => 116,
								"item5" => 135),
							array("performanceId" => 6,
								"matchId" => 378075206,
								"playerId" => 2147483647,
								"level" => 15,
								"hero" => 32,
								"kills" => 7,
								"deaths" => 11,
								"assists" => 3,
								"lastHits" => 38,
								"denies" => 1,
								"xpm" => 302,
								"gpm" => 221,
								"heroDamage" => 17306,
								"towerDamage" => 0,
								"item0" => 71,
								"item1" => 3,
								"item2" => 44,
								"item3" => 63,
								"item4" => 46,
								"item5" => 170),
							array(
								"performanceId" => 7,
								"matchId" => 378075206,
								"playerId" => 2147483647,
								"level" => 14,
								"hero" => 15,
								"kills" => 2,
								"deaths" => 12,
								"assists" => 5,
								"lastHits" => 110,
								"denies" => 9,
								"xpm" => 260,
								"gpm" => 283,
								"heroDamage" => 7460,
								"towerDamage" => 365,
								"item0" => 212,
								"item1" => 63,
								"item2" => 125,
								"item3" => 154,
								"item4" => 0,
								"item5" => 0),
							array("performanceId" => 8,
								"matchId" => 378075206,
								"playerId" => 85595353,
								"level" => 14,
								"hero" => 102,
								"kills" => 0,
								"deaths" => 11,
								"assists" => 5,
								"lastHits" => 60,
								"denies" => 9,
								"xpm" => 241,
								"gpm" => 209,
								"heroDamage" => 2133,
								"towerDamage" => 339,
								"item0" => 50,
								"item1" => 46,
								"item2" => 38,
								"item3" => 166,
								"item4" => 0,
								"item5" => 0),
							array("performanceId" => 9,
								"matchId" => 378075206,
								"playerId" => 2147483647,
								"level" => 13,
								"hero" => 35,
								"kills" => 2,
								"deaths" => 12,
								"assists" => 2,
								"lastHits" => 56,
								"denies" => 0,
								"xpm" => 216,
								"gpm" => 242,
								"heroDamage" => 6784,
								"towerDamage" => 626,
								"item0" => 29,
								"item1" => 36,
								"item2" => 164,
								"item3" => 212,
								"item4" => 24,
								"item5" => 170),
							array("performanceId" => 10,
								"matchId" => 378075206,
								"playerId" => 106977695,
								"level" => 17,
								"hero" => 58,
								"kills" => 3,
								"deaths" => 9,
								"assists" => 2,
								"lastHits" => 92,
								"denies" => 0,
								"xpm" => 389,
								"gpm" => 261,
								"heroDamage" => 3452,
								"towerDamage" => 623,
								"item0" => 121,
								"item1" => 63,
								"item2" => 40,
								"item3" => 23,
								"item4" => 0,
								"item5" => 42)
							)
						)
			);
	}

	/**
	 * Gets indicated statistics for a projection meeting the given criteria.
	 *
	 * Basically allows us to query specific statistics with specific criteria
	 * without having to pass around massive amounts of excess data.
	 *
	 * OVERRIDE THIS. This function should be implemented however is appropriate
	 * for the implementing Model in order to return the correctly formatted
	 * results. (Tests and examples for the correct structure pending.)
	 *
	 * @param $projection An array that contains a list of field names which
	 * should be included in each row.
	 *
	 * @param $criteria An associative array containing field names as the keys
	 * and filtering values as the values. We may need to add an operand value
	 * to perform more complex queries of the model.
	 *
	 * @param $ordering An associative array containing a list of field names
	 * and the corresponding sort criteria (ascending, descending) prioritized
	 * by the order given in the array.
	 *
	 * @return An array of associative arrays containing all the information
	 * specified by the projection array in the order specified by the ordering
	 * array.
	 */
	protected function internal_get_statistics($projection, $criteria)
	{
		return array(
			array("2013-11-10 00:00:00", 22),
			array("2013-11-10 02:06:00", 18),
			array("2013-11-10 03:42:00", 30)
			);
	}

	/**
	 * Gets information about the specified player in the criteria.
	 *
	 * OVERIDE THIS. Given the player vanity url, 32 bit, or 64 bit Id, we should be able to
	 * return player information from the API and given the player Id (equivalent
	 * to the 32 bit id) we should be able to return player information from the
	 * database.
	 *
	 * @param $criteria An associative array containing the given id criteria to
	 * select the player. Currently this includes the player ids in various forms.
	 * However, in the future, we may want to add support for user name queries
	 * through the SteamGuard API to our API model, so this function may be able to
	 * be used for that.
	 *
	 * @return An associative array of player information. The example given has
	 * some sample information, but it could use some elaboration if we determine
	 * we need more player information in order to use the application. (Research
	 * on SteamGuard API pending.)
	 */
	protected function internal_get_player_data($criteria)
	{
		return array(
			"playerId" => 1234567890,
			"imageUrl" => "dudeX"
			);
	}

	/**
	 * Writes the match list information given to the model.
	 *
	 * OVERRIDE THIS. This function may not receive all the attributes of a match
	 * every time it executes, so be sure to handle only partial data insertions,
	 * using null/default values to handle missing fields. Of course, match Ids and
	 * player Ids will be specified.
	 *
	 * @param $matchList Essentially the same as the output from get_match_list().
	 * Note, however, that this associative array may be missing some fields as
	 * mentioned above.
	 *
	 * @return A boolean indicating if the write was successful.
	 */
	protected function internal_add_match_list($matchList)
	{
		// On failure
		return false;
	}

	/**
	 * Writes the player data given to the model.
	 *
	 * OVERRIDE THIS
	 *
	 * @param $playerData Essentially the same as the output from get_player_data().
	 *
	 * @return A boolean indicating if the write was successful.
	 */
	protected function internal_add_player_data($playerData)
	{
		// On failure
		return false;
	}

	/**
	 * Updates a specific match with the given data.
	 *
	 * OVERRIDE THIS. Finds the match matching the given id and applies the match
	 * data to that match.
	 *
	 * @param $matchId The id of the match which should be updated.
	 *
	 * @param $matchData An associative array of fields and the values which should
	 * be stored in those fields. Essentially the same as the output from
	 * get_match_data() except that most of the fields may be missing.
	 *
	 * @return A boolean indicating if the write was successful.
	 */
	protected function internal_update_match_data($matchid, $matchdata)
	{
		// On failure
		return false;
	}

	/**
	 * Updates a specific player with the given data.
	 *
	 * OVERRIDE THIS. Finds the player matching the given criteria and then applies
	 * the player data to the match. In general, it is expected that the criteria
	 * will select a single player.
	 *
	 * @param $criteria An array of arrays containing criteria to select a player
	 * which should be modified by this update.
	 *
	 * @param $matchData An associative array of fields and the values which should
	 * be stored in those fields. Essentially the same as the output from
	 * get_player_data() except that most of the fields may be missing.
	 *
	 * @return A boolean indicating if the write was successful.
	 */
	protected function internal_update_player_data($criteria, $playerData)
	{
		// On failure
		return false;
	}
}

?>
