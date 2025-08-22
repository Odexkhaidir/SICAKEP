<div class="container">
    <h2>Buat Formulir Supervisi</h2>
    <form action="{{ url('perjadin/formulir/store') }}" method="POST">

        @csrf
        <div class="mb-3">
            <label for="nama_supervisi" class="form-label">Nama Supervisi</label>
            <input type="text" class="form-control" id="nama_supervisi" name="nama_supervisi" required>
        </div>
        <div class="mb-3">
            <label for="tahun" class="form-label">Tahun</label>
            <select class="form-control" id="tahun" name="tahun" required>
                <option value="">Pilih Tahun</option>
                @for ($year = date('Y'); $year >= 2000; $year--)
                    <option value="{{ $year }}">{{ $year }}</option>
                @endfor
            </select>
        </div>
        {{-- <div class="mb-3">
            <label for="bulan" class="form-label">Bulan</label>
            <select class="form-control" id="bulan" name="bulan" required>
                <option value="">Pilih Bulan</option>
                <option value="1">Januari</option>
                <option value="2">Februari</option>
                <option value="3">Maret</option>
                <option value="4">April</option>
                <option value="5">Mei</option>
                <option value="6">Juni</option>
                <option value="7">Juli</option>
                <option value="8">Agustus</option>
                <option value="9">September</option>
                <option value="10">Oktober</option>
                <option value="11">November</option>
                <option value="12">Desember</option>
            </select>
        </div> --}}
        <div class="mb-3">
            <label for="link" class="form-label">Link</label>
            <input type="url" class="form-control" id="link" name="link" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
