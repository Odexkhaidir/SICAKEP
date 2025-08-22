<?php

namespace App\Http\Controllers;

use App\Models\Quotes;
use App\Http\Requests\StoreQuotesRequest;
use App\Http\Requests\UpdateQuotesRequest;

class QuotesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreQuotesRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Quotes $quotes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Quotes $quotes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateQuotesRequest $request, Quotes $quotes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quotes $quotes)
    {
        //
    }
}
