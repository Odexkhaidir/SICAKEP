<?php

namespace App\Http\Controllers;

use App\Exports\EvaluationExport;
use App\Models\Team;
use App\Models\Month;
use App\Models\Score;
use App\Models\Output;
use App\Models\Period;
use App\Models\Satker;
use App\Models\Suboutput;
use App\Models\Evaluation;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\StoreEvaluationRequest;
use App\Http\Requests\UpdateEvaluationRequest;

class EvaluationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('evaluator');
        $years = [date('Y'), date('Y') - 1, date('Y') - 2];

        $months = Month::all();

        $this_year = date('Y');

        $period = Period::whereDate('start_date', '<=', date('Y-m-d'))->whereDate('end_date', '>=', date('Y-m-d'))->first();
        // dd($period->month_id);
        if ($period) {
            $this_month = $period->month_id;
            $evaluation_period = true;
        } else {
            $this_month = date('m');
            $evaluation_period = false;
        }


        $evaluations = Evaluation::where('year', $this_year)->where('month_id', $this_month)->get();
        $status = $evaluations->avg('status');

        $teams = (auth()->user()->role == 'admin-provinsi')
            ? Team::where('year', $this_year)->get()
            : Team::where('year', $this_year)->where('leader_id', auth()->user()->id)->get();

        $my_teams = $teams->pluck('id');
        // dd($teams);
        return view('evaluation.index', [
            'evaluations' => Evaluation::where('year', $this_year)->where('month_id', $this_month)->whereIn('team_id', $my_teams)->get(),
            'years' => $years,
            'months' => $months,
            'this_year' => $this_year,
            'this_month' => $this_month,
            'teams' => $teams,
            'evaluation_period' => $evaluation_period,
            'status' => $status,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $period = Period::whereDate('start_date', '<=', date('Y-m-d'))->whereDate('end_date', '>=', date('Y-m-d'))->first();
        // dd($period->month_id);
        if ($period) {
            $this_month = $period->month_id;
            $year = $period->year;
            $evaluation_period = true;
        } else {
            $this_month = date('m');
            $year = date('Y');
            $evaluation_period = false;
        }
        $teams = (auth()->user()->role == 'admin-provinsi')
            ? Team::where('year', $year)->get()
            : Team::where('leader_id', auth()->user()->id)->where('year', $year)->get();

        if ($evaluation_period) {
            return view('evaluation.create', [
                'satkers' => Satker::getKabKota(),
                'teams' => $teams,
                'year' => $year,
                'month' => $this_month,
            ]);
        } else {
            redirect('/evaluation/create');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEvaluationRequest $request)
    {
        // dd($request);
        $period = Period::whereDate('start_date', '<=', date('Y-m-d'))->whereDate('end_date', '>=', date('Y-m-d'))->first();
        // dd($period->month_id);
        if ($period) {
            $this_month = $period->month_id;
            $year = $period->year;
            $evaluation_period = true;
        } else {
            $this_month = date('m');
            $year = date('Y');
            $evaluation_period = false;
        }

        $evaluation = Evaluation::create([
            'team_id' => $request['team'],
            'month_id' => $this_month,
            'year' => $year,
            'suboutput_id' => $request['suboutput'],
            'status' => 0,
            'created_by' => auth()->user()->username,
            'edited_by' => auth()->user()->username,
        ]);

        $satkers = Satker::getKabKota();

        foreach ($satkers as $satker) {
            $score = [
                'evaluation_id' => $evaluation->id,
                'satker_id' => $satker->id,
                'month_id' => $this_month,
                'year' => $year,
                'realization_score' => $request['realization_score_' . $satker->code],
                'time_score' => $request['time_score_' . $satker->code],
                'quality_score' => $request['quality_score_' . $satker->code],
                'note' => $request['note_' . $satker->code],
                'created_by' => auth()->user()->username,
                'edited_by' => auth()->user()->username,
            ];

            Score::create($score);
        }

        return redirect('evaluation')->with('notif',  'Data telah berhasil disimpan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Evaluation $evaluation)
    {
        foreach ($evaluation->score as $key => $score) {
            $average_score = ($score->realization_score + $score->time_score + $score->quality_score) / 3;
            $evaluation->score[$key]->average_score = $average_score;
        }
        return view('evaluation.show', [
            'evaluation' => $evaluation,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Evaluation $evaluation)
    {
        // dd($evaluation->score);$year = date('Y');
        $period = Period::whereDate('start_date', '<=', date('Y-m-d'))->whereDate('end_date', '>=', date('Y-m-d'))->first();
        // dd($period->month_id);
        if ($period) {
            $this_month = $period->month_id;
            $year = $period->year;
            $evaluation_period = true;
        } else {
            $this_month = date('m');
            $year = date('Y');
            $evaluation_period = false;
        }
        $teams = (auth()->user()->role == 'admin-provinsi' || auth()->user()->role == 'supervisor')
            ? Team::where('year', $year)->get()
            : Team::where('leader_id', auth()->user()->id)->where('year', $year)->get();
        $satkers = Satker::getKabKota();

        foreach ($evaluation->score as $key => $score) {
            $average_score = ($score->realization_score + $score->time_score + $score->quality_score) / 3;
            $evaluation->score[$key]->average_score = $average_score;
        }
        return view('evaluation.edit', [
            'evaluation' => $evaluation,
            'satkers' => $satkers,
            'teams' => $teams,
            'year' => $year,
            'month' => $this_month,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEvaluationRequest $request, Evaluation $evaluation)
    {
        $month = $request->month;
        $year = $request->year;

        Evaluation::where('id', $evaluation->id)->update([
            'team_id' => $evaluation->team_id,
            'suboutput_id' => $request['suboutput'],
            'status' => 0,
            'edited_by' => auth()->user()->username,
        ]);

        $satkers = Satker::getKabKota();

        foreach ($satkers as $satker) {
            $score = [
                'realization_score' => $request['realization_score_' . $satker->code],
                'time_score' => $request['time_score_' . $satker->code],
                'quality_score' => $request['quality_score_' . $satker->code],
                'note' => $request['note_' . $satker->code],
                'edited_by' => auth()->user()->username,
            ];

            Score::where('evaluation_id', $evaluation->id)->where('satker_id', $satker->id)->update($score);
        }

        return redirect('evaluation')->with('notif',  'Data telah berhasil diperbaharui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Evaluation $evaluation)
    {
        Evaluation::where('id', $evaluation->id)->delete();
        Score::where('evaluation_id', $evaluation->id)->delete();
        return redirect('/evaluation')->with('notification', 'Data berhasil dihapus!');
    }

    /**
     * Submit the specified resource from storage.
     */
    public function submit(Evaluation $evaluation)
    {
        Evaluation::where('id', $evaluation->id)->update(['status' => 1]);
        return redirect('/evaluation')->with('notification', 'Data berhasil disubmit!');
    }

    /**
     * Submit the specified resource from storage.
     */
    public function approve(Evaluation $evaluation)
    {
        Evaluation::where('id', $evaluation->id)->update(['status' => 2]);
        return redirect(route('evaluation-approval'))->with('notification', 'Data penilaian berhasil disetujui!');
    }

    /**
     * Store a null newly created resource in storage.
     */
    public function create_null(Request $request)
    {

        $filter = (array) json_decode($request->filter);

        $year = $filter['year'];
        $month = $filter['month'];

        $evaluation = Evaluation::create([
            'team_id' => $filter['team'],
            'month_id' => $month,
            'year' => $year,
            'suboutput_id' => null,
            'status' => 2,
            'created_by' => auth()->user()->username,
            'edited_by' => auth()->user()->username,
        ]);

        $satkers = Satker::getKabKota();


        foreach ($satkers as $satker) {
            $score = [
                'evaluation_id' => $evaluation->id,
                'satker_id' => $satker->id,
                'month_id' => $month,
                'year' => $year,
                'realization_score' => null,
                'time_score' => null,
                'quality_score' => null,
                'note' => null,
                'created_by' => auth()->user()->username,
                'edited_by' => auth()->user()->username,
            ];
            // return response()->json(['score' => $score]);

            Score::create($score);
        }

        array_push($notification, [
            'type' => 'success',
            'title' => 'Berhasil',
            'text' => 'Data berhasil dibuat'
        ]);

        return response()->json(['messages' => $notification]);
    }

    /**
     * Show filtered list resource from storage.
     */
    public function filter(Request $request)
    {

        $filter = (array) json_decode($request->filter);
        $notification = [];

        $evaluations = Evaluation::where('year', $filter['year'])->where('month_id', $filter['month'])->where('team_id', $filter['team'])->get();

        array_push($notification, [
            'type' => 'success',
            'title' => 'Berhasil',
            'text' => 'Data berhasil diunduh'
        ]);

        return response()->json(['data' => $evaluations, 'messages' => $notification]);
    }

    public function result()
    {
        $years = [date('Y'), date('Y') - 1, date('Y') - 2];

        $months = Month::all();

        $satkers = Satker::getKabKota();

        $period = Period::whereDate('start_date', '<=', date('Y-m-d'))->whereDate('end_date', '>=', date('Y-m-d'))->first();
        // dd($period->month_id);
        if ($period) {
            $this_month = $period->month_id;
            $this_year = $period->year;
            $evaluation_period = true;
        } else {
            $this_month = date('m', strtotime('-1 month'));
            $this_year = date('Y', strtotime('-1 month'));
            $evaluation_period = false;
        }

        $satkers = Satker::getKabKota();

        $evaluations = Evaluation::where('year', $this_year)->where('month_id', $this_month)->get();
        $scores = Score::where('year', $this_year)->where('month_id', $this_month)->get();

        $status = $evaluations->avg('status');

        $data = [];

        if ($status >= 2) {

            foreach ($satkers as $satker) {
                $data[$satker->id]['satker_id'] = $satker->id;
                $data[$satker->id]['code'] = $satker->code;
                $data[$satker->id]['name'] = $satker->name;
                $data[$satker->id]['realization_score'] = $scores->where('satker_id', $satker->id)->avg('realization_score');
                $data[$satker->id]['time_score'] = $scores->where('satker_id', $satker->id)->avg('time_score');
                $data[$satker->id]['quality_score'] = $scores->where('satker_id', $satker->id)->avg('quality_score');
                $data[$satker->id]['average_score'] = ($data[$satker->id]['realization_score'] + $data[$satker->id]['time_score'] + $data[$satker->id]['quality_score']) / 3;
            }


            array_multisort(array_column($data, 'average_score'), SORT_DESC, $data);
            $rank = 1;

            foreach ($data as $key => $value) {
                if ($key != 0 && $data[$key]['average_score'] == $data[$key - 1]['average_score']) {
                    $data[$key]['rank'] = $data[$key - 1]['rank'];
                } else {
                    $data[$key]['rank'] = $rank++;
                }
            }

            array_multisort(array_column($data, 'code'), SORT_ASC, $data);
        } else {
            foreach ($satkers as $satker) {
                $data[$satker->id]['satker_id'] = $satker->id;
                $data[$satker->id]['code'] = $satker->code;
                $data[$satker->id]['name'] = $satker->name;
                $data[$satker->id]['realization_score'] = null;
                $data[$satker->id]['time_score'] = null;
                $data[$satker->id]['quality_score'] = null;
                $data[$satker->id]['average_score'] = null;
                $data[$satker->id]['rank'] = null;
            }
        }

        return view('evaluation.result', [
            'years' => $years,
            'months' => $months,
            'this_year' => $this_year,
            'this_month' => $this_month,
            'satkers' => $satkers,
            'evaluations' => $data,
            'evaluation_period' => $evaluation_period,
            'status' => $status,
        ]);
    }

    public function getRecap(Request $request)
    {
        $filter = (array) json_decode($request->filter);

        $satkers = Satker::getKabKota();

        $notification = [];

        $evaluations = Evaluation::where('year', $filter['year'])->where('month_id', $filter['month'])->get();
        $scores = Score::where('year', $filter['year'])->where('month_id', $filter['month'])->get();

        $status = $evaluations->avg('status');

        if ($status == 3) {

            $data = [];

            foreach ($satkers as $satker) {
                $data[$satker->id]['code'] = $satker->code;
                $data[$satker->id]['realization_score'] = $scores->where('satker_id', $satker->id)->avg('realization_score');
                $data[$satker->id]['time_score'] = $scores->where('satker_id', $satker->id)->avg('time_score');
                $data[$satker->id]['quality_score'] = $scores->where('satker_id', $satker->id)->avg('quality_score');
                $data[$satker->id]['average_score'] = ($data[$satker->id]['realization_score'] + $data[$satker->id]['time_score'] + $data[$satker->id]['quality_score']) / 3;
            }

            array_multisort(array_column($data, 'average_score'), SORT_DESC, $data);
            $rank = 1;

            foreach ($data as $key => $value) {
                if ($key != 0 && $data[$key]['average_score'] == $data[$key - 1]['average_score']) {
                    $data[$key]['rank'] = $data[$key - 1]['rank'];
                } else {
                    $data[$key]['rank'] = $rank++;
                }
            }

            $teams = Team::where('satker_id', 1)->where('year', $filter['year'])->get();
            $data_team = [];
            foreach ($satkers as $satker) {
                $data_team[$satker->id]['satker_id'] = $satker->id;
                $data_team[$satker->id]['code'] = $satker->code;
                $data_team[$satker->id]['name'] = $satker->name;
                foreach ($teams as $team) {
                    $evaluations_team = $evaluations->where('team_id', $team->id)->pluck('id');
                    $realization_score = $scores->where('satker_id', $satker->id)->whereIn('evaluation_id', $evaluations_team)->avg('realization_score');
                    $time_score = $scores->where('satker_id', $satker->id)->whereIn('evaluation_id', $evaluations_team)->avg('time_score');
                    $quality_score = $scores->where('satker_id', $satker->id)->whereIn('evaluation_id', $evaluations_team)->avg('quality_score');
                    $average_score = ($realization_score + $time_score + $quality_score) / 3;
                    $data_team[$satker->id]['scores'][$team->id]['team_id'] = $team->id;
                    $data_team[$satker->id]['scores'][$team->id]['score'] = $average_score;
                }
            }

            array_push($notification, [
                'type' => 'success',
                'title' => 'Berhasil',
                'text' => 'Data berhasil diunduh'
            ]);

            return response()->json(['status' => $status, 'data' => $data, 'messages' => $notification, 'data_team' => $data_team]);
        } else {

            array_push($notification, [
                'type' => 'error',
                'title' => 'Gagal',
                'text' => 'Data penilaian masih belum final/tersedia'
            ]);

            return response()->json(['status' => $status, 'messages' => $notification]);
        }
    }

    public function monitoring()
    {
        $this->authorize('supervisor');
        $years = [date('Y'), date('Y') - 1, date('Y') - 2];

        $months = Month::all();

        $period = Period::whereDate('start_date', '<=', date('Y-m-d'))->whereDate('end_date', '>=', date('Y-m-d'))->first();
        // dd($period->month_id);
        if ($period) {
            $this_month = $period->month_id;
            $this_year = $period->year;
            $evaluation_period = true;
        } else {
            $this_month = date('m');
            $this_year = date('Y');
            $evaluation_period = false;
        }

        $teams = Team::where('satker_id', 1)->where('year', date('Y'))->get();

        foreach ($teams as $key => $team) {
            if ($team->evaluation) {
                $teams[$key]->status = $team->evaluation->where('year', $this_year)->where('month_id', $this_month)->avg('status');
            } else {
                $teams[$key]->status = 0;
            }
        }

        // dd($teams);

        return view('evaluation.monitoring', [
            'years' => $years,
            'months' => $months,
            'this_year' => $this_year,
            'this_month' => $this_month,
            'teams' => $teams,
            'evaluation_period' => $evaluation_period,
        ]);
    }

    public function fetchMonitoring(Request $request)
    {
        $this->authorize('supervisor');
        $years = [date('Y'), date('Y') - 1, date('Y') - 2];

        $months = Month::all();

        $period = Period::whereDate('start_date', '<=', date('Y-m-d'))->whereDate('end_date', '>=', date('Y-m-d'))->first();

            $this_month = $request['month'];
            $this_year = $request['year'];
            $evaluation_period = false;
        

        $teams = Team::where('satker_id', 1)->where('year', $request['year'])->get();

        foreach ($teams as $key => $team) {
            if ($team->evaluation) {
                $teams[$key]->status = $team->evaluation->where('year', $this_year)->where('month_id', $this_month)->avg('status');
            } else {
                $teams[$key]->status = 0;
            }
        }

        // dd($teams);

        return view('evaluation.monitoring', [
            'years' => $years,
            'months' => $months,
            'this_year' => $this_year,
            'this_month' => $this_month,
            'teams' => $teams,
            'evaluation_period' => $evaluation_period,
        ]);
    }

    public function approval()
    {
        $this->authorize('supervisor');
        $years = [date('Y'), date('Y') - 1, date('Y') - 2];

        $months = Month::all();


        $period = Period::whereDate('start_date', '<=', date('Y-m-d'))->whereDate('end_date', '>=', date('Y-m-d'))->first();
        // dd($period->month_id);
        if ($period) {
            $this_month = $period->month_id;
            $this_year = $period->year;
            $evaluation_period = true;
        } else {
            $this_month = date('m');
            $this_year = date('Y');
            $evaluation_period = false;
        }

        $evaluations = Evaluation::where('year', $this_year)->where('month_id', $this_month)->get();
        $status = $evaluations->avg('status');

        $outputs = (auth()->user()->role == 'admin-provinsi')
            ? Output::where('year', $this_year)->get()
            : Output::where('year', $this_year)->where('supervisor_id', auth()->user()->id)->get();

        $suboutput_list = [];

        foreach ($outputs as $output) {
            foreach ($output->suboutput as $suboutput) {
                array_push($suboutput_list, $suboutput->id);
            }
        }

        $evaluations = Evaluation::where('year', $this_year)->where('month_id', $this_month)->whereIn('suboutput_id', $suboutput_list)->get();

        return view('evaluation.approval', [
            'evaluations' => $evaluations,
            'years' => $years,
            'months' => $months,
            'this_year' => $this_year,
            'this_month' => $this_month,
            'evaluation_period' => $evaluation_period,
            'status' => $status,
        ]);
    }

    public function fetchApproval(Request $request)
    {

        $outputs = (auth()->user()->role == 'admin-provinsi')
            ? Output::where('year', $request->year)->get()
            : Output::where('year', $request->year)->where('supervisor_id', auth()->user()->id)->get();

        $suboutput_list = [];

        foreach ($outputs as $output) {
            foreach ($output->suboutput as $suboutput) {
                array_push($suboutput_list, $suboutput->id);
            }
        }

        $evaluations = Evaluation::where('year', $request->year)->where('month_id', $request->month)->whereIn('suboutput_id', $suboutput_list)->get();

        return response()->json(['data' => $evaluations]);
    }

    public function approve_all(Request $request)
    {
        $notification = [];

        $outputs = (auth()->user()->role == 'admin-provinsi')
            ? Output::where('year', $request->year)->get()
            : Output::where('year', $request->year)->where('supervisor_id', auth()->user()->id)->get();

        $suboutput_list = [];

        foreach ($outputs as $output) {
            foreach ($output->suboutput as $suboutput) {
                array_push($suboutput_list, $suboutput->id);
            }
        }

        $evaluations = Evaluation::where('year', $request->year)->where('month_id', $request->month)->whereIn('suboutput_id', $suboutput_list)->get();

        foreach ($evaluations as $evaluation) {
            Evaluation::where('id', $evaluation->id)->update(['status' => 2]);
        }

        array_push($notification, [
            'type' => 'success',
            'title' => 'Berhasil',
            'text' => 'Data penilaian berhasil disetujui!'
        ]);

        return response()->json(['messages' => $notification]);
    }

    public function finalisasi()
    {
        $this->authorize('approver');
        $years = [date('Y'), date('Y') - 1, date('Y') - 2];

        $months = Month::all();

        $this_year = date('Y');

        $period = Period::whereDate('start_date', '<=', date('Y-m-d'))->whereDate('end_date', '>=', date('Y-m-d'))->first();
        // dd($period->month_id);
        if ($period) {
            $this_month = $period->month_id;
            $this_year = $period->year;
            $evaluation_period = true;
        } else {
            $this_month = date('m', strtotime('-1 month'));
            $this_year = date('Y', strtotime('-1 month'));
            $evaluation_period = false;
        }

        $satkers = Satker::getKabKota();

        $evaluations = Evaluation::where('year', $this_year)->where('month_id', $this_month)->get();
        $status = $evaluations->avg('status');

        $scores = Score::where('year', $this_year)->where('month_id', $this_month)->get();

        $data = [];

        foreach ($satkers as $satker) {
            $data[$satker->id]['satker_id'] = $satker->id;
            $data[$satker->id]['code'] = $satker->code;
            $data[$satker->id]['name'] = $satker->name;
            $data[$satker->id]['realization_score'] = $scores->where('satker_id', $satker->id)->avg('realization_score');
            $data[$satker->id]['time_score'] = $scores->where('satker_id', $satker->id)->avg('time_score');
            $data[$satker->id]['quality_score'] = $scores->where('satker_id', $satker->id)->avg('quality_score');
            $data[$satker->id]['average_score'] = ($data[$satker->id]['realization_score'] + $data[$satker->id]['time_score'] + $data[$satker->id]['quality_score']) / 3;
        }


        array_multisort(array_column($data, 'average_score'), SORT_DESC, $data);
        $rank = 1;

        foreach ($data as $key => $value) {
            if ($key != 0 && $data[$key]['average_score'] == $data[$key - 1]['average_score']) {
                $data[$key]['rank'] = $data[$key - 1]['rank'];
            } else {
                $data[$key]['rank'] = $rank++;
            }
        }

        array_multisort(array_column($data, 'code'), SORT_ASC, $data);

        $teams = Team::where('satker_id', 1)->where('year', $this_year)->get();
        $data_team = [];
        foreach ($satkers as $satker) {
            $data_team[$satker->id]['satker_id'] = $satker->id;
            $data_team[$satker->id]['code'] = $satker->code;
            $data_team[$satker->id]['name'] = $satker->name;
            foreach ($teams as $team) {
                $evaluations_team = Evaluation::where('team_id', $team->id)->where('year', $this_year)->where('month_id', $this_month)->get()->pluck('id');
                $realization_score = $scores->where('satker_id', $satker->id)->whereIn('evaluation_id', $evaluations_team)->avg('realization_score');
                $time_score = $scores->where('satker_id', $satker->id)->whereIn('evaluation_id', $evaluations_team)->avg('time_score');
                $quality_score = $scores->where('satker_id', $satker->id)->whereIn('evaluation_id', $evaluations_team)->avg('quality_score');
                $average_score = ($realization_score + $time_score + $quality_score) / 3;
                $data_team[$satker->id]['scores'][$team->id]['team_id'] = $team->id;
                $data_team[$satker->id]['scores'][$team->id]['score'] = $average_score;
            }
        }
        // dd($data_team);
        return view('evaluation.finalisasi', [
            'status' => $status,
            'evaluations' => $data,
            'years' => $years,
            'months' => $months,
            'this_year' => $this_year,
            'this_month' => $this_month,
            'evaluation_period' => $evaluation_period,
            'data_team' => $data_team,
            'teams' => $teams,
        ]);
    }

    public function final(Request $request)
    {
        $notification = [];

        $evaluations = Evaluation::where('year', $request->year)->where('month_id', $request->month)->get();

        foreach ($evaluations as $evaluation) {
            Evaluation::where('id', $evaluation->id)->update(['status' => 3]);
        }

        array_push($notification, [
            'type' => 'success',
            'title' => 'Berhasil',
            'text' => 'Data penilaian berhasil disetujui!'
        ]);

        return response()->json(['messages' => $notification]);
    }

    public function detail($year, $month, $satker)
    {
        if (auth()->user()->satker_id == $satker || auth()->user()->satker_id == 1) {
            $data = [];
            $scores = Score::where('year', $year)->where('month_id', $month)->where('satker_id', $satker)->where('realization_score', '!=', null)->get();
            foreach ($scores as $score) {
                if ($score->evaluation->suboutput) {
                    $suboutput = $score->evaluation->suboutput;

                    $realization_score = $score->realization_score;
                    $time_score = $score->time_score;
                    $quality_score = $score->quality_score;
                    $average_score = ($realization_score + $time_score + $quality_score) / 3;

                    $data[$suboutput->output->id]['output_name'] = $suboutput->output->name;
                    $data[$suboutput->output->id]['score'][$score->id]['suboutput_name'] = $suboutput->name;
                    $data[$suboutput->output->id]['score'][$score->id]['realization_score'] = $realization_score;
                    $data[$suboutput->output->id]['score'][$score->id]['time_score'] = $time_score;
                    $data[$suboutput->output->id]['score'][$score->id]['quality_score'] = $quality_score;
                    $data[$suboutput->output->id]['score'][$score->id]['average_score'] = $average_score;
                    $data[$suboutput->output->id]['score'][$score->id]['note'] = $score->note;
                }
            }

            // dd($scores);
            $month = Month::where('id', $month)->first();
            $satker = Satker::where('id', $satker)->first();
            return view('evaluation.detail', [
                'scores' => $data,
                'year' => $year,
                'month' => $month,
                'satker' => $satker,
            ]);
        } else {
            return abort(401);
        }
    }

    public function export($year, $month){
        return (new EvaluationExport)->forYear($year)->forMonth($month)->download('penilaian sicakep bulan ' . $month . ' tahun '. $year . '.xlsx');
    }

    public function fetchFilter(Request $request)
    {

        $teams = (auth()->user()->role == 'admin-provinsi')
            ? Team::where('year', $request->year)->get()
            : Team::where('year', $request->year)->where('leader_id', auth()->user()->id)->get();

        return response()->json(['data' => $teams]);
    }
}
