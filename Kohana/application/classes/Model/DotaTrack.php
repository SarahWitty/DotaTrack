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
		return array();
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
		return array( array() );
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
	protected function internalGetStatistics($projection, $criteria)
	{
		return array( array() );
	}
}

?>