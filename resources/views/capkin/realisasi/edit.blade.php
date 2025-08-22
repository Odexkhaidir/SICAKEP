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
        <li class="breadcrumb-item active">Realisasi</li>
    </x-slot>

    <div class="container">
        <h2>Ubah Realisasi Kinerja Satker</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        {{-- {{ $target_kinerja_satker }} --}}
        <form action="{{ url('capaian-kinerja/realisasi/' . $target_kinerja_satker->id) }}" method="POST">
            @method('PUT')
            @csrf
            <div class="mb-3" hidden>
                <label for="target_kinerja_satker_id" class="form-label">Target Kinerja <span
                        class="text-danger">*</span></label>
                <input type="text" class="form-control" id="target_kinerja_satker_id" name="target_kinerja_satker_id"
                    value="{{ $target_kinerja_satker->id }}" required>
            </div>
            <div class="mb-3">
                <label for="satker" class="form-label">Satuan Kerja <span class="text-danger">*</span></label>
                <input readonly type="text" class="form-control" id="satker" name="satker"
                    value="{{ $target_kinerja_satker->satker->name }}" required>
            </div>
            <div class="mb-3">
                <label for="indikator" class="form-label">Indikator <span class="text-danger">*</span></label>
                <input readonly type="text" class="form-control" id="indikator" name="indikator"
                    value="{{ $target_kinerja_satker->indikator }}" required>
            </div>


            <label>Realisasi Kinerja (%) <span class="text-danger">*</span></label>
            <div class="row">

                <div class="col-md-3">
                    <label for="triwulan_1" class="form-label">Triwulan I</label>
                    <input type="number" step="0.01" class="form-control" id="triwulan_1" name="triwulan_1"
                        value="{{ $target_kinerja_satker->capaian_kinerja_satker->triwulan_1 ?? '' }}">

                </div>
                <div class="col-md-3">
                    <label for="triwulan_2" class="form-label">Triwulan II</label>
                    <input type="number" step="0.01" class="form-control" id="triwulan_2" name="triwulan_2"
                        value="{{ $target_kinerja_satker->capaian_kinerja_satker->triwulan_2 ?? '' }}">

                </div>
                <div class="col-md-3">
                    <label for="triwulan_3" class="form-label">Triwulan III</label>
                    <input type="number" step="0.01" class="form-control" id="triwulan_3" name="triwulan_3"
                        value="{{ $target_kinerja_satker->capaian_kinerja_satker->triwulan_3 ?? '' }}">

                </div>
                <div class="col-md-3">
                    <label for="triwulan_4" class="form-label">Triwulan IV</label>
                    <input type="number" step="0.01" class="form-control" id="triwulan_4" name="triwulan_4"
                        value="{{ $target_kinerja_satker->capaian_kinerja_satker->triwulan_4 ?? '' }}">
                </div>
            </div>
            <small class="mb-3 form-text text-muted">Gunakan tanda titik (.) sebagai pemisah desimal.</small>

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
