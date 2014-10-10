<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Test extends Controller_Template {

	public $template = 'test';
	//public $matchData = file_get_contents("https://api.steampowered.com/IDOTA2Match_570/GetMatchHistory/V001/?key=448EF5FD8D44DDC1C6A6B07437D20FFE&account_id=124755068");
		

	public function action_index()
	{
		//var_dump(json_decode($matchData));
		$this->template->model = 'API Model';
		//$api = Model::factory('API');
		$this->template->output = "7";
	}

}

?>
