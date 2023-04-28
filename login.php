<?php
    session_start();
	include("connection.php");
	include("functions.php");
	
    if(loggedIn()){
        header("Location:contact.php");
        exit();
    }
    
    if(isset($_POST['login'])){
        $email = mysqli_real_escape_string($conn , $_POST['email']);
        $password = mysqli_real_escape_string($conn , $_POST['password']);
        
        $query = "select * from user where email='$email' and password='$password'";
        
        $result = $conn->query($query);
        
        if($row = $result->fetch_assoc()){
            if($row['status'] == 1){
                $_SESSION['user_email'] = $email;
                if(isset($_POST['remember_me'])){
                    setcookie("user_email" , $email , time()+60*5);
                }
                header("Location:contact.php");
                exit();
            }else {
                header("Location:login.php?err=" . urlencode("A felhasználói fiókja nincs aktiválva!"));
                exit();
            }
        }else {
            header("Location:login.php?err=" . urlencode("Hibás e-mail vagy jelszó!"));
            exit();
        }
    } 
?>

<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <title>Vegetár - Organic Food Website</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="vegetarsgr, vega" name="keywords">
    <meta content="Preparing and ordering vegetarian meals" name="description">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body >
    <!-- Spinner Start -->
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" role="status"></div>
    </div>
    <!-- Spinner End -->

    <!-- Navbar Start -->
    <div class="container-fluid fixed-top px-0 wow fadeIn" data-wow-delay="0.1s">
        <div class="top-bar row gx-0 align-items-center d-none d-lg-flex">
            <div class="col-lg-6 px-5 text-start">
                <small><i class="fa fa-map-marker-alt me-2"></i>Budapest Municipality Jonavos 173</small>
                <small class="ms-4"><i class="fa fa-envelope me-2"></i>vegetarsgr@gmail.com</small>
            </div>
            <div class="col-lg-6 px-5 text-end">
                <small>Follow us:</small>
                <a class="text-body ms-3" href=""><i class="fab fa-facebook-f"></i></a>
                <a class="text-body ms-3" href=""><i class="fab fa-twitter"></i></a>
                <a class="text-body ms-3" href=""><i class="fab fa-linkedin-in"></i></a>
                <a class="text-body ms-3" href=""><i class="fab fa-instagram"></i></a>
            </div>
        </div>

        <nav class="navbar navbar-expand-lg navbar-light py-lg-0 px-lg-5 wow fadeIn" data-wow-delay="0.1s">
            <a href="index.html" class="navbar-brand ms-4 ms-lg-0">
                <img src="img/mango.jpg" class="fw-bold text-primary m-0" width="60px" height="40px" alt="logo">
            </a>
            <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse"
                data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav ms-auto p-4 p-lg-0">
                    <a href="index.html" class="nav-item nav-link active">Home</a>
                    <a href="about.html" class="nav-item nav-link">Rólunk</a>
                    <a href="hozzavalo.php" class="nav-item nav-link">Termékek</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Egyéb</a>
                        <div class="dropdown-menu m-0">
                            <a href="feature.php" class="dropdown-item">Menük</a>
                            <a href="testimonial.html" class="dropdown-item">Értékelés</a>
                        </div>
                    </div>
                    <a href="contact.php" class="nav-item nav-link">Kapcsolat</a>
                </div>
                <div class="d-none d-lg-flex ms-2">
                    <a class="btn-sm-square bg-white rounded-circle ms-3" href="rendeles.php">
                        <small class="fa fa-shopping-bag text-body"></small>
                    </a>
                </div>
            </div>
        </nav>
    </div>
    <!-- Navbar End -->

    <!-- Page Header -->
    <div class="container-fluid page-header wow fadeIn" data-wow-delay="0.1s"></div>
        
    <div class="container-fluid bg-light bg-icon">
        <div class="container">
            <h1 class="display-3 mb-3 animated slideInDown">Bejelentkezés Vegetar</h1>
            <h4><a href="index.html">Kezdő oldal</a></h4>          
        </div>
        <!--------log in form------>
        <div class="container">
            <form action="login.php" method="POST">
                
                <?php if(isset($_GET['success'])) { ?>        
                <div class="alert alert-success"><?php echo $_GET['success']; ?></div>        
                <?php } ?>
    
                <?php if(isset($_GET['err'])) { ?>
                <div class="alert alert-danger"><?php echo $_GET['err']; ?></div>        
                <?php } ?> 
                <hr>

                <div class="form-group">
                    <label for="exampleInputEmail1">Email-cím</label>
                    <input type="email" name="email" class="form-control" placeholder="Email">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Jelszó</label>
                    <input id="text" type="password" name="password" class="form-control" placeholder="Jelszó">
                </div>
                
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="remember_me">Emlékezz rám            
                    </label>
                </div>
                <button type="submit" name="login" class="btn btn-default">Bejelentkezés</button>
                
                <!-- User Remember password form link -->
                <p>Elfelejtett jelszó<a href="reset_password.php"> Jelszó emlékeztető</a></p>
                
                <!-- User registration form link -->
                <p>Nincs fiókod?<a href="signup.php"> Fiók létrehozása</a></p>
            </form>
        </div>
    </div>

    <!-- Footer Start -->
    <div class="container-fluid bg-dark footer pt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <p> Hétfő: Zárva<br>
                        Kedd: 15:00 - 23:00<br>
                        Szerda: 06:00 - 22:00<br>
                        Csütörtök: Zárva<br>
                        Péntek: 14:00 - 23:00<br>
                        Szombat: 01:00 - 23:00<br>
                        Vasárnap: 01:00 - 23:00</p>
                    <div class="d-flex pt-2">
                        <a class="btn btn-square btn-outline-light rounded-circle me-1" href=""><i
                                class="fab fa-twitter"></i></a>
                        <a class="btn btn-square btn-outline-light rounded-circle me-1" href=""><i
                                class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-square btn-outline-light rounded-circle me-1" href=""><i
                                class="fab fa-youtube"></i></a>
                        <a class="btn btn-square btn-outline-light rounded-circle me-0" href=""><i
                                class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4">Elérhetőségeink</h4>
                    <p><i class="fa fa-map-marker-alt me-3"></i>Budapest Municipality Jonavos 173</p>
                    <p><i class="fa fa-phone-alt me-3"></i>+361237317</p>
                    <p><i class="fa fa-envelope me-3"></i>vegetarsgr@gmail.com</p>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4">Gyors linkek</h4>
                    <a class="btn btn-link" href="about.html">Rólunk</a>
                    <a class="btn btn-link" href="contact.php">Kapcsolat</a>
                    <a class="btn btn-link" href="altalanos_jog.html">Általános szerződési feltételek</a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4">Hírlevél</h4>
                    <div class="position-relative mx-auto" style="max-width: 400px;">
                        <input class="form-control bg-transparent w-100 py-3 ps-4 pe-5" type="text"
                            placeholder="Email">
                        <a href="signup.php"
                            class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">Regisztráció</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid copyright">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        &copy; <a href="www.vegetarsgr.hu">Webhelyünk</a>, Minden jog fentartva 2023.
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>
</html>