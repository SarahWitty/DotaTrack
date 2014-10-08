<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Test extends Controller_Template {

	public $template = 'test';

	public function action_index()
	{
		$this->template->model = 'testing';
		$this->template->output = array('testing', '1', '2', '3');
	}

}

?>
