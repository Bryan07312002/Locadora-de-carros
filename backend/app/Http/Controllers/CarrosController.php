<?php

namespace App\Http\Controllers;

use App\Models\Carros;
use App\Http\Requests\StoreCarrosRequest;
use App\Http\Requests\UpdateCarrosRequest;

class CarrosController extends Controller
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
     * @param  \App\Http\Requests\StoreCarrosRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCarrosRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Carros  $carros
     * @return \Illuminate\Http\Response
     */
    public function show(Carros $carros)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Carros  $carros
     * @return \Illuminate\Http\Response
     */
    public function edit(Carros $carros)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCarrosRequest  $request
     * @param  \App\Models\Carros  $carros
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCarrosRequest $request, Carros $carros)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Carros  $carros
     * @return \Illuminate\Http\Response
     */
    public function destroy(Carros $carros)
    {
        //
    }
}
