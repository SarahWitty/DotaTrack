<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Test extends Controller_Template {

	public $template = 'test';

	public function action_index()
	{
		$this->template->model = 'API Model';
		$api = Model::factory('API');
		//$api->get_match_details('946986070');
		$this->template->output = $api->get_match_history('4294967295');
	}

}

?>
