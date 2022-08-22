@guest
<div class="auth">
    @include('register/login')
    @include('register/register')
</div>
@endguest
<!-- Навигационная панель -->
<nav>
        <!-- Верхняя панель -->
        <div class="top-panel">
            <div class="panel-content">
                <div id="local-date-time"></div>
                <div class="user-panel">
                    @auth
                    <a href="{{ url('logout') }}" class="btn btn-transition active">Log out</a>
                    @endauth
                    @guest
                    <a href="" class="btn btn-transition active">Log in</a>
                    <a href="" class="btn btn-transition">Register</a>
                    @endguest
                </div>
            </div>
        </div>
        <!-- Нижняя панель -->
        <div class="nav-panel">
            <div class="panel-content">
                <a href="{{ url('') }}"><div class="company-icon"></div></a>
                <ul class="nav-menu">
                    <li class="nav-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="nav-item"><a href="">Booking</a></li>
                    <li class="nav-item"><a href="{{ url('admin') }}">Administration</a></li>
                    <li class="nav-item"><a href="">About</a></li>
                    <li class="nav-item"><a href="">Contacts</a></li>
                </ul>
            </div>
        </div>
</nav>
<!-- Скрипт для добавления времени -->
<script>
    const time = document.getElementById('local-date-time');
    setInterval(() => {
        const date = new Date();
        time.innerHTML = date.toLocaleString();
    }, 1000);
</script>