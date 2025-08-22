<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class EvaluationExport implements WithMultipleSheets
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

    public function sheets(): array
    {
        return [
            (new PimpinanExport)->forYear($this->year)->forMonth($this->month),
            (new SatkerscoreExport)->forYear($this->year)->forMonth($this->month),
            (new TimscoreExport)->forYear($this->year)->forMonth($this->month),
            (new BagianUmumExport)->forYear($this->year)->forMonth($this->month),
            // (new TimscoreExport)->forYear($this->year)->forMonth($this->month),
            // (new TimscoreExport)->forYear($this->year)->forMonth($this->month),
        ];
    }
}
