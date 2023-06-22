<?php 
    session_start();
    if ($_SESSION['username'] == false){
        header('Location:../login.php');
    }
    require_once 'init.php';

    //$name = $_SESSION['name'];
    $uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $uri_segments = explode('/', $uri_path);

    $id = $uri_segments[3];

    $queryprojects ="SELECT * FROM projects";
    $result = mysqli_query($koneksi,$queryprojects);
    $data = mysqli_fetch_array($result, MYSQLI_ASSOC);
    var_dump($data);
    die;   
    if(isset($_POST["simpan"])) {
        $name    = $_POST["name"];
        $description = $_POST["description"];
        //$id      = $_SESSION['id'];

        $target_dir = "../img/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        // var_dump($target_file);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        $uploadHasil = 0;
        if(empty($_FILES["image"]["name"])) {
            $queryUpdate = "UPDATE projects SET name ='$name', description ='$description' WHERE id ";
            $result = mysqli_query($koneksi,$queryUpdate);
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
                $link =  str_replace('\layouts','',__dir__);
                unlink($link."/img/".$data["image"]);
                $image = basename($_FILES["image"]["name"]);
                $queryUpdate = "UPDATE projects SET name ='$name', description ='$description', image ='$image' WHERE id ";
                $result = mysqli_query($koneksi,$queryUpdate);
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

    <title>Companies</title>

    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">

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
                
                    <!-- Page Heading -->
                    <!-- <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Create Companies</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                    </div> -->

                    <!-- Content Row -->
                    <!-- <div class="row">

                    </div> -->
                    <!-- Froms Input -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Update Company</h6>
                        </div>
                        <div class="card-body">
                            <?php if(isset($_POST["simpan"])){ ?>
                                <?php if ($uploadOk == 1 || $uploadOk == 6) { ?>
                                    <div class="alert alert-success" role="alert"> <?php echo $hasil;?></div>
                                <?php }else{ ?>
                                    <div class="alert alert-danger" role="danger"> <?php echo $hasil;?></div>
                                <?php } ?> 
                            <?php } ?>   
                            <form action="http://localhost/portofolio/layouts/projects.php" method="post" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" name="name" id="" value="<?php echo $data['name']?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Address</label>
                                    <textarea type="text" class="form-control" name="description" id=""><?php echo $data['description']?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="formFile" class="form-label">image</label>
                                    <input accept="image/*" name="image" class="form-control" type='file' id="image" />
                                    <br>
                                    <img id="blah" src="../img/<?php echo $data['image']?>" name="image" width='100' alt="your image" />
                                </div>
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="">
                                    <label class="form-check-label">Check me out</label>
                                </div>
                                <input type="submit" name="simpan" class="btn btn-primary"></input>
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
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../js/demo/chart-area-demo.js"></script>
    <script src="../js/demo/chart-pie-demo.js"></script>
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