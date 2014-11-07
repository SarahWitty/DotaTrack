<?php  defined('SYSPATH') or die('No direct script access.');

class Controller_Matches extends Controller_DotaTrack {

	public function before()
	{
		// Get the match data
		parent::before();
	}

	public function action_index()
	{
        $view = View::Factory('matches/index');
		
		$session = Session::instance();
		$log = Log::instance();
		
		$log->add(Log::DEBUG, "Summit: I got to the Matches page!");
		$log->write();
		$api = Model::Factory('Api');
		$db = Model::Factory('DotaTrackDatabase');

		$log->add(Log::DEBUG, "Summit: I created the Model Factory for API and DotaTrackDatabase!");
		$log->write();
		$criteria = array(array("playerId","=",$session->get('userId')));
		$matchData = $api->get_match_history($criteria);

		$log->add(Log::DEBUG, "Summit: I got Match History!");
		$log->write();
		//$out = "<p>" . implode("</p><p>",$matchData) . "</p>";

		$db->add_match_list($matchData);
		$log->add(Log::DEBUG, "Summit: I added the Match History to the database!");
		$log->write();
		$out = "<p>[" . implode("][",$db->get_match_list($criteria)) . "]</p>";

		add_javascript("playerId", $session->get('userId'));
		add_javascript("lastMatchId", $matchData[$matchData.length-1]['matchId']);

		$view->output = $out;

        $generated_view = $view->render();

		$this->add_header();
        $this->add_view_content($generated_view);
	}
}

?>
