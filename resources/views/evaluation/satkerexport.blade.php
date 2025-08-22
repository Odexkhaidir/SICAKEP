<table>
    <thead>
        <tr>
            <th>Kode Satker</th>
            <th>Nama Satker</th>
            <th>Realisasi</th>
            <th>Ketepatan Waktu</th>
            <th>Nilai Mutu</th>
            <th>Rata-Rata</th>
            <th>Peringkat</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($evaluations as $evaluation)
            <tr>
                <td>
                    {{ $evaluation['code'] }}
                </td>
                <td>
                    {{ $evaluation['name'] }}
                </td>
                <td>
                    {{ $evaluation['realization_score'] > 0 ? round($evaluation['realization_score'], 2) : '-' }}</td>
                <td>
                    {{ $evaluation['time_score'] > 0 ? round($evaluation['time_score'], 2) : '-' }}</td>
                <td>
                    {{ $evaluation['quality_score'] > 0 ? round($evaluation['quality_score'], 2) : '-' }}</td>
                <td>
                    {{ $evaluation['average_score'] > 0 ? round($evaluation['average_score'], 2) : '-' }}</td>
                <td>
                    {{ $evaluation['rank'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
