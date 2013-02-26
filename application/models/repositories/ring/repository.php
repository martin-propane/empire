<?php namespace Empire\Repositories;

use \stdClass;
use Laravel\Database;
use Empire\Entities\Ring;
use Empire\Entities\RingPicture;
use Empire\Services\Ring_Validator;
use Empire\Services\Ring_Helper;

//Try making this a generic repository, and use dependency injection to get in the tablename and other classes?
class Ring_Repository
{
	public $table = 'Rings';
	public $pic_table = 'RingPictures';

	public function add(&$entity)
	{
		Ring_Validator::validate($entity);

		$attributes = get_object_vars($entity);
		unset($attributes['pictures']); //pictures are saved separately
		$id = Database::table($this->table)->insert_get_id($attributes);

		$entity->id = $id;

		return $id;
	}

	public function save($entity)
	{
		assert($entity->id !== null);
		Ring_Validator::validate($entity);

		$attributes = get_object_vars($entity);
		unset($attributes['pictures']); //pictures are saved separately

		Database::table($this->table)->where('id', '=', $entity->id)->update($attributes);
	}

	public function remove($entity)
	{
		assert($entity->id !== null);

		Database::table($this->table)->where('id', '=', $entity->id)->delete();
	}

	public function add_picture(&$entity)
	{
		$id = Database::table($this->pic_table)->insert_get_id(get_object_vars($entity));

		$entity->id = $id;

		return $id;
	}

	public function save_picture($entity)
	{
		assert($entity->id !== null);

		Database::table($this->pic_table)->where('id', '=', $entity->id)->update(get_object_vars($entity));
	}

	public function remove_picture($entity)
	{
		assert($entity->id !== null);

		Database::table($this->pic_table)->where('id', '=', $entity->id)->delete();
	}

	public function get($id)
	{
		$tuple = Database::table($this->table)->where('id', '=', $id)->first();

		return $this->get_entity($tuple);
	}

	public function get_picture($id)
	{
		$tuple = Database::table($this->pic_table)->where('id', '=', $id)->first();

		return $this->get_picture_entity($tuple);
	}

	public function get_all()
	{
		$tuples = Database::table($this->table)->get();
		$entities = array();

		foreach ($tuples as $tuple)
			$entities[] = $this->get_entity($tuple);

		return $entities;
	}

	protected function get_entity($tuple)
	{
		$id = $tuple->id;

		$pictures = array();
		$pic_tuples = Database::table($this->pic_table)->where('ring_id', '=', $id)->order_by('order', 'asc')->get();
		foreach ($pic_tuples as $pic_tuple)
			$pictures[] = $this->get_picture_entity($pic_tuple);

		$tuple->pictures = $pictures;

		return new Ring(get_object_vars($tuple));
	}

	protected function get_picture_entity($tuple)
	{
		return new RingPicture(get_object_vars($tuple));
	}

	public function query()
	{
		return new Ring_Query();
	}
}


