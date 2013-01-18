<?php

use Empire\Repositories\User_Repository;
use Empire\Entities\User;

class Admin_Users_Controller extends Base_Controller
{
	public $restful = true;
	public $layout = 'layouts.admin';

	public function get_add()
	{
		$this->layout->title = 'Add User';

		$this->layout->nest('content', 'Admin.Users.add');
	}
	public function post_add()
	{
		$this->layout->title = "Add User";

		$cw_repo = IoC::resolve('user_repository');
		$res = $cw_repo->add(Input::all());

		return Redirect::to_action('Admin.Users.view');
	}

	public function get_edit($id)
	{
		$this->layout->title = 'Edit User';

		$user_repo = IoC::resolve('user_repository');

		$user = $user_repo->get($id);

		$arr = get_object_vars($user);
		$this->layout->nest('content', 'Admin.Users.edit', get_object_vars($user));
	}

	public function get_delete($id)
	{
		$this->layout->title = 'Delete User';
		$user_repo = IoC::resolve('user_repository');
		$user_repo->delete($id);

		return Redirect::to_action('Admin.Users.view');
	}

	public function post_edit($id)
	{
		$user_repo = IoC::resolve('user_repository');

		$res = $user_repo->edit($id, Input::all());

		return Redirect::to_action('Admin.Users.view');
	}

	public function get_view()
	{
		$this->layout->title = 'View Users';

		$user_repo = IoC::resolve('user_repository');
		$res = $user_repo->get_all();
		$this->layout->nest('content', 'Admin.Users.view', array('users' => $res));
	}
}

