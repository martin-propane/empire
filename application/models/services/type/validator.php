<?php namespace Empire\Services;

use Empire\Entities\Type;
use Laravel\Validator;

class Type_Validator
{
	public static $RULES = array(
		'id'=>'integer'
	);

	public static function validate(Type $type)
	{
		$validator = Validator::make(get_object_vars($type), self::$RULES);

		return !$validator->fails();
	}
}

