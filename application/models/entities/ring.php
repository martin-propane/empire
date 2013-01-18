<?php namespace Models\Entities;

class Ring 
{
	public $id;
	public $name;
	public $type_id;
	public $description;
	public $price;

	public function __construct($id, $name, $type_id, $description, $price)
	{
		$this->id = $id;
		$this->name = $name;
		$this->type_id = $type_id;
		$this->description = $description;
		$this->price = $price;
	}
}

