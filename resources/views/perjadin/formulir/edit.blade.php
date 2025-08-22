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
        <li class="breadcrumb-item"><a href="{{ url('perjadin/formulir') }}">Perjadin</a></li>
        <li class="breadcrumb-item active">Formulir</li>
    </x-slot>

    <div class="container">
        <h2>Ubah Formulir Supervisi</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ url('perjadin/formulir/' . $formulir->id . '/update') }}" method="POST">

            @csrf
            <div class="mb-3">
                <label for="nama_supervisi" class="form-label">Nama Supervisi</label>
                <input type="text" class="form-control" id="nama_supervisi_edit" name="nama_supervisi"
                    value="{{ $formulir->nama_supervisi ?? '' }}" required>
            </div>
            <div class="mb-3">
                <label for="tahun" class="form-label">Tahun</label>
                @php
                    $currentYear = date('Y');
                    $selectedTahun = old('tahun', $formulir->tahun ?? $currentYear);
                @endphp
                <select class="form-control" id="tahun" name="tahun" required>
                    <option value="">Pilih Tahun</option>
                    @for ($year = 2000; $year <= Date('Y'); $year++)
                        <option value="{{ $year }}" {{ $selectedTahun == $year ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endfor
                </select>
            </div>
            {{-- <div class="mb-3">
                <label for="bulan" class="form-label">Bulan</label>
                @php
                    $selectedBulan = old('bulan', $formulir->bulan ?? '');
                @endphp

                <select class="form-control" id="bulan_edit" name="bulan" required>
                    <option value="">Pilih Bulan</option>
                    @foreach ([
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember',
    ] as $num => $name)
                        <option value="{{ $num }}" {{ $selectedBulan == $num ? 'selected' : '' }}>
                            {{ $name }}</option>
                    @endforeach
                </select>

            </div> --}}
            <div class="mb-3">
                <label for="link" class="form-label">Link</label>
                <input type="url" class="form-control" id="link_edit" name="link"
                    value="{{ $formulir->link ?? '' }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
    <x-slot name="script">
        <!-- Additional JS resources -->
        <script></script>

    </x-slot>

</x-app-Layout>
