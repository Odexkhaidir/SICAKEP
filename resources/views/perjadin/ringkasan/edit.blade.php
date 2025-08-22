<x-app-Layout>

    <x-slot name="title">
        {{ __('Ringkasan Perjalanan Dinas') }}
    </x-slot>

    <x-slot name="head">
        <!-- Additional resources here -->
        <link rel="stylesheet" href="{{ url('') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
        <link rel="stylesheet" href="{{ url('') }}/plugins/select2/css/select2.min.css">
        <link rel="stylesheet" href="{{ url('') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="{{ url('') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
        <link rel="stylesheet" href="{{ url('') }}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
        <link rel="stylesheet" href="{{ url('') }}/plugins/daterangepicker/daterangepicker.css">
    </x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('perjadin/formulir') }}">Perjadin</a></li>
        <li class="breadcrumb-item active">Ringkasan</li>
    </x-slot>

    <div class="container">
        <h2>Ubah Ringkasan Supervisi</h2>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ url('perjadin/ringkasan/' . $ringkasan->id . '/update') }}" method="POST">

            @csrf

            <div class="mb-3">
                <label for="formulir_id" class="form-label">Formulir Terkait</label>
                <input type="text" class="form-control" id="formulir_id" name="formulir_id"
                    value="{{ $ringkasan->formulir->id }}" hidden required>
                <input type="text" class="form-control" id="formulir_nama" name="formulir_nama"
                    value="{{ $ringkasan->formulir->nama_supervisi }}" disabled required>
            </div>
            <div class="mb-3">
                <label for="tanggal" class="form-label">Tanggal</label>
                {{-- <input type="date" class="form-control" id="tanggal_edit" name="tanggal" required> --}}
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="far fa-calendar-alt"></i>
                        </span>
                    </div>
                    <input type="text" class="form-control float-right" id="jadwal" name="date_range"
                        data-end-date="{{ $ringkasan->tanggal_selesai }}"
                        data-start-date="{{ $ringkasan->tanggal_mulai }}">
                </div>
            </div>
            <div class="mb-3">
                <label for="tujuan_supervisi" class="form-label">Tujuan Supervisi</label>
                <input type="text" class="form-control" id="tujuan_supervisi_edit" name="tujuan_supervisi"
                    value="{{ old('tujuan_supervisi', $ringkasan->tujuan_supervisi ?? '') }}" required>
            </div>
            <div class="mb-3">
                <label for="fungsi" class="form-label">Fungsi</label>
                <select class="form-control" id="fungsi_edit" name="fungsi" name="fungsi" required>

                    <option value="">-- Pilih Fungsi --</option>
                    @foreach ($fungsiList as $fungsi)
                        <option value="{{ $fungsi }}"
                            {{ old('fungsi', $ringkasan->fungsi ?? '') == $fungsi ? 'selected' : '' }}>
                            {{ $fungsi }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="temuan" class="form-label">Temuan</label>
                <textarea class="form-control" id="temuan_edit" name="temuan" rows="3" required>{{ old('temuan', $ringkasan->temuan ?? '') }}</textarea>
            </div>
            <div class="mb-3">
                <label for="rekomendasi" class="form-label">Rekomendasi</label>
                <textarea class="form-control" id="rekomendasi_edit" name="rekomendasi" rows="3" required>{{ old('rekomendasi', $ringkasan->rekomendasi ?? '') }}</textarea>
            </div>
            <a href="{{ url('perjadin/ringkasan?year=' . $ringkasan->formulir->tahun . '&month=' . $ringkasan->formulir->bulan) }}"
                class="btn btn-secondary">Batalkan</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
    <x-slot name="script">
        <!-- Additional JS resources -->

        <script src="{{ url('') }}/plugins/moment/moment.min.js"></script>

        <script src="{{ url('') }}/plugins/daterangepicker/daterangepicker.js"></script>

        <script>
            $(function() {
                $('#jadwal').daterangepicker({
                    locale: {
                        format: 'YYYY-MM-DD'
                    },
                    startDate: $('#jadwal').data('start-date'),
                    endDate: $('#jadwal').data('end-date')
                });
            });
        </script>

    </x-slot>

</x-app-Layout>
