<?php 
    ## Author : M. Nasirul Umam
    ## Tanggal : 25 juli 2023
    session_start();
    if ($_SESSION['username'] == false){ // pengecekan apabila username sana dengan salah maka kembali ke menu login
        header('Location:../login.php');
    }
    require_once 'init.php'; // mengambil halaman include dari koneksi

    //$name = $_SESSION['name'];
    
    $queryAbouts ="SELECT *,contacts.id as id_contacts FROM contacts join companies on contacts.company_id = companies.id order by contacts.id asc";
    $resultAbouts = mysqli_query($koneksi,$queryAbouts);
    $data = mysqli_fetch_array($resultAbouts);
    // var_dump($data);
    // die;   
    if(isset($_POST["simpan"])) { 
        $name_contacts= $_POST["name_contacts"];
        $email        = $_POST["email"];
        $message      = $_POST["message"];
        $address      = $_POST["address"];
        $sosial       = $_POST["sosial"];
        $phone        = $_POST["phone"];
        $id_contacts  = $_POST["id_contacts"];
        $id           = $_POST["id"];
        if(empty($address)) {
            $erros = "data harus di isi";
            // var_dump($erros);
        }else {
            if(empty($id)){
                $insert = "INSERT INTO companies (address, sosial, phone) VALUES ('$address', '$sosial', '$phone')";
                $query = mysqli_query($koneksi,$insert);
                $company_id = "select max(id) from companies";
                $query1 = mysqli_query($koneksi,$company_id)->fetch_array(MYSQLI_NUM);
                $inser1 = "INSERT INTO contacts(company_id,name_contacts,email,message) VALUES('$query1[0]','$name_contacts','$email', '$message')";
                $query2 = mysqli_query($koneksi,$inser1);
                if($query2){
                    $uploadOk = 1;
                    $hasil = "Abaouts successfully uploaded";
                }else{
                    $uploadOk = 0;
                    $hasil = "Abaouts fail uploaded";   
                }
            }else{
                $queryUpdate01 = "UPDATE companies SET address ='$address',sosial ='$sosial', phone ='$phone' WHERE id = '$id'";
                $query = mysqli_query($koneksi,$queryUpdate01);
                $queryUpdate02 = "UPDATE contacts SET name_contacts ='$name_contacts',email ='$email',message ='$message' WHERE id = '$id_contacts'";
                $query2 = mysqli_query($koneksi,$queryUpdate02);
                if($query2){
                    $uploadOk = 2;
                    $hasil = "Abaouts successfully uploaded";
                }else{
                    $uploadOk = 0;
                    $hasil = "Abaouts fail uploaded";   
                }
            }
        }
        // var_dump($title);
        //$id      = $_SESSION['id'];

        
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

    <title>Contacts</title>

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
                            <h6 class="m-0 font-weight-bold text-primary">Contacts</h6>
                        </div>
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
                            <form action="http://localhost/portofolio/layouts/contacts.php" method="post">
                                <div class="mb-3">
                                    <label class="form-label">Name Contacts</label>
                                    <input type="text" class="form-control" name="name_contacts" id="" value="<?php if(!empty($data['name_contacts'])) {echo $data['name_contacts'];}?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="text" class="form-control" name="email" id="" value="<?php if(!empty($data['email'])) {echo $data['email'];}?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Message</label>
                                    <input type="text" class="form-control" name="message" id="" value="<?php if(!empty($data['message'])) {echo $data['message'];}?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Address`</label>
                                    <textarea type="text" class="form-control" name="address" id=""><?php if(!empty($data['address'])) {echo $data['address'];}?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Sosial</label>
                                    <input type="text" class="form-control" name="sosial" id="" value="<?php if(!empty($data['sosial'])) {echo $data['sosial'];}?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Phone</label>
                                    <input type="text" class="form-control" name="phone" id="" value="<?php if(!empty($data['phone'])) {echo $data['phone'];}?>">
                                </div>
                                <input type="hidden" name="id" value="<?php if(!empty($data['id'])) {echo $data['id'];}?>">
                                <input type="hidden" name="id_contacts" value="<?php if(!empty($data['id_contacts'])) {echo $data['id_contacts'];}?>">
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

</body>

</html>