<?php

namespace App\Exports;

use App\Models\Score;
use App\Models\Satker;
use App\Models\Evaluation;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class SatkerscoreExport implements FromView, WithTitle
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
        return 'Rekap Satker';
    }

    public function view(): View
    {
        $this_year = $this->year;

        $this_month = $this->month;

        $satkers = Satker::getKabKota();

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

        return view('evaluation.satkerexport', [
            'evaluations' => $data
        ]);
    }
}
