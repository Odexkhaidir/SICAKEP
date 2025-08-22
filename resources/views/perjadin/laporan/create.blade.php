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
        <li class="breadcrumb-item active">Formulir</li>
    </x-slot>

    <div class="container">
        <h2>Unggah Laporan Supervisi</h2>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ url('perjadin/laporan') }}" method="POST" enctype="multipart/form-data">

            @csrf

            <div class="mb-3 form-group row">

                <div class="mb-3 form-group col">
                    <label class="col-form-label" for="year">Tahun</label>
                    <select class="form-control" id="year" name="year">
                        @for ($i = $this_year; $i >= $this_year - 10; $i--)
                            <option value="{{ $i }}" {{ $i == $this_year ? 'selected' : '' }}>
                                {{ $i }}
                            </option>
                        @endfor
                    </select>
                </div>


                <div class="mb-3 form-group col">
                    <label for="formulir_id" class="col-form-label">Formulir Terkait</label>
                    <select class="form-control" id="formulir" name="formulir" required>
                        <option value="">Pilih Formulir</option>
                        @foreach ($daftar_formulir as $formulirItem)
                            <option value="{{ $formulirItem->id }}">
                                {{ $formulirItem->nama_supervisi ?? 'Formulir #' . $formulirItem->id }}
                            </option>
                        @endforeach
                    </select>
                </div>
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
            <div class="mb-3 text-right">

                <a href="{{ url('perjadin/laporan?year=' . $this_year) }}" class="btn btn-secondary">Batalkan</a>
                <input type="submit" class="btn btn-primary" value="Tambahkan"></input>
            </div>
        </form>
    </div>
    <x-slot name="script">
        <!-- Add
            itional JS resources -->
        <script src="{{ url('') }}/plugins/moment/moment.min.js"></script>
        <script src="{{ url('') }}/plugins/daterangepicker/daterangepicker.js"></script>

        <script>
            $(function() {
                $('#jadwal').daterangepicker({
                    locale: {
                        format: 'YYYY-MM-DD'
                    }
                });
            });
            document.addEventListener('DOMContentLoaded', function() {
                const yearSelect = document.getElementById('year');
                // const monthSelect = document.getElementById('month');
                const formulirSelect = document.getElementById('formulir');

                function updateUrl() {
                    const year = yearSelect.value;
                    // const month = monthSelect.value;
                    const formulir = formulirSelect.value;
                    const url = new URL(window.location.href);
                    url.searchParams.set('year', year);
                    // url.searchParams.set('month', month);
                    url.searchParams.set('formulir', formulir);
                    window.location.href = url.toString();
                }

                yearSelect.addEventListener('change', updateUrl);
                // monthSelect.addEventListener('change', updateUrl);
                // formulirSelect.addEventListener('change', updateUrl);
            });
        </script>

    </x-slot>

</x-app-Layout>
