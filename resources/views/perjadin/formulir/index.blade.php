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

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-6">

                    <div class="form-group">
                        <label class="col-4 col-form-label" for="year">Tahun</label>
                        <select class="form-control" id="year" name="year">
                            @for ($year = now()->year; $year >= now()->year - 15; $year--)
                                <option value="{{ $year }}" {{ $year == $this_year ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endfor
                        </select>
                    </div>

                </div>

                {{-- <div class="col-6">

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

                </div> --}}
            </div>
        </div>
    </div>

    <div class="card">

        <div class="card-header">
            <span class="badge badge-primary">Daftar Formulir</span>
            <div class="card-tools">
                <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-lg">
                    <i class="fas fa-plus"></i> Formulir Baru
                </button>
            </div>
        </div>

        <div class="card-body">
            <table id="document-table" class="table">
                <thead>
                    <tr>
                        <th class="text-center">No.</th>
                        <th class="text-center">Nama Supervisi</th>
                        <th class="text-center">Kriteria</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($formulirs as $document)
                        <tr>
                            <td class="text-center">
                                {{ ($formulirs->currentPage() - 1) * $formulirs->perPage() + $loop->iteration }}</td>
                            <td class="text-center">{{ $document->nama_supervisi }}</td>
                            <td class="text-center">
                                <a href="{{ $document->link }}" target="_blank">{{ $document->link }}</a>
                            </td>
                            <td class="project-actions text-center">
                                <a class="btn btn-info btn-sm" href="/perjadin/formulir/{{ $document->id }}/edit">
                                    <i class="fas fa-pencil-alt">
                                    </i>
                                    Edit
                                </a>
                                <a onclick="deleteConfirm('/perjadin/formulir/{{ $document->id }}')"
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
                // const monthSelect = document.getElementById('month');

                function updateUrl() {
                    const year = yearSelect.value;
                    // const month = monthSelect.value;
                    const url = new URL(window.location.href);
                    url.searchParams.set('year', year);
                    // url.searchParams.set('month', month);
                    window.location.href = url.toString();
                }

                yearSelect.addEventListener('change', updateUrl);
                // monthSelect.addEventListener('change', updateUrl);
            });
        </script>

    </x-slot>

</x-app-Layout>
