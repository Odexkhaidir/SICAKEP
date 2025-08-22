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
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;


class PimpinanExport implements FromView, WithTitle, WithStyles, WithEvents
{
    use Exportable;
    public function styles(Worksheet $sheet)
    {
        $styles = [
            // bagian judul
            1 => ['font' => ['bold' => true, 'size' => 14], 'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER]], // Center align header],
            2 => ['font' => ['bold' => true, 'size' => 14], 'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER]], // Center align header],
            // judul kolom
            4 => ['font' => ['bold' => true], 'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true]], // Center align header],
            5 => ['font' => ['bold' => true], 'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true]], // Center align header],
            3 => ['font' => ['bold' => true]],
            'A4:L5' => [
                'font' => ['bold' => true],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => 'BDD7EE']],
            ],
            // angka hasil penilaian sicakep per satker
            'C6:L18' => [
                'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => 'fff2cc']],
            ],
            'C5:L5' => ['font' => ['size' => 8]],
            // Cell Angka
            'C6:Q24' => [
                'numberFormat' => ['formatCode' => '0.00'],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER]
            ],
            // FOrm Tanda Tangan Kepala
            'N26:N32' => [
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER]
            ],
            // box legend
            'S6' => [
                'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => 'fff2cc']],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
            ],
            'S7' => [
                'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => 'c6e0b4']],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
            ],
            'S8' => [
                'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => 'ffff00']],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
            ],
            // Total Penilaian Pembinaan BPS Kabkot
            'C19:M19' => [
                'font' => ['bold' => true],
            ],
            // Penilaian Rata-rata TUgas Utama BPS Kabkot
            'M6:M18' => [
                'font' => ['bold' => true],
            ],

            'A4:Q18' => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
            ],
            'A19:L24' => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
            ],
            'M19' => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
            ],
            'C4:L4' => ['font' => ['bold' => true], 'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER]], // Center align header],
            'Q4:Q5' => ['fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => 'e26b0a']]],
            'B23:B24' => [
                'font' => ['bold' => true],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => 'e26b0a']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER]
            ],
            'Q6:Q18' => [
                'font' => ['bold' => true],
            ],
            'C20:K21' => ['fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => 'ffff00']]],
            'C22:K22' => ['fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => 'c6e0b4']]],
            'L20:L24' => ['fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => '595959']]],
            'C23:K24' => ['font' => ['bold' => true], 'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => '95b3d7']]],
            // bagian kode kabkot 
            'A4:A18' => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER]]

        ];

        $sheet->getStyle('M4:P5') // Style all cells in column C from row 2 onwards
            ->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()
            ->setRGB('c6e0b4');
        $sheet->getStyle('M6:M18') // Style all cells in column C from row 2 onwards
            ->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()
            ->setRGB('fffff');
        $sheet->getStyle('N6:N18') // Style all cells in column C from row 2 onwards
            ->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()
            ->setRGB('ffff00');
        $sheet->getStyle('O6:O18') // Style all cells in column C from row 2 onwards
            ->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()
            ->setRGB('c6e0b4');
        $sheet->getStyle('P6:P18') // Style all cells in column C from row 2 onwards
            ->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()
            ->setRGB('ffff00');

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
        return 'Rekap Kabag Madya';
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;
                $highestRow = $sheet->getHighestRow();

                // Insert formula in column Q for rows 6 to 18

                $bulan = [
                    "Januari",
                    "Februari",
                    "Maret",
                    "April",
                    "Mei",
                    "Juni",
                    "Juli",
                    "Agustus",
                    "September",
                    "Oktober",
                    "November",
                    "Desember"
                ];
                $event->sheet->getColumnDimension('A')->setWidth(7);
                $event->sheet->getColumnDimension('B')->setWidth(45);
                $event->sheet->getColumnDimension('M')->setWidth(13);
                $event->sheet->getColumnDimension('N')->setWidth(13);
                $event->sheet->getColumnDimension('O')->setWidth(13);
                $event->sheet->getColumnDimension('P')->setWidth(13);
                $event->sheet->getColumnDimension('Q')->setWidth(13);

                $sheet->setCellValue('T6', "diisi oleh Kepala BPS Provinsi");
                $sheet->setCellValue('T7', "diisi oleh SDM/Kepegawaian");
                $sheet->setCellValue('T8', "Nilai dari Sicakep");
                $sheet->setCellValue('N26', "Manado, 1 " . $bulan[$this->month - 1] . " 2025");
                $sheet->setCellValue('N27', "Kepala Badan Pusat Statistik");
                $sheet->setCellValue('N28', "Provinsi Sulawesi Utara");
                $sheet->setCellValue('N32', "Aidil Adha");

                for ($row = 6; $row <= 18; $row++) {
                    $sheet->setCellValue('Q' . $row, '=AVERAGE(M' . $row . ',P' . $row . ')');
                    $sheet->setCellValue('C' . $row, "='Bagian Umum'!J" . $row - 2);
                    $sheet->setCellValue('L' . $row, "=AVERAGE('Rekap Tim Kerja'!C" . ($row - 4) . ":D" . ($row - 4) . ")");
                    $sheet->setCellValue('M' . $row, "='Rekap Satker'!F" . $row - 4);
                }
                $rowNumber = 19; // The row where you want to insert the formulas
                $startRow = 6;
                $endRow = 18;
                $columnsToApply = ['C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L']; // Add all the columns you need

                foreach ($columnsToApply as $column) {
                    $formula = '=AVERAGE(' . $column . $startRow . ':' . $column . $endRow . ')';
                    $formula2 = '=((0.2*' . $column . '19)+(0.3*' . $column . '20)+(0.3*' . $column . '21)+(0.2*' . $column . '22))';
                    // $formula2 = '=((0,2*'.$column.'19)+(0,3*'.$column.'20)+(0,3*'.$column.'21)+(0,2*'.$column.'22))';
                    $sheet->setCellValue($column . $rowNumber, $formula);
                    if ($column == "L") {
                        continue;
                    }
                    $sheet->setCellValue($column . 23, $formula2);
                }
                $sheet->setCellValue('M19', '=AVERAGE(M' . $startRow . ':M' . $endRow . ')');
                // Another example: setting a formula in a specific cell
            },
        ];
    }
    public function view(): View
    {
        $nama_kabag = "Bhayu Prabowo";
        $this_year = $this->year;

        $this_month = $this->month;
        $satkers = Satker::getKabKota();

        $evaluations = Evaluation::where('year', $this_year)->where('month_id', $this_month)->get();
        $scores = Score::where('year', $this_year)->where('month_id', $this_month)->get();
        $teams = Team::where('satker_id', 1)->where('year', $this_year)->whereBetween("id", [30, 37])->get();
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
        $bulan = [
            "Januari",
            "Februari",
            "Maret",
            "April",
            "Mei",
            "Juni",
            "Juli",
            "Agustus",
            "September",
            "Oktober",
            "November",
            "Desember"
        ];
        return view('evaluation.pimpinan', [
            'teams' => $teams,
            'evaluations' => $data,
            'month' => $bulan[$this->month - 1]
        ]);
    }
}
