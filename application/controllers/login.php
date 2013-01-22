<?php

class Login_Controller extends Base_Controller
{
	public$restful = true;
	public $layout = 'layouts.bootstrap';


	public function get_index()
	{
		if (Auth::check())
			return Redirect::to_action('admin.types@index');
		$this->layout->title = 'Login';
		$this->layout->nest('content', 'login.index', array());
	}

	public function post_index()
	{
		if (Auth::check())
			return Redirect::to_action('admin.types@index');

		$email = Input::get('email');
		$password = Input::get('password');

		$auth = Auth::attempt(array('username' => $email, 'password' => $password));

		if ($auth)
			return Redirect::to_action('admin.types@index');
		else
			return Response::make('You were not logged in.');
	}
}
