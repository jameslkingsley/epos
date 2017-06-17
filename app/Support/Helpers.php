<?php

use App\Basket\Basket;
use App\Settings\Setting;
use App\Settings\NullSetting;
use App\Basket\Support\Number;

/**
 * Converts a multidimensional array to an object.
 *
 * @return object
 */
function array_to_object($array)
{
    return json_decode(json_encode($array));
}

/**
 * Gets a number instance for the given numeric value.
 *
 * @return App\Basket\Support\Number
 */
function number($number = 0)
{
    return Number::make($number);
}

/**
 * Gets the basket model instance.
 *
 * @return App\Basket\Basket
 */
function basket()
{
    return new Basket;
}

/**
 * Gets the setting instance.
 *
 * @return Setting
 */
function setting(string $name = '', $default = '')
{
    return Setting::make($name, $default);
}
