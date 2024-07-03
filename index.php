<?php 
    require "koneksi.php";
    require "session.php";

    $queryProduk=mysqli_query($con,"SELECT id,nama,harga,foto,detail FROM produk LIMIT 6");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Online | Home</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>

    </style>
</head>

<body>
    <?php require "navbar.php" ?>
     <!-- banner -->
     <div class="container-fluid banner d-flex align-items-center">
        <div class="col-md-8 offset-md-2 text-center text-white">
            <h1>Belanja Mudah, Hidup Lebih Ceria Bersama BLOOB</h1>
            <h3>Halo <?php echo $_SESSION['username']; ?>,Mau Cari Apa?</h3>
            <form method="get" action="produk.php">
                <div class="input-group input-group-lg my-4">
                    <input type="text" class="form-control" placeholder="Nama Barang" aria-label="Recipient's username" aria-describedby="basic-addon2" name="keyword">
                    <button type="submit" class="btn text-white warna2">Telusuri</button>
                </div>
            </form>
        </div>
    </div>

    <!-- highlight kategori -->
    <div class="container-fluid py-5">
        <div class="container text-center">
            <h3>Kategori Terlaris</h3>
            <div class="row mt-5">
                <div class="col-md-4 mb-3">
                    <div class="highlighted-kategori kategori-baju-pria d-flex justify-content-center align-items-center">
                        <h4 class="teks-white"><a class="no-decoration" href="produk.php?kategori=baju pria">Baju Pria</a></h4>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="highlighted-kategori kategori-baju-wanita d-flex justify-content-center align-items-center">
                        <h4 class="teks-white"><a class="no-decoration" href="produk.php?kategori=baju wanita">Baju Wanita</a></h4>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="highlighted-kategori kategori-tas d-flex justify-content-center align-items-center">
                        <h4 class="teks-white"><a class="no-decoration" href="produk.php?kategori=Tas">Tas</a></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- tentang kami -->
    <div class="container-fluid warna3 py-5">
        <div class="container text-center">
            <h3>Tentang Kami</h3>
            <p class="fs-5 mt-3">
                Bloob lahir dari ide untuk menciptakan pengalaman belanja online yang lebih baik dan lebih menyenangkan. Kami memahami betapa sibuknya kehidupan modern, dan tujuan kami adalah untuk membantu Anda menghemat waktu dan tenaga dengan menyediakan berbagai produk kebutuhan sehari-hari di satu tempat yang mudah diakses<a href="tentang-kami.php" class="no-decoration"> .....</a>
                </p>
        </div>
    </div>

    <!-- produk -->
    <div class="container-fluid py-5">
        <div class="container text-center">
            <h3>Produk</h3>
            <div class="row mt-5">
                <?php while($data=mysqli_fetch_array($queryProduk)){?>
                <div class="col-sm-6 col-md-4 mb-3">
                    <div class="card h-100">
                        <div class="image-box">
                            <img src="image/<?php echo $data['foto']?>" class="card-img-top" alt="...">
                        </div>
                        <div class="card-body">
                            <h4 class="card-title"><?php echo $data['nama'] ?></h4>
                            <p class="card-text text-harga">Rp <?php echo $data['harga'] ?></p>
                            <a href="produk-detail.php?nama=<?php echo $data['nama']?>" class="btn warna2 warna3 teks-white">Lihat Detail</a>
                        </div>
                    </div>
                </div>
                <?php }?>
            </div>

            <a class="btn btn-outline-warning mt-3" href="produk.php">See More</a>
        </div>
    </div>

    <?php require "footer.php" ?>
    <script script="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="fontawesome/js/all.min.js"></script>
</body>

</html>