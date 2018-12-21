<?php

namespace RobertHucks\SelfDestruct\Exceptions;

use InvalidArgumentException;

class MissingAttributeOnModel extends InvalidArgumentException
{
    public static function create(string $model_name, $missing_attribute)
    {
        return new static("This trait will not work as your model `{$model_name}` is missing the attribute `{$missing_attribute}`");
    }
}