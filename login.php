<?php
session_start();
require "koneksi.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
    }
</style>

<body>
    <div class="main d-flex flex-column banner3 justify-content-center align-items-center">
        <div class="login-box p-5 shadow" style="background-color: white;">
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
                    <button class="btn btn-success form-control mt-3" type="submit" name="loginbtn">Masuk</button>
                </div>
            </form>
            <div class="mt-3">
                <div>
                    <p class="">Belum Punya Akun? <a href="signup.php" style="text-decoration:none">Daftar</a></p>
                </div>
            </div>
            <!-- Area untuk menampilkan pesan kesalahan -->
            <div class="mt-3">
                <?php
                if (isset($_POST['loginbtn'])) {
                    $username = htmlspecialchars($_POST['username']);
                    $password = htmlspecialchars($_POST['password']);

                    $query = mysqli_query($con, "SELECT * FROM users WHERE username='$username'");
                    $countdata = mysqli_num_rows($query);
                    $data = mysqli_fetch_array($query);

                    if ($countdata > 0) {
                        if (password_verify($password, $data['password'])) {
                            $_SESSION['username'] = $data['username'];
                            $_SESSION['login'] = true;

                            if ($username == 'admin') {
                                header('Location: admin/index.php');
                            } else {
                                header('Location: index.php');
                            }
                            exit(); // Hentikan eksekusi setelah redireksi
                        } else {
                            echo '<div class="alert alert-warning" role="alert">Password salah</div>';
                        }
                    } else {
                        echo '<div class="alert alert-warning" role="alert">Akun tidak tersedia!</div>';
                    }
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>
