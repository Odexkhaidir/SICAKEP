<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use App\Models\Archieve;
use App\Models\Permindok;
use App\Models\Submission;
use App\Http\Requests\StoreSubmissionRequest;
use App\Http\Requests\UpdateSubmissionRequest;

class SubmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $submissions =  (auth()->user()->role == 'admin-provinsi')
            ? Submission::all()
            : Submission::where('satker_id', auth()->user()->satker_id)->get();
        return view('submission.index', [
            'submissions' => $submissions
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
    public function store(StoreSubmissionRequest $request)
    {
        if (!Submission::where('permindok_id', $request['permindok_id'])->where('satker_id', $request['satker_id'])->exists()) {
            $validatedData = $request->validate([
                'permindok_id' => 'required',
                'satker_id' => 'required',
                'supervisor_id' => 'required',
            ]);
            $submission = Submission::create($validatedData);
            if ($submission) {
                foreach ($submission->permindok->document as $document) {
                    $archieve = Archieve::create(['submission_id' => $submission->id, 'document_id' => $document->id]);
                    foreach ($document->criteria as $criteria) {
                        $audit = Audit::create(['archieve_id' => $archieve->id, 'criteria_id' => $criteria->id]);
                    }
                }
                return redirect()->route('permindok.enrollment', [$request['permindok_id']])->with('notif',  'Data telah berhasil disimpan!');
            }
        } else {
            return redirect()->route('permindok.enrollment', [$request['permindok_id']])->with('notif',  'Data permindok dengan satker yang dipilih sudah ada!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Submission $submission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Submission $submission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubmissionRequest $request, Submission $submission)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Submission $submission)
    {
        $archieves = Archieve::where('submission_id', $submission->id)->get()->pluck('id');
        Submission::where('id', $submission->id)->delete();
        Archieve::where('submission_id', $submission->id)->delete();
        Audit::whereIn('archieve_id', $archieves)->delete();
        return redirect()->route('permindok.enrollment', [$submission->permindok->id])->with('notif', 'Data berhasil dihapus!');
    }

    public function archieve(Submission $submission)
    {
        $archieves = $submission->archieve;
        return view('submission.archieve', [
            'archieves' => $archieves,
            'submission' => $submission,
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function supervision()
    {
        $submissions =  (auth()->user()->role == 'admin-provinsi')
            ? Submission::all()
            : Submission::where('supervisor_id', auth()->user()->id)->get();
        return view('submission.supervision', [
            'submissions' => $submissions
        ]);
    }

    public function archieveSupervision(Submission $submission)
    {
        $archieves = $submission->archieve;
        return view('submission.archieve-supervision', [
            'archieves' => $archieves,
            'submission' => $submission,
        ]);
    }


    public function result()
    {
        $submissions =  (auth()->user()->role == 'admin-provinsi')
            ? Submission::all()
            : Submission::where('satker_id', auth()->user()->satker_id)->get();
        return view('submission.result', [
            'submissions' => $submissions
        ]);
    }

    public function detail(Submission $submission)
    {
        return view('submission.result-detail', [
            'submission' => $submission,
        ]);
    }

    public function fresh(Permindok $permindok)
    {
        // dd($permindok);
        foreach ($permindok->document as $document) {
            foreach ($permindok->submission as $submission) {
                if (!Archieve::where('submission_id', $submission->id)->where('document_id', $document->id)->exists()) {
                    $archieve = Archieve::create(['submission_id' => $submission->id, 'document_id' => $document->id]);
                } else {
                    $archieve = Archieve::where('document_id', $document->id)->where('submission_id', $submission->id)->first();
                }
                foreach ($document->criteria as $criteria) {
                    if (!Audit::where('archieve_id', $archieve->id)->where('criteria_id', $criteria->id)->exists()) {
                        $audit = Audit::create(['archieve_id' => $archieve->id, 'criteria_id' => $criteria->id]);
                    }
                }
            }
        }
        return redirect()->route('permindok.enrollment', [$permindok->id])->with('notif',  'Data telah berhasil disimpan!');
    }
}
