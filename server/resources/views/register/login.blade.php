<div class="login">
    <p>Log in Page</p>
    <form action="{{ url('login') }}" method="post">
        @csrf
        <div class="form-group">
            <label for="">Login</label>
            <input type="text" name="login" id="" required>
        </div>
        <div class="form-group">
            <label for="">Password</label>
            <input type="password" name="password" id="" required>
        </div>
        <div class="form-group">
            <input type="submit" value="Enter">
        </div>
    </form>
</div>