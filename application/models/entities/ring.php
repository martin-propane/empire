<?php namespace Empire\Entities;

class Ring extends Base
{
	protected $properties = array('id', 'name', 'type_id', 'date', 'origin', 'description', 'source', 'price', 'quantity', 'display_picture');

	public function __construct($values)
	{
		parent::__construct($this->properties, $values);
	}
}


