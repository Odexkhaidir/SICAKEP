<x-app-layout>

    <x-slot name="title">
        {{ __('Monitoring Penilaian') }}
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
        <form action="{{route('evaluation-fetchmonitoring')}}" method="post" enctype="multipart/form-data" id="filterForm">
            @csrf
            <!-- form start -->
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-4">
                        <select id="year" class="form-control col-sm-6 select2bs4" name="year">
                            <option value="">Pilih Tahun</option>
                            @foreach ($years as $year)
                                <option {{ $this_year == $year ? 'selected' : '' }} value="{{ $year }}">
                                    {{ $year }} </option>
                            @endforeach
                        </select>
                        <div class="help-block"></div>
                    </div>

                    <div class="form-group col-4">
                        <select id="month" class="form-control col-sm-6 select2bs4" name="month">
                            <option value="">Pilih Bulan</option>
                            @foreach ($months as $month)
                                <option {{ $this_month == $month->id ? 'selected' : '' }} value="{{ $month->id }}">
                                    {{ $month->name }} </option>
                            @endforeach
                        </select>
                        <div class="help-block"></div>
                    </div>

                    <div class="col-2">
                        <button type="submit" class="btn btn-info">Tampilkan</button>
                    </div>
                </div>
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
                        <th class="text-left">Tim Kerja</th>
                        <th class="text-center" style="width: 200px">Entri</th>
                        <th class="text-center" style="width: 200px">Submit</th>
                        <th class="text-center" style="width: 200px">Approved</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($teams as $team)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-left">{{ $team->name }}</td>
                            <td class="text-center">
                                @if ($team->status == 0)
                                    <span class="badge bg-danger"> belum </span>
                                @else
                                    <span class="badge bg-success"> sudah </span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($team->status >= 1)
                                    <span class="badge bg-success"> sudah </span>
                                @else
                                    <span class="badge bg-danger"> belum </span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($team->status >= 2)
                                    <span class="badge bg-success"> sudah </span>
                                @else
                                    <span class="badge bg-danger"> belum </span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <x-slot name="script">
        <!-- Additional JS resources -->
        <script src="{{ url('') }}/plugins/select2/js/select2.full.min.js"></script>
        <script>
            sessionStorage.clear()
            const tokens = '{{ csrf_token() }}'

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
