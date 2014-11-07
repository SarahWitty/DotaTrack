<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Match extends Controller_DotaTrack {

	public function action_index(){

		$view = View::Factory('match/index');
		//$generated_view = $view->render();

		$matchId = $this->request->param('id');
		$model = Model::Factory('DotaTrackDatabase');
		
		//die(Debug::vars($matchId));
		
		$result = $model->get_match_data($matchId);
		
		if(!$result){
			$view->performance = array(array());
			$view->match = array();
		
		}else{
			//die(Debug::vars($result));

			$view->output = $result;
			$view->performance = $result['playerPerformance'];

			unset($result['playerPerformance']);
			$view->match = $result;
		}

		$this->add_header();
		$this->add_view_content($view->render());
	}
}

?>
