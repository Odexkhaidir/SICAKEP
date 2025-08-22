<tr>
    <td>Kepala Bagian Umum: {{$nama_kabag}}</td>
</tr>
<tr></tr>
<table>
    <thead style="background-color: #893bff">
        <tr style="background-color: #893bff">
            <th>Kode Satker</th>
            <th>Nama Satker</th>
            @foreach ($teams as $team)
                <th>{{ $team->name }}</th>
            @endforeach
            <th>Rata-rata</th>
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
                <td>
                    {{ $rowValidCount > 0 ? round($rowTotalScore / $rowValidCount, 2) : '-' }}
                    @if ($rowValidCount > 0)
                        @php
                            $overallTotalAverage += ($rowTotalScore / $rowValidCount);
                            $overallAverageCount++;
                        @endphp
                    @endif
                </td>
            </tr>
        @endforeach
        <tr>
            <td colspan="2">
                Rata-rata
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
    </tbody>
</table>
