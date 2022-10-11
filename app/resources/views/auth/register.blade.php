<form action="{{ url('logup') }}" method="post" class="logup-form" style="display:none;">
    <h4>Регистрация</h4>
    @csrf
    <div class="form-group">
        <label>Name</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Surname</label>
        <input type="text" name="surname" class="form-control" required>
    </div>
    <div class="form-group">
        <label>E-mail</label>
        <input type="text" name="email" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Password</label>
        <input type="text" name="password" class="form-control" required>
    </div>
    <div class="form-group">
        <input type="submit" value="Зарегистрироваться" class="btn" />
    </div>
</form>
