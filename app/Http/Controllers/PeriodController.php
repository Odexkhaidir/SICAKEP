<?php

namespace App\Http\Controllers;

use App\Models\Month;
use App\Models\Period;
use App\Http\Requests\StorePeriodRequest;
use App\Http\Requests\UpdatePeriodRequest;

class PeriodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $years = [date('Y'), date('Y') - 1, date('Y') - 2];

        $months = Month::all();
        $periods = Period::orderBy('id', 'desc')->get();
        return view('period.index', [
            'periods' => $periods,
            'years' => $years,
            'months' => $months,
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
    public function store(StoreperiodRequest $request)
    {
        //$this->authorize('admin');
        $range = explode(" - ", $request['date_range']);
        $validatedData = $request->validate([
            'year' => 'required',
            'month_id' => 'required',
        ]);

        $validatedData['start_date'] = $range[0];
        $validatedData['end_date'] = $range[1];
        $validatedData['status'] = 'Aktif';

        //dd($validatedData);

        if (Period::create($validatedData)) {
            return redirect('/period')->with('notif',  'Data telah berhasil disimpan!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\period  $period
     * @return \Illuminate\Http\Response
     */
    public function show(period $period)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\period  $period
     * @return \Illuminate\Http\Response
     */
    public function edit(period $period)
    {
        // dd($period);
        $years = [date('Y'), date('Y') - 1, date('Y') - 2];
        
        $months = Month::all();
        return view('period.edit', [
            'period' => $period,
            'years' => $years,
            'months' => $months,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateperiodRequest  $request
     * @param  \App\Models\period  $period
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateperiodRequest $request, period $period)
    {
        $range = explode(" - ", $request['date_range']);
        $validatedData = $request->validate([
            'year' => 'required',
            'month_id' => 'required',
        ]);

        $validatedData['start_date'] = $range[0];
        $validatedData['end_date'] = $range[1];

        //dd($validatedData);

        Period::where('id', $period->id)->update($validatedData);
        return redirect('/period')->with('notif',  'Data telah berhasil disimpan!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\period  $period
     * @return \Illuminate\Http\Response
     */
    public function destroy(period $period)
    {
        Period::destroy($period->id);
        return redirect('period')->with('notif', 'Data berhasil dihapus!');
    }
}
