<!-- Навигационная панель -->
<nav>
        <div class="nav-panel">
            <div class="panel-content">
                <a href="{{ url('') }}"><div class="company-icon"></div></a>
                <ul class="nav-menu">
                    <li class="nav-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="nav-item"><a href="{{ url('admin/bookings') }}">Booking</a></li>
                    <li class="nav-item"><a href="{{ url('admin') }}">Administration</a></li>
                    <li class="nav-item"><a href="{{ url('admin/contacts') }}">Contacts</a></li>
                </ul>
            </div>
        </div>
</nav>