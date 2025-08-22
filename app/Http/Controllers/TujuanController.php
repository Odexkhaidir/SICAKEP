<?php

namespace App\Http\Controllers;

use App\Models\Tujuan;
use App\Http\Requests\StoreTujuanRequest;
use App\Http\Requests\UpdateTujuanRequest;

class TujuanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tujuan = Tujuan::where('start_year', '<='  , date('Y'))->where('end_year', '>=' , date('Y'))->get();
        return view('tujuan.index', [
            'tujuan' => $tujuan
        ]);
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
    public function store(StoreTujuanRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Tujuan $tujuan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tujuan $tujuan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTujuanRequest $request, Tujuan $tujuan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tujuan $tujuan)
    {
        //
    }
}
