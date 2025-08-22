<?php

namespace App\Exports;

use App\Models\Team;
use App\Models\Score;
use App\Models\Satker;
use App\Models\Evaluation;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;

class BagianUmumExport implements FromView, WithTitle, WithStyles
{
    use Exportable;
    public function styles(Worksheet $sheet)
    {
        $styles = [
            3 => [
                'font' => ['bold' => true],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => 'b6a6ca']],
            ],
            17 => [
                'font' => ['bold' => true],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => '8db4e2']],
            ],
            'A3:' . $sheet->getHighestColumn() . $sheet->getHighestRow() => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000'], // You can change the border color here
                    ],
                ],
            ],
        ];
        $sheet->getStyle('J3:J' . $sheet->getHighestRow()) // Style all cells in column C from row 2 onwards
        ->getFill()
        ->setFillType(Fill::FILL_SOLID)
        ->getStartColor()
        ->setRGB('8db4e2');
        return $styles;
    }
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
        return 'Bagian Umum';
    }

    public function view(): View
    {
        $nama_kabag = User::find(51)->name;
        $this_year = $this->year;

        $this_month = $this->month;
        $satkers = Satker::getKabKota();

        $evaluations = Evaluation::where('year', $this_year)->where('month_id', $this_month)->get();
        $scores = Score::where('year', $this_year)->where('month_id', $this_month)->get();
        $teams = Team::where('satker_id', 1)->where('year', $this_year)->whereBetween("id", [38, 44])->get();
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
        
        return view('evaluation.bagian_umum', [
            'teams' => $teams,
            'evaluations' => $data,
            'nama_kabag'=>$nama_kabag
        ]);
    }
}
