<?php

namespace App\Basket\Printers;

class Generic extends Printer
{
    /**
     * Renders the receipt view.
     *
     * @return string
     */
    public function render()
    {
        return view('receipts.generic', [
            'transaction' => $this->transaction
        ]);
    }
}
