<?php

namespace App\Basket\Printers;

use App\Events\PrintReceipt;

class StarWebPrint extends Printer
{
    /**
     * Renders the receipt view.
     *
     * @return any
     */
    public function render()
    {
        // Raise the print receipt event
        // to process it on the client
        event(new PrintReceipt($this->transaction));
    }
}
