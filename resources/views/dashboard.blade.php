<x-app-layout>

    <x-slot name="title">
        {{ __('Dashboard') }}
    </x-slot>

    <x-slot name="head">
        <!-- Additional resources here -->
    </x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item active">Dashboard</li>
    </x-slot>

    <!-- Default box -->
    <div class="card">
        {{-- <div class="card-header">

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div> --}}
        <div class="card-body">
            Halo, {{ auth()->user()->name }}! Selamat datang di <b>Sicakep</b>, "<i>{{ $quote->description }}</i>"
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

    <div class="row">
        <div class="col-md-4">
            <!-- Box Comment -->
            <div class="card card-widget collapsed-card">
                <div class="card-header">
                    <div class="user-block">
                        <img class="img-circle" src="{{ url('') }}/dist/img/dashboard/plan.png" alt="User Image">
                        <span class="username"><a
                                href="https://ppid.bps.go.id/upload/doc/Reviu_Rencana_Strategis__Renstra__Badan_Pusat_Statistik__BPS__Provinsi_Sulawesi_Utara_2020-2024_1693465045.pdf">Renstra</a></span>
                        <span class="description">Rencana Strategis</span>
                    </div>
                    <!-- /.user-block -->
                    <div class="card-tools">
                        {{-- <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                class="fas fa-plus"></i>
                        </button> --}}
                    </div>
                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <!-- post text -->
                    <div class="callout callout-info">
                        <a href="https://sulut.bps.go.id/backend/fileMenu/Renstra-2020-2024.pdf" target="_blank"><img
                                class="img-fluid pad"
                                src="http://monitoringbps.com/sicakep/assets/dashboard/cover-renstra.jpg"
                                alt="Cover Renstra"></a>

                    </div>

                </div>
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->

        <div class="col-md-4">
            <!-- Box Comment -->
            <div class="card card-widget collapsed-card">
                <div class="card-header">
                    <div class="user-block">
                        <img class="img-circle" src="{{ url('') }}/dist/img/dashboard/flat.png" alt="User Image">
                        <span class="username"><a
                                href="https://ppid.bps.go.id/upload/doc/Laporan_Kinerja_Instansi_Pemerintah_BPS_Provinsi_Sulawesi_Utara_Tahun_2023_1707787222.pdf">LKIP</a></span>
                        <span class="description">Laporan Kinerja Instansi Pemerintah</span>
                    </div>
                    <!-- /.user-block -->
                    <div class="card-tools">
                        {{-- <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                class="fas fa-plus"></i>
                        </button> --}}
                    </div>
                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <!-- post text -->

                    <div class="callout callout-warning">
                        <a href="https://sulut.bps.go.id/backend/fileMenu/Lakip-Tahun-2020-BPS-Provinsi-Sulawesi-Utara.pdf"
                            target="_blank"><img class="img-fluid pad"
                                src="http://monitoringbps.com/sicakep/assets/dashboard/cover-lkip.png"
                                alt="Cover LKIP"></a>
                    </div>

                </div>
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->

        <div class="col-md-4">
            <!-- Box Comment -->
            <div class="card card-widget collapsed-card">
                <div class="card-header">
                    <div class="user-block">
                        <img class="img-circle" src="{{ url('') }}/dist/img/dashboard/handshake.png"
                            alt="User Image">
                        <span class="username"><a
                                href="https://ppid.bps.go.id/upload/doc/Perjanjian_Kinerja_Tahun_2024_BPS_Provinsi_Sulawesi_Utara_1706840283.pdf">Perjanjian
                                Kinerja</a></span>
                        <span class="description">Perjanjian Kinerja</span>
                    </div>
                    <!-- /.user-block -->
                    <div class="card-tools">
                        {{-- <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                class="fas fa-plus"></i>
                        </button> --}}
                    </div>
                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <!-- post text -->

                    <div class="callout callout-danger">
                        <a href="https://sulut.bps.go.id/backend/fileMenu/Perjanjian-Kinerja-BPS-Provinsi-Sulawesi-Utara-Tahun-2021--Reviu-II-.pdf"
                            target="_blank"><img class="img-fluid pad"
                                src="http://monitoringbps.com/sicakep/assets/dashboard/cover-pk.png" alt="Cover PK"></a>
                    </div>

                </div>
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->

        <div class="col-md-4">
            <!-- Box Comment -->
            <div class="card card-widget collapsed-card">
                <div class="card-header">
                    <div class="user-block">
                        <img class="img-circle" src="{{ url('') }}/dist/img/dashboard/form.png" alt="User Image">
                        <span class="username"><a href="#">FRA</a></span>
                        <span class="description">Form Rencana Aksi</span>
                    </div>
                    <!-- /.user-block -->
                    <div class="card-tools">
                        {{-- <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                class="fas fa-plus"></i>
                        </button> --}}
                    </div>
                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <!-- post text -->

                    <div class="callout callout-warning">
                        <a href="https://s.bps.go.id/7100-FRA-2024"><img class="img-fluid pad"
                                src="http://monitoringbps.com/sicakep/assets/dashboard/screenshot_fra.png"
                                alt="FRA"></a>
                    </div>

                </div>
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->

        <div class="col-md-4">
            <!-- Box Comment -->
            <div class="card card-widget collapsed-card">
                <div class="card-header">
                    <div class="user-block">
                        <img class="img-circle" src="{{ url('') }}/dist/img/dashboard/monitor.png"
                            alt="User Image">
                        <span class="username"><a href="https://monev.bps.go.id">Simonev BPS</a></span>
                        <span class="description">Sistem Monitoring Evaluasi</span>
                    </div>
                    <!-- /.user-block -->
                    <div class="card-tools">
                        {{-- <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                class="fas fa-plus"></i>
                        </button> --}}
                    </div>
                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <!-- post text -->

                    <div class="callout callout-success">
                        <a href="https://monev.bps.go.id" target="_blank"><img class="img-fluid pad"
                                src="http://monitoringbps.com/sicakep/assets/dashboard/screenshot_simonev.png"
                                alt="Simonev"></a>
                    </div>

                </div>
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->

        <div class="col-md-4">
            <!-- Box Comment -->
            <div class="card card-widget collapsed-card">
                <div class="card-header">
                    <div class="user-block">
                        <img class="img-circle" src="{{ url('') }}/dist/img/dashboard/education.png"
                            alt="User Image">
                        <span class="username"><a href="https://smart.kemenkeu.go.id">SMART</a></span>
                        <span class="description">SMART</span>
                    </div>
                    <!-- /.user-block -->
                    <div class="card-tools">
                        {{-- <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                class="fas fa-plus"></i>
                        </button> --}}
                    </div>
                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <!-- post text -->

                    <div class="callout callout-info">
                        <a href="http://monev.anggaran.kemenkeu.go.id/smart/" target="_blank"><img
                                class="img-fluid pad"
                                src="http://monitoringbps.com/sicakep/assets/dashboard/screenshot_smart.png"
                                alt="Smart"></a>
                    </div>

                </div>
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
        <div class="col-md-4">
            <!-- Box Comment -->
            <div class="card card-widget collapsed-card">
                <div class="card-header">
                    <div class="user-block">
                        <img class="img-circle" src="{{ url('') }}/dist/img/dashboard/laptop.png"
                            alt="User Image">
                        <span class="username"><a href="http://e-monev.bappenas.go.id/">Bappenas</a></span>
                        <span class="description">Bappenas</span>
                    </div>
                    <!-- /.user-block -->
                    <div class="card-tools">

                    </div>
                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <!-- post text -->

                    <div class="callout callout-info">
                        <a href="http://e-monev.bappenas.go.id/" target="_blank"><img class="img-fluid pad"
                                src="http://monitoringbps.com/sicakep/assets/dashboard/screenshot_bappenas.png"
                                alt="Bappenas"></a>
                    </div>

                </div>
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>

    <div class="col-md-12">
        <!-- BAR CHART -->
        <div class="card card-widget">
            <div class="card-header">
                <h3 class="card-title">Peringkat Satker Bulan {{ $month[0]->name }} {{ $this_year }}</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                            class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                @if ($status == 3)
                    <div class="chart">
                        <canvas id="barChart"
                            style="min-height: 250px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
                    </div>
                @else
                    Data Penilaian Bulan <code>{{ $month[0]->name }}</code> Belum Tersedia
                @endif
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->

    <div class="col-md-12">
        <!-- BAR CHART -->
        <div class="card card-widget">
            <div class="card-header">
                <h3 class="card-title">Penilaian Permindok {{ $permindok_description }}</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                            class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="chart">
                    <canvas id="permindokChart"
                        style="min-height: 250px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->

    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> --}}
                    <p>Halo, {{ auth()->user()->name }}! Selamat datang di <b>Sicakep</b>, <Br>
                        "<i>{{ $quote->description }}</i>"</p>
                </div>
            </div>
        </div>
    </div>


    <x-slot name="script">
        <!-- OPTIONAL SCRIPTS -->
        <script src="{{ url('') }}/plugins/chart.js/Chart.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#modal-default').modal('show');
                $(function() {
                    /* ChartJS
                     * -------
                     * Here we will create a few charts using ChartJS
                     */

                    //--------------
                    //- AREA CHART -
                    //--------------

                    // Get context with jQuery - using jQuery's .get() method.

                    var tempArray = @json($evaluations)

                    var dataLabel = [];
                    var dataRata = [];
                    for (var i = 0; i < tempArray.length; i++) {
                        var num = i + 1;
                        dataLabel.push('[' + num + '] ' + tempArray[i].name);
                        dataRata.push(tempArray[i].average_score);
                    }

                    var areaChartData = {
                        labels: dataLabel,
                        //labels  : ['7101', '7102', '7103', '7104', '7105', '7106', '7107', '7108', '7171', '7172', '7173', '7174',],
                        datasets: [{
                            label: 'Nilai Rata-Rata',
                            backgroundColor: 'rgba(247,155,7,0.9)',
                            borderColor: 'rgba(247,155,7,0.8)',
                            pointRadius: false,
                            pointColor: '#3b8bba',
                            pointStrokeColor: 'rgba(247,155,7,1)',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(247,155,7,1)',
                            data: dataRata
                        }, ]
                    }

                    //-------------
                    //- BAR CHART -
                    //-------------
                    var barChartCanvas = $('#barChart').get(0).getContext('2d')
                    var barChartData = jQuery.extend(true, {}, areaChartData)
                    var temp0 = areaChartData.datasets[0]
                    barChartData.datasets[0] = temp0

                    var barChartOptions = {
                        responsive: true,
                        maintainAspectRatio: false,
                        datasetFill: false
                    }

                    var barChart = new Chart(barChartCanvas, {
                        type: 'bar',
                        data: barChartData,
                        options: barChartOptions
                    })
                })

                $(function() {
                    /* ChartJS
                     * -------
                     * Here we will create a few charts using ChartJS
                     */

                    //--------------
                    //- AREA CHART -
                    //--------------

                    // Get context with jQuery - using jQuery's .get() method.

                    var tempArray = @json($permindok)

                    var dataLabel = [];
                    var dataRata = [];
                    for (var i = 0; i < tempArray.length; i++) {
                        var num = i + 1;
                        dataLabel.push('[' + num + '] ' + tempArray[i].name);
                        dataRata.push(tempArray[i].score);
                    }

                    var areaChartData = {
                        labels: dataLabel,
                        //labels  : ['7101', '7102', '7103', '7104', '7105', '7106', '7107', '7108', '7171', '7172', '7173', '7174',],
                        datasets: [{
                            label: 'Nilai Rata-Rata',
                            backgroundColor: 'rgba(14, 243, 71, 0.8)',
                            borderColor: 'rgba(14, 243, 71, 0.8)',
                            pointRadius: false,
                            pointColor: '#3b8bba',
                            pointStrokeColor: 'rgba(14, 243, 71, 0.8)',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(14, 243, 71, 0.8)',
                            data: dataRata
                        }, ]
                    }

                    //-------------
                    //- BAR CHART -
                    //-------------
                    var barChartCanvas = $('#permindokChart').get(0).getContext('2d')
                    var barChartData = jQuery.extend(true, {}, areaChartData)
                    var temp0 = areaChartData.datasets[0]
                    barChartData.datasets[0] = temp0

                    var barChartOptions = {
                        responsive: true,
                        maintainAspectRatio: false,
                        datasetFill: false
                    }

                    var barChart = new Chart(barChartCanvas, {
                        type: 'bar',
                        data: barChartData,
                        options: barChartOptions
                    })
                })
            });
        </script>
    </x-slot>

</x-app-layout>
