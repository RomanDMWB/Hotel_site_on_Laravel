<!-- Навигационная панель -->
<nav>
    @include('auth.login')
    @include('auth.register')
    <div class="auth-options">
        <div>
            <input type="radio" name="auth" id="log-in" />
            <label for="log-in">Log in</label>
            <input type="radio" name="auth" id="log-up" />
            <label for="log-up">Log up</label>
        </div>
    </div>
    <div class="nav-panel">
        <div class="panel-content">
            <a href="{{ url('/') }}">
                <div class="company-icon"></div>
            </a>
            <ul class="nav-menu">
                <li class="nav-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="nav-item"><a href="{{ url('admin/bookings') }}">Booking</a></li>
                <li class="nav-item"><a href="{{ url('admin') }}">Administration</a></li>
                <li class="nav-item"><a href="{{ url('admin/contacts') }}">Contacts</a></li>
            </ul>
        </div>
    </div>
</nav>
<script>
    document.getElementById("log-in").addEventListener("change", (e) => {
        document.querySelector(".login-form").style.display = "block";
        document.querySelector(".logup-form").style.display = "none";
    });
    document.getElementById("log-up").addEventListener("change", (e) => {
        document.querySelector(".login-form").style.display = "none";
        document.querySelector(".logup-form").style.display = "block";
    });

</script>
