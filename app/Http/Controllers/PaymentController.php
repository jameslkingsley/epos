<?php

namespace App\Http\Controllers;

use App\Basket\Basket;
use App\Events\BasketReload;
use Illuminate\Http\Request;
use App\Events\BasketChanged;
use App\Basket\Models\Payment;

class PaymentController extends Controller
{
    /**
     * Payment instance.
     *
     * @var any
     */
    protected $payment;

    /**
     * Constructor method.
     *
     * @return any
     */
    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(
            $this->payment->all()
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        basket()->payments->add(
            array_to_object($request->all())
        );

        // Reload the basket if the transaction
        // isn't yet completed
        basket()->reloadIfOpen();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        basket()->payments->remove($payment);

        basket()->reload();
    }

    /**
     * Services the payment.
     *
     * @return mixed
     */
    public function service(Request $request)
    {
        $payment = $this->payment->findOrFail(
            array_to_object($request->payment)->id
        );

        $payment->provider->service()->complete();
    }
}
