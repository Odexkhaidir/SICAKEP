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
    </x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item"><a href="/documentation">Documentation</a></li>
        <li class="breadcrumb-item active">Show</li>
    </x-slot>

    <!-- Default box -->
    <div class="card">

        <div class="card-body">
            <table id="documentation-table" class="table">
                <tbody>
                    <tr>
                        <td class="text-left">Nama Kegiatan</td>
                        <td class="text-left">: {{ $documentation->name }}</td>
                    </tr>
                    <tr>
                        <td class="text-left">Tanggal Mulai</td>
                        <td class="text-left">: {{ strftime('%A, %d %B %Y', strtotime($documentation->start_date)) }}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-left">Tanggal Selesai</td>
                        <td class="text-left">: {{ strftime('%A, %d %B %Y', strtotime($documentation->end_date)) }}</td>
                    </tr>
                    <tr>
                        <td class="text-left">Tim Kerja</td>
                        <td class="text-left">: {{ $documentation->team->name }}</td>
                    </tr>
                    <tr>
                        <td class="text-left">Jenis Kegiatan</td>
                        <td class="text-left">: {{ $documentation->jenis_kegiatan->name }}</td>
                    </tr>
                    <tr>
                        <td class="text-left">Link Laporan/Kelengkapan</td>
                        <td class="text-left">: {{ $documentation->link }}</td>
                    </tr>
                    {{-- Add code for download file $documentation->file --}}
                    <tr>
                        <td class="text-left">File Laporan/Kelengkapan</td>
                        <td class="text-left">: <a href="{{ Storage::url($documentation->file_path) }}"
                                target="_blank">Download</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <a href="{{ url('documentation') }}" class="btn btn-danger">Kembali</a>
            @if ($documentation->created_by == Auth::user()->username)
                <a href="{{ url('documentation/' . $documentation->id . '/edit') }}" class="btn btn-warning">Edit</a>
            @endif

        </div>
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
