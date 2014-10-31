<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Statistics extends Controller_Template {

	public $template = "dotatrack_template";

	public function action_index()
	{
		$view = View::factory('statistics/index');

		$generated_view = $view->render();

		$this->template->body = $generated_view;
	}
}

?>
