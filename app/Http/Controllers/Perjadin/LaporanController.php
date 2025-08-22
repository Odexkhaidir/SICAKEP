<?php

namespace App\Http\Controllers\Perjadin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Month;
use App\Models\Perjadin\Formulir;
use App\Models\Satker;
use App\Models\Perjadin\Laporan;
use Illuminate\Support\Facades\Storage;


class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $year = $request->input('year');
        $month = $request->input('month');
        $formulir_id = (int)$request->input('formulir');

        // Set default values if not provided
        if (empty($year)) {
            $year = date('Y');
        } else {
            $year = $request->input('year', date('Y'));
        }
        if (empty($month)) {
            $month = date('m');
        } else {
            $month = $request->input('month', date('m'));
        }
        if (empty($formulir_id)) {
            $this_formulir = "";
        } else {
            $this_formulir = $formulir_id;
        }
        $month = $request->input('month', date('m'));
        $years = [date('Y'), date('Y') - 1, date('Y') - 2];

        $months = Month::all();


        $daftar_formulir = Formulir::where('tahun', $year)
            // ->where('bulan', $month)
            // ->whereDoesntHave('laporan')
            ->get();
        $daftar_laporan = Laporan::with(['formulir'])->whereHas('formulir', function ($query) use ($year, $month, $formulir_id) {
            if (!empty($formulir_id)) {
                $query->where('id', $formulir_id);
            } else {
                $query->where('tahun', $year);
                // ->where('bulan', $month);
            }
        })->paginate(5);
        // dd($daftar_laporan, $formulir_id);

        // $formulirs = Ringkasan::where('tahun', $this_year)
        //     ->where('bulan', $this_month)
        //     ->get();
        // dd($daftar_laporan);
        return view('perjadin.laporan.index', [
            'years' => $years,
            'months' => $months,
            'this_year' => $year,
            'this_month' => $month,
            'satkers' => Satker::all(),
            'daftar_formulir' => $daftar_formulir,
            'daftar_laporan' => $daftar_laporan,
            'this_formulir' => $this_formulir,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $year = request()->input('year', date('Y'));

        $fungsiList = [
            'Supervisi Keuangan',
            'Supervisi Umum',
            'Supervisi Teknis',
            'Supervisi SDM',
            'Supervisi Lainnya'
        ];
        $daftar_formulir = Formulir::where('tahun', $year)
            // ->where('bulan', $month)
            // ->whereDoesntHave('laporan')
            ->get();
        return view('perjadin.laporan.create', [
            'this_year' => $year,
            'months' => Month::all(),
            // 'satkers' => $satkers,
            'fungsiList' => $fungsiList,
            'daftar_formulir' => $daftar_formulir,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'formulir' => 'required|exists:perjadin_formulir,id',
            'file' => 'required|file|mimes:pdf|max:2048', // Validasi file PDF dengan ukuran maksimum 2MB

            // Tambahkan validasi lain sesuai kebutuhan field formulir
        ]);

        $laporan = new Laporan();
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $laporan->user_id = auth()->id();
            $laporan->file_name = $file->getClientOriginalName();
            $laporan->file_type = $file->getClientOriginalExtension();
            $laporan->file_size = $file->getSize();
            $filePath = $file->store('laporan', 'public');
            $laporan->file_path = $filePath;
        }

        $laporan->formulir_id = $request->input('formulir');
        $laporan->save();

        return redirect()->route('perjadin.laporan.index', [
            'year' => $laporan->formulir->tahun,
            'month' => $laporan->formulir->bulan
        ])->with('success', 'Data ringkasan berhasil disimpan.');
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

        $year = request()->input('year', date('Y'));
        return view('perjadin.laporan.edit', [
            'year' => $year,
            'laporan' => Laporan::findOrFail($id),
            'this_laporan' => $id,
            // 'formulirs' => $formulirs,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'formulir_id' => 'required|exists:perjadin_formulir,id',
            'file' => 'required|file|mimes:pdf|max:2048', // Validasi file PDF dengan ukuran maksimum 2MB

            // Tambahkan validasi lain sesuai kebutuhan field formulir
        ]);

        $laporan = Laporan::findOrFail($id);
        if ($request->hasFile('file')) {
            // Hapus file lama jika ada
            if ($laporan->file_path) {
                Storage::disk('public')->delete($laporan->file_path);
            }
            $file = $request->file('file');
            $laporan->user_id = auth()->id();
            $laporan->file_name = $file->getClientOriginalName();
            $laporan->file_type = $file->getClientOriginalExtension();
            $laporan->file_size = $file->getSize();
            $filePath = $file->store('laporan', 'public');
            $laporan->file_path = $filePath;
        }

        // $laporan->formulir_id = $request->input('formulir');
        $laporan->save();

        return redirect()->route('perjadin.laporan.index', [
            'year' => $laporan->formulir->tahun,
            // 'month' => $laporan->formulir->bulan
        ])->with('success', 'Data laporan berhasil disimpan.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $laporan = Laporan::findOrFail($id);
        if ($laporan->file_path) {
            Storage::disk('public')->delete($laporan->file_path);
        }
        $laporan->delete();

        return redirect()->route('perjadin.laporan.index', [
            'year' => $laporan->formulir->tahun,
            'month' => $laporan->formulir->bulan
        ])->with('success', 'Data laporan berhasil dihapus.');
    }
}
