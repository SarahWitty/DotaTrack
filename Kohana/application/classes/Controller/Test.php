<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Test extends Controller_Template {

	public $template = 'test';
		

	public function action_index()
	{
		$this->template->model = 'Api Model';
		$api = Model::factory('Api');
		//$this->template->output = $api->internal_get_match_data("884421153");
		$this->template->output = $api->get_heroes();
	}

}

?>
