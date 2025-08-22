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
        <li class="breadcrumb-item active">Penilaian</li>
    </x-slot>

    <div class="card" id="result-card">
        <div class="card-header border-1">
            <div class="row">
                <div class="col-4">
                    <div class="form-group">
                        <label for="description" class="col-4 col-form-label">Satuan Kerja :</label>
                        <div>
                            <input type="text" class="form-control" id="description" placeholder="satker"
                                name="satker" readonly value="{{ $satker->name }}">
                        </div>
                        @error('description')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-4">
                    <div class="form-group">
                        <label class="col-4 col-form-label" for="year">Tahun</label>
                        <input type="text" class="form-control" id="year" placeholder="Tahun Penilaian"
                            name="year" readonly value="{{ old('year', $year) }}">
                        @error('year')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>

                <div class="col-4">
                    <div class="form-group">
                        <label class="col-4 col-form-label" for="year">Bulan</label>
                        <input type="text" class="form-control" id="month" placeholder="Bulan Penilaian"
                            name="month" readonly value="{{ old('month', $month->name) }}">
                        @error('month')
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
                        <th class="text-center">Output/Suboutput</th>
                        <th class="text-center">Realisasi</th>
                        <th class="text-center">Ketepatan Waktu</th>
                        <th class="text-center">Nilai Mutu</th>
                        <th class="text-center">Rata-Rata</th>
                        <th class="text-center">Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($scores as $score)
                    <tr>
                        <td colspan="6">
                            <b>{{$score['output_name']}}</b>
                        </td>
                    </tr>
                        @foreach ($score['score'] as $item)
                            <tr>
                                <td>&ensp;{{ $item['suboutput_name'] }}</td>
                                <td>{{ round($item['realization_score'],2) }}</td>
                                <td>{{ round($item['time_score'],2) }}</td>
                                <td>{{ round($item['quality_score'],2) }}</td>
                                <td>{{ round($item['average_score'],2) }}</td>
                                <td>{{ $item['note'] }}</td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    <x-slot name="script">
        <!-- Additional JS resources -->
        <script src="{{ url('') }}/plugins/select2/js/select2.full.min.js"></script>
        <script>
            sessionStorage.clear()

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
