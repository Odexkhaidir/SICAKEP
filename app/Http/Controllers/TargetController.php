<?php

namespace App\Http\Controllers;

use App\Models\Target;
use App\Models\Month;
use App\Http\Requests\StoreTargetRequest;
use App\Http\Requests\UpdateTargetRequest;
use App\Models\Satker;
use App\Models\TargetKinerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

class TargetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $satker_id = $user->satker_id ?? null;

        $year = $request->input('year', Date('Y'));
        if (auth()->user()->satker_id == '1') {
                $satker_id = $request->input('satker', $satker_id);
            }
        // dd($satker_id, $year);
        // Set default values if not provided

        $years = [date('Y'), date('Y') - 1, date('Y') - 2];

        $months = Month::all();

        $daftar_target_kinerja_satker = TargetKinerja::where('tahun', $year)
            ->where('satker_id', $satker_id)
            ->get();
        
        if (auth()->user()->satker_id != '1') {
                $satkers = Satker::where('id', $satker_id)->get();  
            }
        else{
                $satkers = Satker::all();
            }

        return view('capkin.target.index', [
            'years' => $years,
            'months' => $months,
            'this_year' => $year,
            'this_satker' => $satker_id,

            'daftar_target_kinerja_satker' => $daftar_target_kinerja_satker,
            'satkers' => $satkers,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('capkin.target.create', [
            'target_kinerja_satker' => new TargetKinerja(),
            'satkers' => Satker::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'satker' => 'required|exists:satkers,id',
            'tahun' => 'required|integer',
            'indikator' => 'required|string|max:255',
            'target' => 'required|numeric',
            'satuan' => 'required|string|max:50',

        ]);

        $target = new TargetKinerja();
        $target->satker_id = $request->input('satker');
        $target->tahun = $request->input('tahun');
        $target->indikator = $request->input('indikator');
        $target->target = $request->input('target');
        $target->satuan = $request->input('satuan');
        $target->save();

        return redirect()->route('capaian-kinerja.target.index')->with('success', 'Data formulir berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Target $target)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TargetKinerja $target)
    {
        return view('capkin.target.edit', [
            'target_kinerja_satker' => $target
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TargetKinerja $target)
    {
        $request->validate([
            'tahun' => 'required|integer',
            'indikator' => 'required|string|max:255',
            'target' => 'required|numeric',
            'satuan' => 'required|string|max:50',

        ]);

        $target->tahun = $request->input('tahun');
        $target->indikator = $request->input('indikator');
        $target->target = $request->input('target');
        $target->satuan = $request->input('satuan');
        $target->save();

        return redirect()->route('capaian-kinerja.target.index')->with('success', 'Data formulir berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TargetKinerja $target)
    {
        $target->delete();
        return redirect()->route('capaian-kinerja.target.index')->with('success', 'Data formulir berhasil dihapus.');
    }
}
