<?php defined('SYSPATH') or die('No direct script access.');

class Model_DotaTrack extends Model {

	/**
	 * Gets all the data for a single match.
	 *
	 * DON'T OVERRIDE THIS. Use the internalGetMatchData() function instead.
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
	public function getMatchData($matchId)
	{
		return $this->internalGetMatchData($matchId);
	}

	/**
	 * Gets all the data for a list of matches meeting the given criteria.
	 *
	 * DON'T OVERRIDE THIS. Use the internalGetMatchData() function instead.
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
	public function getMatchList($criteria)
	{
		$sanitizedCriteria = $this->whitelistMatchListCriteria($criteria);

		return $this->internalGetMatchList($sanitizedCriteria);
	}

	/**
	 * Gets indicated statistics for a projection meeting the given criteria.
	 *
	 * Basically allows us to query specific statistics with specific criteria
	 * without having to pass around massive amounts of excess data.
	 *
	 * DON'T OVERRIDE THIS. Use the internalGetMatchData() function instead.
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
	public function getStatistics($projection, $criteria, $ordering)
	{
		$sanitizedProjection = $this->whitelistStatisticProjection($projection);
		$sanitizedOrdering = $this->whitelistStatisticOrdering($ordering);
		$sanitizedCriteria = $this->whitelistStatisticCriteria($criteria);

		return $this->internalGetStatistics(
			$sanitizedProjection, $sanitizedCriteria);
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
	private function whitelistMatchListCriteria($criteria)
	{
		$sanitizedCriteria = array();

		return $sanitizedCriteria;
	}

	/**
	 * Whitelists criteria to prevent injection of invalid criteria into
	 * queries.
	 *
	 * If this function ends up duplicating whitelistMatchListCriteria() too
	 * much, we should combine them.
	 *
	 * @param $criteria The raw associative array containing field names and
	 * values which will be filtered for harmful input.
	 *
	 * @return A refined version of the criteria containing only valid field
	 * names and values.
	 */
	private function whitelistStatisticCriteria($criteria)
	{
		$sanitizedCriteria = array();

		return $sanitizedCriteria;
	}

	/**
	 * Whitelists the projection array to prevent injection of invalid criteria
	 * into queries.
	 *
	 * @param $criteria The raw array containing field names which will be
	 * filtered for harmful input.
	 *
	 * @return A refined version of the projection array containing only valid
	 * field names.
	 */
	private function whitelistStatisticProjection($projection)
	{
		$sanitizedCriteria = array();

		return $sanitizedProjection;
	}

	/**
	 * Whitelists the ordering to prevent injection of invalid criteria into
	 * queries.
	 *
	 * @param $criteria The raw array containing field names and ordering
	 * criteria which will be filtered for harmful input.
	 *
	 * @return A refined version of the ordering array containing only valid
	 * field names and ordering criteria.
	 */
	private function whitelistStatisticOrdering($ordering)
	{
		$sanitizedOrdering = array();

		return $sanitizedOrdering;
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
	protected function internalGetMatchData($matchId)
	{
	return array("matchId" => string(9) "378075206"
				"skillLevel" => string(1) "0"
				"duration" => string(4) "2593"
				"result" => string(1) "1" // Boolean
				"gameMode" => string(1) "1"
				"region" => string(1) "0"
				"date" => string(10) "2013-11-10 00:00:00" // Date
				"matchType" => string(1) "0"
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
						"item5" => 0)
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
	protected function internalGetMatchList($criteria)
	{
		return array(
			array("matchId" => string(9) "378075206"
						"skillLevel" => string(1) "0"
						"duration" => string(4) "2593"
						"result" => string(1) "1" // Boolean
						"gameMode" => string(1) "1"
						"region" => string(1) "0"
						"date" => string(10) "2013-11-10 00:00:00" // Date
						"matchType" => string(1) "0"
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
								"item5" => 0)
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
			array("matchId" => string(9) "378075206"
						"skillLevel" => string(1) "0"
						"duration" => string(4) "2593"
						"result" => string(1) "1" // Boolean
						"gameMode" => string(1) "1"
						"region" => string(1) "0"
						"date" => string(10) "2013-11-10 00:00:00" // Date
						"matchType" => string(1) "0"
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
								"item5" => 0)
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
	protected function internalGetStatistics($projection, $criteria, $ordering)
	{
		return array(
			array("2013-11-10 00:00:00", 22),
			array("2013-11-10 02:06:00", 18),
			array("2013-11-10 03:42:00", 30)
			);
	}

	}
}

?>