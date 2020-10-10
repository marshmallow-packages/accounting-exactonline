<?php

namespace Marshmallow\ExactOnline\Helpers;

use Illuminate\Database\Eloquent\Model;

class MappingHelper
{
    public static function map($exact_model, Model $our_model, $mapping_name)
    {
        $mapping = ConfigHelper::mapping($mapping_name);

        foreach ($mapping as $exact_field => $model_field) {
            if (is_array($model_field)) {
                $relationship = $model_field[0];
                $model_field = $model_field[1];
                $exact_model->{$exact_field} = $our_model->{$relationship}->$model_field;
            } else {
                $exact_model->{$exact_field} = $our_model->{$model_field};
            }
        }

        return $exact_model;
    }
}
