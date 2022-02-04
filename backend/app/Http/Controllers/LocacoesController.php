<?php

namespace App\Http\Controllers;

use App\Models\locacoes;
use App\Http\Requests\StorelocacoesRequest;
use App\Http\Requests\UpdatelocacoesRequest;

class LocacoesController extends Controller
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
     * @param  \App\Http\Requests\StorelocacoesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorelocacoesRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\locacoes  $locacoes
     * @return \Illuminate\Http\Response
     */
    public function show(locacoes $locacoes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\locacoes  $locacoes
     * @return \Illuminate\Http\Response
     */
    public function edit(locacoes $locacoes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatelocacoesRequest  $request
     * @param  \App\Models\locacoes  $locacoes
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatelocacoesRequest $request, locacoes $locacoes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\locacoes  $locacoes
     * @return \Illuminate\Http\Response
     */
    public function destroy(locacoes $locacoes)
    {
        //
    }
}
