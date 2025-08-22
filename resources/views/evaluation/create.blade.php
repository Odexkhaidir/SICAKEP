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
        <li class="breadcrumb-item active">Entri</li>
    </x-slot>

    <!-- Default box -->
    <form action="/evaluation" method="post">
        @csrf
        <div class="card">
            <div class="card-header border-1">
                <div class="row">
                    <div class="col-6">

                        <div class="form-group">
                            <label class="col-4 col-form-label" for="year">Tahun</label>
                            <input type="text" class="form-control" id="year" placeholder="Tahun Penilaian"
                                name="year" readonly value="{{ $year }}">
                        </div>

                        <div class="form-group">
                            <label class="col-4 col-form-label" for="team">Tim Kerja:</label>
                            <select id="team" class="form-control select2bs4" name="team" required>
                                <option value="">Pilih Tim Kerja</option>
                                @foreach ($teams as $team)
                                    <option {{ old('team') == $team->id ? 'selected' : '' }}
                                        value="{{ $team->id }}">{{ $team->name }}</option>
                                @endforeach
                            </select>
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
                                name="month" readonly value="{{ $month }}">
                        </div>

                        <div class="form-group">
                            <label for="suboutput" class="col-4 col-form-label">Output/Suboutput :</label>

                            <select id="suboutput" class="form-control select2bs4" name="suboutput" required>
                                <option value="">Pilih Output/Suboutput</option>
                                {{-- @foreach ($outputs as $output)
                                    @foreach ($output->suboutput as $suboutput)
                                        <option {{ old('suboutput') == $suboutput->id ? 'selected' : '' }}
                                            value="{{ $suboutput->id }}">
                                            {{ $output->name . ' - ' . $suboutput->name }}
                                        </option>
                                    @endforeach
                                @endforeach --}}
                            </select>
                            @error('suboutput')
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
                        @foreach ($satkers as $satker)
                            <tr>
                                <td>
                                    {{ $satker->code }}
                                    <input type="hidden" class="form-control" id="{{ 'satker' . $satker->id }}"
                                        name="{{ 'satker_' . $satker->code }}" value="{{ $satker->code }}">
                                </td>
                                <td>
                                    {{ $satker->name }}
                                </td>
                                <td style="text-align:center">
                                    <input type="number" class="form-control"
                                        id="{{ 'realization_score_' . $satker->id }}"
                                        name="{{ 'realization_score_' . $satker->code }}"  max="100" step=".01">
                                </td>
                                <td style="text-align:center">
                                    <input type="number" class="form-control" id="{{ 'time_score_' . $satker->id }}"
                                        name="{{ 'time_score_' . $satker->code }}"  max="100" step=".01">
                                </td>
                                <td style="text-align:center">
                                    <input type="number" class="form-control"
                                        id="{{ 'quality_score_' . $satker->id }}"
                                        name="{{ 'quality_score_' . $satker->code }}"  max="100" step=".01">
                                </td>
                                <td style="text-align:center">
                                    <input readonly type="number" class="form-control"
                                        id="{{ 'average_score_' . $satker->id }}"
                                        name="{{ 'average_score_' . $satker->code }}"  max="100" step=".01">
                                </td>
                                <td style="text-align:center">
                                    <input type="text" class="form-control" id="{{ 'note_' . $satker->code }}"
                                        name="{{ 'note_' . $satker->code }}">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="button" class="btn btn-success float-right" data-toggle="modal"
                    data-target="#modal-simpan">Simpan</button>
                <a href="{{ url('evaluation') }}" class="btn btn-danger float-right"
                    style="margin-right: 5px;">Batal</a>
            </div>

        </div>
        <!-- /.card -->

        <div class="modal fade" id="modal-simpan">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Konfirmasi</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Pastikan data yang anda isikan sudah benar</p>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-success" id="save-button">Simpan</button>
                    </div>
                </div>
    </form>
    <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <x-slot name="script">
        <!-- Additional JS resources -->
        <script src="{{ url('') }}/plugins/select2/js/select2.full.min.js"></script>
        <script src="{{ url('') }}/js/create-evaluation.js"></script>
        <script>

            const url_fetch_output = new URL("{{ route('output-fetch') }}")
            const tokens = '{{ csrf_token() }}'

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
