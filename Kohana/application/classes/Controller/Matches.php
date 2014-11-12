<?php  defined('SYSPATH') or die('No direct script access.');

class Controller_Matches extends Controller_DotaTrack {

	public function before()
	{
		// Get the match data
		parent::before();
	}

	public function action_apiCall(){
		$view = View::Factory('matches/index1');

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

		//$db->add_match_list($matchData);
		//$log->add(Log::DEBUG, "Summit: I added the Match History to the database!");
		//$log->write();
		//$out = "<p>[" . implode("][",$db->get_match_list($criteria)) . "]</p>";



		for ($i = 0; $i < count($matchData); $i++) {
				$matchData[$i] = $this->nicify_match_data($matchData[$i]);
		}

		$log->add(Log::DEBUG, "Summit: I nicified!");
		$log->write();

		$out = $matchData;

		$view->output = $out;

		$this->add_javascript("playerId", $session->get('userId'));
		$this->add_javascript("lastMatchId", $matchData[count($matchData)-1]['matchId']);

        $generated_view = $view->render();
		$this->add_header();
        $this->add_view_content($generated_view);
	}


	public function action_index()
	{
		$view = View::Factory('matches/index');

		//take 32 bit id (PlayerId) out of Session::instance()->set("key","value")
		$session = Session::instance();
		$playerId = $session->get('userId');
		//die(Debug::vars($playerId));

		//$playerId = "83414088";
		//die(Debug::vars($playerId));

		//query for the database (get match List) takes criteria. Where playerId = session
		$model = Model::Factory('DotaTrackDatabase');

		$criteria = array(array('playerId', "=", $playerId));
		$projection =
		array(
			'matchId' => 'Not',
			'date' => 'Desc',
			'result' => 'Not',
			'hero' => 'Not',
			'kills' =>'Not',
			'deaths' =>'Not',
			'assists' => 'Not',
		);
		$titles = array(
			'matchId',
			'date',
			'result',
			'hero',
			'kills',
			'deaths',
			'assists',
		);
		//die(Debug::vars($criteria));

		$result = $model->get_statistics($projection, $criteria);
		//die(Debug::vars($result));

		$view->statistics = $result;
		$view->titles = $titles;

		//MatchList to MatchesPage fun table output


		//as clickable links to Match page DotaTrack/Match/index/id#	url::base()

        $generated_view = $view->render();

		$this->add_header();
        $this->add_view_content($generated_view);
		$this->render_template();
	}
}

?>
