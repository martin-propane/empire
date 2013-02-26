<?php namespace Empire\Entities;

class RingPicture extends Base
{
	protected $properties = array('id', 'order', 'url', 'ring_id');

	public function __construct($values)
	{
		parent::__construct($this->properties, $values);
	}
}


