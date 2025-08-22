<x-app-layout>

    <x-slot name="title">
        {{ __('Target Kinerja') }}
    </x-slot>

    <x-slot name="head">
        <!-- Additional resources here -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="{{ url('') }}/plugins/select2/css/select2.min.css">
        <link rel="stylesheet" href="{{ url('') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    </x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item">Capaian Kinerja</li>
        <li class="breadcrumb-item active">Realisasi</li>
    </x-slot>

    <!-- Default box -->
    <div class="card">
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


                @can('admin-provinsi')
                    <div class="form-group col-4">
                        <select id="satker" class="form-control col-sm-6 select2bs4" name="satker">
                            <option value="">Pilih Satker</option>
                            @foreach ($satkers as $satker)
                                <option {{ $this_satker == $satker->id ? 'selected' : '' }} value="{{ $satker->id }}">
                                    {{ $satker->name }} </option>
                            @endforeach
                        </select>
                    </div>
                @endcan


            </div>
        </div>

        <div class="card-footer" style="background-color:white">

        </div>
        </form>
    </div>
    <!-- /.card -->

    @if (session('errors'))
        {{-- Display validation errors --}}
        <div class="alert alert-danger">
            <ul class="mb-0">
                <li>{{ $errors }}</li>

            </ul>
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
            <script>
                setTimeout(function() {
                    document.querySelector('.alert-success').style.display = 'none';
                }, 3000);
            </script>
        </div>
    @endif
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Realisasi Kinerja Satker</h3>
            {{-- <div class="card-tools">
                <a href="{{ route('capaian-kinerja.target.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Tambah Target Kinerja
                </a>
            </div> --}}
        </div>
        <div class="card">
            <div class="card-body table-responsive p-0">
                <table id="capaian-table" class="table table-hover">
                    <thead>
                        <tr>
                            <th rowspan="3" class="align-middle text-center">No.</th>
                            <th rowspan="3" class="align-middle text-center">Indikator</th>
                            <th rowspan="3" class="align-middle text-center">Target</th>
                            <th rowspan="3" class="align-middle text-center">Satuan</th>
                            <th colspan="4" class="text-center">Realisasi Kumulatif</th>
                            <th rowspan="3" class="align-middle text-center">Progress <br> (%)</th>
                            <th rowspan="3" class="align-middle text-center">Aksi</th>
                        </tr>
                        <tr>
                            <th colspan="4" class="text-center">Triwulan</th>
                        </tr>
                        <tr>
                            <th class="text-center">I</th>
                            <th class="text-center">II</th>
                            <th class="text-center">III</th>
                            <th class="text-center">IV</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($daftar_realisasi_kinerja_satker as $realisasi_kinerja_satker)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}.</td>

                                <td class="text-center">{{ $realisasi_kinerja_satker->indikator }}</td>
                                <td class="text-center">{{ $realisasi_kinerja_satker->target }}</td>
                                <td class="text-center">{{ $realisasi_kinerja_satker->satuan }}</td>
                                <td class="text-center">
                                    {{ $realisasi_kinerja_satker->capaian_kinerja_satker->triwulan_1 ?? '-' }}</td>
                                <td class="text-center">
                                    {{ $realisasi_kinerja_satker->capaian_kinerja_satker->triwulan_2 ?? '-' }}</td>
                                <td class="text-center">
                                    {{ $realisasi_kinerja_satker->capaian_kinerja_satker->triwulan_3 ?? '-' }}</td>
                                <td class="text-center">
                                    {{ $realisasi_kinerja_satker->capaian_kinerja_satker->triwulan_4 ?? '-' }}</td>

                                <td class="text-center">
                                    {{-- {{ round((max($realisasi_kinerja_satker->capaian_kinerja_satker->triwulan_1 ?? 0, $realisasi_kinerja_satker->capaian_kinerja_satker->triwulan_2 ?? 0, $realisasi_kinerja_satker->capaian_kinerja_satker->triwulan_3 ?? 0, $realisasi_kinerja_satker->capaian_kinerja_satker->triwulan_4 ?? 0) / $realisasi_kinerja_satker->target) * 100, 2) ?? 0.0 }} --}}
                                    {{ number_format(
                                        (max(
                                            $realisasi_kinerja_satker->capaian_kinerja_satker->triwulan_1 ?? 0,
                                            $realisasi_kinerja_satker->capaian_kinerja_satker->triwulan_2 ?? 0,
                                            $realisasi_kinerja_satker->capaian_kinerja_satker->triwulan_3 ?? 0,
                                            $realisasi_kinerja_satker->capaian_kinerja_satker->triwulan_4 ?? 0,
                                        ) /
                                            max($realisasi_kinerja_satker->target, 1)) *
                                            100,
                                        2,
                                    ) }}

                                </td>
                                <td class="text-center">
                                    <a href="{{ route('capaian-kinerja.realisasi.edit', $realisasi_kinerja_satker->id) }}"
                                        class="btn btn-sm btn-primary" title="Edit">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger" title="Hapus"
                                        onclick="deleteConfirm('{{ route('capaian-kinerja.realisasi.destroy', $realisasi_kinerja_satker->id) }}')">
                                        <i class="fas fa-trash-alt"></i> Hapus
                                    </button>

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
                document.addEventListener('DOMContentLoaded', function() {
                    const yearSelect = document.getElementById('year');
                    const satkerSelect = document.getElementById('satker');

                    function updateUrl() {

                        const year = yearSelect.value;
                        const satker = satkerSelect.value;
                        const url = new URL(window.location.href);
                        url.searchParams.set('year', year);
                        url.searchParams.set('satker', satker);
                        window.location.href = url.toString();
                    }
                    $('#year, #satker').on('change', updateUrl);

                    // yearSelect.addEventListener('change', updateUrl);
                    // satkerSelect.addEventListener('change', updateUrl);
                });
            </script>
        </x-slot>

</x-app-layout>
