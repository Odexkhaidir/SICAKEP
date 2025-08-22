<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use App\Models\Document;
use App\Models\Permindok;
use App\Http\Requests\StoreDocumentRequest;
use App\Http\Requests\UpdateDocumentRequest;

class DocumentController extends Controller
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
    public function store(StoreDocumentRequest $request)
    {
        $validatedData = $request->validate([
            'permindok_id' => 'required',
            'name' => 'required',
        ]);

        $validatedData['created_by'] = auth()->user()->username;
        $validatedData['updated_by'] = auth()->user()->username;

        if (Document::create($validatedData)) {
            return redirect()->route('permindok.documents', [$request['permindok_id']])->with('notif',  'Data telah berhasil disimpan!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Document $document)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Document $document)
    {
        return view('document.edit', [
            'document' => $document
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDocumentRequest $request, Document $document)
    {
        $validatedData = $request->validate([
            'permindok_id' => 'required',
            'name' => 'required',
        ]);

        $validatedData['updated_by'] = auth()->user()->username;

        if (Document::where('id', $document->id)->update($validatedData)) {
            return redirect()->route('permindok.documents', [$request['permindok_id']])->with('notif',  'Data telah berhasil disimpan!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Document $document)
    {
        Document::where('id', $document->id)->delete();
        $archieves = Archieve::where('document_id', $document->id)->get();
        $archieves_id = $archieves->pluck('id');
        $archieves->delete();
        Audit::whereIn('archieve_id', $archieves_id)->delete();
        Criteria::where('document_id', $document->id)->delete();
        return redirect()->route('permindok.documents', [$document->permindok_id])->with('notif', 'Data berhasil dihapus!');
    }

    public function criteria(Document $document)
    {
        $criterias = $document->criteria;
        return view('document.criteria', [
            'document' => $document,
            'criterias' => $criterias,
        ]);
    }
}
