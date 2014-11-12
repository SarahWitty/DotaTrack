<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Statistics extends Controller_DotaTrack {

	public function action_index()
	{
		$view = View::factory('statistics/index');

		$generated_view = $view->render();

		$this->add_header();
		$this->add_view_content($generated_view);
		$this->render_template();
	}
}

?>
