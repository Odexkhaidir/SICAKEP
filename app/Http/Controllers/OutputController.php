<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use App\Models\Output;
use Illuminate\Http\Request;
use App\Http\Requests\StoreOutputRequest;
use App\Http\Requests\UpdateOutputRequest;

class OutputController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $outputs = Output::where('year', date('Y'))->get();
        $years = [date('Y'), date('Y') - 1, date('Y') - 2];
        
        return view('output.index', [
            'outputs' => $outputs,
            'years' => $years,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $teams = Team::where('satker_id', auth()->user()->satker_id)->get();
        $supervisors = User::where('role', 'supervisor')->get();
        $years = [date('Y'), date('Y') - 1, date('Y') - 2];

        return view('output.create', [
            'teams' => $teams,
            'supervisors' => $supervisors,
            'years' => $years,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOutputRequest $request)
    {
        $output = Output::create([
            'name' => $request['name'],
            'team_id' => $request['team_id'],
            'supervisor_id' => $request['supervisor_id'],
            'year' => $request['year'],
        ]);

        return redirect(route('output.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Output $output)
    {        
        return view('output.show', [
            'output' => $output,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Output $output)
    {
        $teams = Team::where('satker_id', auth()->user()->satker_id)->get();
        $supervisors = User::where('role', 'supervisor')->get();
        $years = [date('Y'), date('Y') - 1, date('Y') - 2];

        return view('output.edit', [
            'output' => $output,
            'teams' => $teams,
            'supervisors' => $supervisors,
            'years' => $years,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOutputRequest $request, Output $output)
    {
        Output::where('id', $output->id)->update([
            'name' => $request['name'],
            'team_id' => $request['team_id'],
            'supervisor_id' => $request['supervisor_id'],
            'year' => $request['year'],
        ]);

        return redirect(route('output.show', $output->id));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Output $output)
    {
        Output::where('id', $output->id)->delete();
        return redirect(route('output.index'))->with('notification', 'Data berhasil dihapus!');
    }

    public function teamFetch(Request $request){
        $data = Output::where('team_id', $request->team)->where('year', $request->year)->get();
        return response()->json($data);
    }
}
