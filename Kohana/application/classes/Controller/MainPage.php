<?php  defined('SYSPATH') or die('No direct script access.');

class Controller_MainPage extends Controller_Template {
	public $template = "dotatrack_template";

	public $playerName = "";

	protected function add_header()
	{
		$header = View::Factory('mainpage_header');

		$header->playerName = Session::instance()->get('playerName', 'No Name');

		$header = $header->render();

		if(isset($this->template->body))
		{
			$this->template->body .= $header;
		}
		else
		{
			$this->template->body = $header;
		}
	}
}

?>
