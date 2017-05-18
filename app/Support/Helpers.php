<?php

/**
 * Converts a multidimensional array to an object.
 *
 * @return object
 */
function array_to_object($array)
{
    return json_decode(json_encode($array));
}
