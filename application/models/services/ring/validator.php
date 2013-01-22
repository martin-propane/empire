<?php namespace Empire\Services;

use Empire\Entities\Ring;
use Laravel\Validator;

class Ring_Validator
{
	public static $RULES = array(
		'id'=>'integer'
	);

	public static function validate(Ring $ring)
	{
		$validator = Validator::make(get_object_vars($ring), self::$RULES);

		return !$validator->fails();
	}
}


