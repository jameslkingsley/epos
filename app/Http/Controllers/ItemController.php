<?php

namespace App\Http\Controllers;

use App\Basket\Basket;
use App\Basket\Models\Item;
use App\Events\BasketReload;
use Illuminate\Http\Request;
use App\Basket\Models\Barcode;
use Illuminate\Support\Facades\Log;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        basket()->items->add(
            array_to_object($request->all())
        );

        basket()->reload();
    }

    /**
     * Adds many items to the basket.
     *
     * @return any
     */
    public function addMany(Request $request, int $count = 1)
    {
        basket()->items->addMany(
            array_to_object($request->all()),
            $count
        );

        basket()->reload();
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
    public function destroy(Request $request, Item $item, int $qty = -1)
    {
        basket()->items->remove($item, $qty);

        basket()->reload();
    }

    /**
     * Attempts to add and item by the given barcode.
     *
     * @return any
     */
    public function addViaBarcode(Request $request, Barcode $barcode)
    {
        $item = $barcode->resolve($request->code);

        if ($item) {
            basket()->items->add($item);

            basket()->reload();
        }
    }
}
