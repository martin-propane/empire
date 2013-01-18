<?php

class Logout_Controller extends Base_Controller
{
	public function action_index()
	{
		if (Auth::check())
			Auth::logout();

		return Redirect::to_action('login@index');
	}
}

