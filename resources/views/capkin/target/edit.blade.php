<x-app-Layout>

    <x-slot name="title">
        {{ __('Formulir Perjalanan Dinas') }}
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
        <li class="breadcrumb-item"><a href="{{ url('perjadin/formulir') }}">Capaian Kinerja</a></li>
        <li class="breadcrumb-item active">Target</li>
    </x-slot>

    <div class="container">
        <h2>Ubah Target Kinerja Satker</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ url('capaian-kinerja/target/' . $target_kinerja_satker->id) }}" method="POST">
            @method('PUT')
            @csrf
            <div class="mb-3">
                <label for="tahun" class="form-label">Tahun</label>
                @php
                    $currentYear = date('Y');
                    $selectedTahun = old('tahun', $target_kinerja_satker->tahun ?? $currentYear);
                @endphp
                <label for="tahun" class="form-label">Tahun <span class="text-danger">*</span></label>
                <select class="form-control" id="tahun" name="tahun" required>
                    <option value="">Pilih Tahun</option>
                    @for ($year = 2000; $year <= Date('Y'); $year++)
                        <option value="{{ $year }}" {{ $selectedTahun == $year ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endfor
                </select>
            </div>
            <div class="mb-3">
                <label for="indikator" class="form-label">Indikator Kinerja <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="indikator" name="indikator"
                    value="{{ $target_kinerja_satker->indikator ?? '' }}" required>
            </div>
            <div class="mb-3">
                <label for="target" class="form-label">Target <span class="text-danger">*</span></label>
                <input type="number" step="0.01" class="form-control" id="target" name="target"
                    value="{{ $target_kinerja_satker->target ?? '' }}" required>
                <small class="form-text text-muted">Gunakan tanda titik (.) sebagai pemisah desimal.</small>
            </div>
            <div class="mb-3">
                <label for="satuan" class="form-label">Satuan <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="satuan" name="satuan"
                    value="{{ $target_kinerja_satker->satuan ?? '' }}" required>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan
            </button>
        </form>
    </div>
    <x-slot name="script">
        <!-- Additional JS resources -->
        <script></script>

    </x-slot>

</x-app-Layout>
