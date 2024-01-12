<div class="dash-nav dash-nav-dark">
    <header>
        <a href="#!" class="menu-toggle">
            <i class="fas fa-bars"></i>
        </a>
        <a href="{{ route('home') }}" class="spur-logo"><i class="fas fa-bolt" style="color: #14BDEB"></i> <span>Sharon</span></a>
    </header>
    <nav class="dash-nav-list">
        <a href="{{ route('home') }}" class="dash-nav-item">
            <i class="fas fa-home"></i> Principal </a>
        <a href="{{ route('corte.index') }}" class="dash-nav-item">
            <i class="fa-solid fa-shirt"></i> Cortes </a>
        <div class="dash-nav-dropdown">
            <a href="#!" class="dash-nav-item dash-nav-dropdown-toggle">
                <i class="fas fa-chart-bar"></i> Terceros </a>
            <div class="dash-nav-dropdown-menu">
                <a href="{{ route('modista.index') }}" class="dash-nav-dropdown-item">Modistas</a>
            </div>
        </div>
    </nav>
</div>
