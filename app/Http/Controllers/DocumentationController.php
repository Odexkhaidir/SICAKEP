<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use App\Models\Documentation;
use App\Models\Month;
use App\Models\JenisKegiatan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
class DocumentationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $documentations = Documentation::all();
        $startYears = DB::table('documentations')
            ->selectRaw('YEAR(start_date) AS year')
            ->distinct()
            ->pluck('year')
            ->toArray();

        // Get the unique years from the end_date column
        $endYears = DB::table('documentations')
            ->selectRaw('YEAR(end_date) AS year')
            ->distinct()
            ->pluck('year')
            ->toArray();

        // Merge the two arrays and get the unique years
        $years = array_unique(array_merge($startYears, $endYears));

        // Sort the years in ascending order
        sort($years);
        $months = Month::all();
        $this_year = date('Y');
        $jenis_kegiatans = JenisKegiatan::all();
        return view('documentation.index', [
            'documentations' => $documentations,
            'years' => $years,
            'months' => $months,
            'this_year' => $this_year,
            'jenis_kegiatans' => $jenis_kegiatans
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $teams = Team::all();
        $jenis_kegiatans = JenisKegiatan::all();
        return view('documentation.create',[
            'teams' => $teams,
            'jenis_kegiatans' => $jenis_kegiatans
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $range = explode(" - ", $request['date_range']);
        $request->validate([
            'file' => 'required|mimes:pdf|max:2048',
            'name' => 'required',
            'team_id' => 'required',
            'jenis_kegiatan_id' =>'required',
        ]);
        $doc = new Documentation;
        if($request->file()) {
            $fileName = $range[0] . '_' . $request->file->getClientOriginalName();
            $filePath = 'public/uploads/' . $fileName;

            // Check if the file already exists
            if (Storage::exists($filePath)) {
                return back()
                    ->withInput()
                    ->with('error', 'File dengan nama dan tanggal yang sama sudah pernah diupload, mohon mengganti nama file atau cek ulang isian');
            }

            // Store the file after checking if it exists
            $request->file('file')->storeAs('public/uploads', $fileName);
            $doc->name = $request->name;
            $doc->team_id = $request->team_id;
            $doc->jenis_kegiatan_id = $request->jenis_kegiatan_id;
            $doc->link = $request->link;
            $doc->created_by = auth()->user()->username;
            $doc->edited_by = auth()->user()->username;
            $doc->start_date = $range[0];
            $doc->end_date = $range[1];
            $doc->file_path = $filePath;
            $doc->save();
            return redirect('documentation')
                ->with('notification','File berhasil diupload')
                ->with('file', $request->file->getClientOriginalName());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Documentation $documentation)
    {
        return view('documentation.show', [
            "documentation" => $documentation
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Documentation $documentation)
    {
        $teams = Team::all();
        $jenis_kegiatans = JenisKegiatan::all();
        return view('documentation.edit', [
            "documentation" => $documentation,
            'teams' => $teams,
            'jenis_kegiatans' => $jenis_kegiatans
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //add update code
        $range = explode(" - ", $request['date_range']);
        $request->validate([
            'file' => 'nullable|mimes:pdf|max:2048',
            'name' => 'required',
            'team_id' => 'required',
            'jenis_kegiatan_id' =>'required',
        ]);
        
        $doc = Documentation::findOrFail($id);
        $doc->name = $request->name;
        $doc->team_id = $request->team_id;
        $doc->jenis_kegiatan_id = $request->jenis_kegiatan_id;
        $doc->link = $request->link;
        $doc->edited_by = auth()->user()->username;
        $doc->start_date = $range[0];
        $doc->end_date = $range[1];
        if ($request->file()) {
            // Delete the old file
            Storage::delete($doc->file_path);
        

            $fileName = $range[0] . '_' . $request->file->getClientOriginalName();
            $filePath = 'public/uploads/' . $fileName;
            
            // Check if the file already exists
            if (Storage::exists($filePath)) {
                return back()
                    ->withInput()
                    ->with('error', 'File dengan nama dan tanggal yang sama sudah pernah diupload, mohon mengganti nama file atau cek ulang isian');
            }

            // Store the new file
            $request->file('file')->storeAs('public/uploads', $fileName);
            // Save the relative path to the file in the database
            $doc->file_path = $filePath;
        }
        $doc->save();
        return redirect('documentation')
            ->with('notification', 'File berhasil diupdate');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $doc = Documentation::findOrFail($id);
        // Delete the file from storage
        Storage::delete($doc->file_path);
        // Delete the documentation record from the database
        $doc->delete();
        return redirect('documentation')
            ->with('notification', 'File berhasil dihapus');
    }

    public function filter(Request $request)
    {
        $year = $request->input('year');
        $month = $request->input('month');
        $jenisKegiatan = $request->input('jenis_kegiatan');

        $query = Documentation::query();

        if ($year) {
            $query->whereYear('start_date', $year);
        }

        if ($month) {
            $query->whereMonth('start_date', $month);
        }

        if ($jenisKegiatan && $jenisKegiatan !== 'all') {
            $query->where('jenis_kegiatan_id', $jenisKegiatan);
        }

        $documentations = $query->with(['jenis_kegiatan', 'team'])->get();

        return response()->json($documentations);
    }
}
