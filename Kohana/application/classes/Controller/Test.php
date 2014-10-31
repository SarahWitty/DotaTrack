<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Test extends Controller {

	public function action_index()
	{
		$view = View::factory('test');

		$view->model = 'testing';
		$view->output = Model::factory('DotaTrackDatabase')->get_match_list(array("test"=>"value"));

		$this->response->body($view->render());
	}

	public function action_input()
	{
		$view = View::factory('test/input');

		$this->response->body($view->render());
	}

	public function action_submit()
	{
		$view = View::factory('test');

		// Get the text from the input form
		$testText = $this->request->post('testText');

		// Json decode the input
		$testJson = json_decode($testText, true);

		$view->model = 'submit (<a href="'.URL::base().'Test/input">Hacks!</a>)';
		$view->output = $testJson;

		$this->response->body($view->render());
	}

}

?>
