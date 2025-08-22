@php
    setlocale(LC_TIME, 'id_ID');
@endphp
<x-app-layout>

    <x-slot name="title">
        {{ __('Laporan Kegiatan') }}
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
        <li class="breadcrumb-item active">Laporan Kegiatan</li>
    </x-slot>

    <div class="card">
        <form method="post" enctype="multipart/form-data" id="filterForm">
            <!-- form start -->
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-4">
                        <select id="year" class="form-control select2bs4" name="year">
                            <option value="">Pilih Tahun</option>
                            @foreach ($years as $year)
                                <option {{ $this_year == $year ? 'selected' : '' }} value="{{ $year }}">
                                    {{ $year }} </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-4">
                        <select id="month" class="form-control select2bs4" name="month">
                            <option value="">Pilih Bulan</option>
                            @foreach ($months as $month)
                                <option value="{{ $month->id }}">
                                    {{ $month->name }} </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-4">
                        <select id="jenis_kegiatan" class="form-control select2bs4" name="jenis_kegiatan">
                            <option value="">Pilih Jenis Kegiatan</option>
                            @foreach ($jenis_kegiatans as $jenis_kegiatan)
                                <option value="{{ $jenis_kegiatan->id }}">{{ $jenis_kegiatan->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>

            <div class="card-footer" style="background-color:white">
                <button id="filter-button" type="button" class="btn btn-info float-right">Tampilkan</button>
            </div>
        </form>
    </div>

    <!-- Default box -->
    <div class="card">

        <div class="card-header">
            <div class="card-tools float-left">
                <a href="{{ url('documentation/create') }}" class="btn btn-success">
                    <i class="fas fa-plus"></i> Add
                </a>
            </div>
        </div>

        <div class="card-body">
            <table id="user-table" class="table">
                <thead>
                    <tr>
                        <th class="text-center">No.</th>
                        <th class="text-center">Nama Kegiatan</th>
                        <th class="text-center">Tanggal Mulai</th>
                        <th class="text-center">Tanggal Selesai</th>
                        <th class="text-center">Jenis Kegiatan</th>
                        <th class="text-center max-w-px">Tim Kerja</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($documentations as $documentation)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ $documentation->name }}</td>
                            <td class="text-center">
                                {{ strftime('%A, %d %B %Y', strtotime($documentation->start_date)) }}</td>
                            <td class="text-center">{{ strftime('%A, %d %B %Y', strtotime($documentation->end_date)) }}
                            </td>
                            <td class="text-center ">{{ $documentation->jenis_kegiatan->name }}</td>
                            <td class="text-center ">{{ $documentation->team->name }}</td>
                            <td class="project-actions text-center">
                                <a class="btn btn-primary btn-sm" href="/documentation/{{ $documentation->id }}">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if ($documentation->created_by == Auth::user()->username)
                                    <a class="btn btn-info btn-sm" href="/documentation/{{ $documentation->id }}/edit">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <a onclick="deleteConfirm('/documentation/{{ $documentation->id }}')"
                                        class="btn btn-danger btn-sm" href="#">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                @endif
                                @if ($documentation->link && $documentation->link !== '-')
                                    <a class="btn btn-secondary btn-sm"
                                        href="{{ Str::startsWith($documentation->link, ['http://', 'https://']) ? $documentation->link : 'http://' . $documentation->link }}">
                                        <i class="fas fa-link"></i>
                                    </a>
                                @endif
                                <a class="btn btn-success btn-sm" href="{{ Storage::url($documentation->file_path) }}">
                                    <i class="fas fa-download"></i>
                                </a>
                            </td>
                        </tr>
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
                let file = "{{ Session::get('file') }}";

                if (notif != '') {
                    Toast.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: notif + ': ' + file
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

            //Filter handling
            document.getElementById('filter-button').addEventListener('click', function() {
                const year = document.getElementById('year').value;
                const month = document.getElementById('month').value;
                const jenisKegiatan = document.getElementById('jenis_kegiatan').value;

                const filterData = {
                    year: year,
                    month: month,
                    jenis_kegiatan: jenisKegiatan
                };

                axios.post('/documentation/filter', filterData)
                    .then(response => {
                        // Handle the successful response here
                        const documentations = response.data;
                        // Update the table with the filtered documentations
                        updateDocumentationsTable(documentations);
                    })
                    .catch(error => {
                        // Handle the error here
                        console.error('Error filtering documentations:', error);
                    });
            });

            function updateDocumentationsTable(documentations) {
                const table = $('#user-table').DataTable();
                table.clear().destroy(); // Destroy the existing DataTable instance

                const tableBody = document.querySelector('#user-table tbody');
                tableBody.innerHTML = ''; // Clear the existing table body

                documentations.forEach((documentation, index) => {
                    const row = document.createElement('tr');

                    // Create table cells and populate them with data
                    const serialCell = document.createElement('td');
                    serialCell.classList.add('text-center');
                    serialCell.textContent = index + 1;
                    row.appendChild(serialCell);

                    const nameCell = document.createElement('td');
                    nameCell.classList.add('text-center');
                    nameCell.textContent = documentation.name;
                    row.appendChild(nameCell);

                    const startDateCell = document.createElement('td');
                    startDateCell.classList.add('text-center');
                    startDateCell.textContent = formatDate(documentation.start_date);
                    row.appendChild(startDateCell);

                    const endDateCell = document.createElement('td');
                    endDateCell.classList.add('text-center');
                    endDateCell.textContent = formatDate(documentation.end_date);
                    row.appendChild(endDateCell);

                    const jenisKegiatanCell = document.createElement('td');
                    jenisKegiatanCell.classList.add('text-center');
                    jenisKegiatanCell.textContent = documentation.jenis_kegiatan.name;
                    row.appendChild(jenisKegiatanCell);

                    const teamCell = document.createElement('td');
                    teamCell.classList.add('text-center');
                    teamCell.textContent = documentation.team.name;
                    row.appendChild(teamCell);

                    const actionCell = document.createElement('td');
                    actionCell.classList.add('project-actions', 'text-center');

                    const viewButton = document.createElement('a');
                    viewButton.classList.add('btn', 'btn-primary', 'btn-sm');
                    viewButton.href = `/documentation/${documentation.id}`;
                    const viewIcon = document.createElement('i');
                    viewIcon.classList.add('fas', 'fa-eye');
                    viewButton.appendChild(viewIcon);
                    actionCell.appendChild(viewButton);

                    if (documentation.created_by === '{{ Auth::user()->username }}') {
                        const editButton = document.createElement('a');
                        editButton.classList.add('btn', 'btn-info', 'btn-sm');
                        editButton.href = `/documentation/${documentation.id}/edit`;
                        const editIcon = document.createElement('i');
                        editIcon.classList.add('fas', 'fa-pencil-alt');
                        editButton.appendChild(editIcon);
                        actionCell.appendChild(editButton);

                        const deleteButton = document.createElement('a');
                        deleteButton.classList.add('btn', 'btn-danger', 'btn-sm');
                        deleteButton.href = '#';
                        deleteButton.onclick = () => deleteConfirm(`/documentation/${documentation.id}`);
                        const deleteIcon = document.createElement('i');
                        deleteIcon.classList.add('fas', 'fa-trash');
                        deleteButton.appendChild(deleteIcon);
                        actionCell.appendChild(deleteButton);
                    }

                    const linkButton = document.createElement('a');
                    linkButton.classList.add('btn', 'btn-secondary', 'btn-sm');
                    const link = documentation.link && documentation.link !== '-' ?
                        documentation.link.startsWith('http://') || documentation.link.startsWith('https://') ?
                        documentation.link :
                        `http://${documentation.link}` :
                        null;

                    if (link) {
                        linkButton.href = link;
                        const linkIcon = document.createElement('i');
                        linkIcon.classList.add('fas', 'fa-link');
                        linkButton.appendChild(linkIcon);
                        actionCell.appendChild(linkButton);
                    }

                    const downloadButton = document.createElement('a');
                    downloadButton.classList.add('btn', 'btn-success', 'btn-sm');
                    downloadButton.href = `{{ Storage::url('') }}${documentation.file_path}`;
                    const downloadIcon = document.createElement('i');
                    downloadIcon.classList.add('fas', 'fa-download');
                    downloadButton.appendChild(downloadIcon);
                    actionCell.appendChild(downloadButton);

                    row.appendChild(actionCell);
                    tableBody.appendChild(row);
                });

                // Re-initialize the DataTable with the new data
                $('#user-table').DataTable({
                    "paging": true,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false,
                    "responsive": true,
                });
            }

            function formatDate(dateString) {
                const date = new Date(dateString);
                const options = {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                };
                return date.toLocaleDateString('id-ID', options);
            }
        </script>
    </x-slot>

</x-app-layout>
