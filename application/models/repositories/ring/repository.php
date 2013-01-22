<?php namespace Empire\Repositories;

use \stdClass;
use Laravel\Database;
use Empire\Entities\Ring;
use Empire\Services\Ring_Validator;
use Empire\Services\Ring_Helper;

//Try making this a generic repository, and use dependency injection to get in the tablename and other classes?
class Ring_Repository
{
	public $table = 'Rings';

	public function add(&$entity)
	{
		Ring_Validator::validate($entity);
		var_dump($entity);
		$id = Database::table($this->table)->insert_get_id(get_object_vars($entity));

		$entity->id = $id;

		return $id;
	}

	public function save($entity)
	{
		assert($entity->id !== null);
		Ring_Validator::validate($entity);
		Database::table($this->table)->where('id', '=', $entity->id)->update(get_object_vars($entity));
	}

	public function remove($entity)
	{
		assert($entity->id !== null);

		Database::table($this->table)->where('id', '=', $entity->id)->delete();
	}

	public function get($id)
	{
		$tuple = Database::table($this->table)->where('id', '=', $id)->first();

		return $this->get_entity($tuple);
	}

	public function get_all()
	{
		$tuples = Database::table($this->table)->get();
		$entities = array();
		foreach ($tuples as $tuple)
		{
			$entities[] = $this->get_entity($tuple);
		}
		return $entities;
	}

	protected function get_entity($tuple)
	{
		return new Ring(get_object_vars($tuple));
	}

	public function query()
	{
		return new Ring_Query();
	}
}


