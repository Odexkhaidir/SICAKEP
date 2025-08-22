<table>
    <thead>
        <tr>
            <th>Kode Satker</th>
            <th>Nama Satker</th>
            @foreach ($teams as $team)
                <th>{{ $team->name }}</th>
            @endforeach
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
                @foreach ($evaluation['scores'] as $item)
                    <td>
                        {{ $item['score'] != 0 ? round($item['score'], 2) : '-' }}
                    </td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
