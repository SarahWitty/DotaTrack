<?php  defined('SYSPATH') or die('No direct script access.');

class Controller_Matches extends Controller_Template {
	public $template = "dotatrack_template";

	public function before()
	{
		// Get the match data
		parent::before();
	}

	public function action_index()
	{
        $view = View::Factory('matches/index');

        $generated_view = $view->render();

        $this->template->body = $generated_view;
	}
}

?>
