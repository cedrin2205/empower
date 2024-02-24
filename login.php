
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login Form</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,500;0,600;0,700;1,600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="login.css">


    </head>
    <body>

        <header>
            <h2 class="logo"> 
                EmpowerEDU
            </h2>
            <nav class="navigation">
                <a href="#">About</a>
                <a href="#">Services</a>
                <a href="#">Contact</a>
                <button class="btnLogin-popup">Login</button>

            </nav>
        </header>

        <div class="background-text">
            <h2>Welcome to EmpowerEDU</h2>
            <p>Welcome to Empower EDU! We're dedicated to simplifying education through innovative technology. </p>
        </div>

        <div class="wrapper">
            <span class="icon-close">
                <ion-icon name="close"></ion-icon>
            </span>
            <div class="form-box login">
                <h2>Login</h2>
                <?php if (isset($loginError)) { ?>
                <div class="alert alert-danger"><?php echo $loginError; ?></div>
                <?php } ?>
                <form action="logged-in.php" method="post">
                    <div class="input-box">
                        <span class="icon"><ion-icon name="mail"></ion-icon></span>
                        <input type="email" name="email" required>
                        <label>Email</label>
                    </div>
                    <div class="input-box">
                        <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
                        <input type="password" name="password" required>
                        <label>Password</label>
                    </div>
                    <div class="remember-forgot">
                        <label><input type="checkbox">Remember me</label>
                        <a href="#">Forgot Password?</a>
                    </div>
                    <button type="submit" name="login" class="btn">Login</button>
                    <div class="login-register">
                        <p>Don't have an account
                            <a href="#" class="register-link">Register</a></p>
                     </div>
                </form>
            </div>
            <div class="form-box register">
            <h2>Registration</h2>
            <form action="registration.php" method="post">
                <div class="input-box"  style="
                margin-top: 40px;
                ">
                    <span class="icon"><ion-icon name="person"></ion-icon></span>
                    <input type="text" name="username" required>
                    <label>Username</label>
                </div>
                <div class="input-box">
                    <span class="icon"><ion-icon name="mail"></ion-icon></span>
                    <input type="email" name="email" required>
                    <label>Email</label>
                </div>
                <div class="input-box">
                    <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
                    <input type="password" name="password" required>
                    <label>Password</label>
                </div>
                <div class="input-box">
                    <select class="form-select" name="role">
                        <option selected disabled>Select a Grade Strand</option>
                        <option value="Humms">Humms11</option>
                        <option value="ABM">ABM11</option>
                        <option value="ICT">ICT11</option>
                        <option value="STEM">STEM11</option>
                        <option value="GAS">GAS11</option>
                        <option value="Humms">Humms12</option>
                        <option value="ABM">ABM12</option>
                        <option value="ICT">ICT12</option>
                        <option value="STEM">STEM12</option>
                        <option value="GAS">GAS12</option>
                        <option value="admin">admin</option>
                    </select>
                </div>
                <button type="submit" value="register" name="submit" class="btn">Register</button>
                <div class="login-register">
                    <p>Already have an account? <a href="#" class="login-link">Login</a></p>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
        </div>
            

        <script src="script.js"></script>
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
            
        
    </body>
</html>
