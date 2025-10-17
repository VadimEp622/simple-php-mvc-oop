<?php

namespace Core;

class Validator
{
    public static function string($value, $min = 1, $max = 1000): bool
    {
        if (!is_string($value)) return false;
        $value = trim($value);
        return strlen($value) >= $min && strlen($value) <= $max;
    }

    public static function email($value): bool
    {
        return !!filter_var($value, FILTER_VALIDATE_EMAIL);
    }

    public static function id_int($value): bool
    {
        $options = array(
            'options' => array(
                'min_range' => 1
            ),
        );

        return !!filter_var($value, FILTER_VALIDATE_INT, $options);
    }
}
