<x-app-layout>

    <x-slot name="title">
        {{ __('Evaluasi') }}
    </x-slot>

    <x-slot name="head">
        <!-- Additional resources here -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="{{ url('') }}/plugins/select2/css/select2.min.css">
        <link rel="stylesheet" href="{{ url('') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    </x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item active">Penilaian</li>
    </x-slot>

    <!-- Default box -->
    <div class="card">
        <form method="post" enctype="multipart/form-data" id="filterForm">
            <!-- form start -->
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-4">
                        <select id="year" class="form-control col-sm-9 select2bs4" name="year">
                            <option value="">Pilih Tahun</option>
                            @foreach ($years as $year)
                                <option {{ $this_year == $year ? 'selected' : '' }} value="{{ $year }}">
                                    {{ $year }} </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-4">
                        <select id="month" class="form-control col-sm-6 select2bs4" name="month">
                            <option value="">Pilih Bulan</option>
                            @foreach ($months as $month)
                                <option {{ $this_month == $month->id ? 'selected' : '' }} value="{{ $month->id }}">
                                    {{ $month->name }} </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-4">
                        <select id="team" class="form-control col-sm-9 select2bs4" name="team">
                            <option value="">Pilih Tim</option>
                            @foreach ($teams as $team)
                                <option value="{{ $team->id }}">{{ $team->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>

            <div class="card-footer" style="background-color:white">
                @if ($evaluation_period)
                    @if ($status < 3)
                        <div class="margin">
                            <a href="/evaluation/create" class="btn btn-success float-left" style='margin-right:10px'>
                                Input Penilaian Baru</a>
                            <button id="create-none-button" type="button" class="btn btn-warning float-left"
                                style='margin-right:10px'>
                                Tidak Ada Penilaian</button>
                        </div>
                    @endif
                @endif

                <button id="filter-button" type="button" class="btn btn-info float-right">Tampilkan</button>

            </div>
        </form>
    </div>
    <!-- /.card -->

    @if (!$evaluation_period)
        <div class="alert alert-warning alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-exclamation-triangle"></i> Pemberitahuan!</h5>
            Periode penilaian bulan {{ $this_month }} tahun {{ $this_year }} masih belum dibuka.
        </div>
    @endif

    <div class="card">
        <div class="card-body table-responsive p-0">
            <table id="evaluation-table" class="table table-hover">
                <thead>
                    <tr>
                        <th class="text-center">No.</th>
                        <th class="text-center">Tim Kerja</th>
                        <th class="text-center">Tahun</th>
                        <th class="text-center">Bulan</th>
                        <th class="text-center">Output/Suboutput</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($evaluations as $evaluation)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ $evaluation->team->name }}</td>
                            <td class="text-center">{{ $evaluation->year }}</td>
                            <td class="text-center">{{ $evaluation->month->name }}</td>
                            <td class="text-center">{{ ($evaluation->suboutput) ? $evaluation->suboutput->name : 'Tidak ada kegiatan' }}</td>
                            <td class="text-center">
                                @switch($evaluation->status)
                                    @case(1)
                                        <span class="badge bg-warning"> submit </span>
                                    @break

                                    @case(2)
                                        <span class="badge bg-primary"> approved </span>
                                    @break

                                    @case(3)
                                        <span class="badge bg-success"> final </span>
                                    @break

                                    @default
                                        <span class="badge bg-danger"> entri </span>
                                @endswitch
                            </td>
                            <td class="project-actions text-center">
                                <button type="button" class="btn btn-sm btn-default dropdown-toggle"
                                    data-toggle="dropdown">
                                    Aksi
                                </button>
                                <div class="dropdown-menu">
                                    @if ($evaluation->status <= 1)
                                        <a class="dropdown-item" href="/evaluation/submit/{{ $evaluation->id }}">
                                            <i class="fas fa-check"></i>
                                            Submit
                                        </a>
                                    @endif
                                    <a class="dropdown-item" href="/evaluation/{{ $evaluation->id }}">
                                        <i class="fas fa-eye"></i>
                                        Show
                                    </a>
                                    @if ($evaluation->status <= 2 && $evaluation->suboutput != null)
                                        <a class="dropdown-item" href="/evaluation/{{ $evaluation->id }}/edit">
                                            <i class="fas fa-pencil-alt"></i>
                                            Edit
                                        </a>
                                    @endif
                                    @if ($evaluation->status <= 1)
                                        <a onclick="deleteConfirm('/evaluation/{{ $evaluation->id }}')"
                                            class="dropdown-item" href="#">
                                            <i class="fas fa-trash"></i>
                                            Delete
                                        </a>
                                    @endif
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
        <script src="{{ asset('js/evaluation.js') }}"></script>
        <script>
            sessionStorage.clear()
            const tokens = '{{ csrf_token() }}'
            const url_fetch_filter = new URL("{{ route('evaluation-fetch-filter') }}")
            const url_get_data = new URL("{{ route('filter-evaluation') }}")
            const url_post_null = new URL("{{ route('create-null') }}")

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
