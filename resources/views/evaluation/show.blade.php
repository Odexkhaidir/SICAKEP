<x-app-layout>

    <x-slot name="title">
        {{ __('Evaluasi') }}
    </x-slot>

    <x-slot name="head">
        <!-- Additional resources here -->
        <link rel="stylesheet" href="{{ url('') }}/plugins/select2/css/select2.min.css">
        <link rel="stylesheet" href="{{ url('') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    </x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/evaluation') }}">Penilaian</a></li>
        <li class="breadcrumb-item active">Show</li>
    </x-slot>

    <!-- Default box -->
    <div class="card">
        <div class="card-header border-1">
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label class="col-4 col-form-label" for="year">Tahun</label>
                        <input type="text" class="form-control" id="year" placeholder="Tahun Penilaian"
                            name="year" readonly value="{{ old('year', $evaluation->year) }}">
                        @error('year')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="col-4 col-form-label" for="team">Tim Kerja:</label>
                        <input type="text" class="form-control" id="team" placeholder="Bulan Penilaian"
                            name="team" readonly value="{{ old('team', $evaluation->team->name) }}">
                        @error('team')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="col-6">
                    <div class="form-group">
                        <label class="col-4 col-form-label" for="year">Bulan</label>
                        <input type="text" class="form-control" id="month" placeholder="Bulan Penilaian"
                            name="month" readonly value="{{ old('month', $evaluation->month_id) }}">
                        @error('month')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description" class="col-4 col-form-label">Keterangan Penilaian :</label>
                        <div>
                            <input type="text" class="form-control" id="description" placeholder="Nama Kegiatan"
                                name="description" readonly
                                value="{{$evaluation->suboutput ? $evaluation->suboutput->name : 'Tidak ada kegiatan'}}">
                        </div>
                        @error('description')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>
            </div>

        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-valign-middle">
                <thead>
                    <tr>
                        <th style="width: 150px">Kode Satker</th>
                        <th style="width: 300px">Nama Satker</th>
                        <th style="width: 100px">Realisasi</th>
                        <th style="width: 100px">Ketepatan Waktu</th>
                        <th style="width: 100px">Nilai Mutu</th>
                        <th style="width: 100px">Rata-Rata</th>
                        <th>Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($evaluation->score as $score)
                        <tr>
                            <td>
                                {{ $score->satker->code }}
                            </td>
                            <td>
                                {{ $score->satker->name }}
                            </td>
                            <td style="text-align:center">
                                {{ $score->realization_score != null ? round($score->realization_score, 2) : '-' }}
                            </td>
                            <td style="text-align:center">
                                {{ $score->time_score != null ? round($score->time_score, 2) : '-' }}
                            </td>
                            <td style="text-align:center">
                                {{ $score->quality_score != null ? round($score->quality_score, 2) : '-' }}</td>
                            <td style="text-align:center">
                                {{ $score->average_score != null ? round($score->average_score, 2) : '-' }}</td>
                            <td>{{ $score->note }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            @if ($evaluation->status <= 1)
                <a href="{{ back() }}" class="btn btn-warning float-right" style="margin-right: 5px;">Edit</a>
            @endif
            <a onclick="javascript:history.go(-1)" class="btn btn-danger float-right" style="margin-right: 5px;">Kembali</a>
        </div>

    </div>
    <!-- /.card -->

    <x-slot name="script">
        <!-- Additional JS resources -->
        <script src="{{ url('') }}/plugins/select2/js/select2.full.min.js"></script>
        <script>
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
