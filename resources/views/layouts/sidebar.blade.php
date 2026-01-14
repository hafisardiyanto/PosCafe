<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">

        <div class="sb-sidenav-menu">
            <div class="nav">

                {{-- CORE --}}
                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <div class="sb-nav-link-icon">
                        <i class="fas fa-tachometer-alt"></i>
                    </div>
                    Dashboard
                </a>

                {{-- ADMIN --}}
                @if(Auth::user()->role === 'admin')
                    <div class="sb-sidenav-menu-heading">Admin</div>
                    <a class="nav-link" href="{{ url('/menu-approval') }}">
                        <div class="sb-nav-link-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        Menu Approval
                    </a>

                       <a class="nav-link" href="{{ route('kasir.create') }}">
                         <div class="sb-nav-link-icon">
                         <i class="fas fa-user-plus"></i>
                         </div> Tambah Kasir
                        </a>

                             <div class="sb-sidenav-menu-heading">Monitoring Absen</div>
                                <a class="nav-link" href="{{ route('login.logs') }}">
                            <div class="sb-nav-link-icon">
                                <i class="fas fa-clock"></i>
                                Detail Absen
                            </div>
                                </a>

                                 <div class="sb-sidenav-menu-heading">Manajemen Menu</div>

    <a class="nav-link" href="{{ url('/menus') }}">
        <div class="sb-nav-link-icon">
            <i class="fas fa-utensils"></i>
        </div>
        Kelola Menu
    </a>

                @endif
                {{-- MANAGER --}}
                @if(Auth::user()->role === 'manager')
                    <div class="sb-sidenav-menu-heading">Manager</div>
                    <a class="nav-link" href="{{ url('/manager/laporan') }}">
                        <div class="sb-nav-link-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        Laporan
                    </a>
                @endif

                {{-- KASIR --}}
                @if(Auth::user()->role === 'kasir')
                    <div class="sb-sidenav-menu-heading">Kasir</div>
                     <a class="nav-link" href="{{ route('kasir.transaksi') }}">
    <div class="sb-nav-link-icon">
        <i class="fas fa-cash-register"></i>
    </div>
    Transaksi
</a>

<a class="nav-link" href="{{ route('menus.index') }}">
    <div class="sb-nav-link-icon">
        <i class="fas fa-utensils"></i>
    </div>
    Status Menu
</a>

                    <a class="nav-link" href="{{ url('/shift') }}">
                        <div class="sb-nav-link-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        Shift
                    </a>

                    <div class="sb-sidenav-menu-heading">Menu UMKM</div>

    <a class="nav-link" href="{{ route('kasir.menu.umkm') }}">
        <div class="sb-nav-link-icon">
            <i class="fas fa-camera"></i>
        </div>
        Tambah Menu UMKM
    </a>

                @endif

            </div>
        </div>

        

        <div class="sb-sidenav-footer">
            <div class="small">Login sebagai:</div>
            {{ Auth::user()->name }}
        </div>

       


    </nav>
</div>
