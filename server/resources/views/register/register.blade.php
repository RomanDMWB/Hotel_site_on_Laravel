<div class="register">
    <p>Register Page</p>
    <form action="{{ url('register') }}" method="post">
        @csrf
        <div class="form-group">
            <label for="">Name</label>
            <input type="text" name="name" id="" required>
        </div>
        <div class="form-group">
            <label for="">Surname</label>
            <input type="text" name="surname" id="" required>
        </div>
        <div class="form-group">
            <label for="">E-mail</label>
            <input type="email" name="mail" id="" required>
        </div>
        <div class="form-group">
            <label for="">Login</label>
            <input type="text" name="login" id="" required>
        </div>
        <div class="form-group">
            <label for="">Password</label>
            <input type="password" name="password" id="" required>
        </div>
        <div class="form-group">
            <input type="submit" value="Register">
        </div>
    </form>
</div>