<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use App\Models\Criteria;
use App\Http\Requests\StoreCriteriaRequest;
use App\Http\Requests\UpdateCriteriaRequest;

class CriteriaController extends Controller
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
    public function store(StoreCriteriaRequest $request)
    {
        
        $validatedData = $request->validate([
            'document_id' => 'required',
            'description' => 'required',
        ]);
        
        $validatedData['created_by'] = auth()->user()->username;
        $validatedData['updated_by'] = auth()->user()->username;

        if (Criteria::create($validatedData)) {
            return redirect()->route('document.criterias', [$request['document_id']])->with('notif',  'Data telah berhasil disimpan!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Criteria $criterion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Criteria $criterion)
    {
        return view('criteria.edit', [
            'criteria' => $criterion
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCriteriaRequest $request, Criteria $criterion)
    {     
        $validatedData = $request->validate([
            'document_id' => 'required',
            'description' => 'required',
        ]);
        
        $validatedData['updated_by'] = auth()->user()->username;

        if (Criteria::where('id', $criterion->id)->update($validatedData)) {
            return redirect()->route('document.criterias', [$request['document_id']])->with('notif',  'Data telah berhasil disimpan!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Criteria $criterion)
    {
        Criteria::where('id', $criterion->id)->delete();
        Audit::where('criteria_id', $criterion->id)->delete();
        return redirect()->route('document.criterias', [$criterion['document_id']])->with('notif', 'Data berhasil dihapus!');
    }
}
