<form action="./login" method="post">
    {{ csrf_field() }}
    <div class="form-group">
        <label>Username</label>
        <input type="text" class="form-control" id="login-username" name="username" placeholder="Username">
    </div>
    <div class="form-group">
        <label>Password</label>
        <input type="password" class="form-control" id="login-password" name="password"
               placeholder="Password">
    </div>
    <input type="submit" class="btn btn-dark" value="Login">
</form>
