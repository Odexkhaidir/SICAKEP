<x-app-layout>

    <x-slot name="title">
        {{ __('Output') }}
    </x-slot>

    <x-slot name="head">
        <!-- Additional resources here -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="{{ url('') }}/plugins/select2/css/select2.min.css">
        <link rel="stylesheet" href="{{ url('') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
        <link rel="stylesheet" href="{{ url('') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet"
            href="{{ url('') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
        <link rel="stylesheet" href="{{ url('') }}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    </x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item active">Output</li>
    </x-slot>

    <!-- Default box -->
    <div class="card">
        <form method="post" enctype="multipart/form-data" id="filterForm">
            <!-- form start -->
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-4">
                        <select id="year" class="form-control col-sm-6 select2bs4" name="year">
                            <option value="">Pilih Tahun</option>
                            @foreach ($years as $year)
                                <option {{ $year == date('Y') ? 'selected' : '' }} value="{{ $year }}">
                                    {{ $year }} </option>
                            @endforeach
                        </select>
                        <div class="help-block"></div>
                    </div>


                    <div class="col-4">
                        <button id="filter-button" type="button" class="btn btn-info">Tampilkan</button>
                    </div>

                </div>
            </div>
        </form>
    </div>
    <!-- /.card -->

    <div class="card">
        <div class="card-header">
            <a href="{{ route('output.create') }}" class="btn btn-success">Tambah</a>
        </div>

        <div class="card-body table-responsive p-0">
            <table id="output-table" class="table table-hover">
                <thead>
                    <tr>
                        <th class="text-center">No.</th>
                        <th class="text-center">Output</th>
                        <th class="text-center">Tim Kerja</th>
                        <th class="text-center">Supervisor</th>
                        <th class="text-center">Tahun</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($outputs as $output)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $output->name }}</td>
                            <td>{{ $output->team->name }}</td>
                            <td>{{ $output->supervisor->name }}</td>
                            <td>{{ $output->year }}</td>
                            <td class="project-actions text-center">
                                <button type="button" class="btn btn-sm btn-default dropdown-toggle"
                                    data-toggle="dropdown">
                                    Aksi
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('output.show', $output->id) }}">
                                        <i class="fas fa-eye"></i>
                                        Show
                                    </a>
                                    <a class="dropdown-item" href="{{ route('output.edit', $output->id) }}">
                                        <i class="fas fa-pencil-alt"></i>
                                        Edit
                                    </a>
                                    <a onclick="deleteConfirm('/output/{{ $output->id }}')" class="dropdown-item"
                                        href="#">
                                        <i class="fas fa-trash"></i>
                                        Delete
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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
        <script src="{{ url('') }}/plugins/select2/js/select2.full.min.js"></script>
        <script src="{{ url('') }}/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="{{ url('') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
        <script src="{{ url('') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
        <script src="{{ url('') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
        <script src="{{ url('') }}/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
        <script src="{{ url('') }}/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
        <script src="{{ url('') }}/plugins/jszip/jszip.min.js"></script>
        <script src="{{ url('') }}/plugins/pdfmake/pdfmake.min.js"></script>
        <script src="{{ url('') }}/plugins/pdfmake/vfs_fonts.js"></script>
        <script src="{{ url('') }}/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
        <script src="{{ url('') }}/plugins/datatables-buttons/js/buttons.print.min.js"></script>
        <script src="{{ url('') }}/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
        <script>
            sessionStorage.clear()
            const tokens = '{{ csrf_token() }}'
            const url_approve_all = new URL("{{ route('approveall-evaluation') }}")
            const url_fetch_approval = new URL("{{ route('fetch-approval') }}")

            function deleteConfirm(url) {
                $('#btn-delete').attr('action', url);
                $('#deleteModal').modal();
            }

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

            $(function() {
                $('#output-table').DataTable({
                    "paging": true,
                    "lengthChange": false,
                    "searching": false,
                    "ordering": false,
                    "info": true,
                    "autoWidth": false,
                    "responsive": true,
                });
            });
        </script>
    </x-slot>

</x-app-layout>
