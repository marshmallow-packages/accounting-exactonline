<?php

namespace Marshmallow\ExactOnline\Helpers;
use Illuminate\Database\Schema\Blueprint;

class ConfigHelper
{
	public static function mapping ($mapping)
	{
		return config('exactonline.mapping.' . $mapping);
	}
}