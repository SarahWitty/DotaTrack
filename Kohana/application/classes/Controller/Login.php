<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Login extends Controller_DotaTrack {

	public function action_index()
	{
		$view = View::Factory('login/login');

		$generated_view = $view->render();

		$stuff = Debug::dump($generated_view);

		$this->add_view_content($generated_view);
	}

	public function action_potato()
	{
		$view = View::Factory('login/login2');

		if ($this->request->post('pid')) {
			$view->has_pid = true;
			$view->pid = $this->request->post('pid');
			$view->output = Model::factory('Api')->get_match_history(array(array("playerId","=",$view->pid),array("matchId",">","973740011")));
		}
		else {
			$view->has_pid = false;
			$view->output = "Please log in first.";
		}


		$view->request = $this->request->post('pid');

		$generated_view = $view->render();

		$stuff = Debug::dump($generated_view);

		$this->add_view_content($generated_view);

	}
}
?>
