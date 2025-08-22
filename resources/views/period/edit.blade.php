<x-app-Layout>

    <x-slot name="title">
        {{ __('Rekonsiliasi') }}
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
        <li class="breadcrumb-item active">Jadwal</li>
    </x-slot>

    <div class="card">
        <form action="/period/{{ $period->id }}" method="post">
            @csrf
            @method('put')
            <div class="card-header">
                <a href="{{ url('period') }}">
                    <button type="button" class="btn btn-warning"> {{ _('< Kembali') }} </button>
                </a>
            </div>

            <div class="card-body">

                <div class="form-group">
                    <label class="col-form-label" for="tahunSelect">Tahun:</label>
                    <select id="tahunSelect" class="form-control select2bs4" name="year">
                        <option value="" disabled selected>Pilih Tahun</option>
                        @foreach ($years as $year)
                            <option {{ old('year', $period->year) == $year ? 'selected' : '' }} value='{{ $year }}'>{{ $year }}</option>
                        @endforeach
                    </select>
                    <div class="help-block"></div>
                </div>

                <div class="form-group">
                    <label class="col-form-label" for="month">Bulan:</label>

                    <select id="month" class="form-control select2bs4" name="month_id">
                        <option value="">Pilih Bulan</option>
                        @foreach ($months as $month)
                            <option {{old('month_id', $period->month_id == $month->id ? 'selected' : '')}} value="{{ $month->id }}"> {{ $month->name }} </option>
                        @endforeach
                    </select>
                    <div class="help-block"></div>
                </div>

                <div class="form-group">
                    <label class="col-form-label">Jadwal:</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="far fa-calendar-alt"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control" id="jadwal" name="date_range"
                            value="{{ old('date_range', $period->start_date . ' - ' . $period->end_date) }}">
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <div class="float-right">
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </div>
        </form>
    </div>

    <x-slot name="script">
        <!-- Additional JS resources -->
        <script src="{{ url('') }}/plugins/select2/js/select2.full.min.js"></script>
        <script src="{{ url('') }}/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="{{ url('') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
        <script src="{{ url('') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
        <script src="{{ url('') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
        <script src="{{ url('') }}/plugins/moment/moment.min.js"></script>
        <script src="{{ url('') }}/plugins/daterangepicker/daterangepicker.js"></script>
        <script src="{{ url('') }}/plugins/moment/moment.min.js"></script>
        <script>
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
                    theme: 'bootstrap4'
                })

                $("#periodTable").DataTable({
                    "scrollX": true,
                    "ordering": false,
                    "searching": false,
                    "responsive": true,
                    "lengthChange": false,
                    "autoWidth": false,
                })
            });

            //Date range picker
            $('#jadwal').daterangepicker({

                locale: {
                    format: 'YYYY-MM-DD'
                }
            })
        </script>
    </x-slot>

</x-app-Layout>
