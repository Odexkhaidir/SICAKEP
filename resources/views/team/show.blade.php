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
        <li class="breadcrumb-item active">Show</li>
    </x-slot>

    <!-- Default box -->
    <div class="card">
        
        <div class="card-body">
            <table id="user-table" class="table">
                <tbody>
                    <tr>
                        <td class="text-left">Nama</td>
                        <td class="text-left">: {{$team->name}}</td>
                    </tr>
                    <tr>
                        <td class="text-left">Satuan Kerja</td>
                        <td class="text-left">: {{$team->satker->name}}</td>
                    </tr>
                    <tr>
                        <td class="text-left">Tahun</td>
                        <td class="text-left">: {{$team->year}}</td>
                    </tr>
                    <tr>
                        <td class="text-left">Ketua</td>
                        <td class="text-left">: {{$team->leader->name}}</td>
                    </tr>
                    <tr>
                        <td class="text-left">Anggota</td>
                        <td class="text-left">: @foreach ($team->members as $member)
                            {{ $member->name }} <br /> &nbsp;
                        @endforeach</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <a href="{{ url('team') }}" class="btn btn-danger">Kembali</a>
            <a href="{{ url('team/'.$team->id.'/edit') }}" class="btn btn-warning">Edit</a>
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
