<x-app-layout>

    <x-slot name="title">
        {{ __('Evaluasi') }}
    </x-slot>

    <x-slot name="head">
        <!-- Additional resources here -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="{{ url('') }}/plugins/select2/css/select2.min.css">
        <link rel="stylesheet" href="{{ url('') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    </x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item">Penilaian</li>
        <li class="breadcrumb-item active">Finalisasi</li>
    </x-slot>

    <!-- Default box -->

    <div class="card">
        <form method="post" enctype="multipart/form-data" id="filterForm">
            <!-- form start -->
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-4">
                        <select id="year" class="form-control col-sm-6 select2bs4" name="year">
                            <option value="">Pilih Tahun</option>
                            @foreach ($years as $year)
                                <option {{ $this_year == $year ? 'selected' : '' }} value="{{ $year }}">
                                    {{ $year }} </option>
                            @endforeach
                        </select>
                        <div class="help-block"></div>
                    </div>

                    <div class="form-group col-4">
                        <select id="month" class="form-control col-sm-6 select2bs4" name="month">
                            <option value="">Pilih Bulan</option>
                            @foreach ($months as $month)
                                <option {{ $this_month == $month->id ? 'selected' : '' }} value="{{ $month->id }}">
                                    {{ $month->name }} </option>
                            @endforeach
                        </select>
                        <div class="help-block"></div>
                    </div>

                    <div class="col-4">
                        <button id="filter-button" type="button" class="btn btn-info">Tampilkan</button>
                        @if ($status == 2)
                            <button id="final-button" type="button" class="btn btn-success">Final</button>
                        @endif
                        <a href="{{route('evaluation-export', [$this_year, $this_month])}}" id="export-button" type="button" class="btn btn-default" target="_blank">Export</a>
                    </div>

                </div>
            </div>
        </form>
    </div>
    <!-- /.card -->

    @if ($status < 2)
        <div class="alert alert-warning alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-exclamation-triangle"></i> Pemberitahuan!</h5>
            Penilaian bulan {{ $this_month }} tahun {{ $this_year }} masih belum selesai.
        </div>
    @endif

    <div class="card" id="result-card">
        <div class="card-body table-responsive p-0">
            <table class="table table-valign-middle">
                <thead>
                    <tr>
                        <th style="width: 150px">Kode Satker</th>
                        <th style="width: 350px">Nama Satker</th>
                        <th class="text-center">Realisasi</th>
                        <th class="text-center">Ketepatan Waktu</th>
                        <th class="text-center">Nilai Mutu</th>
                        <th class="text-center">Rata-Rata</th>
                        <th class="text-center">Peringkat</th>
                        <th class="text-center" style="width: 150px"></th>
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
                            <td style="text-align:center" id="{{ 'realization_score_' . $evaluation['code'] }}">
                                {{ $evaluation['realization_score'] >0 ? round($evaluation['realization_score'], 2) : '-' }}</td>
                            <td style="text-align:center" id="{{ 'time_score_' . $evaluation['code'] }}">
                                {{ $evaluation['time_score'] >0 ? round($evaluation['time_score'], 2) : '-'  }}</td>
                            <td style="text-align:center" id="{{ 'quality_score_' . $evaluation['code'] }}">
                                {{ $evaluation['quality_score'] >0 ? round($evaluation['quality_score'], 2) : '-'  }}</td>
                            <td style="text-align:center" id="{{ 'average_score_' . $evaluation['code'] }}">
                                {{ $evaluation['average_score'] >0 ? round($evaluation['average_score'], 2) : '-'  }}</td>
                            <td style="text-align:center" id="{{ 'rank_' . $evaluation['code'] }}">
                                {{ $evaluation['rank'] }}</td>
                            <td><a
                                    href="/evaluation/detail/{{ $this_year . '/' . $this_month . '/' . $evaluation['satker_id'] }}"><span
                                        class="badge bg-warning"> detail </span></a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="card" id="result-card">
        <div class="card-body table-responsive p-0">
            <table class="table table-valign-middle">
                <thead>
                    <tr>
                        <th style="width: 150px">Kode Satker</th>
                        <th style="width: 350px">Nama Satker</th>
                        @foreach ($teams as $team)
                            <th>{{ $team->name }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data_team as $evaluation)
                        <tr>
                            <td>
                                {{ $evaluation['code'] }}
                            </td>
                            <td>
                                {{ $evaluation['name'] }}
                            </td>
                            @foreach ($evaluation['scores'] as $item)
                                <td id={{ 'score_' . $evaluation['satker_id'] . '_' . $item['team_id'] }}>
                                    {{ $item['score'] != 0 ? round($item['score'], 2) : '-' }}
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    <x-slot name="script">
        <!-- Additional JS resources -->
        <script src="{{ url('') }}/plugins/select2/js/select2.full.min.js"></script>
        <script src="{{ asset('js/final.js') }}"></script>
        <script>
            sessionStorage.clear()
            const tokens = '{{ csrf_token() }}'
            const url_final = new URL("{{ route('final-evaluation') }}")
            const url_get_recap = new URL("{{ route('evaluation-recap') }}")

            function deleteConfirm(url) {
                $('#btn-delete').attr('action', url);
                $('#deleteModal').modal();
            }

            $(document).on('focus', '.select2-selection', function(e) {
                $(this).closest(".select2-container").siblings('select:enabled').select2('open');
            })

            $(document).on('select2:open', () => {
                document.querySelector('.select2-search__field').focus();
            });

            $(function() {
                //Initialize Select2 Elements
                $('.select2').select2()

                //Initialize Select2 Elements
                $('.select2bs4').select2({
                    theme: 'bootstrap4',
                    width: '100%',
                })
            });
        </script>
    </x-slot>

</x-app-layout>
