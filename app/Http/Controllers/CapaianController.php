<?php

namespace App\Http\Controllers;

use App\Models\Month;
use App\Models\Satker;
use App\Models\TargetKinerja;
use Illuminate\Http\Request;

class CapaianController extends Controller
{
    public function monitoring(Request $request)
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


        $daftar_realisasi_satker = TargetKinerja::with('capaian_kinerja_satker')->where('tahun', $year)
            ->where('satker_id', $satker_id)

            ->get();

        if (auth()->user()->satker_id != '1') {
                $satkers = Satker::where('id', $satker_id)->get();  
            }
        else{
                $satkers = Satker::all();
            }
        // dd($daftar_realisasi_satker);
        // return response()->json($daftar_realisasi_satker, 200);
        

        return view('capkin.monitoring', [
            'years' => $years,
            'this_year' => $year,
            'this_satker' => $satker_id,

            'daftar_realisasi_kinerja_satker' => $daftar_realisasi_satker,
            
            'satkers' => $satkers,
        ]);
    }


    public function permindok()
    {
        $years = [date('Y'), date('Y') - 1, date('Y') - 2];

        $months = Month::all();

        $this_year = date('Y');
        $this_month = date('m');

        return view('permindok.dokumen', [
            'years' => $years,
            'months' => $months,
            'this_year' => $this_year,
            'this_month' => $this_month,
            'satkers' => Satker::all(),
        ]);
    }
}