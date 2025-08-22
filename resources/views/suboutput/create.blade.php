<x-app-layout>

    <x-slot name="title">
        {{ __('Suboutput') }}
    </x-slot>

    <x-slot name="head">
        <!-- Additional resources here -->
        <link rel="stylesheet" href="{{ url('') }}/plugins/select2/css/select2.min.css">
        <link rel="stylesheet" href="{{ url('') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    </x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item"><a href="/documentation">Suboutput</a></li>
        <li class="breadcrumb-item active">Create</li>
    </x-slot>

    <!-- Default box -->
    <div class="card">

        <form action="/suboutput" method="post">
            @csrf

            <div class="card-body">

                <table id="output-show-table" class="table">
                    <tbody>
                        <tr>
                            <td class="text-left">Output</td>
                            <td class="text-left">
                                <select id="outputSelect"
                                    class="form-control select2bs4 @error('output_id') is-invalid @enderror"
                                    style="width: 100%;" name="output_id" required>
                                    <option value="" disabled>Pilih Output</option>
                                    <option selected
                                        value='{{ $output->id }}'>{{ $output->name }}</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left">Nama Suboutput</td>
                            <td class="text-left">
                                <input name="name" type="text" class="form-control" id="name-input"
                                    placeholder="Suboutput" value="{{ old('name') }}" required>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left">Tahun</td>
                            <td class="text-left">
                                <select id="yearSelect"
                                    class="form-control select2bs4 @error('year') is-invalid @enderror"
                                    style="width: 100%;" name="year" required>
                                    <option value="" disabled>Pilih Tahun</option>
                                        <option value='{{ $output->year }}' selected>{{ $output->year }}</option>
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-success">Simpan</button>
            </div>
        </form>
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
