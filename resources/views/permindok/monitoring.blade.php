<x-app-Layout>
    <x-slot name="title">
        {{ __('Monitoring Permindok') }}
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
        <li class="breadcrumb-item">Permindok</li>
        <li class="breadcrumb-item active">Monitoring</li>
    </x-slot>


    <div class="card">

        <div class="card-header">
            <span class="badge badge-primary">Daftar Permindok</span>
            <div class="card-tools">
            </div>
        </div>

        <div class="card-body">
            <table id="permindok-table" class="table">
                <thead>
                    <tr>
                        <th class="text-center">No.</th>
                        <th class="text-center">Nama Permindok</th>
                        <th class="text-center">Upload</th>
                        <th class="text-center"></th>
                        <th class="text-center">Pemeriksaan</th>
                        <th class="text-center"></th>
                        <th class="text-center">Kesesuaian</th>
                        <th class="text-center"></th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($permindoks as $permindok)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ $permindok->description }}</td>
                            @if ($permindok->upload_progress < 51)
                                <td>
                                    <div class="progress progress-xs">
                                        <div class="progress-bar bg-danger"
                                            style="width: {{ $permindok->upload_progress }}%"></div>
                                </td>
                                <td><span class="badge bg-danger">{{ $permindok->upload_progress }}%</span></td>
                            @elseif ($permindok->upload_progress < 81)
                                <td>
                                    <div class="progress progress-xs">
                                        <div class="progress-bar bg-warning"
                                            style="width: {{ $permindok->upload_progress }}%"></div>
                                </td>
                                <td><span class="badge bg-warning">{{ $permindok->upload_progress }}%</span></td>
                            @elseif ($permindok->upload_progress < 91)
                                <td>
                                    <div class="progress progress-xs">
                                        <div class="progress-bar bg-primary"
                                            style="width: {{ $permindok->upload_progress }}%"></div>
                                </td>
                                <td><span class="badge bg-primary">{{ $permindok->upload_progress }}%</span></td>
                            @else
                                <td>
                                    <div class="progress progress-xs">
                                        <div class="progress-bar bg-success"
                                            style="width: {{ $permindok->upload_progress }}%"></div>
                                </td>
                                <td><span class="badge bg-success">{{ $permindok->upload_progress }}%</span></td>
                            @endif
                            @if ($permindok->audit_progress < 51)
                                <td>
                                    <div class="progress progress-xs">
                                        <div class="progress-bar bg-danger"
                                            style="width: {{ $permindok->audit_progress }}%"></div>
                                </td>
                                <td><span class="badge bg-danger">{{ $permindok->audit_progress }}%</span></td>
                            @elseif ($permindok->audit_progress < 81)
                                <td>
                                    <div class="progress progress-xs">
                                        <div class="progress-bar bg-warning"
                                            style="width: {{ $permindok->audit_progress }}%"></div>
                                </td>
                                <td><span class="badge bg-warning">{{ $permindok->audit_progress }}%</span></td>
                            @elseif ($permindok->audit_progress < 91)
                                <td>
                                    <div class="progress progress-xs">
                                        <div class="progress-bar bg-primary"
                                            style="width: {{ $permindok->audit_progress }}%"></div>
                                </td>
                                <td><span class="badge bg-primary">{{ $permindok->audit_progress }}%</span></td>
                            @else
                                <td>
                                    <div class="progress progress-xs">
                                        <div class="progress-bar bg-success"
                                            style="width: {{ $permindok->audit_progress }}%"></div>
                                </td>
                                <td><span class="badge bg-success">{{ $permindok->audit_progress }}%</span></td>
                            @endif
                            @if ($permindok->progress < 51)
                                <td>
                                    <div class="progress progress-xs">
                                        <div class="progress-bar bg-danger" style="width: {{ $permindok->progress }}%">
                                        </div>
                                </td>
                                <td><span class="badge bg-danger">{{ $permindok->progress }}%</span></td>
                            @elseif ($permindok->progress < 81)
                                <td>
                                    <div class="progress progress-xs">
                                        <div class="progress-bar bg-warning"
                                            style="width: {{ $permindok->progress }}%"></div>
                                </td>
                                <td><span class="badge bg-warning">{{ $permindok->progress }}%</span></td>
                                @elseif ($permindok->progress < 91)
                                    <td>
                                        <div class="progress progress-xs">
                                            <div class="progress-bar bg-primary"
                                                style="width: {{ $permindok->progress }}%"></div>
                                    </td>
                                    <td><span class="badge bg-primary">{{ $permindok->progress }}%</span></td>
                            @else
                                <td>
                                    <div class="progress progress-xs">
                                        <div class="progress-bar bg-success"
                                            style="width: {{ $permindok->progress }}%"></div>
                                </td>
                                <td><span class="badge bg-success">{{ $permindok->progress }}%</span></td>
                            @endif
                            <td class="text-center">
                                <a href="{{ route('permindok.monitoring.show', $permindok->id) }}">
                                    <span class="badge bg-warning">lihat detail</span>
                                </a>
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
        <script src="{{ url('') }}/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="{{ url('') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
        <script src="{{ url('') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
        <script src="{{ url('') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
        <script src="{{ url('') }}/plugins/moment/moment.min.js"></script>
        <script src="{{ url('') }}/plugins/daterangepicker/daterangepicker.js"></script>
        <script>
            function deleteConfirm(url) {
                $('#btn-delete').attr('action', url);
                $('#deleteModal').modal();
            }

            $(function() {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });

                var notif = "{{ Session::get('notif') }}";

                if (notif != '') {
                    Toast.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: notif
                    })
                } else if (notif == '2') {
                    Toast.fire({
                        icon: 'danger',
                        title: 'Gagal',
                        text: notif
                    })
                }
            });

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

            //Date range picker
            $('#jadwal').daterangepicker({

                locale: {
                    format: 'YYYY-MM-DD'
                }
            })
        </script>
    </x-slot>

    </x-dashboard-Layout>
