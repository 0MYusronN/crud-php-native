<?php

    // Koneksi DB
    $server = "localhost";
    $user = "root";
    $pass = "";
    $database = "coba_crud-native";

    $koneksi = mysqli_connect($server, $user, $pass, $database)or die(mysqli_error($koneksi));

    // tombol simpan
    if (isset($_POST['bsimpan'])) 
    {
            // UJI DATA akan di edit atau simpan
        if ($_GET['hal'] == "edit") {
            $edit = mysqli_query($koneksi, " UPDATE users set username = '$_POST[tuser]', password = '$_POST[tpass]',level = '$_POST[tlevel]' WHERE id_users = '$_GET[id]' ");
    
                if($edit)
                {
                echo "<script>
                        alert('edit data suksess');
                        document.location='index.php';
                    </script>";
                }
                else {
                    echo "<script>
                            alert('edit data GAGAL');
                            document.location='index.php';
                        </script>";
                }
        }else 
        {
            $simpan = mysqli_query($koneksi, "INSERT INTO users (username, password,level) VALUES ('$_POST[tuser]','$_POST[tpass]','$_POST[tlevel]')");
    
                if($simpan)
                {
                echo "<script>
                        alert('Simpan data suksess');
                        document.location='index.php';
                    </script>";
                }
                else {
                    echo "<script>
                            alert('Simpan data GAGAL');
                            document.location='index.php';
                        </script>";
                }
        }
        
    }
// jika tombol edit

if (isset($_GET['hal'])) {
    // uji edit
    if ($_GET['hal'] == "edit") {
        // tampilkan data dipilih
        $tampil = mysqli_query($koneksi, "SELECT * FROM users WHERE id_users = '$_GET[id]'");
        $data = mysqli_fetch_array($tampil);
        if ($data) 
        {
            // JIKA DATA DITEMUKAN
            $vuser = $data['username'];
            $vpass = $data['password'];
            $vlevel = $data['level'];
        }
    }
    else if($_GET['hal'] == "hapus")
        {
            $hapus = mysqli_query($koneksi, "DELETE FROM users WHERE id_users = '$_GET[id]'");    
        
        if ($hapus) {
            echo "<script>
                        alert('Hapus data SUKSESS');
                        document.location='index.php';
                    </script>";
        }
        }
}

?>

<!doctype html>
<html lang="en">

<head>
    <title>CRUD-PHP-NATIVE</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css"">
    <!-- FONTAWESOM 6.30 -->
    <link rel=" stylesheet" href="assets/css/fontawesome-pro-6.css"">


</head>
<body>
    <div class=" container-fluid">
    <!-- # NAVBAR -->
    <nav class=" navbar navbar-expand-lg navbar-dark bg-danger">
        <a class="navbar-brand" href="#">CRUD</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
            aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-link active" href="#">HOME</a>
                <a class="nav-link" href="#">USERS</a>
                <a class="nav-link" href="#">PEMASUKAN</a>
                <a class="nav-link disabled">PENGELUARAN</a>
            </div>
        </div>
    </nav>
    <!-- / NAVBAR END -->

    <!-- # CARD INPUT DATA -->
    <div class="card mt-4 mb-4">
        <div class="card-header bg-primary text-light">
            FORM INPUT
        </div>
        <div class="card-body">
            <form action="" method="post">
                <div class="form-group">
                    <label for="tuser">Username</label>
                    <input type="text" name="tuser" value="<?=@$vuser?>" id="tuser" class="form-control" placeholder="Masukan Usernmae"
                        required>
                </div>
                <div class="form-group">
                    <label for="tpass">Password</label>
                    <input type="text" name="tpass" value="<?=@$vpass?>" id="tpass" class="form-control" placeholder="Masukan Usernmae"
                        required>
                </div>
                <div class="form-group">
                    <label for="tlevel">Level User</label>
                    <select class="form-control" name="tlevel" id="tlevel">
                        <option value="<?=@$vlevel?>"><?=@$vlevel?></option>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                    </select>
                </div>
                
                <button type="submit" class="btn btn-success" name="bsimpan">
                    <i class="fa-solid fa-floppy-disk"></i> SAVE
                </button>
                <button type="reset" class="btn btn-danger" name="breset">
                    <i class="fa-solid fa-ban"></i> CANCEL
                </button>
            </form>

        </div>
    </div>
    <!-- / CARD INPUT END -->

    <!-- # CARD TAMPIL DATA  -->
    <div class="card mt-4">
        <div class="card-header bg-success text-light">
            DATA USER
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">username</th>
                        <th scope="col">password</th>
                        <th scope="col">level</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <?php
                $no = 1;
                $tampil = mysqli_query($koneksi, "SELECT * FROM users order by id_users ASC");
                    while($data = mysqli_fetch_array($tampil)):
                ?>
                <tbody>
                    <tr>
                        <th scope="row"><?= $no++; ?></th>
                        <td><?= $data['username']; ?></td>
                        <td><?= $data['password']; ?></td>
                        <td><?= $data['level']; ?></td>
                        <td>
                            <a href="index.php?hal=edit&id=<?=$data['id_users']?>" class="btn btn-warning text-light">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <a href="index.php?hal=hapus&id=<?=$data['id_users']?>" onclick="return confirm('Are You Sure ?')" class="btn btn-danger text-light">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        
                        </td>
                    </tr>
                </tbody>
                <?php
                endwhile;
                ?>
            </table>
        </div>
    </div>
    <!-- / CARD TAMPIL DATA END -->
    </div>






    <!-- Optional JavaScript -->

    <script type=" text/javascript" src="assets/js/fontawesome-pro-6.js"></script>
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script type=" text/javascript" src="assets/js/jquery-3.3.1.slim.min.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
    </body>

</html>