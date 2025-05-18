<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="Stylesheet" href="sia.css">
    <link rel="Stylesheet" href="css/all.min.css">
    <link rel="Stylesheet" href="css/fontawesome.min.css">

</head>
<body>
    <div class="Loginbox">
        <form action="connections/connection.php" method = "POST">

            <div class="login-container">
                <div class="logo-heading">
                    <h2>Grade Central</h2>
                    <img src="bcp logo.png" alt="Logo">
                    </div>
                    <span><i class="fa-solid fa-user"></i></span>
                    <label>Username</label>
                <input type="text" name="username" placeholder="Username">
                <span><i class="fa-solid fa-lock"></i></span>
                <label>Password</label>
                <input type="password" name="password" placeholder="Password">
                
                <input type="submit" name="submit" value="Login">
                <div class="forgot"> <a href="test.html">Forgot Password?</a></div>
              </div>
        </form>
    </div>
</body>
</html>