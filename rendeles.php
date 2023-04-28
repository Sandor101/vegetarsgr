<?php
    session_start();

    include("connection.php");
    include("functions.php");

    // Check login
    if(!loggedIn()){
        header("Location:rendeles.php?err=" . urlencode("Be kell jelentkeznie a megtekintéshez!!"));
        exit();
    }

    
?>

<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="utf-8">
    <title>Vegetár - Organic Food Website</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="vegetarsgr, vega" name="keywords">
    <meta content="Preparing and ordering vegetarian meals" name="description">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Lora:wght@600;700&display=swap"
        rel="stylesheet">

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

    <!-- Unique Stylesheet -->
    <link href="css/buy.css" rel="stylesheet">
</head>

<body>
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
                    <a class="btn-sm-square bg-white rounded-circle ms-3" href="login.php">
                        <small class="fa fa-user text-body"></small>
                    </a>
                    <a class="btn-sm-square bg-white rounded-circle ms-3" href="rendeles.php">
                        <small class="fa fa-shopping-bag text-body"></small>
                    </a>
                    <a class="btn-sm-square bg-white rounded-circle ms-3" href="logout.php">
                        <small class="fa fa-sign-out-alt"></small>
                    </a>
                </div>
            </div>
        </nav>
    </div>
    <!-- Navbar End -->

    <!-- Page Header Start -->
    <div class="container-fluid page-header wow fadeIn" data-wow-delay="0.1s">
        <div class="container">
            <h1 class="display-3 mb-3 animated slideInDown">Rendelés</h1>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Navbar Order Start -->
    <div class="container-fluid bg-light bg-icon container2">
        <div class="py-5 text-center">
            <h2>Fizetés véglegesítés</h2>
        </div>
        <!-- Cart Start -->
    
        <div class="container" id="shopping-cart">
            <!-- Emptying the Cart -->
            <a id="btnEmpty" href="hozzavalo.php?action=empty">Kosár kiürítése</a>
            <?php
                if(isset($_SESSION["cart_item"])){
                    $total_quantity = 0;
                    $total_price = 0;
            ?>
            
            <!-- Cart table Start -->
            <table class="tbl-cart" cellpadding="10" cellspacing="1">
                <tbody>
                    <tr>
                        <th style="text-align:left;">Név</th>
                        <th style="text-align:left;">kód</th>
                        <th style="text-align:right;" width="5%">Mennyiség</th>
                        <th style="text-align:right;" width="10%">Egység ár</th>
                        <th style="text-align:right;" width="10%">Ár</th>
                    </tr>
                    <!-- Cart table display final list Start -->
                    <?php		
                        foreach ($_SESSION["cart_item"] as $item){
                            $item_price = $item["quantity"]*$item["price"];
                    ?>
                    <tr>
                        <td><img src="<?php echo $item["image"]; ?>" class="cart-item-image"/>
                        <?php echo $item["name"]; ?></td>
                        <td><?php echo $item["code"]; ?></td>
                        <td style="text-align:right;"><?php echo $item["quantity"]; ?></td>
                        <td style="text-align:right;"><?php echo $item["price"]." Ft"; ?></td>
                        <td style="text-align:center;"><?php echo number_format($item_price,2)." Ft"; ?></td>
                    </tr>
                    <?php
                        $total_quantity += $item["quantity"];
                        $total_price += ($item["price"]*$item["quantity"]);
                        }
                    ?>

                    <!-- Cart Total price -->
                    <form method="post" action="rendeles.php">
                        <tr>
                            <td colspan="2" align="right">Végösszeg:</td>
                            <td align="right"></td>
                            <td align="right" colspan="2"><strong><?php echo number_format($total_price, 2)." Ft"; ?></strong></td>                                                          
                        </tr>
                    </form>                        
                    <!-- Cart table display final list End -->      
                                         
                </tbody>
            </table>
            <!-- Cart table End -->
            <?php
                } else {
            ?>
            <div class="no-records">Üres a kosár</div>
            <?php 
                }
            ?>

            <!-- Purchase total Start -->
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted">Kosár tartalma: 
                    <?php
                    
                        echo $total_quantity;
                    
                    ?>
                </span>
            </h4>
            <!-- Purchase total End -->
        </div>           
    
        <!-- Cart End -->


        <!-- Order personal Data Start -->
        <div class="text-center col-md-8 order-md-1 container py-3 mb-3" style="width: 100%;">
            <h4 class="mb-3 py-5 text-center">Szállítási cím</h4>
            <form class="needs-validation" novalidate>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="firstName">Vezetéknév</label>
                        <input type="text" class="form-control" id="firstName" placeholder="" value="" required>
                        <div class="invalid-feedback">Érvényes keresztnév szükséges.</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="lastName">Keresztnév</label>
                        <input type="text" class="form-control" id="lastName" placeholder="" value="" required>
                        <div class="invalid-feedback">Érvényes vezetéknév szükséges.</div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="username">Felhasználónév</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="username" placeholder="Username" required>
                        <div class="invalid-feedback" style="width: 100%;">
                            Felhasználónév megadása kötelező.
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="email">Email<span class="text-muted">(Választható)</span></label>
                    <input type="email" class="form-control" id="email" placeholder="you@example.com">
                    <div class="invalid-feedback">
                        Kérjük, adjon meg egy érvényes e-mail címet a szállítási frissítésekhez.
                    </div>
                </div>

                <div class="mb-3">
                    <label for="address">Cím</label>
                    <input type="text" class="form-control" id="address" placeholder="1234 Main St" required>
                    <div class="invalid-feedback">
                        Kérjük, adja meg szállítási címét.
                    </div>
                </div>

                <div class="mb-3">
                    <label for="address2">Cím 2 <span class="text-muted">(Választható)</span></label>
                    <input type="text" class="form-control" id="address2" placeholder="Apartment or suite">
                </div>

                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="country">Ország</label>
                        <select class="custom-select d-block w-100" id="country" required>
                            <option value="">Ország...</option>
                            <option>Magyar</option>
                            <option>Olasz</option>
                            <option>Litvánia</option>
                            <option>Szlovákia</option>
                        </select>
                        <div class="invalid-feedback">
                            Kérjük, válasszon érvényes országot.
                        </div>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="zip">Irányítószám</label>
                        <input max=999 type="text" class="form-control" id="zip" placeholder="" required>
                        <div class="invalid-feedback">
                            Irányítószám szükséges.
                        </div>
                    </div>
                </div>

                <hr class="mb-4">

                <h4 class="mb-3">Fizetés</h4>
                <div class="d-block my-3">
                    <div class="custom-control custom-radio">
                        <input id="credit" onclick="check()" value="kartya" name="paymentMethod" type="radio" class="custom-control-input" checked required>
                        <label class="custom-control-label" for="credit">Hitelkártya</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input id="debit" onclick="javascript:check();" name="paymentMethod" type="radio" class="custom-control-input" required>
                        <label class="custom-control-label" for="debit">Utánvétel</label>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label id="cc-name-text2" for="cc-name">Kártya tulajdonosa</label>
                        <input onclick="check()" type="text" class="form-control" id="cc-name" placeholder="" required>
                        <small id="cc-name-text" class="text-muted">Kártyán feltüntetett teljes név</small>
                        <div class="invalid-feedback">
                            Kártyán szereplő név kötelező
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label id="cc-number-text" for="cc-number">Kártya szám</label>
                        <input onclick="check()" type="text" class="form-control" id="cc-number" placeholder="" required>
                        <div class="invalid-feedback">
                            Hitelkártya száma kötelező
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label id="cc-expiration-text" for="cc-expiration">Lejárata</label>
                        <input onclick="check()" min=2023 max=2100 type="number" class="form-control" id="cc-expiration" placeholder="" required>
                        <div class="invalid-feedback">
                            Lejárati dátum szükséges
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label id="cc-cvv-text" for="cc-cvv">CVC</label>
                        <input onclick="check()" min=100 max=999 type="number" class="form-control" id="cc-cvv" placeholder="" required>
                        <div class="invalid-feedback">
                            Biztonsági kód szükséges
                        </div>
                    </div>
                </div>

                <hr class="mb-4">
                <button name = "vegleg" class="btn btn-primary btn-lg btn-block" type="submit">Véglegesít</button>
            </form>
        </div>
        <!-- Order personal Data End -->
    </div>
    <!-- Navbar Order End -->

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
                        <input class="form-control bg-transparent w-100 py-3 ps-4 pe-5" type="text" placeholder="Email">
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

    <!-- Back to Top -->
    <a href="rendeles.php" class="btn btn-lg btn-primary btn-lg-square rounded-circle back-to-top">
        <i class="bi bi-arrow-up"></i>
    </a>

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