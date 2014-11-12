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

		//$criteria = array(array("playerId","=",$session->get('userId')));
		$criteria = array(array("playerId","=","16373900"));
		$matchData = $api->get_match_history($criteria);
		//$matchData = $db->get_match_list($criteria);

		$log->add(Log::DEBUG, "Summit: I got the match list!");

		$db->add_match_list($matchData);

		$log->add(Log::DEBUG, "Summit: I added the match list!");
		//$log->add(Log::DEBUG, "Summit: I added the Match History to the database!");
		//$log->write();

		foreach($matchData as $key => $value) {
		//for ($i = 0; $i < count($matchData); $i++) {
				$matchData[$key] = $this->nicify_match_data($value);
		}

		$this->response->headers(array("Content-Type" => "application/json"));
		$this->response->body(json_encode($matchData));
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

		$this->add_javascript("playerId", $session->get('userId'));
		//$this->add_javascript("lastMatchId", $matchData[count($matchData)-1]['matchId']);

        $generated_view = $view->render();

		$this->add_header();
        $this->add_view_content($generated_view);
		$this->render_template();
	}
}

?>
