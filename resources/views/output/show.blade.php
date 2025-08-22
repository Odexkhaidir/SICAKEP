<x-app-layout>

    <x-slot name="title">
        {{ __('Output') }}
    </x-slot>

    <x-slot name="head">
        <!-- Additional resources here -->
        <link rel="stylesheet" href="{{ url('') }}/plugins/select2/css/select2.min.css">
        <link rel="stylesheet" href="{{ url('') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    </x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item"><a href="/documentation">Output</a></li>
        <li class="breadcrumb-item active">Show</li>
    </x-slot>

    <!-- Default box -->
    <div class="card">

        <div class="card-body">
            <table id="output-show-table" class="table">
                <tbody>
                    <tr>
                        <td class="text-left">Nama Output</td>
                        <td class="text-left">: {{ $output->name }}</td>
                    </tr>
                    <tr>
                        <td class="text-left">Tim Kerja</td>
                        <td class="text-left">: {{ $output->team->name . ' - ' . $output->team->leader->name }}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-left">Supervisor</td>
                        <td class="text-left">: {{ $output->supervisor->name }}</td>
                    </tr>
                    <tr>
                        <td class="text-left">Tahun</td>
                        <td class="text-left">: {{ $output->year }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <a href="{{ route('output.index') }}" class="btn btn-danger">Kembali</a>
            <a href="{{ route('output.edit', $output->id) }}" class="btn btn-warning">Edit</a>
        </div>
    </div>

    <div class="card">

        <div class="card-header">

            <div class="card-tools">
                <a href="{{ route('suboutput-create', $output->id) }}" class="btn btn-success">Tambah</a>
            </div>

        </div>

        <div class="card-body">
            <table id="suboutput-show-table" class="table">
                <thead>
                    <tr>
                        <th class="text-center">No.</th>
                        <th class="text-center">Suboutput</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($output->suboutput as $suboutput)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $suboutput->name }}</td>
                            <td class="project-actions text-center">
                                <a class="btn btn-info btn-sm" href="{{ route('suboutput.edit',$suboutput->id) }}">
                                    <i class="fas fa-pencil-alt">
                                    </i>
                                    Edit
                                </a>
                                <a onclick="deleteConfirm('/suboutput/{{ $suboutput->id }}')" class="btn btn-danger btn-sm"
                                    href="#">
                                    <i class="fas fa-trash">
                                    </i>
                                    Delete
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
        <script>
            $(document).on('focus', '.select2-selection', function(e) {
                $(this).closest(".select2-container").siblings('select:enabled').select2('open');
            })

            $(document).on('select2:open', () => {
                document.querySelector('.select2-search__field').focus();
            });
            
            function deleteConfirm(url) {
                $('#btn-delete').attr('action', url);
                $('#deleteModal').modal();
            }

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
