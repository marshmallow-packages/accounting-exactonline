<?php

namespace Marshmallow\ExactOnline\Helpers;

class ConfigHelper
{
    public static function mapping($mapping)
    {
        return config('exactonline.mapping.' . $mapping);
    }
}
