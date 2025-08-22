<x-app-layout>

    <x-slot name="title">
        {{ __('Evaluasi') }}
    </x-slot>

    <x-slot name="head">
        <!-- Additional resources here -->
        <link rel="stylesheet" href="{{ url('') }}/plugins/select2/css/select2.min.css">
        <link rel="stylesheet" href="{{ url('') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    </x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item"><a href="/user">User</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </x-slot>

    <!-- Default box -->
    <form action="/user/{{$user->username}}" method="post">
        @csrf
        @method('put')
        <div class="card">

            <div class="card-header">
                <div class="card-tools float-left">
                    <button type="button" class="btn btn-primary">
                        Formulir Edit User
                    </button>
                </div>
            </div>

            <div class="card-body">
                <div class="form-group">
                    <label for="name-text" class="col-form-label">Nama:</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name-text"
                        name="name" placeholder="Nama" value="{{ old('name', $user->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="username-text" class="col-form-label">Username:</label>
                    <input type="text" class="form-control @error('username') is-invalid @enderror"
                        id="username-text" name="username" placeholder="Username" value="{{ old('username', $user->username) }}"
                        required>
                        @error('username')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                </div>

                <div class="form-group">
                    <label for="email-text" class="col-form-label">E-Mail:</label>
                    <input type="text" class="form-control @error('email') is-invalid @enderror" id="email-text"
                        name="email" placeholder="E-Mail" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                </div>

                <div class="form-group">
                    <label class="col-form-label" for="satkerSelect">Satuan Kerja:</label>
                    <select id="satkerSelect" class="form-control select2bs4 @error('satker_id') is-invalid @enderror"
                        style="width: 100%;" name="satker_id" required>
                        <option value="" disabled selected>Pilih Satuan Kerja</option>
                        @foreach ($satkers as $satker)
                            <option {{ old('satker_id', $user->satker_id) == $satker->id ? 'selected' : '' }} value='{{ $satker->id }}'>{{ $satker->name }}</option>
                        @endforeach
                    </select>
                    @error('satker_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="col-form-label" for="roleSelect">Role:</label>
                    <select id="roleSelect" class="form-control select2bs4 @error('role') is-invalid @enderror"
                        style="width: 100%;" name="role" required>
                        <option value="" disabled selected>Pilih Role</option>
                        <option {{ old('role', $user->role) == 'admin-provinsi' ? 'selected' : '' }} value="admin-provinsi">admin-provinsi</option>
                        <option {{ old('role', $user->role) == 'admin-satker' ? 'selected' : '' }} value="admin-satker">admin-satker</option>
                        <option {{ old('role', $user->role) == 'approver' ? 'selected' : '' }} value="approver">approver</option>
                        <option {{ old('role', $user->role) == 'supervisor' ? 'selected' : '' }} value="supervisor">supervisor</option>
                        <option {{ old('role', $user->role) == 'evaluator' ? 'selected' : '' }} value="evaluator">evaluator</option>
                        <option {{ old('role', $user->role) == 'supervisor-akip' ? 'selected' : '' }} value="supervisor-akip">supervisor-akip</option>
                        <option {{ old('role', $user->role) == 'operator-kinerja' ? 'selected' : '' }} value="operator-kinerja">operator-kinerja</option>
                        <option {{ old('role', $user->role) == 'viewer' ? 'selected' : '' }} value="viewer">viewer</option>
                    </select>
                    @error('role')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- <div class="form-group">
                    <label for="password-text" class="col-form-label">Password:</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                        id="password-text" name="password" placeholder="Password" value="{{ old('password') }}"
                        required>
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="col-form-label">Konfirmasi Password:</label>
                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                        id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi Password"
                        value="{{ old('password_confirmation') }}" required>
                        @error('password_confirmation')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                </div> --}}

            </div>
            <div class="card-footer">
                <a href="{{ url('user') }}" class="btn btn-danger">Batal</a>
                <button type="submit" class="btn btn-success">Simpan</button>
            </div>
        </div>
    </form>

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
