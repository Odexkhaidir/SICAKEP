<tr>
    <td colspan="17" rowspan="2">REKAP PENILAIAN KINERJA KABAG UMUM, PENANGGUNGJAWAB FUNGSI DAN KEPALA BPS
        KABUPATEN/KOTA</td>
</tr>
<tr></tr>
<tr>
    <td>Bulan: {{ $month }}</td>
</tr>
<table>
    <thead>
        <tr>
            <th rowspan="2">No</th>
            <th rowspan="2">Kab/Kota</th>
            <th colspan="{{ sizeof($teams) + 2 }}">RB Tematik/Admin/Tim Kerja</th>
            <th rowspan="2">Rata-rata Tugas Utama</th>
            <th rowspan="2">Tugas Tambahan</th>
            <th rowspan="2">Presensi KabKota</th>
            <th rowspan="2">Kepatuhan/ Ketaatan</th>
            <th rowspan="2">CKP Eseleon III KabKota</th>
        </tr>
        <tr>
            <th>Adm. Umum</th>

            @foreach ($teams as $team)
                <th>{{ $team->name }}</th>
            @endforeach
            <th>IPDS</th>

        </tr>

    </thead>
    {{-- <tbody>
        @foreach ($evaluations as $evaluation)
            <tr>
                <td>
                    {{ $evaluation['code'] }}
                </td>
                <td>
                    {{ $evaluation['name'] }}
                </td>
                @php
                    $validTotalScore = 0;
                    $validCount = 0;
                @endphp
                @foreach ($evaluation['scores'] as $item)
                    @php
                        if ($item['score'] != 0) {
                            $validTotalScore += $item['score'];
                            $validCount++;
                        }
                    @endphp
                    <td>
                        {{ $item['score'] != 0 ? round($item['score'], 3) : '-' }}
                    </td>
                @endforeach
                <td>{{ $validCount > 0 ? round($validTotalScore / $validCount, 3) : '-' }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="2">
                Rata-rata
            </td>
            @foreach ($evaluation['scores'] as $item)
                <td>
                    {{ $item['score'] != 0 ? round($item['score'], 2) : '-' }}
                </td>
            @endforeach
            <td>tbd</td>
        </tr>
    </tbody> --}}
    <tbody>
        @php
            $columnTotals = [];
            $columnCounts = [];
            $overallTotalAverage = 0;
            $overallAverageCount = 0;
        @endphp
        @foreach ($evaluations as $evaluation)
            <tr>
                <td>
                    {{ $evaluation['code'] }}
                </td>
                <td>
                    {{ $evaluation['name'] }}
                </td>
                @php
                    $rowTotalScore = 0;
                    $rowValidCount = 0;
                @endphp
                <td></td>
                @foreach ($evaluation['scores'] as $index => $item)
                    @php
                        if (!isset($columnTotals[$index])) {
                            $columnTotals[$index] = 0;
                            $columnCounts[$index] = 0;
                        }
                    @endphp
                    <td>
                        {{ $item['score'] != 0 ? round($item['score'], 2) : '-' }}
                        @if ($item['score'] != 0)
                            @php
                                $columnTotals[$index] += $item['score'];
                                $columnCounts[$index]++;
                                $rowTotalScore += $item['score'];
                                $rowValidCount++;
                            @endphp
                        @endif
                    </td>
                @endforeach
                <td></td>
                <td>
                    {{ $rowValidCount > 0 ? round($rowTotalScore / $rowValidCount, 2) : '-' }}
                    @if ($rowValidCount > 0)
                        @php
                            $overallTotalAverage += $rowTotalScore / $rowValidCount;
                            $overallAverageCount++;
                        @endphp
                    @endif
                </td>
            </tr>
        @endforeach
        <tr>
            <td></td>
            <td>
                Total Nilai Pembinaan Kabkot
            </td>
            @foreach ($evaluation['scores'] as $index => $item)
                <td>
                    {{ isset($columnCounts[$index]) && $columnCounts[$index] > 0 ? round($columnTotals[$index] / $columnCounts[$index], 2) : '-' }}
                </td>
            @endforeach
            <td>
                {{ $overallAverageCount > 0 ? round($overallTotalAverage / $overallAverageCount, 2) : '-' }}
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
                Tugas dari Pimpinan
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>
                Kepatuhan/Ketaatan
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>
                Presensi
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td rowspan="2">
                CKP Ketua Gugus Tugas/Penanggungjawab Fungsi
            </td>
            @foreach ($evaluation['scores'] as $index => $item)
                <td>
                    {{ isset($columnCounts[$index]) && $columnCounts[$index] > 0 ? round($columnTotals[$index] / $columnCounts[$index], 2) : '-' }}
                </td>
            @endforeach
            <td>
                {{ $overallAverageCount > 0 ? round($overallTotalAverage / $overallAverageCount, 2) : '-' }}
            </td>
        </tr>
        <tr>
            <td></td>
            <td>KABAG</td>
            <td>Titien</td>
            <td>Sirly</td>
            <td>Norma</td>
            <td>Wuri</td>
            <td>Roy</td>
            <td>Anton</td>
            <td>Ratna</td>
            <td>Viktor</td>
            <td></td>

        </tr>
    </tbody>
</table>
