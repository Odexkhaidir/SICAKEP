<x-app-layout>

    <x-slot name="title">
        {{ __('Capaian Kinerja') }}
    </x-slot>

    <x-slot name="head">
        <!-- Additional resources here -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="{{ url('') }}/plugins/select2/css/select2.min.css">
        <link rel="stylesheet" href="{{ url('') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    </x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item active">Capaian Kinerja</li>
    </x-slot>

    <!-- Default box -->
    <div class="card">
        <form method="post" enctype="multipart/form-data" id="filterForm">
            <!-- form start -->
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-3">
                        <select id="year" class="form-control col-sm-9 select2bs4" name="year">
                            <option value="">Pilih Tahun</option>
                            @foreach ($years as $year)
                                <option {{ $this_year == $year ? 'selected' : '' }} value="{{ $year }}">
                                    {{ $year }} </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-3">
                        <select id="month" class="form-control col-sm-6 select2bs4" name="month">
                            <option value="">Pilih Permindok</option>
                            @foreach ($months as $month)
                                <option value="{{ $month->id }}"> {{ $month->name }} </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-4">
                        <select id="satker" class="form-control col-sm-6 select2bs4" name="satker">
                            <option value="">Pilih Satker</option>
                            @foreach ($satkers as $satker)
                                <option value="{{ $satker->id }}"> {{ $satker->name }} </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-2">
                        <button id="filter-button" type="button" class="btn btn-info">Tampilkan</button>
                    </div>
                </div>
            </div>

            <div class="card-footer" style="background-color:white">

            </div>
        </form>
    </div>
    <!-- /.card -->

    <div class="row">
        <div class="col-md-3">
            <!-- <a href="compose.html" class="btn btn-primary btn-block mb-3">Compose</a> -->

            <div class="card">
                <div class="card-header">
                    <i class="fas fa-inbox"></i>
                    SAKIP
                    <div class="card-tools">
                        <a href="http://monitoringbps.com/sicakep/sakip/tambah_jenis">
                            <button type="button" class="btn bg-success margin">
                                <i class="fas fa-plus"></i>
                            </button>
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item active">
                            <a href="http://monitoringbps.com/sicakep/sakip/daftar/renstra" class="nav-link">
                                <i class="far fa-circle text-warning"></i> Renstra </a>
                        </li>
                        <li class="nav-item active">
                            <a href="http://monitoringbps.com/sicakep/sakip/daftar/lkip" class="nav-link">
                                <i class="far fa-circle text-warning"></i> LKIP </a>
                        </li>
                        <li class="nav-item active">
                            <a href="http://monitoringbps.com/sicakep/sakip/daftar/pk" class="nav-link">
                                <i class="far fa-circle text-warning"></i> Perjanjian Kinerja </a>
                        </li>
                        <li class="nav-item active">
                            <a href="http://monitoringbps.com/sicakep/sakip/daftar/fra" class="nav-link">
                                <i class="far fa-circle text-warning"></i> FRA </a>
                        </li>
                        <li class="nav-item active">
                            <a href="http://monitoringbps.com/sicakep/sakip/daftar/rp" class="nav-link">
                                <i class="far fa-circle text-warning"></i> Reward & Punishment </a>
                        </li>
                        <li class="nav-item active">
                            <a href="http://monitoringbps.com/sicakep/sakip/daftar/iku" class="nav-link">
                                <i class="far fa-circle text-warning"></i> IKU </a>
                        </li>
                        <li class="nav-item active">
                            <a href="http://monitoringbps.com/sicakep/sakip/daftar/iki" class="nav-link">
                                <i class="far fa-circle text-warning"></i> IKI </a>
                        </li>
                        <li class="nav-item active">
                            <a href="http://monitoringbps.com/sicakep/sakip/daftar/ckp" class="nav-link">
                                <i class="far fa-circle text-warning"></i> SKP dan CKP </a>
                        </li>
                        <li class="nav-item active">
                            <a href="http://monitoringbps.com/sicakep/sakip/daftar/msmart" class="nav-link">
                                <i class="far fa-circle text-warning"></i> Monev SMART </a>
                        </li>
                        <li class="nav-item active">
                            <a href="http://monitoringbps.com/sicakep/sakip/daftar/mbappenas" class="nav-link">
                                <i class="far fa-circle text-warning"></i> Monev Bappenas </a>
                        </li>
                        <li class="nav-item active">
                            <a href="http://monitoringbps.com/sicakep/sakip/daftar/msakip" class="nav-link">
                                <i class="far fa-circle text-warning"></i> Monev Sakip </a>
                        </li>
                        <li class="nav-item active">
                            <a href="http://monitoringbps.com/sicakep/sakip/daftar/sop" class="nav-link">
                                <i class="far fa-circle text-warning"></i> SOP </a>
                        </li>
                    </ul>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Renstra</h3>

                    <div class="card-tools">
                        <a href="http://monitoringbps.com/sicakep/sakip/tambah_dokumen/renstra">
                            <button type="button" class="btn bg-success margin">
                                <i class="fas fa-plus"></i>
                            </button>
                        </a>
                    </div>
                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <div class="table-responsive p-0">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Dokumen</th>
                                    <th>Periode</th>
                                    <th>Pelaksana</th>
                                    <th style="width: 110px">Dokumen</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>RENSTRA 2020-2024</td>
                                    <td>Tahunan</td>
                                    <td>
                                        Bagian Umum </td>
                                    <td>
                                        <a href="http://monitoringbps.com/sicakep/sakip/daftar_file_dokumen/renstra/1">
                                            <button type="button" class="btn btn-default btn-sm"><i
                                                    class="fas fa-file-alt"></i> File</button>
                                        </a>
                                    </td>
                                    <td class="text py-0 align-middle">
                                        <div class="btn-group btn-group-sm">
                                            <a href="http://monitoringbps.com/sicakep/sakip/edit_dokumen/renstra/1"
                                                class="btn btn-info"><i class="fas fa-edit"></i></a>
                                            <a onclick="deleteConfirm('http://monitoringbps.com/sicakep/sakip/delete_dok/renstra/1')"
                                                href="#" class="btn btn-danger"><i
                                                    class="fas fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Surat Penjelasan Penetapan Target Renstra 2020-2024</td>
                                    <td>Tahunan</td>
                                    <td>
                                        Bagian Umum </td>
                                    <td>
                                        <a href="http://monitoringbps.com/sicakep/sakip/daftar_file_dokumen/renstra/2">
                                            <button type="button" class="btn btn-default btn-sm"><i
                                                    class="fas fa-file-alt"></i> File</button>
                                        </a>
                                    </td>
                                    <td class="text py-0 align-middle">
                                        <div class="btn-group btn-group-sm">
                                            <a href="http://monitoringbps.com/sicakep/sakip/edit_dokumen/renstra/2"
                                                class="btn btn-info"><i class="fas fa-edit"></i></a>
                                            <a onclick="deleteConfirm('http://monitoringbps.com/sicakep/sakip/delete_dok/renstra/2')"
                                                href="#" class="btn btn-danger"><i
                                                    class="fas fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Tabel & Notulen Monitoring Renstra 2020-2024</td>
                                    <td>Tahunan</td>
                                    <td>
                                        Bagian Umum </td>
                                    <td>
                                        <a href="http://monitoringbps.com/sicakep/sakip/daftar_file_dokumen/renstra/3">
                                            <button type="button" class="btn btn-default btn-sm"><i
                                                    class="fas fa-file-alt"></i> File</button>
                                        </a>
                                    </td>
                                    <td class="text py-0 align-middle">
                                        <div class="btn-group btn-group-sm">
                                            <a href="http://monitoringbps.com/sicakep/sakip/edit_dokumen/renstra/3"
                                                class="btn btn-info"><i class="fas fa-edit"></i></a>
                                            <a onclick="deleteConfirm('http://monitoringbps.com/sicakep/sakip/delete_dok/renstra/3')"
                                                href="#" class="btn btn-danger"><i
                                                    class="fas fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Surat Pernyataan Reviu Renstra / IKU terupdate</td>
                                    <td>Tahunan</td>
                                    <td>
                                        Bagian Umum </td>
                                    <td>
                                        <a href="http://monitoringbps.com/sicakep/sakip/daftar_file_dokumen/renstra/4">
                                            <button type="button" class="btn btn-default btn-sm"><i
                                                    class="fas fa-file-alt"></i> File</button>
                                        </a>
                                    </td>
                                    <td class="text py-0 align-middle">
                                        <div class="btn-group btn-group-sm">
                                            <a href="http://monitoringbps.com/sicakep/sakip/edit_dokumen/renstra/4"
                                                class="btn btn-info"><i class="fas fa-edit"></i></a>
                                            <a onclick="deleteConfirm('http://monitoringbps.com/sicakep/sakip/delete_dok/renstra/4')"
                                                href="#" class="btn btn-danger"><i
                                                    class="fas fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>Capture Upload Renstra di Website</td>
                                    <td>Tahunan</td>
                                    <td>
                                        Bagian Umum </td>
                                    <td>
                                        <a href="http://monitoringbps.com/sicakep/sakip/daftar_file_dokumen/renstra/5">
                                            <button type="button" class="btn btn-default btn-sm"><i
                                                    class="fas fa-file-alt"></i> File</button>
                                        </a>
                                    </td>
                                    <td class="text py-0 align-middle">
                                        <div class="btn-group btn-group-sm">
                                            <a href="http://monitoringbps.com/sicakep/sakip/edit_dokumen/renstra/5"
                                                class="btn btn-info"><i class="fas fa-edit"></i></a>
                                            <a onclick="deleteConfirm('http://monitoringbps.com/sicakep/sakip/delete_dok/renstra/5')"
                                                href="#" class="btn btn-danger"><i
                                                    class="fas fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>Capture Upload Renstra di Simonev</td>
                                    <td>Tahunan</td>
                                    <td>
                                        Bagian Umum </td>
                                    <td>
                                        <a href="http://monitoringbps.com/sicakep/sakip/daftar_file_dokumen/renstra/6">
                                            <button type="button" class="btn btn-default btn-sm"><i
                                                    class="fas fa-file-alt"></i> File</button>
                                        </a>
                                    </td>
                                    <td class="text py-0 align-middle">
                                        <div class="btn-group btn-group-sm">
                                            <a href="http://monitoringbps.com/sicakep/sakip/edit_dokumen/renstra/6"
                                                class="btn btn-info"><i class="fas fa-edit"></i></a>
                                            <a onclick="deleteConfirm('http://monitoringbps.com/sicakep/sakip/delete_dok/renstra/6')"
                                                href="#" class="btn btn-danger"><i
                                                    class="fas fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td>Capture Upload Renstra di Esr Kemenpan</td>
                                    <td>Tahunan</td>
                                    <td>
                                        Bagian Umum </td>
                                    <td>
                                        <a href="http://monitoringbps.com/sicakep/sakip/daftar_file_dokumen/renstra/7">
                                            <button type="button" class="btn btn-default btn-sm"><i
                                                    class="fas fa-file-alt"></i> File</button>
                                        </a>
                                    </td>
                                    <td class="text py-0 align-middle">
                                        <div class="btn-group btn-group-sm">
                                            <a href="http://monitoringbps.com/sicakep/sakip/edit_dokumen/renstra/7"
                                                class="btn btn-info"><i class="fas fa-edit"></i></a>
                                            <a onclick="deleteConfirm('http://monitoringbps.com/sicakep/sakip/delete_dok/renstra/7')"
                                                href="#" class="btn btn-danger"><i
                                                    class="fas fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>8</td>
                                    <td>Kelengkapan Rapat Penyusunan Renstra 2020-2024 (Undangan, Daftar Hadir,
                                        Dokumentasi, notulensi)</td>
                                    <td>Tahunan</td>
                                    <td>
                                        Bagian Umum </td>
                                    <td>
                                        <a href="http://monitoringbps.com/sicakep/sakip/daftar_file_dokumen/renstra/8">
                                            <button type="button" class="btn btn-default btn-sm"><i
                                                    class="fas fa-file-alt"></i> File</button>
                                        </a>
                                    </td>
                                    <td class="text py-0 align-middle">
                                        <div class="btn-group btn-group-sm">
                                            <a href="http://monitoringbps.com/sicakep/sakip/edit_dokumen/renstra/8"
                                                class="btn btn-info"><i class="fas fa-edit"></i></a>
                                            <a onclick="deleteConfirm('http://monitoringbps.com/sicakep/sakip/delete_dok/renstra/8')"
                                                href="#" class="btn btn-danger"><i
                                                    class="fas fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>9</td>
                                    <td>Dokumen Lainnya (CTH. Jadwal reviu / Monitoring Renstra)</td>
                                    <td>Tahunan</td>
                                    <td>
                                        Bagian Umum </td>
                                    <td>
                                        <a href="http://monitoringbps.com/sicakep/sakip/daftar_file_dokumen/renstra/9">
                                            <button type="button" class="btn btn-default btn-sm"><i
                                                    class="fas fa-file-alt"></i> File</button>
                                        </a>
                                    </td>
                                    <td class="text py-0 align-middle">
                                        <div class="btn-group btn-group-sm">
                                            <a href="http://monitoringbps.com/sicakep/sakip/edit_dokumen/renstra/9"
                                                class="btn btn-info"><i class="fas fa-edit"></i></a>
                                            <a onclick="deleteConfirm('http://monitoringbps.com/sicakep/sakip/delete_dok/renstra/9')"
                                                href="#" class="btn btn-danger"><i
                                                    class="fas fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>10</td>
                                    <td>Monitoring RENSTRA</td>
                                    <td>Tahunan</td>
                                    <td>
                                        Bagian Umum </td>
                                    <td>
                                        <a
                                            href="http://monitoringbps.com/sicakep/sakip/daftar_file_dokumen/renstra/79">
                                            <button type="button" class="btn btn-default btn-sm"><i
                                                    class="fas fa-file-alt"></i> File</button>
                                        </a>
                                    </td>
                                    <td class="text py-0 align-middle">
                                        <div class="btn-group btn-group-sm">
                                            <a href="http://monitoringbps.com/sicakep/sakip/edit_dokumen/renstra/79"
                                                class="btn btn-info"><i class="fas fa-edit"></i></a>
                                            <a onclick="deleteConfirm('http://monitoringbps.com/sicakep/sakip/delete_dok/renstra/79')"
                                                href="#" class="btn btn-danger"><i
                                                    class="fas fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <!-- /.table -->
                    </div>
                    <!-- /.mail-box-messages -->
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

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
