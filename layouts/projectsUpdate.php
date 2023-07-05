<?php
## Author : M. Nasirul Umam
## Tanggal : 25 juli 2023 
    session_start();
    if ($_SESSION['username'] == false){ // pengecekan apabila username sama dengan salah maka kembali ke login
        header('Location:../login.php');
    }
    require_once 'init.php'; // mengambil halaman include dari koneksi

    //$name = $_SESSION['name'];
    $uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); // untuk Mengambil jalur dari URL yang diminta oleh pengguna menggunakan fungsi parse_url.
    $uri_segments = explode('/', $uri_path); // Memecah jalur URL menjadi segmen-segmen terpisah berdasarkan karakter "/" menggunakan fungsi explode.

    $id = $uri_segments[4]; //Mengambil nilai yang ada pada segmen keempat (indeks 4) dari array segmen-segmen untuk digunakan sebagai nilai variabel $id

    $queryprojects ="SELECT * FROM projects WHERE id = '$id'"; // Query untuk memilih semua kolom dari tabel 'projects' dengan kondisi 'id' yang sama dengan nilai variabel '$id'
    $result = mysqli_query($koneksi,$queryprojects); // Menjalankan query menggunakan fungsi mysqli_query dengan menggunakan koneksi '$koneksi'.
    $data = mysqli_fetch_array($result); // Mengambil hasil query sebagai array menggunakan fungsi mysqli_fetch_array.
    
    if(isset($_POST["simpan"])) { // pengecekan apakah klik  "simpan" telah ditekan pada formulir sebelum melanjutkan.
        $name    = $_POST["name"]; // deklarasi variabel name dari kiriman from 
        $description = $_POST["description"]; // // deklarasi variabel name dari kiriman from 
        //$id      = $_SESSION['id'];

        $target_dir = "../img/"; //  Menentukan direktori target untuk menyimpan file gambar.
        $target_file = $target_dir . basename($_FILES["image"]["name"]); // Membentuk jalur lengkap ke file target dengan menggabungkan direktori target dan nama file gambar yang diunggah
        // upload ok = apakah masing - masing if di jalankan atau didak ?
        // uploadHasil = mengarahkan error ke perintah yang mana
        // uploadOk = 1 berhasil
        // uploadHasil = 2 file bukan gambar
        // uploadHasil = 3 file sudah ada 
        // uploadHasil = 4 file terlalu besar
        // uploadHasil = 5 file harus jpg, jpeg, png, dan gif
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION)); //  Mendapatkan ekstensi file dari jalur file target dan mengubahnya menjadi huruf kecil.

        $uploadHasil = 0;
        // pengecekan apakah file tipe gambar kosong atau tidak 
        if(empty($_FILES["image"]["name"])) {
            $queryUpdate = "UPDATE projects SET name ='$name', description ='$description' WHERE id = '$id'"; // // Query untuk melakukan pembaruan data pada tabel 'projects' dengan mengatur nilai kolom 'name' dan 'description' berdasarkan kondisi 'id'.
            $result = mysqli_query($koneksi,$queryUpdate); // Menjalankan query menggunakan fungsi mysqli_query dengan menggunakan koneksi '$koneksi'.
            $uploadOk = 6;
            $hasil = "Pofile photo cant be empty";
        }else {
            $check = getimagesize($_FILES["image"]["tmp_name"]); // Memeriksa apakah file yang diunggah adalah gambar valid
            // var_dump($check);
            if($check !== false) {
                $uploadOk = 1;
            } else {
                $uploadOk = 0;
                $uploadHasil = 2;
            }
        
            // Check if file already exists
            if (file_exists($target_file)) {
                $uploadOk = 0;
                $uploadHasil = 3;
            }

            // Check file size
            if ($_FILES["image"]["size"] > 500000) {
                $uploadOk = 0;
                $uploadHasil = 4;
                }

            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                $uploadHasil = 5;
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                if($uploadHasil == 2){
                    $hasil = "File is not an image";
                } else if($uploadHasil ==3){
                    $hasil = "Sorry, file is already exists";    
                } else if($uploadHasil == 4){
                    $hasil = "Sorrr, your file is too large";    
                } else if($uploadHasil == 5){
                    $hasil = "Sorry, only jpg, jpeg, png and gif files are supported";
                }
            // if everything is ok, try to upload file
            } else {
                $link =  str_replace('\layouts','',__dir__); // Mengganti bagian '/layouts' dari direktori saat ini dengan string kosong untuk mendapatkan jalur menuju direktori yang diinginkan.
                unlink($link."/img/".$data["image"]); // Menghapus file gambar lama yang terkait dengan proyek sebelumnya
                $image = basename($_FILES["image"]["name"]); // Mendapatkan nama file gambar yang diunggah saat ini.
                $queryUpdate = "UPDATE projects SET name ='$name', description ='$description', image ='$image' WHERE id = '$id'"; // Query untuk memperbarui data pada tabel 'projects' dengan mengatur nilai kolom 'name', 'description', dan 'image' berdasarkan kondisi 'id'.
                $result = mysqli_query($koneksi,$queryUpdate); // Menjalankan query menggunakan fungsi mysqli_query dengan menggunakan koneksi '$koneksi'.
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) { //Mengunggah file gambar yang diunggah ke direktori target.
                    // var_dump( "Upload ");
                    $hasil = "The file ". htmlspecialchars( basename( $_FILES["image"]["name"])). " has been uploaded.";
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        }
        
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Projects</title>

    <!-- Custom fonts for this template-->
    <link href="http://localhost/portofolio/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="http://localhost/portofolio/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php include '../sidebar.php';?>
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
                <?php include '../content.php';?>
                <!-- Begin Page Content -->
                <div class="container-fluid">
                
                    <!-- Froms Input -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Update Projects</h6>
                        </div>
                        <div class="card-body">
                            <?php if(isset($_POST["simpan"])){ ?>
                                <?php if ($uploadOk == 1 || $uploadOk == 6) { ?>
                                    <div class="alert alert-success" role="alert"> <?php echo $hasil;?></div>
                                <?php }else{ ?>
                                    <div class="alert alert-danger" role="danger"> <?php echo $hasil;?></div>
                                <?php } ?> 
                            <?php } ?>   
                            <form action="http://localhost/portofolio/layouts/projectsUpdate.php/<?php echo $data['id'];?>" method="post" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" name="name" id="" value="<?php echo $data['name']?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea type="text" class="form-control" name="description" id=""><?php echo $data['description']?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="formFile" class="form-label">image</label>
                                    <input accept="image/*" name="image" class="form-control" type='file' id="image" />
                                    <br>
                                    <img id="blah" src="http://localhost/portofolio/img/<?php echo $data['image']?>" name="image" width='100' alt="your image" />
                                </div>
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="">
                                    <label class="form-check-label">Check me out</label>
                                </div>
                                <input type="hidden" name="id" value="<?php echo $data['id'];?>" class="btn btn-primary">
                                <input type="submit" name="simpan" class="btn btn-primary">
                                <a href="<?php $_SERVER['PHP_SELF']; ?>" class="btn btn-secondary">Refresh</a>
                            </form>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php include '../footer.php';?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <?php include '../modallogout.php';?>

    <!-- Bootstrap core JavaScript-->
    <script src="http://localhost/portofolio/vendor/jquery/jquery.min.js"></script>
    <script src="http://localhost/portofolio/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="http://localhost/portofolio/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="http://localhost/portofolio/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="http://localhost/portofolio/vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="http://localhost/portofolio/js/demo/chart-area-demo.js"></script>
    <script src="http://localhost/portofolio/js/demo/chart-pie-demo.js"></script>
    <script>
        logo.onchange = evt => {
        const [file] = logo.files
        if (file) {
            blah.src = URL.createObjectURL(file)
        }
        }
    </script>

</body>

</html>