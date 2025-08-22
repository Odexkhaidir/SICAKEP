<x-app-Layout>

    <x-slot name="title">
        {{ __('Dokumen') }}
    </x-slot>

    <x-slot name="head">
        <!-- Additional resources here -->
        <link rel="stylesheet" href="{{ url('') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
        <link rel="stylesheet" href="{{ url('') }}/plugins/select2/css/select2.min.css">
    </x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('permindok.index') }}">Permindok</a></li>
        <li class="breadcrumb-item"><a href="{{ route('permindok.documents', $document->permindok_id) }}">Dokumen</a>
        </li>
        <li class="breadcrumb-item active">Edit</li>
    </x-slot>

    <div class="card">

        <div class="card-header">
            <h3 class="card-title">Edit Dokumen</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-lg">
                    <i class="fas fa-plus"></i> Add
                </button>
            </div>
        </div>

        <form id="document-form" action="/document/{{ $document->id }}" method="post">
            @csrf
            @method('put')

            <div class="card-body">

                <div class="form-group">
                    <label class="col-form-label" for="permindok_id">Dokumen:</label>
                    <select id="permindok" class="form-control select2bs4" style="width: 100%;"
                        name="permindok_id">
                        <option value='{{ $document->permindok_id }}'>{{ $document->permindok->description }}</option>
                    </select>
                    <div class="help-block"></div>
                </div>

                <div class="form-group">
                    <label for="name-text" class="col-form-label">Deskripsi Kriteria:</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                        id="name-text" name="name" placeholder="name"
                        value="{{ old('name', $document->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

            </div>
            <div class="card-footer">
                <a href="{{ route('permindok.documents', $document->permindok_id) }}" class="btn btn-default">Back</a>
                <button type="submit" class="btn btn-success">Simpan</button>
            </div>
        </form>
    </div>


    <x-slot name="script">
        <!-- Additional JS resources -->
        <script src="{{ url('') }}/plugins/select2/js/select2.full.min.js"></script>
        <script src="{{ url('') }}/plugins/moment/moment.min.js"></script>
        <script src="{{ url('') }}/plugins/daterangepicker/daterangepicker.js"></script>
        <script>
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

        </script>
    </x-slot>

    </x-dashboard-Layout>
