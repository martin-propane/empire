<?php namespace Empire\Entities;

class Type extends Base
{
	protected $properties = array('id', 'description', 'short_description');

	public function __construct($values)
	{
		parent::__construct($this->properties, $values);
	}
}

