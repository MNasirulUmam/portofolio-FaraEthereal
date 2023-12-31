<?php
## Author : M. Nasirul Umam
## Tanggal : 25 juli 2023 
    include "Koneksi.php";

    $queryCompanies ="SELECT * FROM companies";
    $resultCompanies = mysqli_query($koneksi,$queryCompanies);
    $dataCompanies = mysqli_fetch_array($resultCompanies);
    
    $queryAbouts ="SELECT * FROM abouts";
    $resultAbouts = mysqli_query($koneksi,$queryAbouts);
    $dataAbouts = mysqli_fetch_array($resultAbouts);

    $queryProjets ="SELECT * FROM projects";
    $dataProjets = mysqli_query($koneksi,$queryProjets);

    $queryContacts ="SELECT *,contacts.id as id_contacts FROM contacts join companies on contacts.company_id = companies.id order by contacts.id asc";
    $resultContacts = mysqli_query($koneksi,$queryContacts);
    $dataContacts = mysqli_fetch_array($resultContacts);
    
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fara Ethereal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <!-- Bootsrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- Bootstrap end -->
    <!-- My Css -->
    <link rel="stylesheet" href="css/style.css">
  </head>
  <body id="home">
    <!-- Navbar -->
    <nav class="navbar fixed-top navbar-expand-lg navbar-dark shadow" style ="background-color: #E9967A">
      <div class="container">
        <a class="navbar-brand" href="index.php"><?php echo $dataCompanies['name']?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="#home">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#about">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#projects">Projects</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#contact">Contact Us</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- Navbar end -->
    <!-- Jumbotron -->
    <section class="jumbotron text-center">
      <img src="img/<?php echo $dataCompanies['logo']?>" alt="Fara Ethereal" width="200">
      <h1 class="display-4"><?php echo $dataCompanies['name']?></h1>
      <p class="lead"><?php echo $dataCompanies['tagline']?></p>
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#ffff" fill-opacity="1" d="M0,128L48,160C96,192,192,256,288,250.7C384,245,480,171,576,122.7C672,75,768,53,864,85.3C960,117,1056,203,1152,240C1248,277,1344,267,1392,261.3L1440,256L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>      
    </section>
    <!-- Jumbotron end -->
    <!-- Abouts -->
    <section id ="about">
      <div class="container text-center mb-3">
        <div class="row mt-5 mb-2">
          <h2>Abouts</h2>
        </div>
        <div class="row justify-content-center fs-5">
          <div class="col-md-10">
            <h3><?php echo $dataAbouts['title']?></h3>
            <?php echo $dataAbouts['description']?>
          </div>
          <!-- <div class="col-md-4">
              Lorem ipsum dolor sit amet consectetur, adipisicing elit. Similique veritatis dolorem animi itaque, 
              porro reiciendis deserunt ullam atque veniam impedit cupiditate accusantium numquam suscipit mollitia placeat voluptate, officia eaque assumenda.
          </div> -->
        </div>
      </div>
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#ffe4c4" fill-opacity="1" d="M0,128L48,160C96,192,192,256,288,250.7C384,245,480,171,576,122.7C672,75,768,53,864,85.3C960,117,1056,203,1152,240C1248,277,1344,267,1392,261.3L1440,256L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>
    </section>
    <!-- Abouts end -->

    <!-- Ny projects -->
    <section id="projects">
      <div class="container mb-2" style="background-color: #ffe4c4">
        <div class="row text-center mb-3">
          <div class="col">
            <h2>Projects</h2>
          </div>
        </div>
       <div class="row justify-content-center">
          <?php foreach ($dataProjets as $datas) { ;?>
              <div class="col-md-4 mb-4">
                  <div class="card">
                      <img src="img/<?php echo $datas['image']?>" class="card-img-top" alt="SC4a">
                      <div class="card-body">
                        <h2><?php echo $datas['name']?></h2>
                        <p class="card-text"><?php echo $datas['description']?></p>
                      </div>
                  </div>
              </div>
          <?php } ?>
        </div>
      </div>
    </section>
    <!-- Ny projects end -->

    <!-- Contact us -->
    <section id="contact">
      <div class="container">
        <div class="row text-center mb-3">
          <div class="col">
            <h2>Contact Us</h2>
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-md-6 mb-3">
            <div class="info">
              <div class="info-item d-flex">
                <i class="bi bi-geo-alt-fill"></i>
                <div>
                  <h4>Lokasi:</h4>
                  <p><?php echo $dataCompanies['address']?></p>
                </div>
              </div>
              <div class="info-item d-flex">
                <i class="bi bi-instagram"></i>
                <div>
                  <h4>Instagram:</h4>
                  <p><a href="https://www.instagram.com/faraethereal/"><?php echo $dataCompanies['sosial']?></a></p>
                </div>
              </div>
              <div class="info-item d-flex">
                <i class="bi bi-phone"></i>
                <div>
                  <h4>Phone</h4>
                  <p><?php echo $dataCompanies['phone']?></p>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6 mb-3">
          <form>
            <div class="mb-3">
              <label for="name" class="form-label">Name</label>
              <input type="text" class="form-control" id="name" aria-describedby="name">
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" id="email" aria-describedby="email">
            </div>
            <div class="mb-3">
              <label for="message" class="form-label">Message</label>
              <textarea class="form-control" id="message" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
          </div>
        </div>
      </div>
    </section>
    <!-- Contact us end -->

    <!-- Footer -->
    <footer class ="text-center text-white pb-3" style ="background-color: #E9967A">
      <div class="container text-center">
        <div class="row">
          <div class="col-sm-12">
            <p>&copy; copyright <?php echo date("Y");?> | built with <i class="bi bi-suit-heart-fill text-danger"></i> by. <a href="https://github.com/MNasirulUmam">M. Nasirul Umam</a>.</p>
          </div>
        </div>
    </footer>
    <!-- Footer us -->
  </body>
</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
<script type="text/JavaScript"> var theDate=new Date() document.write(theDate.getFullYear()) </script>
