<!-- Навигационная панель -->
<?php
use App\Http\Middleware\Admin;
use App\Http\Middleware\User;
$user = User::getUser(); 
$admin = false;
if($user){
    $admin = new Admin();
    $admin = $admin->getAdmin();
}
 ?>
<nav>
    @include('auth.login')
    @include('auth.register')
    <div class="auth-options">
        <div>
            @if($user||$admin)
            <a href="{{ url('logout') }}" onclick="(function(e){if(!confirm('Вы точно хотите выйти?'))e.preventDefault();})(event)" id="log-out">Log out</a>
            <a href="{{ url('user/page') }}">{{$user->displayName}}</a>
            @else
            <input type="radio" name="auth" id="log-in" />
            <label for="log-in">Log in</label>
            <input type="radio" name="auth" id="log-up" />
            <label for="log-up">Log up</label>
            @endif
        </div>
    </div>
    <div class="nav-panel">
        <div class="panel-content">
            <a href="{{ url('/') }}">
                <div class="company-icon"></div>
            </a>
            <ul class="nav-menu">
                @if(!$admin&&$user)
                <li class="nav-item"><a href="{{ url('bookings') }}">Bookings</a></li>
                @endif
                <li class="nav-item"><a href="{{ url('/') }}">Home</a></li>
                @if($admin)
                <li class="nav-item"><a href="{{ url('admin') }}">Administration</a></li>
                @endif
                <li class="nav-item"><a href="{{ url('contacts') }}">Contacts</a></li>
                <li class="nav-item"><a href="{{ url('about') }}">About</a></li>
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
