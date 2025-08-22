<x-app-layout>

    <x-slot name="title">
        {{ __('Tim Kerja') }}
    </x-slot>

    <x-slot name="head">
        <!-- Additional resources here -->
        <link rel="stylesheet" href="{{ url('') }}/plugins/select2/css/select2.min.css">
        <link rel="stylesheet" href="{{ url('') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    </x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item"><a href="/team">Tim Kerja</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </x-slot>

    <!-- Default box -->
    <div class="card">
        <!-- /.card-header -->
        <div class="card-body table-reponsive">
            <form action="/team/{{ $team->id }}" method="post">
                @csrf
                @method('put')

                <div class="form-group">
                    <label class="control-label" for="year">Tahun:</label>
                    <select id="year" class="form-control select2bs4" name="year" required>
                        <option value="" disabled selected>Pilih Tahun</option>
                        <option {{ old('year', $team->year) == 2025 ? 'selected' : '' }} value='2025'>2025</option>
                        <option {{ old('year', $team->year) == 2024 ? 'selected' : '' }} value='2024'>2024</option>
                    </select>
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="control-label" for="name">Nama Tim Kerja:</label>
                    <input type="text" id="name" class="form-control @error('name') is-invalid @enderror"
                        name="name" required value="{{ old('name', $team->name) }}">
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="control-label" for="satker_id">Satuan Kerja:</label>
                    <select id="satker_id" class="form-control select2bs4" name="satker_id" required>
                        <option value="" disabled selected>Pilih Satker</option>
                        @foreach ($satkers as $satker)
                            <option {{ old('satker_id', $team->satker_id) == $satker->id ? 'selected' : '' }}
                                value="{{ $satker->id }}">{{ $satker->name }}</option>
                        @endforeach
                    </select>
                    @error('satker_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="control-label" for="leader_id">Ketua Tim:</label>
                    <select id="leader_id" class="form-control select2bs4" name="leader_id" required>
                        <option value="" disabled selected>Pilih Ketua Tim</option>
                        @foreach ($users as $user)
                            <option {{ old('leader_id', $team->leader_id) == $user->id ? 'selected' : '' }} value="{{ $user->id }}">
                                {{ $user->name }}</option>
                        @endforeach
                    </select>
                    @error('leader_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="control-label" for="members">Anggota Tim</label>
                    <select id="members" name="members[]" class="select2bs4" multiple="multiple"
                        data-placeholder="Pilih Anggota Tim" style="width: 100%;">
                        @foreach ($users as $user)
                            <option {{ (collect(old('members', $members))->contains($user->id)) ? 'selected' : '' }} value="{{ $user->id }}">
                                {{ $user->name }}</option>
                        @endforeach
                    </select>
                    @error('members')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>


            </form>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">

        </div>
        <!-- /.card-footer-->
    </div>
    <!-- /.card -->

    <x-slot name="script">
        <!-- Additional JS resources -->
        <script src="{{ url('') }}/plugins/select2/js/select2.full.min.js"></script>
        <script>
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
