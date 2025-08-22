<?php

namespace App\Http\Controllers\Perjadin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Month;
use App\Models\Perjadin\Formulir;
use App\Models\Satker;
use App\Models\Perjadin\Ringkasan;


class RingkasanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $year = $request->input('year');
        $month = $request->input('month');

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
        $month = $request->input('month', date('m'));
        $years = [date('Y'), date('Y') - 1, date('Y') - 2];

        $months = Month::all();



        $formulirs = Ringkasan::with(['formulir'])->whereHas('formulir', function ($query) use ($year, $month) {
            $query->where('tahun', $year);
        })
            ->where(function ($q) use ($month) {
                // BETWEEN is inclusive, so this will include records where $month is equal to MONTH(tanggal_mulai) or MONTH(tanggal_selesai)
                $q->whereRaw('? between MONTH(tanggal_mulai) and MONTH(tanggal_selesai)', [$month]);
            })
            ->paginate(5);


        // $formulirs = Ringkasan::where('tahun', $this_year)
        //     ->where('bulan', $this_month)
        //     ->get();
        return view('perjadin.ringkasan.index', [
            'years' => $years,
            'months' => $months,
            'this_year' => $year,
            'this_month' => $month,
            'satkers' => Satker::all(),
            'formulirs' => $formulirs,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $year = request()->input('year', date('Y'));
        // $month = request()->input('month', date('m'));
        // dd($year, $month);
        $formulirs = Formulir::where('tahun', $year)
            // ->where('bulan', $month)
            ->whereDoesntHave('ringkasan')
            ->get();
        $fungsiList = [
            'Supervisi Keuangan',
            'Supervisi Umum',
            'Supervisi Teknis',
            'Supervisi SDM',
            'Supervisi Lainnya'
        ];
        return view('perjadin.ringkasan.create', [
            'year' => $year,
            // 'months' => $months,
            // 'satkers' => $satkers,
            'fungsiList' => $fungsiList,
            'formulirs' => $formulirs,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'formulir_id' => 'required|exists:perjadin_formulir,id',
            'date_range' => 'required',
            'tujuan_supervisi' => 'required|string|max:255',
            'fungsi' => 'required|string|max:255',
            'temuan' => 'required|string|max:1000',
            'rekomendasi' => 'required|string|max:1000',
            // Tambahkan validasi lain sesuai kebutuhan field formulir
        ]);

        $ringkasan = new Ringkasan();
        $ringkasan->formulir_id = $request->input('formulir_id');
        // Ambil tanggal_mulai dan tanggal_selesai dari input date_range (format: "YYYY-MM-DD - YYYY-MM-DD")
        $dateRange = $request->input('date_range');
        [$tanggal_mulai, $tanggal_selesai] = array_map('trim', explode(' - ', $dateRange));
        $ringkasan->tanggal_mulai = $tanggal_mulai;
        $ringkasan->tanggal_selesai = $tanggal_selesai;
        $ringkasan->tujuan_supervisi = $request->input('tujuan_supervisi');
        $ringkasan->fungsi = $request->input('fungsi');
        $ringkasan->temuan = $request->input('temuan');
        $ringkasan->rekomendasi = $request->input('rekomendasi');
        // Tambahkan assignment field lain sesuai kebutuhan
        $ringkasan->save();

        return redirect()->route('perjadin.ringkasan.index')->with('success', 'Data ringkasan berhasil disimpan.');
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
        $ringkasan = Ringkasan::findOrFail($id);
        // dd($ringkasan);
        $fungsiList = [
            'Supervisi Keuangan',
            'Supervisi Umum',
            'Supervisi Teknis',
            'Supervisi SDM',
            'Supervisi Lainnya'
        ];
        return view('perjadin.ringkasan.edit', compact('ringkasan', 'fungsiList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'formulir_id' => 'required|exists:perjadin_formulir,id',
            'date_range' => [
                'required',
                function ($attribute, $value, $fail) {
                    // Pastikan format: "YYYY-MM-DD - YYYY-MM-DD"
                    if (!preg_match('/^\d{4}-\d{2}-\d{2} - \d{4}-\d{2}-\d{2}$/', $value)) {
                        return $fail('Format rentang tanggal tidak valid. Gunakan format: YYYY-MM-DD - YYYY-MM-DD');
                    }
                    [$start, $end] = array_map('trim', explode(' - ', $value));
                    if (strtotime($start) === false || strtotime($end) === false) {
                        return $fail('Tanggal mulai atau tanggal selesai tidak valid.');
                    }
                    if ($start > $end) {
                        return $fail('Tanggal mulai tidak boleh lebih besar dari tanggal selesai.');
                    }
                }
            ],
            'tujuan_supervisi' => 'required|string|max:255',
            'fungsi' => 'required|string|max:255',
            'temuan' => 'required|string|max:1000',
            'rekomendasi' => 'required|string|max:1000',
            // Tambahkan validasi lain sesuai kebutuhan field formulir
        ]);

        // dd($request->all());
        $ringkasan = Ringkasan::findOrFail($id);
        $ringkasan->formulir_id = $request->input('formulir_id');
        $dateRange = $request->input('date_range');
        [$tanggal_mulai, $tanggal_selesai] = array_map('trim', explode(' - ', $dateRange));
        $ringkasan->tanggal_mulai = $tanggal_mulai;
        $ringkasan->tanggal_selesai = $tanggal_selesai;
        $ringkasan->tujuan_supervisi = $request->input('tujuan_supervisi');
        $ringkasan->fungsi = $request->input('fungsi');
        $ringkasan->temuan = $request->input('temuan');
        $ringkasan->rekomendasi = $request->input('rekomendasi');
        // Tambahkan assignment field lain sesuai kebutuhan
        $ringkasan->save();
        // dd($ringkasan->formulir->tahun, $ringkasan->formulir->bulan);
        return redirect()->route('perjadin.ringkasan.index', [
            'year' => $ringkasan->formulir->tahun,
            'month' => \Carbon\Carbon::parse($ringkasan->tanggal_mulai)->format('m'),
        ])->with('success', 'Data formulir berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $ringkasan = Ringkasan::findOrFail($id);
        $ringkasan->delete();

        return redirect()->route('perjadin.ringkasan.index')->with('success', 'Data ringkasan berhasil dihapus.');
    }
}
