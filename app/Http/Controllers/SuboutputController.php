<?php

namespace App\Http\Controllers;

use App\Models\Suboutput;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSuboutputRequest;
use App\Http\Requests\UpdateSuboutputRequest;
use App\Models\Output;

class SuboutputController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Output $output)
    {
        // $years = [date('Y'), date('Y') - 1, date('Y') - 2];

        return view('suboutput.create', [
            'output' => $output,
            // 'years' => $years,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSuboutputRequest $request)
    {
        $suboutput = Suboutput::create([
            'output_id' => $request['output_id'],
            'name' => $request['name'],
            'year' => $request['year'],
        ]);

        return redirect(route('output.show', $suboutput->output_id));
    }

    /**
     * Display the specified resource.
     */
    public function show(Suboutput $suboutput)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Suboutput $suboutput)
    {
        return view('suboutput.edit', [
            'suboutput' => $suboutput,
            // 'years' => $years,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSuboutputRequest $request, Suboutput $suboutput)
    {
        
        Suboutput::where('id', $suboutput->id)->update([
            'output_id' => $request['output_id'],
            'name' => $request['name'],
            'year' => $request['year'],
        ]);

        return redirect(route('output.show', $suboutput->output_id));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Suboutput $suboutput)
    {
        Suboutput::where('id', $suboutput->id)->delete();
        return redirect(route('output.show', $suboutput->output_id))->with('notification', 'Data berhasil dihapus!');
    }

}
