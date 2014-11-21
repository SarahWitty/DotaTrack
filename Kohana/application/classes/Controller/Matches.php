<?php  defined('SYSPATH') or die('No direct script access.');

class Controller_Matches extends Controller_DotaTrack {

	public function before()
	{
		// Get the match data
		parent::before();
	}

	public function action_apiCall(){
		$view = View::Factory('matches/index1');
		$log = Log::instance();
		
		$session = Session::instance();

		$api = Model::Factory('Api');
		$db = Model::Factory('DotaTrackDatabase');
		
		$log->add(Log::DEBUG, "Summit: Added the models.");
		$log->write();
		
		$criteria = array(
			array("playerId","=",$session->get('userId')),
			array("matchId",">",$this->request->param('id', 0))
		);
		
		$log->add(Log::DEBUG, "Summit: Set criteria: " . $this->request->param('id', 0));
		$log->write();
		
		$matchData = $api->get_match_history($criteria);
		
		$log->add(Log::DEBUG, "Summit: Got matchData.");
		$log->write();
		
		// Add player rows to the databases
		foreach($matchData as $match) {
			if (isset($match['playerPerformance'])) {
				foreach($match['playerPerformance'] as $perform) {
					$log->add(Log::DEBUG, "Summit: Adding player:" . $perform['playerId']);
					$player = ORM::factory('ORM_Player', $perform['playerId']);
					
					if(!$player->loaded())
					{
						$player->playerId = $perform['playerId'];
						$player->save();
						//$player->values($perform)->create();
					}
				}
			}
		}

		$log->add(Log::DEBUG, "Summit: Added players to database.");
		$log->write();
		
		$db->add_match_list($matchData);

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

		$results = $db->get_statistics($projection,$criteria);
		
		foreach($results as $key => $value) {
			$results[$key] = $this->nicify_match_data($value);
		}

		$this->response->headers(array("Content-Type" => "application/json"));
		$this->response->body(json_encode($results));
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
		
		foreach($result as $key => $value) {
			$result[$key] = $this->nicify_match_data($value);
		}
		
		//die(Debug::vars($result));

		$view->statistics = $result;
		$view->titles = $titles;

		//MatchList to MatchesPage fun table output
		//as clickable links to Match page DotaTrack/Match/index/id#	url::base()

		$this->add_javascript("playerId", $session->get('userId'));
		$this->add_javascript("lastMatchId", count($result)? $result[0]['matchId']: 0);
		$this->add_javascript("baseUrl", URL::base());

        $generated_view = $view->render();

		$this->add_header();
        $this->add_view_content($generated_view);
		$this->render_template();
	}
}

?>
