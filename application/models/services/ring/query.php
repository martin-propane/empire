<?php namespace Empire\Services;

use \stdClass;
use Laravel\Database;
use Shinefind\Entities\Carwash;

class Ring_Query
{
	protected $query;

	public $TABLE = 'Rings';

	public function __construct()
	{
		$this->query = Database::table($this->TABLE);
	}

	public function name_like($name)
	{
		$this->query = $this->query->where('name', 'LIKE', '%' . $name . '%');

		return $this;
	}

	public function type_id_is($type_id)
	{
		$this->query = $this->query->where('type_id', '=', $type_id);

		return $this;
	}

	public function sort_id($order = 'asc')
	{
		$this->query = $this->query->order_by('id', $order);

		return $this;
	}

	public function sort_name($order = 'asc')
	{
		$this->query = $this->query->order_by('name', $order);

		return $this;
	}

	public function sort_display_picture($order = 'asc')
	{
		$this->query = $this->query->order_by('display_picture', $order);

		return $this;
	}

	public function sort_type_id($order = 'asc')
	{
		$this->query = $this->query->order_by('type_id', $order);

		return $this;
	}

	public function sort_price($order = 'asc')
	{
		$this->query = $this->query->order_by('price', $order);

		return $this;
	}

	public function sort_quantity($order = 'asc')
	{
		$this->query = $this->query->order_by('quantity', $order);

		return $this;
	}

	public function count()
	{
		return $this->query->count();
	}

	public function get()
	{
		return $this->query->get();
	}

	public function page($per_page, $page_num)
	{
		$tuples = $this->query->skip($per_page * $page_num)->take($per_page)->get();

		return $this->get_entities($tuples);
	}

	protected function get_entities($tuples)
	{
		$entities = array();

		foreach ($tuples as $tuple)
			$entities[] = $this->get_entity($tuple);

		return $entities;
	}

	protected function get_entity($tuple)
	{
		return new Ring(get_object_vars($tuple));
	}
}
