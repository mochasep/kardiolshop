<nav class="navbar navbar-expand-lg sticky-top navbar-dark bg-dark">
    <a class="navbar-brand" href="./">Kardi Online Shop</a>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav">
            <li class="nav-item {{ isset($home) && $home ? 'active' : '' }}">
                <a class="nav-link" href="./">Home</a>
            </li>
            <li class="nav-item {{ isset($control_panel) && $control_panel ? 'active' : '' }}">
                <a class="nav-link" href="./admin">Control Panel</a>
            </li>
        </ul>
    </div>
    @if(Session::has('login'))
        <a href="./logout" class="btn btn-danger float-right">Logout</a>
    @endif
</nav>