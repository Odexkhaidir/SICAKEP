<aside class="main-sidebar sidebar-light-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('') }}" class="brand-link">
        <img src="{{ url('') }}/dist/img/logo-sicakep.png" alt="SICAKEP Logo" class="brand-image">
        <span class="brand-text font-weight-bold">{{ config('app.name', 'Laravel') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
       with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ url('dashboard') }}"
                        class="nav-link {{ Request::is('/', 'dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                @can(abilities: 'kabkot')
                    <li class="nav-item {{ Request::is('capaian-kinerja*') ? 'menu-open' : '' }}">
                        <a href="" class="nav-link {{ Request::is('capaian-kinerja*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-chart-bar"></i>
                            <p>
                                Capaian Kinerja
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ url('capaian-kinerja/monitoring') }}"
                                    class="nav-link {{ Request::is('capaian-kinerja/monitoring') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Monitoring</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('capaian-kinerja/target') }}"
                                    class="nav-link {{ Request::is('capaian-kinerja/target*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Target</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('capaian-kinerja/realisasi') }}"
                                    class="nav-link {{ Request::is('capaian-kinerja/realisasi*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Realisasi</p>
                                </a>
                            </li>
                            {{-- <li class="nav-item">
                                <a href="{{ url('capaian-kinerja/summary') }}"
                                    class="nav-link {{ Request::is('capaian-kinerja/summary') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Summary</p>
                                </a>
                            </li> --}}
                        </ul>
                    </li>
                @endcan
                @can('user-akip')
                    <li class="nav-item {{ Request::is('submission*', 'permindok/monitoring*') ? 'menu-open' : '' }}">
                        <a href=""
                            class="nav-link {{ Request::is('submission*', 'permindok/monitoring*') ? 'active' : '' }}">
                            <i class="nav-icon far fa-folder-open"></i>
                            <p>
                                Permindok
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('permindok.monitoring') }}"
                                    class="nav-link {{ Request::is('permindok/monitoring*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Monitoring</p>
                                </a>
                            </li>
                            @can('kabkot')
                                <li class="nav-item">
                                    <a href="{{ route('submission.index') }}"
                                        class="nav-link {{ Request::is('submission/supervision*') ? '' : (Request::is('submission/result*') ? '' : (Request::is('submission*') ? 'active' : '')) }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Submit</p>
                                    </a>
                                </li>
                            @endcan
                            @can('supervisor-akip')
                                <li class="nav-item">
                                    <a href="{{ route('submission.supervision') }}"
                                        class="nav-link {{ Request::is('submission/supervision*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Pemeriksaan</p>
                                    </a>
                                </li>
                            @endcan
                            <li class="nav-item">
                                <a href="{{ route('submission.result') }}"
                                    class="nav-link {{ Request::is('submission/result*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Hasil</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                <li class="nav-item {{ Request::is('evaluation*') ? 'menu-open' : '' }}">
                    <a href="" class="nav-link {{ Request::is('evaluation*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>
                            Penilaian Satker
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('supervisor')
                            <li class="nav-item">
                                <a href="{{ url('evaluation/monitoring') }}"
                                    class="nav-link {{ Request::is('evaluation/monitoring') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Monitoring</p>
                                </a>
                            </li>
                        @endcan
                        @can('evaluator')
                            <li class="nav-item">
                                <a href="{{ url('evaluation') }}"
                                    class="nav-link {{ Request::is('evaluation') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Penilaian</p>
                                </a>
                            </li>
                        @endcan
                        @can('supervisor')
                            <li class="nav-item">
                                <a href="{{ route('evaluation-approval') }}"
                                    class="nav-link {{ Request::is('evaluation/approval') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Approval</p>
                                </a>
                            </li>
                        @endcan
                        @can(abilities: 'approver')
                            <li class="nav-item">
                                <a href="{{ route('evaluation-finalization') }}"
                                    class="nav-link {{ Request::is('evaluation/finalisasi') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Finalisasi</p>
                                </a>
                            </li>
                        @endcan
                        <li class="nav-item">
                            <a href="{{ route('evaluation-result') }}"
                                class="nav-link {{ Request::is('evaluation/result') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Rekapitulasi</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @can('user-provinsi')
                    <li class="nav-item {{ Request::is('perjadin*') ? 'menu-open' : '' }}">
                        <a href="" class="nav-link {{ Request::is('perjadin*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-car"></i>
                            <p>
                                Perjalanan Dinas
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ url('perjadin/formulir') }}"
                                    class="nav-link {{ Request::is('perjadin/formulir*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Form Pemeriksaan</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('perjadin/ringkasan') }}"
                                    class="nav-link {{ Request::is('perjadin/ringkasan*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Ringkasan Hasil</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('perjadin/laporan') }}"
                                    class="nav-link {{ Request::is('perjadin/laporan*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Unggah Laporan</p>
                                </a>
                            </li>

                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('documentation') }}"
                            class="nav-link {{ Request::is('documentation*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-archive"></i>
                            <p>
                                Laporan Kegiatan
                            </p>
                        </a>
                    </li>
                @endcan

                @can('admin')
                    <li class="nav-header">PENGATURAN</li>
                    <li class="nav-item">
                        <a href="{{ url('user') }}" class="nav-link {{ Request::is('user*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Pengguna
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('team') }}" class="nav-link {{ Request::is('team*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-sitemap"></i>
                            <p>
                                Tim Kerja
                            </p>
                        </a>
                    </li>
                    @can('admin-provinsi')
                        <li class="nav-item">
                            <a href="{{ route('period.index') }}"
                                class="nav-link {{ Request::is('period*') ? 'active' : '' }}">
                                <i class="nav-icon far fa-calendar"></i>
                                <p>
                                    Periode
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('output.index') }}"
                                class="nav-link {{ Request::is('output*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-bullseye"></i>
                                <p>
                                    Output
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('permindok.index') }}"
                                class="nav-link {{ Request::is('permindok/monitoring*') ? '' : (Request::is('permindok*', 'document*', 'criteria*') && !Request::is('documentation*') ? 'active' : '') }}">
                                <i class="nav-icon fas fa-file"></i>
                                <p>
                                    Permindok
                                </p>
                            </a>
                        </li>
                    @endcan
                @endcan
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
