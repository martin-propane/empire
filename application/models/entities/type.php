<?php namespace Empire\Entities;

class Type extends Base
{
	protected $properties = array('id', 'description', 'short_description');

	public function __construct($values)
	{
		$this->setProperties($this->properties, $values);
	}
}

