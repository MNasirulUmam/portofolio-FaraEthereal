<?php
## Author : M. Nasirul Umam
## Tanggal : 25 juni 2023
    session_start();
    if ($_SESSION['username'] == false){ // pengecekan apabila username sana dengan salah maka kembali ke menu login
        header('Location:../login.php');
    }
    require_once 'init.php'; // mengambil halaman include dari koneski
    //$name = $_SESSION['name'];
    
    $queryProjets ="SELECT * FROM projects"; // deklaras variable untuk tabel projets
    $resultProjets = mysqli_query($koneksi,$queryProjets); // perintah sql untuk mengecek sql konek ke database dengan query projets
    //$data = mysqli_fetch_array($resultAbouts);

    if (isset($_POST["hapus"])) { // pengecekan  apakah sebuah variabel post[hapus] telah tersedia (sudah didefenisikan) atau belum.
        $id = $_POST["id"]; // deklrasi variable id
        $queryhapus = "DELETE FROM projects WHERE id = '$id'"; // query untuk menghapus data berdasrakan id
        mysqli_query($koneksi,$queryhapus);
        header("Location:projects.php"); // pindah lokasi ke halaman projets.php
    }

    if(isset($_POST["simpan"])) {
        $name       = $_POST["name"];
        $description= $_POST["description"];
        //$id = $_POST["id"];
        //var_dump($_POST['image' ]);
        //$id      = $_SESSION['id'];

        $target_dir = "../img/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        // var_dump($target_file);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $image = basename($_FILES["image"]["name"]);
        // upload ok = apakah masing - masing if di jalankan atau didak ?
        // uploadHasil = mengarahkan error ke perintah yang mana
        // uploadOk = 1 berhasil
        // uploadHasil = 2 file bukan gambar
        // uploadHasil = 3 file sudah ada 
        // uploadHasil = 4 file terlalu besar
        // uploadHasil = 5 file harus jpg, jpeg, png, dan gif
        $uploadHasil = 0;
        
        $queryInsert ="INSERT INTO projects (name, description,image) values ('$name', '$description','$image')";
        $result = mysqli_query($koneksi,$queryInsert);
        // pengecekan apakah file tipe gambar kosong atau tidak 
        if(empty($_FILES["image"]["name"])) {
            // $queryUpdate = "UPDATE companies SET name ='$name', description='$description' WHERE id ";
            // $result = mysqli_query($koneksi,$queryUpdate);
            $uploadOk = 6;
            $hasil = "Pofile photo cant be empty";
        }else {
            $check = getimagesize($_FILES["image"]["tmp_name"]);
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
                // $link =  str_replace('\layouts','',__dir__);
                // unlink($link."/img/".$data["image"]);
                // var_dump($target_file);
                // $image = basename($_FILES["image"]["name"]);
                // $queryInsert ="INSERT INTO projects (name, description,image) values ('$name', '$description','$image')";
                // $result = mysqli_query($koneksi,$queryInsert);
                
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
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
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    <!-- Custom styles for this page -->
    <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

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
        
                    <!-- DataTales -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Data Projects</h6>
                            <!-- Button trigger modal -->
                        </div>  
                        <button type="button" class="btn btn-primary btn-xs ml-auto mr-5 mt-3" data-toggle="modal" data-target="#exampleModal">
                        Create Data
                        </button>
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Modal Projects</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="http://localhost/portofolio/layouts/projects.php" method="post" enctype="multipart/form-data">
                                            <div class="mb-3">
                                                <label class="form-label">Name</label>
                                                <input type="text" class="form-control" name="name" id="">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Description</label>
                                                <textarea type="text" class="form-control" name="description" id=""></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="formFile" class="form-label">Image</label>
                                                <input accept="image/*" name="image" class="form-control" type='file' id="image"/>
                                                <br>
                                                <img id="blah" src="http://localhost/portofolio/img/<?php echo $data['image']?>" name="image" width='100' alt="your image"/>
                                                <input type="hidden" class="form-control" name="id" value ="0">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="submit" class="btn btn-primary" name="simpan" value="simpan">
                                            </form>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal End-->
                        <div class="card-body">
                                <?php if(isset($_POST["simpan"])){ ?>
                                    <?php if(!empty($erros)){?>
                                        <div class="alert alert-danger" role="danger"> <?php echo $erros ?> </div>
                                    <?php } else { ?>
                                        <?php if ($uploadOk == 1 || $uploadOk == 2) { ?>
                                            <div class="alert alert-success" role="alert"> <?php echo $hasil;?></div>
                                        <?php }else{ ?>
                                            <div class="alert alert-danger" role="danger"> <?php echo $hasil;?></div>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>   
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Image</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Image</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    <?php
                                        $no=1;
                                        foreach($resultProjets as $datas){
                                            echo "<tr>";
                                                echo "<td>{$no}</td>";
                                                echo "<td>{$datas['name']}</td>";
                                                echo "<td>{$datas['description']}</td>";?>
                                                <td><img src ="http://localhost/portofolio/img/<?php echo $datas['image']?>" width = 100></td>
                                                <?php echo "<td>";?>
                                                    <a class="btn btn-info" href="http://localhost/portofolio/layouts/projectsUpdate.php/<?php echo $datas['id'];?>">Update</a>
                                                    <form onsubmit="return confirm('Apakah yaknik mau dihapus?')" method="post" action="http://localhost/portofolio/layouts/projects.php">
                                                        <input type="hidden" name="id" value="<?php echo $datas['id'];?>">
                                                        <input type="submit" name="hapus" value= "Delate" class="btn btn-danger">
                                                    </form>
                                                    </td>
                                            <?php echo "</tr>";
                                            $no++;
                                        }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
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
     <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../js/demo/datatables-demo.js"></script>
    <script>
        image.onchange = evt => {
        const [file] = image.files
        if (file) {
            blah.src = URL.createObjectURL(file)
        }
        }
    </script>

</body>

</html>