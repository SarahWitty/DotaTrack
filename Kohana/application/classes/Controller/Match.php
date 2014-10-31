<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Match extends Controller_Template {
	public $template = "dotatrack_template";

	public function action_index()
	{
		$view = View::Factory('match/index');

		$generated_view = $view->render();

		$this->template->body = $generated_view;
	}
	public function action_json(){
		$view = View::Factory('match/index');
		//$generated_view = $view->render();

		$matchId = $this->request->param('matchId');
		$model = Model::Factory('DotaTrack');
		$result = $model->get_match_data($matchId);
		//die(Debug::vars($result));

		$view->output = $result;
		$this->template->body = $view->render();
	}
}

?>
