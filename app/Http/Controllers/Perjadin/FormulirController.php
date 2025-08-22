<?php

namespace App\Http\Controllers\Perjadin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Month;
use App\Models\Satker;


class FormulirController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $year = $request->input('year');
        // $month = $request->input('month');

        // Set default values if not provided
        if (empty($year)) {
            $year = date('Y');
            $this_year = date('Y');
        } else {
            $this_year = $year;
        }
        // $years = [date('Y'), date('Y') - 1, date('Y') - 2];

        // $months = Month::all();


        $formulirs = \App\Models\Perjadin\Formulir::where('tahun', $year)
            ->paginate(5);
        // $formulirs = \App\Models\Perjadin\Formulir::where('tahun', $this_year)
        //     ->where('bulan', $this_month)
        //     ->get();
        // dd($formulirs);
        return view('perjadin.formulir.index', [
            // 'years' => $years,
            'this_year' => $this_year,
            'satkers' => Satker::all(),
            'formulirs' => $formulirs,
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
    public function store(Request $request)
    {
        $request->validate([
            'tahun' => 'required|integer',
            // 'bulan' => 'required|integer',
            'nama_supervisi' => 'required|string|max:255',
            'link' => 'required|url',
            // Tambahkan validasi lain sesuai kebutuhan field formulir
        ]);

        $formulir = new \App\Models\Perjadin\Formulir();
        $formulir->tahun = $request->input('tahun');
        // $formulir->bulan = $request->input('bulan');
        $formulir->nama_supervisi = $request->input('nama_supervisi');
        $formulir->link = $request->input('link');
        // Tambahkan assignment field lain sesuai kebutuhan
        $formulir->save();

        return redirect()->route('perjadin.formulir.index')->with('success', 'Data formulir berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $formulir = \App\Models\Perjadin\Formulir::findOrFail($id);
        // dd($formulir);
        return view('perjadin.formulir.edit', compact('formulir'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'tahun' => 'required|integer',
            // 'bulan' => 'required|integer',
            'nama_supervisi' => 'required|string|max:255',
            'link' => 'required|url',
            // Tambahkan validasi lain sesuai kebutuhan field formulir
        ]);

        $formulir = \App\Models\Perjadin\Formulir::findOrFail($id);
        $formulir->tahun = $request->input('tahun');
        // $formulir->bulan = $request->input('bulan');
        $formulir->nama_supervisi = $request->input('nama_supervisi');
        $formulir->link = $request->input('link');
        // Tambahkan assignment field lain sesuai kebutuhan
        $formulir->save();

        return redirect()->route('perjadin.formulir.index')->with('success', 'Data formulir berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $formulir = \App\Models\Perjadin\Formulir::findOrFail($id);
        $formulir->delete();

        return redirect()->route('perjadin.formulir.index')->with('success', 'Data formulir berhasil dihapus.');
    }
}
