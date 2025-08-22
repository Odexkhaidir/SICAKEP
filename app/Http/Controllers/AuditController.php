<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use App\Http\Requests\StoreAuditRequest;
use App\Http\Requests\UpdateAuditRequest;

class AuditController extends Controller
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
    public function store(StoreAuditRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Audit $audit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Audit $audit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAuditRequest $request, Audit $audit)
    {        
        $validatedData = $request->validate([
            'status' => 'required',
        ]);

        $validatedData['notes'] = $request->notes;
        $validatedData['supervised_by'] = auth()->user()->username;

        //dd($validatedData);

        if (Audit::where('id', $audit->id)->update($validatedData)) {
            return redirect()->route('submission.audit.supervision', $audit->archieve_id)->with('notif',  'Data telah berhasil disimpan!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Audit $audit)
    {
        //
    }
}
