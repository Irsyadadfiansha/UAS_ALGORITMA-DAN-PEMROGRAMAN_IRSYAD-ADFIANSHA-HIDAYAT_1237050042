<?php
require "../session.php";
require "../koneksi.php";

$query = mysqli_query($con, "SELECT a.*, b.nama AS nama_kategori FROM produk a JOIN kategori b ON a.kategori_id=b.id");
$jumlahProduk = mysqli_num_rows($query);

$queryKategori = mysqli_query($con, "SELECT*FROM kategori");

//pembuat nama unik file upload
function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">

</head>

<style>
    .no-decoration {
        text-decoration: none;
    }

    form div {
        margin-bottom: 10px;
    }
</style>

<body>
    <?php require "navbar.php"; ?>
    <div class="container mt-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="../admin" class="no-decoration text-muted">
                        <i class="fas fa-home"></i> Home
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <i class="fa-solid fa-boxes-stacked "></i> Produk
                </li>
            </ol>
        </nav>
        <!--tambah produk-->
        <div class="my-5 col-12 col-md-6">
            <h3>Tambah Produk</h3>

            <form action="" method="post" enctype="multipart/form-data">
                <div>
                    <label for="nama">Nama</label>
                    <input type="text" id="nama" name="nama" class="form-control" autocomplete="off">
                </div>
                <div>
                    <label for="kategori">Kategori</label>
                    <select name="kategori" id="kategori" class="form-control">
                        <option value="">Pilih </option>
                        <?php
                        while ($data = mysqli_fetch_array($queryKategori)) {
                            ?>
                            <option value="<?php echo $data['id'] ?>"><?php echo $data['nama']; ?></option>
                            <?php
                        }
                        ?>

                    </select>
                </div>
                <div>
                    <label for="harga">Harga</label>
                    <input type="number" class="form-control" name="harga">
                </div>
                <div>
                    <label for="foto">Foto</label>
                    <input type="file" name="foto" id="foto" class="form-control">
                </div>
                <div>
                    <label for="detail">Detail</label>
                    <textarea name="detail" id="detail" cols="30" rows="10" class="form-control"></textarea>
                </div>
                <div>
                    <label for="ketersediaan_stok">Ketersediaan Stok</label>
                    <select name="ketersediaan_stok" id="ketersediaan_stok" class="form-control">
                        <option value="tersedia"> Tersedia</option>
                        <option value="habis">habis</option>
                    </select>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary" name="simpan">
                        simpan
                    </button>
                </div>
            </form>
            <?php
            if (isset($_POST['simpan'])) {
                $nama = htmlspecialchars($_POST['nama']);
                $kategori = htmlspecialchars($_POST['kategori']);
                $harga = htmlspecialchars($_POST['harga']);
                $detail = htmlspecialchars($_POST['detail']);
                $ketersediaan_stok = htmlspecialchars($_POST['ketersediaan_stok']);

                $target_dir = "../image/";
                $nama_file = basename($_FILES["foto"]["name"]);
                $target_file = $target_dir . $nama_file;
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                $image_size = $_FILES["foto"]["size"];
                $random_name = generateRandomString(20);
                $new_name = $random_name . "." . $imageFileType;


                if ($nama == '' || $kategori == '' || $harga == '') {
                    ?>
                    <div class="alert alert-warning mt-3" role="alert">
                        Nama,kategori dan harga wajib diisi
                    </div>
                    <?php
                } else {
                    if ($nama_file != '') {
                        if ($image_size > 50000000) {
                            ?>
                            <div class="alert alert-warning mt-3" role="alert">
                                file Tidak boleh lebih dari 500kb
                            </div>

                            <?php
                        } else {
                            if ($imageFileType != 'jpg' && $imageFileType != 'png' && $imageFileType != 'gif') {
                                ?>
                                <div class="alert alert-warning mt-3" role="alert">
                                    file wajib bertipe jpg atau png atau gif
                                </div>
                                <?php
                            } else {
                                move_uploaded_file($_FILES["foto"]["tmp_name"], $target_dir . $new_name);

                            }
                        }
                    }
                    //query insert to produk table
                    $queryTambah = mysqli_query($con, "INSERT INTO produk(kategori_id ,nama ,harga ,foto ,detail ,ketersediaan_stok) VALUES('$kategori','$nama','$harga','$new_name','$detail','$ketersediaan_stok')");

                    if ($queryTambah) {
                        ?>
                        <div class="alert alert-primary mt-3" role="alert">
                            produk berhasil disimpan
                        </div>
                        <meta http-equiv="refresh" content="2" ; url="produk.php" />
                        <?php
                    }
                }
            }
            ?>
        </div>
        <div class="my-5 col-12 col-md-6 mb-5">
            <div class="mt-3">
                <h2>List Produk</h2>

                <div class="table-responsive mt-5">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama</th>
                                <th>Kategori</th>
                                <th>Harga</th>
                                <th>Ketersediaan Stok</th>
                                <th>Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($jumlahProduk == 0) {
                                ?>
                                <tr>
                                    <td colspan=6 class="text-center">Tidak ada data produk</td>
                                </tr>
                                <?php
                            } else {
                                $jumlah = 1;
                                while ($data = mysqli_fetch_array($query)) {
                                    ?>
                                    <tr>
                                        <td><?php echo $jumlah ?></td>
                                        <td><?php echo $data['nama']; ?></td>
                                        <td><?php echo $data['nama_kategori']; ?></td>
                                        <td><?php echo $data['harga']; ?></td>
                                        <td><?php echo $data['ketersediaan_stok']; ?></td>
                                        <td>
                                            <a href="produk-detail.php?p=<?php echo $data['id']; ?>" class="btn btn-info"><i
                                                    class="fas fa-search"></i></a>
                                        </td>

                                    </tr>
                                    <?php
                                    $jumlah++;
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>

</body>

</html>