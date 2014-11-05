<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Login extends Controller_DotaTrack {

	public function action_index()
	{
		$view = View::Factory('login/login');
		
		session_start();
		
		if ($this->request->post('pid')) {
			$view->has_pid = true;
			$_SESSION["userId"] = $this->request->post('pid');
			$view->output = "Redirecting...";
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
