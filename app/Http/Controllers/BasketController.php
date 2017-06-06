<?php

namespace App\Http\Controllers;

use App\Basket\Basket;
use App\Events\BasketReload;
use Illuminate\Http\Request;
use App\Events\BasketModeChanged;
use Illuminate\Support\Facades\Log;

class BasketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        basket()->reload();
    }

    /**
     * Create a new basket instance in the session.
     *
     * @return App\Basket
     */
    public function create()
    {
        //
    }

    /**
     * Account and store the current basket.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function empty()
    {
        basket()
            ->empty()
            ->reload();
    }

    /**
     * Changes basket to the given mode.
     *
     * @return void
     */
    public function mode(int $mode)
    {
        basket()->update(function($basket) use($mode) {
            $basket->mode = $mode;

            return $basket->withEvent(BasketModeChanged::class, $mode);
        })->reload();
    }
}
