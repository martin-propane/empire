<?php namespace Empire\Entities;

abstract class Base
{
	protected $_properties;

	public function __construct($properties, $values)
	{
		$this->_properties = $properties;

		foreach ($properties as $p)
		{
			if (array_key_exists($p, $values))
				$this->$p = $values[$p];
			else
				$this->$p = null;
		}
	}

	public function update($values)
	{
		foreach ($values as $p=>$val)
		{
			if (in_array($p, $this->_properties))
				$this->$p = $values[$p];
		}
	}
}


