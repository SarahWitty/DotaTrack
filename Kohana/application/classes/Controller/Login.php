<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Login extends Controller {
	public function action_index()
	{
		$view = View::Factory('login');

		$generated_view = $view->render();

		$stuff = Debug::dump($generated_view);

		$this->response->body($generated_view);
	}
}
