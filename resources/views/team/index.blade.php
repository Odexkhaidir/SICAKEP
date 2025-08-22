<x-app-layout>

    <x-slot name="title">
        {{ __('Tim Kerja') }}
    </x-slot>

    <x-slot name="head">
        <!-- Additional resources here -->
        <link rel="stylesheet" href="{{ url('') }}/plugins/select2/css/select2.min.css">
        <link rel="stylesheet" href="{{ url('') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    </x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item active">Tim Kerja</li>
    </x-slot>

    <!-- Default box -->
    <div class="card">
        <!-- form start -->
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    <select id="yearSelect" class="form-control select2bs4" name="tahun" required>
                        <option value="" disabled selected>Pilih Tahun</option>
                        @foreach ($years as $year)
                            <option {{ old('year', $this_year) == $year ? 'selected' : '' }}
                                value='{{ $year }}'>{{ $year }}</option>
                        @endforeach
                    </select>
                    <div class="help-block"></div>
                </div>

                <div class="col-4">
                    <select id="satkerSelect" class="form-control select2bs4" name="satker_id" required>
                        <option value="" disabled selected>Pilih Satker</option>
                        @foreach ($satkers as $satker)
                            <option {{ old('satker_id', $this_satker) == $satker->id ? 'selected' : '' }}
                                value="{{ $satker->id }}">{{ $satker->name }}</option>
                        @endforeach
                    </select>
                    <div class="help-block"></div>
                </div>

                <div class="col-4">
                    <button id="filter-button" class="btn btn-warning float-left">
                        Tampilkan
                    </button>
                </div>
            </div>

            <!-- /.card-body -->
        </div>
    </div>
    <!-- /.card -->

    <div class="card">

        <div class="card-header">
            <div>
                <a href="/team/create" class="btn btn-success float-left">
                    <small><i class="fas fa-plus nav-icon"></i></small>
                    Tambah
                </a>
            </div>
        </div>

        <div class="card-body">

            <table id="team-table" class="table table-striped table-hover projects">
                <thead>
                    <tr class="text-center">
                        <th style="width: 5%">
                            #
                        </th>
                        <th style="width: 40%">
                            Tim Kerja
                        </th>
                        <th style="width: 20%">
                            Ketua
                        </th>
                        <th style="width: 20%">
                            Tahun
                        </th>
                        <th style="width: 15%">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($teams as $team)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ $team->name }}</td>
                            <td class="text-center">{{ $team->leader->name }}</td>
                            <td class="text-center">{{ $team->year }}</td>
                            <td class="project-actions text-center">
                                <button type="button" class="btn btn-sm btn-default dropdown-toggle"
                                    data-toggle="dropdown">
                                    Aksi
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="/team/{{ $team->id }}">
                                        <i class="fas fa-eye"></i>
                                        Show
                                    </a>
                                    @can('admin')
                                        <a class="dropdown-item" href="/team/{{ $team->id }}/edit">
                                            <i class="fas fa-pencil-alt"></i>
                                            Edit
                                        </a>
                                        <a onclick="deleteConfirm('/team/{{ $team->id }}')" class="dropdown-item"
                                            href="#">
                                            <i class="fas fa-trash"></i>
                                            Delete
                                        </a>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

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
        <script src="{{ asset('js/team.js') }}"></script>
        <script>
            sessionStorage.clear()
            const tokens = '{{ csrf_token() }}'
            const url_get_data = new URL("{{ route('filter-team') }}")
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
        </script>
    </x-slot>

</x-app-layout>
