<?php

namespace App\Http\Controllers;

use App\Models\Archieve;
use App\Http\Requests\StoreArchieveRequest;
use App\Http\Requests\UpdateArchieveRequest;

class ArchieveController extends Controller
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
    public function store(StoreArchieveRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Archieve $archieve)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Archieve $archieve)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateArchieveRequest $request, Archieve $archieve)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Archieve $archieve)
    {
        //
    }

    public function updateLink(UpdateArchieveRequest $request, Archieve $archieve)
    {
        $validatedData = $request->validate([
            'link' => 'required',
        ]);

        $validatedData['status'] = 'submit';
        $validatedData['updated_by'] = auth()->user()->username;

        //dd($validatedData);

        if (Archieve::where('id', $archieve->id)->update($validatedData)) {
            return redirect()->route('submission.archieves', $archieve->submission_id)->with('notif',  'Data telah berhasil disimpan!');
        }
    }

    public function updateStatus(UpdateArchieveRequest $request, Archieve $archieve)
    {
        $validatedData = $request->validate([
            'status' => 'required',
        ]);

        $validatedData['supervised_by'] = auth()->user()->username;

        //dd($validatedData);

        if (Archieve::where('id', $archieve->id)->update($validatedData)) {
            return redirect()->route('submission.archieves.supervision', $archieve->submission_id)->with('notif',  'Data telah berhasil disimpan!');
        }
    }
    
    public function auditSupervision(Archieve $archieve)
    {
        $audits = $archieve->audit;
        return view('submission.audit-supervision', [
            'archieve' => $archieve,
            'audits' => $audits,
        ]);
    }
}
