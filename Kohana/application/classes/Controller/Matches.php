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

		$criteria = array(array("playerId","=",$session->get('userId')));
		$matchData = $api->get_match_history($criteria);
		
		$out = "<p>" . implode("</p><p>",$matchData) . "</p>";
		
		//$db->add_match_list($matchData);	
		
		//$out = "<p>[" . implode("][",$db->get_match_list($criteria)) . "]</p>";
		
		$view->output = $out;
		
        $generated_view = $view->render();

		$this->add_header();
        $this->add_view_content($generated_view);
	}
}

?>
