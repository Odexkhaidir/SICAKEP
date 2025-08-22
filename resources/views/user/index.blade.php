<x-app-layout>

    <x-slot name="title">
        {{ __('Evaluasi') }}
    </x-slot>

    <x-slot name="head">
        <!-- Additional resources here -->
        <link rel="stylesheet" href="{{ url('') }}/plugins/select2/css/select2.min.css">
        <link rel="stylesheet" href="{{ url('') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
        <link rel="stylesheet" href="{{ url('') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="{{ url('') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
        <link rel="stylesheet" href="{{ url('') }}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    </x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item active">User</li>
    </x-slot>

    <!-- Default box -->
    <div class="card">

        <div class="card-header">
            <div class="card-tools float-left">
                <a href="{{ url('user/create') }}" class="btn btn-success">
                    <i class="fas fa-plus"></i> Add
                </a>
            </div>
        </div>

        <div class="card-body">
            <table id="user-table" class="table">
                <thead>
                    <tr>
                        <th class="text-center">No.</th>
                        <th class="text-center">Nama</th>
                        <th class="text-center">Username</th>
                        <th class="text-center">Email</th>
                        <th class="text-center">Role</th>
                        <th class="text-center">Satker</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ $user->name }}</td>
                            <td class="text-center">{{ $user->username }}</td>
                            <td class="text-center">{{ $user->email }}</td>
                            <td class="text-center">
                                @switch($user->role)
                                    @case('admin-provinsi')
                                        <span class="badge bg-maroon"> {{ $user->role }} </span>
                                    @break

                                    @case('admin-satker')
                                        <span class="badge bg-fuchsia"> {{ $user->role }} </span>
                                    @break

                                    @case('approver')
                                        <span class="badge bg-indigo"> {{ $user->role }} </span>
                                    @break

                                    @case('supervisor')
                                        <span class="badge bg-teal"> {{ $user->role }} </span>
                                    @break

                                    @case('evaluator')
                                        <span class="badge bg-primary"> {{ $user->role }} </span>
                                    @break

                                    @case('operator-kinerja')
                                        <span class="badge bg-success"> {{ $user->role }} </span>
                                    @break

                                    @case('supervisor-akip')
                                        <span class="badge bg-purple"> {{ $user->role }} </span>
                                    @break

                                    @default
                                        <span class="badge bg-warning"> {{ $user->role }} </span>
                                @endswitch
                            </td>
                            <td class="text-center">{{ $user->satker->name }}</td>
                            <td class="project-actions text-center">
                                <a class="btn btn-primary btn-sm" href="/user/{{ $user->username }}">
                                    <i class="fas fa-eye"></i>
                                    
                                </a>
                                <a class="btn btn-info btn-sm" href="/user/{{ $user->username }}/edit">
                                    <i class="fas fa-pencil-alt"></i>
                                    
                                </a>
                                <a class="btn btn-warning btn-sm" href="/user/reset-password/{{ $user->username }}">
                                    <i class="fas fa-key"></i>
                                    
                                </a>
                                <a onclick="deleteConfirm('/user/{{ $user->username }}')" class="btn btn-danger btn-sm"
                                    href="#">
                                    <i class="fas fa-trash"></i>
                                    
                                </a>
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

                var notif = "{{ Session::get('notification') }}";

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
            $(function() {
                $("#example1").DataTable({
                    "responsive": true,
                    "lengthChange": false,
                    "autoWidth": false,
                    "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
                }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
                $('#user-table').DataTable({
                    "paging": true,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false,
                    "responsive": true,
                });
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
        </script>
    </x-slot>

</x-app-layout>
