<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Statistics extends Controller_DotaTrack {

	//new action returns Json with certain criteria and projection from the $_POST
	public function action_populateGraphs()
	{		
		$projection = $this->request->post('projection');
		$criteria = $this->request->post('criteria');
		
		//die(print_r($criteria, true));
		
		//test projection and criteria
		$session = Session::instance();
		$db = Model::Factory('DotaTrackDatabase');
		/*$projection =
		array(
			'matches.matchId' => 'asc',
			'kills' =>'not',
		); 
		$criteria = array(
			array("date", ">", "1400468669"),
			array("playerId","=","4294967295"),
			array("matchType","!=","4")
			//array("playerId","=",$session->get('userId')),
			//array("matchId",">",$this->request->param('id', 0))
		);*/
		//date too
		//die(print_r($session->get('userId'), true));
		
		$results = $db->get_statistics($projection,$criteria);
		
		//die(print_r($results, true));
		$this->response->body(json_encode($results));
	}

	public function action_index()
	{
		$view = View::factory('statistics/index');
		$session = Session::instance();

		//$this->add_javascript("matchId", $session->get('matchId'));
		//$this->add_javascript("kills", $session->get('kills'));
		$this->add_javascript("playerId", $session->get('userId'));
		$this->add_javascript("date", $session->get('date'));
		
		
		$generated_view = $view->render();
		
		$this->add_header();
		$this->add_view_content($generated_view);
		$this->render_template();
	}
}

?>
