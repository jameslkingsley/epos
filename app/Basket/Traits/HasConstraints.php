<?php

namespace App\Basket\Traits;

use App\Basket\Constraints\Constraint;

trait HasConstraints
{
    /**
     * Constraint instance.
     *
     * @var App\Basket\Constraints\PaymentConstraint
     */
    protected $constraintProvider;

    /**
     * Passes data to the constraint instance.
     *
     * @return App\Basket\Constraints\Constraint
     */
    public function constraint()
    {
        // Return provider if args are empty
        if (empty(func_get_args())) {
            return $this->constraintProvider;
        }

        // Register constraint provider
        if (func_get_arg(0) instanceof Constraint) {
            $this->constraintProvider = func_get_arg(0);
            return $this->constraintProvider;
        }

        // Store dynamic data for constraint to use
        foreach (func_get_arg(0) as $key => $value) {
            $this->constraintProvider->$key = $value;
        }

        return $this->constraintProvider;
    }
}
