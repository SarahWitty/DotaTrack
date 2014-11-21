<?php  defined('SYSPATH') or die('No direct script access.');

class Controller_DotaTrack extends Controller {
	public $template;

	protected function add_header()
	{
		$header = View::Factory('mainpage_header');

		$header->playerName = Session::instance()->get('playerName', 'No Name');
		$header->playerImage = Session::instance()->get('playerImage', '#');

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
		if(isset($this->template))
		{
			$this->template->body .= $content;
		}
		else
		{
			$this->template = View::factory('dotatrack_template');
			$this->template->body = $content;
		}
	}

	protected function render_template()
	{
		$this->write_javascript();
		$rendered = $this->template->render();

		$this->response->body($rendered);
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
		$this->template->javascript = "var server = ".json_encode($javascriptVars).";";
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

		// Nicify Result
		if (isset($matchData['result'])) {
			if ($matchData['result'] == 0) {
				$matchData['result'] = "Radiant Victory";
			}
			else {
				$matchData['result'] = "Dire Victory";
			}
		}

		// Nicify Game Mode
		if (isset($matchData['gameMode'])) {
			$matchData['gameMode'] = $db->get_mode_data($matchData['gameMode'])['name'];
		}

		// Nicify Match Type
		if (isset($matchData['matchType'])) {
			$matchData['matchType'] = $db->get_lobby_data($matchData['matchType'])['name'];
		}

		// Nicify Date
		if (isset($matchData['date'])) {
			$matchData['date'] = date("j M Y G:i:s", $matchData['date']);
		}

		// Nicify Duration
		if (isset($matchData['duration'])) {
			if ($matchData['duration'] >= 3600) {
				$matchData['duration'] = gmdate("H:i:s", $matchData['duration']);
			}
			else {
				$matchData['duration'] = gmdate("i:s", $matchData['duration']);
			}
		}

		// Nicify Performance
		if (isset($matchData['playerPerformance'])) {
			foreach ($matchData['playerPerformance'] as $key => $value) {
				// Nicify Items 0-5
				$matchData['playerPerformance'][$key]['item0'] = "<div class='item'><img src='" . URL::base() . "resources/images/itemIcons/" . $value['item0'] . ".png' alt='" . $db->get_item_data($value['item0'])['name'] . "'></div>";
				$matchData['playerPerformance'][$key]['item1'] = "<div class='item'><img src='" . URL::base() . "resources/images/itemIcons/" . $value['item1'] . ".png' alt='" . $db->get_item_data($value['item1'])['name'] . "'></div>";
				$matchData['playerPerformance'][$key]['item2'] = "<div class='item'><img src='" . URL::base() . "resources/images/itemIcons/" . $value['item2'] . ".png' alt='" . $db->get_item_data($value['item2'])['name'] . "'></div>";
				$matchData['playerPerformance'][$key]['item3'] = "<div class='item'><img src='" . URL::base() . "resources/images/itemIcons/" . $value['item3'] . ".png' alt='" . $db->get_item_data($value['item3'])['name'] . "'></div>";
				$matchData['playerPerformance'][$key]['item4'] = "<div class='item'><img src='" . URL::base() . "resources/images/itemIcons/" . $value['item4'] . ".png' alt='" . $db->get_item_data($value['item4'])['name'] . "'></div>";
				$matchData['playerPerformance'][$key]['item5'] = "<div class='item'><img src='" . URL::base() . "resources/images/itemIcons/" . $value['item5'] . ".png' alt='" . $db->get_item_data($value['item5'])['name'] . "'></div>";

				// Nicify Heroes

				$matchData['playerPerformance'][$key]['hero'] = "<div class='hero'><img src='" . URL::base() . "resources/images/heroIcons/" . $value['hero'] . ".png' alt='" . $db->get_hero_data($value['hero'])['heroName'] . "'></div>";
			}
		}


		// Nicify Items 0-5 (if outside of playerPerformance context)
		if (isset($matchData['item0'])) {
			$matchData['item0'] = "<div class='item'><img src='" . URL::base() . "resources/images/itemIcons/" . $matchData['item0'] . ".png' alt='" . $db->get_item_data($matchData['item0'])['name'] . "'></div>";
		}
		if (isset($matchData['item1'])) {
			$matchData['item1'] = "<div class='item'><img src='" . URL::base() . "resources/images/itemIcons/" . $matchData['item1'] . ".png' alt='" . $db->get_item_data($matchData['item1'])['name'] . "'></div>";
		}
		if (isset($matchData['item2'])) {
			$matchData['item2'] = "<div class='item'><img src='" . URL::base() . "resources/images/itemIcons/" . $matchData['item2'] . ".png' alt='" . $db->get_item_data($matchData['item2'])['name'] . "'></div>";
		}
		if (isset($matchData['item3'])) {
			$matchData['item3'] = "<div class='item'><img src='" . URL::base() . "resources/images/itemIcons/" . $matchData['item3'] . ".png' alt='" . $db->get_item_data($matchData['item3'])['name'] . "'></div>";
		}
		if (isset($matchData['item4'])) {
			$matchData['item4'] = "<div class='item'><img src='" . URL::base() . "resources/images/itemIcons/" . $matchData['item4'] . ".png' alt='" . $db->get_item_data($matchData['item4'])['name'] . "'></div>";
		}
		if (isset($matchData['item5'])) {
			$matchData['item5'] = "<div class='item'><img src='" . URL::base() . "resources/images/itemIcons/" . $matchData['item5'] . ".png' alt='" . $db->get_item_data($matchData['item5'])['name'] . "'></div>";
		}

		// Nicify Heroes (if outside of playerPerformance context)
		if (isset($matchData['hero'])) {
			$matchData['hero'] = "<div class='hero'><img src='" . URL::base() . "resources/images/heroIcons/" . $matchData['hero'] . ".png' alt='" . $db->get_hero_data($matchData['hero'])['heroName'] . "'></div>";
		}

		return $matchData;
	}


}

?>
