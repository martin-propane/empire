<?php namespace Empire\Repositories;

use \stdClass;
use Laravel\Database;
use Laravel\Hash;
use Empire\Entities\User;

class User_Repository
{
	public $TABLE = 'Users';

	public function add($data)
	{
		assert(array_key_exists('email', $data));
		assert(array_key_exists('password', $data));
		assert(array_key_exists('admin', $data));

		$send['email'] = $data['email'];
		$send['password'] = Hash::make($data['password']);
		$send['admin'] = $data['admin'];

		$id = Database::table($this->TABLE)->insert_get_id($send);
	}

	public function edit($id, $data)
	{
		if (array_key_exists('email', $data))
			$send['email'] = $data['email'];
		if (array_key_exists('password', $data))
			$send['password'] = Hash::make($data['password']);
		if (array_key_exists('admin', $data))
			$send['admin'] = $data['admin'];

		Database::table($this->TABLE)->where('id', '=', $id)->update($send);
	}

	public function delete($id)
	{
		Database::table($this->TABLE)->delete($id);
	}

	public function get_all()
	{
		return $this->get_entities(Database::table($this->TABLE)->get());
	}

	public function get($id)
	{
		return $this->get_entity(Database::table($this->TABLE)->where('id', '=', $id)->first());
	}

	public function get_entities($user_tuples)
	{
		$users = array();
		foreach ($user_tuples as $i=>$user)
		{
			$users[$i] = $this->get_entity($user);
		}

		return $users;
	}

	public function get_entity($tuple)
	{
		return new User($tuple->id, $tuple->email, $tuple->password, $tuple->admin);
	}
}
