<x-app-layout>

    <x-slot name="title">
        {{ __('Laporan Kegiatan') }}
    </x-slot>

    <x-slot name="head">
        <!-- Additional resources here -->
        <link rel="stylesheet" href="{{ url('') }}/plugins/daterangepicker/daterangepicker.css">
    </x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item"><a href="/user">Laporan Kegiatan</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </x-slot>

    <!-- Default box -->
    <form action="/documentation/{{ $documentation->id }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card">

            <div class="card-header">
                <div class="card-tools float-left">
                    <h4>
                        Edit Laporan Kegiatan
                    </h4>
                </div>
            </div>

            <div class="card-body">
                <div class="form-group">
                    <label for="name-text" class="col-form-label">Nama Kegiatan:</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name-text"
                        name="name" placeholder="Nama Kegiatan" value="{{ old('name', $documentation->name) }}"
                        required>
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="col-form-label" for="teamSelect">Tim Kerja:</label>
                    <select id="teamSelect" class="form-control select2bs4 @error('team_id') is-invalid @enderror"
                        style="width: 100%;" name="team_id" required>
                        <option value="" disabled selected>Pilih Tim Kerja</option>
                        @foreach ($teams as $team)
                            <option {{ old('team_id', $documentation->team_id) == $team->id ? 'selected' : '' }}
                                value='{{ $team->id }}'>{{ $team->name }}</option>
                        @endforeach
                    </select>
                    @error('team_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="col-form-label" for="jenisSelect">Jenis Kegiatan:</label>
                    <select id="jenisSelect"
                        class="form-control select2bs4 @error('jenis_kegiatan_id') is-invalid @enderror"
                        style="width: 100%;" name="jenis_kegiatan_id" required>
                        <option value="" disabled selected>Pilih Jenis Kegiatan</option>
                        @foreach ($jenis_kegiatans as $jenis_kegiatan)
                            <option
                                {{ old('jenis_kegiatan_id', $documentation->jenis_kegiatan_id) == $jenis_kegiatan->id ? 'selected' : '' }}
                                value='{{ $jenis_kegiatan->id }}'>
                                {{ $jenis_kegiatan->name }}</option>
                        @endforeach
                    </select>
                    @error('jenis_kegiatan_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <div class="form-group">
                        <label for="jadwal" class="col-form-label">Jadwal:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="far fa-calendar-alt"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control float-right" id="jadwal" name="date_range"
                                value="{{ old('date_range', $documentation->date_range) }}">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="link-text" class="col-form-label">Link Laporan/Kelengkapan:</label>
                    <input type="text" class="form-control @error('link') is-invalid @enderror" id="link-text"
                        name="link" placeholder="Link Laporan/Kelengkapan"
                        value="{{ old('link', $documentation->link) }}">
                    @error('link')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="chooseFile" class="col-form-label">File laporan:</label>
                    <input type="file" class="@error('file') is-invalid @enderror" name="file" id="chooseFile">
                    @error('file')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                @if ($documentation->file_path)
                    <div class="form-group">
                        <label for="uploadedFile" class="col-form-label">File yang diupload:</label>
                        <div>
                            <a href="{{ Storage::url($documentation->file_path) }}"
                                target="_blank">{{ str_replace('public/uploads/', '', $documentation->file_path) }}</a>
                        </div>
                    </div>
                @endif

                <div class="card-footer">
                    <a href="{{ url('documentation') }}" class="btn btn-danger">Batal</a>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </div>
    </form>

    <x-slot name="script">
        <!-- Additional JS resources -->
        <script src="{{ url('') }}/plugins/moment/moment.min.js"></script>
        <script src="{{ url('') }}/plugins/daterangepicker/daterangepicker.js"></script>
        <script>
            //Date range picker
            $('#jadwal').daterangepicker({
                locale: {
                    format: 'YYYY-MM-DD'
                }
            })

            $(function() {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });

                var error = "{{ Session::get('error') }}";

                if (error != '') {
                    Toast.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: error
                    })
                }
            });
        </script>
    </x-slot>

</x-app-layout>
