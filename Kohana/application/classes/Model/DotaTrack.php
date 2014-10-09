<?php defined('SYSPATH') or die('No direct script access.');

class Model_DotaTrack extends Model {

	public function getMatchData($matchId)
	{
		return $this->internalGetMatchData($matchId);
	}

	public function getMatchList($criteria)
	{
		$sanitizedCriteria = $this->whitelistMatchListCriteria($criteria);

		return $this->internalGetMatchList($sanitizedCriteria);
	}

	public function getStatistics($projection, $criteria)
	{
		$sanitizedProjection = $this->whitelistStatisticProjection($projection);
		$sanitizedCriteria = $this->whitelistStatisticCriteria($criteria);

		return $this->internalGetStatistics($sanitizedProjection, $sanitizedCriteria);
	}

	private function whitelistMatchListCriteria($criteria)
	{
		$sanitizedCriteria = array();

		return $sanitizedCriteria;
	}

	private function whitelistStatisticCriteria($criteria)
	{
		$sanitizedCriteria = array();

		return $sanitizedCriteria;
	}

	private function whitelistStatisticProjection($projection)
	{
		$sanitizedCriteria = array();

		return $sanitizedProjection;
	}

	protected function internalGetMatchData($matchId)
	{
		return array();
	}

	protected function internalGetMatchList($criteria)
	{
		return array( array() );
	}

	protected function internalGetStatistics($projection, $criteria)
	{
		return array( array() );
	}
}

?>