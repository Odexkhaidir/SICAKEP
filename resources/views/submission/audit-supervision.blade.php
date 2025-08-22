<x-app-Layout>

    <x-slot name="title">
        {{ __('Pemeriksaan Dokumen Permindok') }}
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
        <li class="breadcrumb-item"><a href="{{ route('submission.supervision') }}">Pemeriksaan Permindok</a></li>
        <li class="breadcrumb-item"><a
                href="{{ route('submission.archieves.supervision', $archieve->submission_id) }}">Dokumen</a></li>
        <li class="breadcrumb-item active">Kriteria</li>
    </x-slot>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-6">

                    <div class="form-group">
                        <label class="col-4 col-form-label" for="year">Permindok</label>
                        <input type="text" class="form-control" id="year" placeholder="Deskripsi Permindok"
                            name="year" disabled value="{{ $archieve->submission->permindok->description }}">
                    </div>

                </div>

                <div class="col-6">

                    <div class="form-group">
                        <label class="col-4 col-form-label" for="year">Waktu</label>
                        <input type="text" class="form-control" id="month" placeholder="Waktu Permindok"
                            name="month" disabled
                            value="{{ $archieve->submission->permindok->start_date . ' - ' . $archieve->submission->permindok->end_date }}">
                    </div>

                </div>

            </div>
            <div class="form-group">
                <label class="col-4 col-form-label" for="satker">Satuan Kerja</label>
                <input type="text" class="form-control" id="satker" placeholder="Satuan Kerja" name="satker"
                    disabled value="{{ $archieve->submission->satker->name }}">
            </div>
            <div class="row">
                <div class="col-9">
                    <div class="form-group">
                        <label class="col-4 col-form-label" for="satker">Nama Dokumen</label>
                        <input type="text" class="form-control" id="satker" placeholder="Satuan Kerja"
                            name="satker" disabled value="{{ $archieve->document->name }}">
                    </div>
                </div>

                <div class="col-3">
                    <div class="form-group">
                        <label class="col-4 col-form-label" for="satker">Link Dokumen</label>
                        <a class="form-control btn btn-warning btn-sm" href="{{ $archieve->link }}" target="blank">
                            <i class="fas fa-link">
                            </i>
                            Link
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="card">

        <div class="card-header">
            <span class="badge badge-primary">Daftar Dokumen</span>
            <div class="card-tools">
            </div>
        </div>

        <div class="card-body">
            <table id="document-table" class="table">
                <thead>
                    <tr>
                        <th class="text-center">No.</th>
                        <th>Kriteria Dokumen</th>
                        <th>Status</th>
                        <th>Catatan</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($audits as $audit)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $audit->criteria->description }}</td>
                            <td>
                                @switch($audit->status)
                                    @case('sesuai')
                                        <span class="badge bg-success"> {{ $audit->status }} </span>
                                    @break

                                    @case('belum sesuai')
                                        <span class="badge bg-danger"> {{ $audit->status }} </span>
                                    @break

                                    @default
                                        <span class="badge bg-warning"> belum diperiksa </span>
                                @endswitch

                            </td>
                            <td>{{ $audit->notes ? $audit->notes : '-' }}</td>
                            <td>
                                <a onclick="auditForm('{{ route('audit.update', $audit->id) }}', '{{ $audit->status }}', '{{ $audit->notes }}')"
                                    class="btn btn-default btn-xs" href="#"><i class="fas fa-pencil-alt"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="audit-modal">
        <div class="modal-dialog modal-lg">
            <form id="audit-form" action="" method="post">
                @csrf
                @method('put')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Status Pemeriksaan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        <div class="form-group">
                            <select id="status-select" class="form-control select2bs4" style="width: 100%;"
                                name="status">
                                <option value='' selected disabled>Pilih Status</option>
                                <option value='sesuai'>Sesuai</option>
                                <option value='belum sesuai'>Belum Sesuai</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                    <div class="form-group">
                        <label class="col-form-label" for="notes">Catatan Pemeriksaan</label>
                        <input type="text" class="form-control" id="notes-text" placeholder="Catatan Pemeriksaan"
                            name="notes" value="">
                    </div>

                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                        <button id="permindok-submit" type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </div>
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


            function auditForm(url, status, notes) {
                $('#audit-form').attr('action', url);
                $('#notes-text').attr('value', notes);
                $('#audit-modal').modal();
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

                $("#permindok-table").DataTable({
                    "scrollX": true,
                    "ordering": false,
                    "searching": true,
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

    </x-dashboard-Layout>
