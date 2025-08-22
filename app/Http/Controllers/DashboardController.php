<?php

namespace App\Http\Controllers;

use App\Models\Month;
use App\Models\Score;
use App\Models\Period;
use App\Models\Quotes;
use App\Models\Satker;
use App\Models\Permindok;
use App\Models\Evaluation;
use App\Models\Submission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        if (date('d') >= 26) {
            $period = Period::where('year', date('Y'))->where('month_id', date('m'))->first();
            if (is_null($period)) {
                $new_period = Period::create([
                    'year' => date('Y'),
                    'month_id'  => date('m'),
                    'start_date' => date('Y-m-d'),
                    'end_date' => date('Y-m-d', strtotime('+4 days')),
                    'status' => 'Aktif',
                ]);
            }
        }

        // $this_year = date('Y');

        $period = Period::whereDate('start_date', '<=', date('Y-m-d'))->whereDate('end_date', '>=', date('Y-m-d'))->first();
        // $period = Period::where('month_id', 3)->first();
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
        $month = Month::where('id', $this_month)->get();

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

        $permindok_id = Permindok::latest()->get()->first();
        $submissions = Submission::where('permindok_id', $permindok_id->id)->get();
        $permindok = [];
        foreach ($submissions as $submission) {
            $archieve_uploaded = $submission->archieve->where('status', 'uploaded')->count();
            $archieve_total = $submission->archieve->count();
            $audit_checked =  0;
            $audit_sesuai = 0;
            $audit_total = 0;
            foreach ($submission->archieve as $archieve) {
                $audit_checked += $archieve->audit->where('status', '!=', null)->count();
                $audit_sesuai += $archieve->audit->where('status', 'sesuai')->count();
                $audit_total += $archieve->audit->count();
            }
            $submission->upload_progress = $archieve_total > 0 ?  round(100 * $archieve_uploaded / $archieve_total, 2) : 0;
            $submission->audit_progress = $audit_total > 0 ?  round(100 * $audit_checked / $audit_total, 2) : 0;
            $submission->progress = $audit_total > 0 ?  round(100 * $audit_sesuai / $audit_total, 2) : 0;
            $submission->score = $submission->progress * 0.75;

            //pengecualian boltim
            if ($submission->satker->code != '7111') {
                $permindok[$submission->satker->id]['code'] = $submission->satker->code;
                $permindok[$submission->satker->id]['name'] = $submission->satker->name;
                $permindok[$submission->satker->id]['score'] = $submission->score;
            }
        }

        array_multisort(array_column($permindok, 'score'), SORT_DESC, $permindok);
        $rank = 1;

        foreach ($permindok as $key => $value) {
            if ($key != 0 && $permindok[$key]['score'] == $permindok[$key - 1]['score']) {
                $permindok[$key]['rank'] = $permindok[$key - 1]['rank'];
            } else {
                $permindok[$key]['rank'] = $rank++;
            }
        }

        $quote = Quotes::inRandomOrder()->first();

        // dd($data);
        return view('dashboard', [
            'status' => $status,
            'evaluations' => $data,
            'this_year' => $this_year,
            'month' => $month,
            'evaluation_period' => $evaluation_period,
            'permindok' => $permindok,
            'permindok_description' => $permindok_id->description,
            'quote' => $quote,
        ]);
    }
}
