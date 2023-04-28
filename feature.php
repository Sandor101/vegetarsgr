<?php 
    session_start();

    include("connection.php");
    include("functions.php");

    // Check login
    if(!loggedIn()){
        header("Location:login.php?err=" . urlencode("Be kell jelentkeznie a megtekintéshez!!"));
        exit();
    }

    // Cart helper
  require_once("connection.php");
  $db_handle = new DBController();

  if(!empty($_GET["action"])) {
    // Cart add in the list
    switch($_GET["action"]) {
      case "add":
        if(!empty($_POST["quantity"])) {
          $productByCode = $db_handle->runQuery("SELECT * FROM menuall WHERE code='" . $_GET["code"] . "'");
          // Cart item Array
          $itemArray = array($productByCode[0]["code"]=>array('name'=>$productByCode[0]["name"], 'code'=>$productByCode[0]["code"], 'quantity'=>$_POST["quantity"], 'price'=>$productByCode[0]["price"], 'image'=>$productByCode[0]["image"]));
                
          if(!empty($_SESSION["cart_item"])) {
            if(in_array($productByCode[0]["code"],array_keys($_SESSION["cart_item"]))) {
              foreach($_SESSION["cart_item"] as $k => $v) {
                if($productByCode[0]["code"] == $k) {
                  if(empty($_SESSION["cart_item"][$k]["quantity"])) {
                    $_SESSION["cart_item"][$k]["quantity"] = 0;
                  }
                  $_SESSION["cart_item"][$k]["quantity"] += $_POST["quantity"];
                }
              }
            } else {
              $_SESSION["cart_item"] = array_merge($_SESSION["cart_item"],$itemArray);
            }
          } else {
            $_SESSION["cart_item"] = $itemArray;
          }
        }
      break;

      // Cart remove item in the list
      case "remove":
        if(!empty($_SESSION["cart_item"])) {
          foreach($_SESSION["cart_item"] as $k => $v) {
            if($_GET["code"] == $k)
              unset($_SESSION["cart_item"][$k]);				
            if(empty($_SESSION["cart_item"]))
              unset($_SESSION["cart_item"]);
          }
        }
      break;

      // Emptying the cart
      case "empty":
        unset($_SESSION["cart_item"]);
      break;	
    }
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
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
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
                <img src="img/mango.jpg" class="fw-bold text-primary m-0" width="60px" height="40px"alt="logo">
            </a>
            <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav ms-auto p-4 p-lg-0">
                    <a href="index.html" class="nav-item nav-link">Home</a>
                    <a href="about.html" class="nav-item nav-link">Rólunk</a>
                    <a href="hozzavalo.php" class="nav-item nav-link">Termékek</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle active" data-bs-toggle="dropdown">Egyéb</a>
                        <div class="dropdown-menu m-0">
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
            <h1 class="display-3 mb-3 animated slideInDown">Menük</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a class="text-body" href="index.html">Home</a></li>
                    <li class="breadcrumb-item"><a class="text-body">Pages</a></li>
                    <li class="breadcrumb-item text-dark active" aria-current="page">Menük</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->

    <div class="container-fluid bg-light bg-icon " data-wow-delay="0.1s">
        <!-- Cart Start -->
        <div class="container" id="shopping-cart">
            <a id="btnEmpty" href="feature.php?action=empty">Kosár kiürítése</a>
            <?php
            if(isset($_SESSION["cart_item"])){
                $total_quantity = 0;
                $total_price = 0;
            ?>
      
            <!-- Cart table Start-->
            <table class="tbl-cart" cellpadding="10" cellspacing="1">
                <tbody>
                    <tr>
                        <th style="text-align:left;">Név</th>
                        <th style="text-align:left;">kód</th>
                        <th style="text-align:right;" width="5%">Mennyiség</th>
                        <th style="text-align:right;" width="10%">Egység ár</th>
                        <th style="text-align:right;" width="10%">Ár</th>
                        <th style="text-align:center;" width="5%">Törlés</th>    
                    </tr>
                
                    <!-- Cart table display final list Start -->
                    <?php
                    foreach ($_SESSION["cart_item"] as $item){
                        $item_price = $item["quantity"]*$item["price"];
                    ?>
                    <tr>
                        <td><img src="<?php echo $item["image"]; ?>" class="cart-item-image" /><?php echo $item["name"]; ?></td>
                        <td><?php echo $item["code"]; ?></td>
                        <td style="text-align:right;"><?php echo $item["quantity"]; ?></td>
                        <td style="text-align:right;"><?php echo $item["price"]." Ft"; ?></td>
                        <td style="text-align:right;"><?php echo number_format($item_price,2)." Ft"; ?></td>
                        <td style="text-align:center;"><a href="feature.php?action=remove&code=<?php echo $item["code"]; ?>" class="btnRemoveAction"><img src="img/icon-delete.png" alt="Remove Item" /></a></td>
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
                            <td align="right"><?php echo $total_quantity; ?></td>
                            <td align="right" colspan="2"><strong><?php echo number_format($total_price, 2)." Ft"; ?></strong></td>
                            <td><div class="cart-action"><input type="submit" value="Fizetés" class="btnAddAction" /></div></td>    
                        </tr>
                    </form>          
                </tbody>
            </table>
            <!-- Cart table End-->
                    
            <?php
            } else {
            ?>
            <div class="no-records">Üres a kosár</div>
            <?php 
            }
            ?>
        </div>

        <!-- Product Start -->
        <div class="container">
            <div class="txt-heading">Menü</div>
            
            <!-- Search in items -->
            <input id="txtSearch" type="text" name="search" placeholder="Kereső">
    
            <?php
                $product_array = $db_handle->runQuery("SELECT * FROM menuall ORDER BY id ASC");
      
                if (!empty($product_array)) { 
                foreach($product_array as $key=>$value){
            ?>
            
            <div class="product-item col-sm-4 " id="items">
                <form method="post" action="feature.php?action=add&code=<?php echo $product_array[$key]["code"]; ?>">
                <div class="prduct ">
                    <div class="product-image" id="p-image"><img src="<?php echo $product_array[$key]["image"]; ?>"></div>
                    <div class="product-tile-footer" id="p-tile-footer">
                        <div class="product-title" id="p-title"><?php echo $product_array[$key]["name"]; ?></div>
                        <details>
                            <summary><p>Hozzávalók:</p></summary>
                            <p><?php echo '<pre>'; echo $product_array[$key]["hozza"]; echo '</pre>'; ?></p>
                        </details>
                        <details>
                            <summary><p>Elkészítés:</p></summary>
                            <p><?php echo '<pre>'; echo $product_array[$key]["elkesz"]; echo '</pre>'; ?></p>
                        </details>
                        <details>
                            <summary><p>Tápértékek:</p></summary>
                            <p><?php echo '<pre>'; echo $product_array[$key]["tapert"]; echo '</pre>'; ?></p>
                        </details>                      
                        <div class="product-price" id="p-priceg"><?php echo $product_array[$key]["price"]." Ft"; ?></div>
                        <div class="cart-action">
                            <input type="text" class="product-quantity" name="quantity" value="1" size="2" />
                            <input type="submit" value="Kosárba" class="btnAddAction"/>
                        </div>
                    </div>                     

                </div>
                </form>    
            </div>  
            <?php
                }
            }
            ?>
        </div>       
        <!-- Product End -->
    </div>
    <!-- Cart End -->


    <!-- Footer Start -->
    <div class="container-fluid bg-dark footer pt-5 wow fadeIn spacing" data-wow-delay="0.1s" >
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <p> Hétfő:            Zárva<br>
                        Kedd:     15:00 - 23:00<br>
                        Szerda:   06:00 - 22:00<br>
                        Csütörtök:        Zárva<br>
                        Péntek:   14:00 - 23:00<br>
                        Szombat:  01:00 - 23:00<br>
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

    <!-- Back to Top -->
    <a href="feature.html" class="btn btn-lg btn-primary btn-lg-square rounded-circle back-to-top"><i class="bi bi-arrow-up"></i></a>

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