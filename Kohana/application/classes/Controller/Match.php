<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Match extends Controller {
	public function action_index()
	{
		$view = View::Factory('match/index');

		$generated_view = $view->render();

		$this->response->body($generated_view);
	}
}

?>
