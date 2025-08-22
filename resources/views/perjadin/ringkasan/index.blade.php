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
        <li class="breadcrumb-item active">Ringkasan</li>
    </x-slot>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-6">

                    <div class="form-group">
                        <label class="col-4 col-form-label" for="year">Tahun</label>
                        <select class="form-control" id="year" name="year">
                            @foreach ($years as $year)
                                <option value="{{ $year }}" {{ $year == $this_year ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <div class="col-6">

                    <div class="form-group">
                        <label class="col-4 col-form-label" for="year">Bulan</label>
                        <select class="form-control" id="month" name="month">
                            @foreach ($months as $month)
                                <option value="{{ $month->id }}" {{ $month->id == $this_month ? 'selected' : '' }}>
                                    {{ $month->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="card">

        <div class="card-header">
            <span class="badge badge-primary">Daftar Ringkasan</span>
            <div class="card-tools">
                <a href="{{ url('perjadin/ringkasan/create') }}?year={{ request('year', $this_year) }}&month={{ request('month', $this_month) }}"
                    class="btn btn-sm btn-success" id="create-summary-btn">
                    <i class="fas fa-plus"></i> Ringkasan Baru
                </a>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const yearSelect = document.getElementById('year');
                        const monthSelect = document.getElementById('month');
                        const createBtn = document.getElementById('create-summary-btn');

                        function updateCreateBtnUrl() {
                            const baseUrl = "{{ url('perjadin/ringkasan/create') }}";
                            const year = yearSelect.value;
                            const month = monthSelect.value;
                            createBtn.href = `${baseUrl}?year=${year}&month=${month}`;
                        }
                        yearSelect.addEventListener('change', updateCreateBtnUrl);
                        monthSelect.addEventListener('change', updateCreateBtnUrl);
                    });
                </script>
            </div>
        </div>

        <div class="card-body">
            <table id="document-table" class="table">
                <thead>
                    <tr>
                        <th class="text-center">No.</th>
                        <th class="text-center">Nama Supervisi</th>
                        <th class="text-center">Tujuan</th>
                        <th class="text-center">Tanggal</th>
                        <th class="text-center">Fungsi</th>
                        <th class="text-center">Temuan</th>
                        <th class="text-center">Rekomendasi</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($formulirs as $document)
                        <tr>
                            <td class="text-center">
                                {{ ($formulirs->currentPage() - 1) * $formulirs->perPage() + $loop->iteration }}</td>
                            <td class="text-center">{{ $document->formulir->nama_supervisi }}</td>
                            <td class="text-center">
                                {{ $document->tujuan_supervisi }}
                            </td>
                            <td class="text-center">
                                {{ \Carbon\Carbon::parse($document->tanggal_mulai)->translatedFormat('d F Y') }}
                                @if ($document->tanggal_selesai && $document->tanggal_selesai != $document->tanggal_mulai)
                                    s.d
                                    {{ \Carbon\Carbon::parse($document->tanggal_selesai)->translatedFormat('d F Y') }}
                                @endif
                            </td>
                            <td class="text-center">
                                {{ $document->fungsi }}
                            </td>
                            <td class="text-center">
                                {{ $document->temuan }}
                            </td>
                            <td class="text-center">
                                {{ $document->rekomendasi }}
                            </td>
                            <td class="project-actions text-center">
                                <a class="btn btn-info btn-sm" href="/perjadin/ringkasan/{{ $document->id }}/edit">
                                    <i class="fas fa-pencil-alt">
                                    </i>
                                    Edit
                                </a>
                                <a onclick="deleteConfirm('/perjadin/ringkasan/{{ $document->id }}')"
                                    class="btn btn-danger btn-sm" href="#">
                                    <i class="fas fa-trash">
                                    </i>
                                    Delete
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{ $formulirs->links() }}

    <div class="modal fade" id="modal-lg">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Formulir</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('perjadin.formulir.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        @include('perjadin.formulir.create')
                    </div>
            </div>
            {{-- <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div> --}}
            </form>
        </div>
    </div>




    <div class="modal fade" id="deleteModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Konfirmasi</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda Benar-Benar Ingin Menghapusnya?</p>
                </div>
                <form action="" method="post" id="btn-delete">
                    <div class="modal-footer justify-content-between">
                        @method('delete')
                        @csrf
                        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <x-slot name="script">
        <!-- Additional JS resources -->
        <script>
            function deleteConfirm(url) {
                $('#btn-delete').attr('action', url);
                $('#deleteModal').modal();
            }
            document.addEventListener('DOMContentLoaded', function() {
                const yearSelect = document.getElementById('year');
                const monthSelect = document.getElementById('month');

                function updateUrl() {
                    const year = yearSelect.value;
                    const month = monthSelect.value;
                    const url = new URL(window.location.href);
                    url.searchParams.set('year', year);
                    url.searchParams.set('month', month);
                    window.location.href = url.toString();
                }

                yearSelect.addEventListener('change', updateUrl);
                monthSelect.addEventListener('change', updateUrl);
            });
        </script>

    </x-slot>

</x-app-Layout>
