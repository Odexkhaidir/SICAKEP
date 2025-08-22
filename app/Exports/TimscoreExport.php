<?php

namespace App\Exports;

use App\Models\Team;
use App\Models\Score;
use App\Models\Satker;
use App\Models\Evaluation;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithTitle;

class TimscoreExport implements FromView, WithTitle
{
    use Exportable;
   
    public function forYear(int $year)
    {
        $this->year = $year;

        return $this;
    }

    public function forMonth(int $month)
    {
        $this->month = $month;

        return $this;
    }

    public function title(): string
    {
        return 'Rekap Tim Kerja';
    }

    public function view(): View
    {
        $this_year = $this->year;

        $this_month = $this->month;
        $satkers = Satker::getKabKota();

        $evaluations = Evaluation::where('year', $this_year)->where('month_id', $this_month)->get();
        $scores = Score::where('year', $this_year)->where('month_id', $this_month)->get();
        $teams = Team::where('satker_id', 1)->where('year', $this_year)->get();
        $data = [];
        foreach ($satkers as $satker) {
            $data[$satker->id]['satker_id'] = $satker->id;
            $data[$satker->id]['code'] = $satker->code;
            $data[$satker->id]['name'] = $satker->name;
            foreach ($teams as $team) {
                $evaluations_team = $evaluations->where('team_id', $team->id)->pluck('id');
                $realization_score = $scores->where('satker_id', $satker->id)->whereIn('evaluation_id', $evaluations_team)->avg('realization_score');
                $time_score = $scores->where('satker_id', $satker->id)->whereIn('evaluation_id', $evaluations_team)->avg('time_score');
                $quality_score = $scores->where('satker_id', $satker->id)->whereIn('evaluation_id', $evaluations_team)->avg('quality_score');
                $average_score = ($realization_score + $time_score + $quality_score) / 3;
                $data[$satker->id]['scores'][$team->id]['team_id'] = $team->id;
                $data[$satker->id]['scores'][$team->id]['team_name'] = $team->name;
                $data[$satker->id]['scores'][$team->id]['score'] = $average_score;
            }
        }
        return view('evaluation.timexport', [
            'teams' => $teams,
            'evaluations' => $data
        ]);
    }
}
