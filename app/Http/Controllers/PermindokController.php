<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Satker;
use App\Models\Permindok;
use App\Models\Submission;
use App\Http\Requests\StorePermindokRequest;
use App\Http\Requests\UpdatePermindokRequest;

class PermindokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permindoks =  Permindok::all();
        return view('permindok.index', [
            'permindoks' => $permindoks
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
    public function store(StorePermindokRequest $request)
    {
        $range = explode(" - ", $request['date_range']);
        $validatedData = $request->validate([
            'description' => 'required',
        ]);

        $validatedData['start_date'] = $range[0];
        $validatedData['end_date'] = $range[1];
        $validatedData['created_by'] = auth()->user()->username;
        $validatedData['updated_by'] = auth()->user()->username;

        //dd($validatedData);

        if (Permindok::create($validatedData)) {
            return redirect('/permindok')->with('notif',  'Data telah berhasil disimpan!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Permindok $permindok)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permindok $permindok)
    {
        return view('permindok.edit', [
            'permindok' => $permindok
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePermindokRequest $request, Permindok $permindok)
    {
        $range = explode(" - ", $request['date_range']);
        $validatedData = $request->validate([
            'description' => 'required',
        ]);

        $validatedData['start_date'] = $range[0];
        $validatedData['end_date'] = $range[1];
        $validatedData['updated_by'] = auth()->user()->username;

        //dd($validatedData);

        if (Permindok::where('id', $permindok->id)->update($validatedData)) {
            return redirect('/permindok')->with('notif',  'Data telah berhasil disimpan!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permindok $permindok)
    {
        $documents = Document::where('permindok_id', $permindok->id)->get()->pluck('id');
        Permindok::where('id', $permindok->id)->delete();
        Document::where('permindok_id', $permindok->id)->delete();
        Criteria::whereIn('document_id', $documents)->delete();
        return redirect()->route('permindok.index')->with('notif', 'Data berhasil dihapus!');
    }

    public function document(Permindok $permindok)
    {
        $documents = $permindok->document;
        return view('permindok.dokumen', [
            'documents' => $documents,
            'permindok' => $permindok,
        ]);
    }

    public function enrollment(Permindok $permindok)
    {
        $satkers = Satker::all();
        $users = User::all();
        return view('permindok.enrollment', [
            'satkers' => $satkers,
            'permindok' => $permindok,
            'users' => $users,
        ]);
    }

    public function monitoring()
    {
        $permindoks = Permindok::all();
        foreach ($permindoks as $permindok) {
            $archieve_uploaded =  0;
            $archieve_total = 0;
            $audit_checked =  0;
            $audit_sesuai = 0;
            $audit_total = 0;
            foreach ($permindok->submission as $submission) {
                $archieve_uploaded += $submission->archieve->where('status', 'uploaded')->count();
                $archieve_total += $submission->archieve->count();
                foreach ($submission->archieve as $archieve) {
                    $audit_checked += $archieve->audit->where('status', '!=', null)->count();
                    $audit_sesuai += $archieve->audit->where('status', 'sesuai')->count();
                    $audit_total += $archieve->audit->count();
                }
            }
            $permindok->upload_progress = $archieve_total > 0 ?  round(100 * $archieve_uploaded / $archieve_total, 2) : 0;
            $permindok->audit_progress = $audit_total > 0 ?  round(100 * $audit_checked / $audit_total, 2) : 0;
            $permindok->progress = $audit_total > 0 ?  round(100 * $audit_sesuai / $audit_total, 2) : 0;
        }
        return view('permindok.monitoring', [
            'permindoks' => $permindoks,
        ]);
    }

    public function monitoringShow(Permindok $permindok)
    {
        $submissions = Submission::where('permindok_id', $permindok->id)->get();
        foreach ($submissions as $submission) {
            $archieve_uploaded = $submission->archieve->where('status', 'uploaded')->count();
            $archieve_total = $submission->archieve->count();
            $audit_checked =  0;
            $audit_sesuai = 0;
            $audit_total = 0;
            foreach ($submission->archieve as $archieve) {
                $audit_checked += $archieve->audit->where('status', '!=', null)->count();
                $audit_sesuai += $archieve->audit->where('status', 'sesuai')->count();
                $audit_total += $archieve->audit->count();
            }
            
            $submission->upload_progress = $archieve_total > 0 ?  round(100 * $archieve_uploaded / $archieve_total, 2) : 0;
            $submission->audit_progress = $audit_total > 0 ?  round(100 * $audit_checked / $audit_total, 2) : 0;
            $submission->progress = $audit_total > 0 ?  round(100 * $audit_sesuai / $audit_total, 2) : 0;
        }
        return view('permindok.monitoring-show', [
            'permindok' => $permindok,
            'submissions' => $submissions,
        ]);
    }
}
