<?php
require "koneksi.php";

?>

<!DOCTYPE html>
<html lang="en">
    
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Signup</title>
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
        </head>
        
        <style>
            .main {
                height: 100vh;
                }
                
                .login-box {
                    width: 500px;
                    height: 300px;
                    box-sizing: border-box;
                    border-radius: 10px;
                    background-color: white;
                    }
                    </style>

<body>
    <div class="main d-flex flex-column banner3 justify-content-center align-items-center">
        <div class="login-box p-5 shadow">
            <form action="" method="post">
                <div>
                    <label for="username">Username</label>
                    <input type="text" class="form-control" name="username" id="username" required>
                    </div>
                    
                    <div>
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password" id="password" required>
                        </div>
                        
                        <div>
                            <button class="btn btn-success form-control mt-3" type="submit" name="loginbtn">Daftar</button>
                            </div>
                            <div class="mt-3">
                                
                                <p class="">Sudah Punya Akun? <a href="login.php" style="text-decoration:none">Masuk</a></p>
                                </div>
                                </form>
                                <div>
                                    <?php 
                if (isset($_POST['loginbtn'])) {
                    $username = htmlspecialchars($_POST['username']);
                    $password = password_hash(htmlspecialchars($_POST['password']), PASSWORD_BCRYPT);
                
                $pemasukan = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
                if ($con->query($pemasukan) === TRUE) { ?>
                    <div class="alert alert-primary mt-3" role="alert">
                        <?php echo "Registration successful. <a href='login.php'>Login here</a>"; ?>
                        </div><?php
                } else {
                    echo "Error: " . $pemasukan . "<br>" . $con->error;
                    }
                }
                    ?>
       
            </div>
        </div>
    </div>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>
