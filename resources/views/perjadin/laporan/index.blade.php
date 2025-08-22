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
                        <label class="col-4 col-form-label" for="formulir">Formulir</label>
                        <select class="form-control" id="formulir" name="formulir">
                            <option value="">-- Pilih Formulir --</option>
                            @foreach ($daftar_formulir as $formulir)
                                <option value="{{ $formulir->id }}"
                                    {{ $formulir->id == $this_formulir ? 'selected' : '' }}>
                                    {{ $formulir->nama_supervisi }}
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
            <span class="badge badge-primary">Daftar Laporan</span>
            <div class="card-tools">
                <a href="{{ url('perjadin/laporan/create') }}?year={{ request('year', $this_year) }}&formulir={{ request('formulir', $this_formulir) }}"
                    class="btn btn-sm btn-success" id="create-summary-btn">
                    <i class="fas fa-plus"></i> Laporan Baru
                </a>

            </div>
        </div>

        <div class="card-body">
            <table id="document-table" class="table">
                <thead>
                    <tr>
                        <th class="text-center">No.</th>
                        <th class="text-center">Nama Supervisi</th>
                        <th class="text-center">Nama Pegawai</th>
                        <th class="text-center">File Path</th>
                        <th class="text-center">Tipe</th>
                        <th class="text-center">Size</th>
                        {{-- <th class="text-center"></th> --}}
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($daftar_laporan as $laporan)
                        <tr>
                            <td class="text-center">
                                {{ ($daftar_laporan->currentPage() - 1) * $daftar_laporan->perPage() + $loop->iteration }}
                            </td>
                            <td class="text-center">{{ $laporan->formulir->nama_supervisi }}</td>

                            <td class="text-center">
                                {{ $laporan->user->name }}
                            </td>
                            <td class="text-center">
                                {{ $laporan->file_path }}
                            </td>
                            <td class="text-center">
                                {{ $laporan->file_type }}
                            </td>
                            <td class="text-center">
                                {{ $laporan->size }} KB
                            </td>
                            <td class="project-actions text-center">
                                <a class="btn btn-primary btn-sm" href="{{ asset('storage/' . $laporan->file_path) }}"
                                    target="_blank">
                                    <i class="fas fa-eye"></i> View
                                </a>
                                <a class="btn btn-info btn-sm" href="/perjadin/laporan/{{ $laporan->id }}/edit">
                                    <i class="fas fa-pencil-alt">
                                    </i>
                                    Edit
                                </a>
                                <a onclick="deleteConfirm('/perjadin/laporan/{{ $laporan->id }}')"
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
    {{ $daftar_laporan->links() }}






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
                const formulirSelect = document.getElementById('formulir');

                function updateUrl() {
                    const year = yearSelect.value;
                    const formulir = formulirSelect.value;
                    const url = new URL(window.location.href);
                    url.searchParams.set('year', year);
                    url.searchParams.set('formulir', formulir);
                    window.location.href = url.toString();
                }

                yearSelect.addEventListener('change', updateUrl);
                formulirSelect.addEventListener('change', updateUrl);
            });
        </script>

    </x-slot>

</x-app-Layout>
