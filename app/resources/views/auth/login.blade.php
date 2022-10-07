<form action="{{ url('login') }}" method="post" class="login-form">
    <h4>Вход</h4>
    @csrf
    <div class="form-group">
        <label>E-mail</label>
        <input type="text" name="email" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Password</label>
        <input type="text" name="password" class="form-control" required>
    </div>
    <div class="form-group">
        <input type="submit" value="Войти" class="btn" />
    </div>
</form>
