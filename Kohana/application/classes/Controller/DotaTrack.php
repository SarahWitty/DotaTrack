<?php  defined('SYSPATH') or die('No direct script access.');

class Controller_DotaTrack extends Controller_Template {
	public $template = "dotatrack_template";

	protected function add_header()
	{
		$header = View::Factory('mainpage_header');

		$header->playerName = Session::instance()->get('playerName', 'No Name');

		$header = $header->render();

		$this->add_view_content($header);
	}

	/**
	 * Adds the given content to the body of the template.
	 *
	 * @param $content A string containing the content to add to the template body.
	 */
	protected function add_view_content($content)
	{
		if(isset($this->template->body))
		{
			$this->template->body .= $content;
		}
		else
		{
			$this->template->body = $content;
		}
	}

	protected function add_javascript($key, $value)
	{
		$javascriptVars = Session::instance()->get('javascriptVariables', array());

		$javascriptVars[$key] = $value;

		Session::instance()->set('javascriptVariables', $javascriptVars);
	}

	protected function write_javascript()
	{
		$javascriptVars = Session::instance()->get('javascriptVariables', array());
		$this->javascript = "var server = ".json_encode($javascriptVars).";";
	}

	/**
	 * Takes the id's present in the match data and translates it into human
	 * readable junk.
	 *
	 * @param $matchData Contains a whole bunch of relatively confusing ids for
	 * the match data. The data structure is equivalent to what get_match_data
	 * will return for most models.
	 *
	 * @return A revised $matchData containing human readable strings.
	 */
	protected function nicify_match_data($matchData)
	{
		
		$db = Model::Factory('DotaTrackDatabase');
		$matchData['gameMode'] = $db->get_mode_data($matchData['gameMode'])['name'];
		$matchData['matchType'] = $db->get_lobby_data($matchData['matchType'])['name'];
		$matchData['date'] = date("j M Y G:i:s", $matchData['date']);
		if ($matchData['duration'] >= 3600) {
			$matchData['duration'] = gmdate("H:i:s", $matchData['duration']);
		}
		else {
			$matchData['duration'] = gmdate("i:s", $matchData['duration']);
		}
		// DD MON YEAR HR:MI:SE
		
		//$matchData['hero'] = $db->get_hero_data($matchData['hero']);
		return $matchData;
	}
}

?>
