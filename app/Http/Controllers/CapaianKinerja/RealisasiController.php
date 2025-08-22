<?php

namespace App\Http\Controllers\CapaianKinerja;

use App\Http\Controllers\Controller;
use App\Models\CapaianKinerja;
use Illuminate\Http\Request;
use App\Models\Month;
use App\Models\Satker;
use App\Models\TargetKinerja;

class RealisasiController extends Controller
{
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

        return view('capkin.realisasi.index', [
            'years' => $years,
            'this_year' => $year,
            'this_satker' => $satker_id,

            'daftar_realisasi_kinerja_satker' => $daftar_realisasi_satker,
            'satkers' => $satkers,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('capkin.realisasi.create', [
            'capaian_kinerja' => new CapaianKinerja(),
            'satkers' => Satker::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'target_kinerja_satker_id' => 'required|exists:target_kinerja_satker,id',
            'bulan' => 'required|integer|between:1,12',
            'realisasi' => 'required|numeric|min:0',

        ]);

        $capaian = new CapaianKinerja();
        $capaian->target_kinerja_satker_id = $request->input('target_kinerja_satker_id');
        $capaian->bulan = $request->input('bulan');
        $capaian->realisasi = $request->input('realisasi');
        $capaian->save();

        return redirect()->route('capkin.realisasi.index')->with('success', 'Data formulir berhasil disimpan.');
    }



    /**
     * Display the specified resource.
     */
    public function show(CapaianKinerja $capaian)
    {
        return view('capkin.realisasi.show', [
            'capaian_kinerja' => $capaian
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($target_kinerja_satker)
    {
        $target_kinerja_satker = TargetKinerja::with(['capaian_kinerja_satker'])->findOrFail($target_kinerja_satker);
        // dd($target_kinerja_satker);

        // return response()->json($target_kinerja_satker, 200);

        return view('capkin.realisasi.edit', [
            'target_kinerja_satker' => $target_kinerja_satker
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TargetKinerja $target)
    {
        // $request->validate([
        //     'target_kinerja_satker_id' => 'required|exists:target_kinerja_satker,id',
        //     // 'bulan' => 'required|integer|between:1,12',
        //     'triwulan_1' => 'nullable|numeric|min:0',
        //     'triwulan_2' => ['nullable', 'numeric', function ($attribute, $value, $fail) use ($request) {
        //         if ($value < $request->input('triwulan_1')) {
        //             $fail('Triwulan II tidak boleh kurang dari Triwulan I.');
        //         }
        //     }],
        //     'triwulan_3' => ['nullable', 'numeric', function ($attribute, $value, $fail) use ($request) {
        //         if ($value < $request->input('triwulan_2')) {
        //             $fail('Triwulan III tidak boleh kurang dari Triwulan II.');
        //         }
        //     }],
        //     'triwulan_4' => ['nullable', 'numeric', function ($attribute, $value, $fail) use ($request) {
        //         if ($value < $request->input('triwulan_3')) {
        //             $fail('Triwulan IV tidak boleh kurang dari Triwulan III.');
        //         }
        //     }],
        // ]);

        $request->validate([
            'target_kinerja_satker_id' => 'required|exists:target_kinerja_satker,id',
            'triwulan_1' => 'nullable|numeric|min:0',
            'triwulan_2' => [
                'nullable',
                'numeric',
                function ($attribute, $value, $fail) use ($request) {
                    $t1 = $request->input('triwulan_1');
                    if (!is_null($value) && !is_null($t1) && $value < $t1) {
                        $fail('Triwulan II tidak boleh kurang dari Triwulan I.');
                    }
                }
            ],
            'triwulan_3' => [
                'nullable',
                'numeric',
                function ($attribute, $value, $fail) use ($request) {
                    $prev = $request->input('triwulan_2') ?? $request->input('triwulan_1');
                    if (!is_null($value) && !is_null($prev) && $value < $prev) {
                        $fail('Triwulan III tidak boleh kurang dari nilai sebelumnya yang terisi.');
                    }
                }
            ],
            'triwulan_4' => [
                'nullable',
                'numeric',
                function ($attribute, $value, $fail) use ($request) {
                    $prev = $request->input('triwulan_3')
                        ?? $request->input('triwulan_2')
                        ?? $request->input('triwulan_1');
                    if (!is_null($value) && !is_null($prev) && $value < $prev) {
                        $fail('Triwulan IV tidak boleh kurang dari nilai sebelumnya yang terisi.');
                    }
                }
            ],
        ]);


        // Validate that at least one triwulan is filled out
        if (!$request->input('triwulan_1') && !$request->input('triwulan_2') && !$request->input('triwulan_3') && !$request->input('triwulan_4')) {
            return redirect()->back()->withErrors(['Salah satu triwulan harus diisi.'])->withInput();
        }

        $capaian = CapaianKinerja::where('target_kinerja_satker_id', $request->input('target_kinerja_satker_id'))
            ->first();

        if (!$capaian) {
            $capaian = new CapaianKinerja();
        }
        $capaian->target_kinerja_satker_id = $request->input('target_kinerja_satker_id');
        $capaian->triwulan_1 = $request->input('triwulan_1');
        $capaian->triwulan_2 = $request->input('triwulan_2');
        $capaian->triwulan_3 = $request->input('triwulan_3');
        $capaian->triwulan_4 = $request->input('triwulan_4');
        $capaian->save();


        return redirect()->route('capaian-kinerja.realisasi.index')->with('success', 'Data formulir berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($target_id)
    {
        $capaian = CapaianKinerja::where('target_kinerja_satker_id', $target_id)
            ->first();
        if (!$capaian) {
            return redirect()->route('capaian-kinerja.realisasi.index')->with('errors', 'Data Capaian belum dientri.');
        }
        $capaian->delete();
        return redirect()->route('capaian-kinerja.realisasi.index')->with('success', 'Data formulir berhasil dihapus.');
    }
}