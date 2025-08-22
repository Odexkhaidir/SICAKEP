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
        {{-- <h2>{{ $ringkasan->formulir->bulan }}</h2> --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ url('perjadin/laporan/' . $laporan->id . '/update') }}" method="POST"
            enctype="multipart/form-data">

            @csrf

            <div class="mb-3">
                <label for="formulir_id" class="form-label">Formulir Terkait</label>
                <input type="text" class="form-control" id="formulir_id" name="formulir_id"
                    value="{{ $laporan->formulir->id }}" hidden required>
                <input type="text" class="form-control" id="formulir_nama" name="formulir_nama"
                    value="{{ $laporan->formulir->nama_supervisi }}" disabled required>
            </div>
            <div class="mb-3 form-group row">
                <div class="mb-3 form-group col">
                    <label for="file_upload" class="col-form-label">Upload File</label>
                    <input type="file" class="form-control" id="file" name="file" accept=".pdf"
                        onchange="validatePDF(this)">
                    <small id="fileWarning" class="text-danger" style="display:none;">Hanya file PDF yang
                        diperbolehkan.</small>
                    <script>
                        function validatePDF(input) {
                            const file = input.files[0];
                            const warning = document.getElementById('fileWarning');
                            if (file && file.type !== 'application/pdf') {
                                warning.style.display = 'block';
                                input.value = '';
                            } else {
                                warning.style.display = 'none';
                            }
                        }
                    </script>
                </div>
            </div>

            <a href="{{ url('perjadin/laporan?year=' . $laporan->formulir->tahun) }}"
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
