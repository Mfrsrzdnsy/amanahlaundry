<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">

            <ul>
                <li class="menu-title">
                    <span>Main Menu</span>
                </li>

                <li class="{{ request()->is('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}">
                        <i class="feather-grid"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="{{ request()->is('pelanggan*') ? 'active' : '' }}">
                    <a href="{{ route('pelanggan.index') }}">
                        <i class="fas fa-users"></i>
                        <span>Pelanggan</span>
                    </a>
                </li>

                <li class="{{ request()->is('paket*') ? 'active' : '' }}">
                    <a href="{{ route('paket.index') }}">
                        <i class="fas fa-tag"></i>
                        <span>Paket Laundry</span>
                    </a>
                </li>

                <li class="{{ request()->is('transaksi*') ? 'active' : '' }}">
                    <a href="{{ route('transaksi.index') }}">
                        <i class="fas fa-receipt"></i>
                        <span>Transaksi</span>
                    </a>
                </li>

                <li class="{{ request()->is('pengaturan') ? 'active' : '' }}">
                    <a href="#">
                        <i class="fas fa-cog"></i>
                        <span>Pengaturan</span>
                    </a>
                </li>
            </ul>

        </div>
    </div>
</div>
