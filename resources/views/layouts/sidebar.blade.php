<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{route('dashboard')}}" class="brand-link">
        <img src="{{ asset('images/login.png') }}" alt="Pilkades" class="brand-image elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">Pilkades</span>
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{asset('dist/img/avatar.png')}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{auth()->user()->name}}</a>
                <a href="#"><i class="fa fa-circle text-success text-sm"></i><span class="text-sm"> Online</span></a>
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-header">Menu Utama</li>
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ Request::is("*dashboard") ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                @if (Auth::user()->role == 'ADMIN')
                <li class="nav-item">
                    <a href="{{route('admin.index')}}" class="nav-link {{ Request::is("*admin") ? 'active' : '' }}">
                        <i class="nav-icon fa fa-hdd"></i>
                        <p>Daftar Admin</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link  {{ Request::is("*pengawas") ? 'active' : '' }}">
                        <i class="nav-icon fa fa-hdd"></i>
                        <p>Daftar Pengawas</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-hdd"></i>
                        <p>Daftar Calon</p>
                    </a>
                </li>
                @endif
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Daftar Data Pemilih
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sudah Memilih</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Belum Memilih</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-folder"></i>
                        <p>
                            Rekap Suara Masuk
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Rekap Perolehan</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-folder"></i>
                        <p>Laporan Hasil Pemilihan</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-users"></i>
                        <p>Pengguna</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-cogs"></i>
                        <p>Pengaturan Web</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
