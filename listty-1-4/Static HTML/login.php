<?php
session_start();

$bdd = new PDO('mysql:host=127.0.0.1;dbname=smartrepair', 'root', '');

if(isset($_POST['formconnexion'])) {
   $mailconnect = htmlspecialchars($_POST['mailconnect']);
   $mdpconnect = sha1($_POST['mdpconnect']);
   if(!empty($mailconnect) AND !empty($mdpconnect)) {
      $requser = $bdd->prepare("SELECT * FROM utilisateur WHERE mail = ? AND mot_de_passe = ?");
      $requser->execute(array($mailconnect, $mdpconnect));
      $userexist = $requser->rowCount();
      if($userexist == 1) {
         $userinfo = $requser->fetch();
         $_SESSION['id'] = $userinfo['id'];
         $_SESSION['pseudo'] = $userinfo['pseudo'];
         $_SESSION['mail'] = $userinfo['mail'];
         header("Location: profile.php?id=".$_SESSION['id']);
      } else {
         $erreur = "Mauvais mail ou mot de passe !";
      }
   } else {
      $erreur = "Tous les champs doivent être complétés !";
   }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>

  <!-- SITE TITTLE -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Member Login - Listty</title>

  <!-- PLUGINS CSS STYLE -->
  <link href="assets/plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet">
  <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="assets/plugins/listtyicons/style.css" rel="stylesheet">
  <link href="assets/plugins/bootstrapthumbnail/bootstrap-thumbnail.css" rel="stylesheet">
  <link href="assets/plugins/datepicker/datepicker.min.css" rel="stylesheet">
  <link href="assets/plugins/selectbox/select_option1.css" rel="stylesheet">
  <link href="assets/plugins/owl-carousel/owl.carousel.min.css" rel="stylesheet">
  <link href="assets/plugins/fancybox/jquery.fancybox.min.css" rel="stylesheet"/>
  <link href="assets/plugins/isotope/isotope.min.css" rel="stylesheet">
  <link href="assets/plugins/map/css/map.css" rel="stylesheet">
  <link href="assets/plugins/rateyo/jquery.rateyo.min.css" rel="stylesheet">
  <link href="assets/plugins/animate/animate.css" rel="stylesheet">
  <!-- <link href="assets/plugins/bootstrap-rtl/bootstrap-rtl.min.css" rel="stylesheet"> -->
  <link href="" rel="stylesheet" id="bootstrap-rtl">


  <!-- GOOGLE FONT -->
  <link href="https://fonts.googleapis.com/css?family=Muli:200,300,400,600,700,800,900" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Herr+Von+Muellerhoff" rel="stylesheet">

  <!-- CUSTOM CSS -->
  <link href="assets/css/app.css" rel="stylesheet">

  <link rel="stylesheet" href="assets/css/default.css" id="option_color">

  <!-- FAVICON -->
  <link href="assets/img/favicon.png" rel="shortcut icon">

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

</head>

<body id="body" class="body-wrapper boxed-menu " >

  <div class="main-wrapper">
    <!-- HEADER -->
    <header id="pageTop" class="header">

      <!-- TOP INFO BAR -->

      <div class="nav-wrapper navbarWhite">
        <!-- NAVBAR -->
        <nav id="menuBar" class="navbar navbar-default lightHeader animated " role="navigation">
          <div class="container">

            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="index.html">
                <svg class="logo-svg" version="1" xmlns="http://www.w3.org/2000/svg" width="140" height="44">
                  <path class="path-1" fill="" d="M0 44V0h139.813v44H0zM137.346 2.467H2.467v39.065h134.879V2.467z"/>
                  <path class="path-1" fill="" d="M120.927 22.389v11.095h-4.566V22.389a371.288 371.288 0 0 0-2.086-2.888 347.047 347.047 0 0 1-2.2-3.053 386.86 386.86 0 0 0-2.201-3.053c-.7-.959-1.395-1.922-2.086-2.888h5.617l5.255 7.287 5.222-7.287h5.649c.002 0-8.604 11.882-8.604 11.882zM98.034 33.484h-4.565V15.069h-6.372v-4.562h17.244v4.562h-6.306v18.415zm-21.908 0H71.56V15.069h-6.372v-4.562h17.244v4.562h-6.306v18.415zm-17.425-1.789c-.69.623-1.511 1.116-2.463 1.477-.953.361-1.987.542-3.104.542-1.007 0-1.982-.143-2.923-.427a10.814 10.814 0 0 1-2.661-1.214h.033a9.928 9.928 0 0 1-1.577-1.215 18.73 18.73 0 0 1-.953-.952l3.416-3.151c.153.197.399.432.739.706.339.274.728.537 1.166.788.44.253.902.467 1.38.64.481.175.941.262 1.379.262.372 0 .744-.044 1.117-.131.359-.082.703-.22 1.018-.41.305-.185.564-.437.755-.739.197-.306.296-.689.296-1.149 0-.175-.06-.366-.181-.574-.12-.208-.329-.432-.624-.673-.296-.241-.706-.498-1.232-.771a20.567 20.567 0 0 0-1.971-.87 25.42 25.42 0 0 1-2.562-1.132 8.896 8.896 0 0 1-2.053-1.428 5.903 5.903 0 0 1-1.347-1.871c-.317-.7-.476-1.51-.476-2.429 0-.94.175-1.822.526-2.642a6.21 6.21 0 0 1 1.494-2.133c.646-.602 1.423-1.072 2.332-1.412.908-.339 1.911-.509 3.006-.509.591 0 1.22.077 1.889.23.668.153 1.319.35 1.954.591a12.95 12.95 0 0 1 1.79.837c.558.317 1.023.64 1.396.968l-2.825 3.545a15.71 15.71 0 0 0-1.281-.788 10.316 10.316 0 0 0-1.281-.558 4.311 4.311 0 0 0-1.478-.263c-.919 0-1.637.181-2.151.542-.515.361-.772.881-.772 1.559 0 .307.093.586.279.837.186.252.438.482.756.689.348.225.717.417 1.1.574.416.176.854.34 1.314.492 1.314.504 2.42 1.013 3.318 1.526.898.514 1.62 1.062 2.168 1.642s.936 1.204 1.166 1.871c.23.668.345 1.395.345 2.183 0 .963-.197 1.871-.591 2.724a6.803 6.803 0 0 1-1.626 2.216zM34.839 10.507h4.532v22.977h-4.532V10.507zm-20.036 0h4.566v18.415h9.263v4.563H14.803V10.507z"/>
                </svg>
              </a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li class=" dropdown singleDrop">
                      <a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">home <i class="fa fa-angle-down" aria-hidden="true"></i></a>
                    <ul class="dropdown-menu ">
                      <li><a class="" href="index.html">Home Map</a></li>
                      <li><a class="" href="index-2.html">Home Travel</a></li>
                      <li><a class="" href="index-3.html">Home Automobile</a></li>
                      <li><a class="" href="index-4.html">Home City</a></li>
                    </ul>
                  </li>
                  <li class=" dropdown megaDropMenu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Listing <i class="fa fa-angle-down" aria-hidden="true"></i></a>
                    <ul class="row dropdown-menu">
                      <li class="col-sm-4 col-xs-12">
                        <ul class="list-unstyled">
                          <li class="list-item-heading">Grid Layout</li>
                          <li><a href="listing-grid-right-sidebar.html">Right Sidebar</a></li>
                          <li><a href="listing-grid-left-sidebar.html">Left Sidebar</a></li>
                          <li><a href="listing-grid-fullwidth.html">Fullwidth</a></li>
                        </ul>
                        <ul class="list-unstyled">
                          <li class="list-item-heading">List Layout</li>
                          <li><a href="listing-list-right-sidebar.html">Right Sidebar</a></li>
                          <li><a href="listing-list-left-sidebar.html">left Sidebar</a></li>
                          <li><a href="listing-list-fullwidth.html">Fullwidth</a></li>
                        </ul>
                      </li>
                      <li class="col-sm-4 col-xs-12">
                        <ul class="list-unstyled">
                          <li class="list-item-heading">Half Screen Map</li>
                          <li><a href="listings-half-screen-map-list.html">List Layout</a></li>
                          <li><a href="listings-half-screen-map-grid.html">Grid Layout</a></li>
                        </ul>
                        <ul class="list-unstyled">
                          <li class="list-item-heading">Single listing</li>
                          <li><a href="listing-details-right.html">Right Sidebar</a></li>
                          <li><a href="listing-details-left.html">left Sidebar</a></li>
                          <li><a href="listing-details-full.html">Fullwidth</a></li>
                        </ul>
                      </li>
                      <li class="col-sm-4 col-xs-12">
                        <ul class="list-unstyled">
                          <li class="mega-img">
                            <a href=""><img src="assets/img/works/works-big-3.png" alt="Image"></a>
                          </li>
                        </ul>
                      </li>
                    </ul>
                  </li>
                  <li class="active dropdown singleDrop">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">pages <i class="fa fa-angle-down" aria-hidden="true"></i></a>
                    <ul class="dropdown-menu ">
                      <li><a href="contact-us.html">Contact Us</a></li>
                      <li><a href="terms-of-services.html">Terms and Conditions</a></li>
                      <li><a href="sign-up.html">Create Account</a></li>
                      <li><a href="login.html">Login</a></li>
                      <li><a href="pricing-table.html">Pricing</a></li>
                      <li><a href="payment-process.html">Payment</a></li>
                      <li><a href="how-it-works.html">How It Works</a></li>
                      <li><a href="user-profile.html">User Profile</a></li>
                      <li><a href="comming-soon.html">Coming Soon</a></li>
                      <li><a href="404-page.html">404 Page</a></li>
                    </ul>
                  </li>
                  <li class=""><a href="blog.html">blog </a></li>
                  <li class=" dropdown singleDrop">
                    <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">admin <i class="fa fa-angle-down" aria-hidden="true"></i></a>
                    <ul class="dropdown-menu ">
                      <li><a href="dashboard.html">Dashboard</a></li>
                      <li><a href="add-listings.html">Add Listing</a></li>
                      <li><a href="edit-listings.html">Edit Listing</a></li>
                      <li><a href="booking-list.html">Booking List</a></li>
                      <li><a href="dashboard-reviews.html">Reviews</a></li>
                      <li><a href="listings.html">My Listings</a></li>
                      <li><a href="profile.html">My Profile</a></li>
                      <li><a href="oders.html">My Orders</a></li>
                      <li><a href="sign-up.html">Create Account</a></li>
                      <li><a href="login.html">Login</a></li>
                      <li><a href="index.html">Log Out</a></li>
                    </ul>
                  </li>
                </ul>
            </div>
            <a class="btn btn-default navbar-btn" href="add-listings.html"> + <span>Add Listing</span></a>
          </div>
        </nav>
      </div>
    </header>


<!-- LOGIN SECTION -->
<section class="clearfix loginSection">
  <div class="container">
    <div class="row">
      <div class="center-block col-md-5 col-sm-6 col-xs-12">
        <div class="panel panel-default loginPanel">
          <div class="panel-heading text-center">Members log in</div>
          <div class="panel-body">
            <form method="POST" class="loginForm">
              <div class="form-group">
                <label for="userName">Nom d'utilisateur *</label>
                <input type="email" name="mailconnect" class="form-control" id="Mail" placeholder="Mail">
                <p class="help-block">Entrez votre Pseudo ou votre E-mail.</p>
              </div>
              <div class="form-group">
                <label for="userPassword">Mot de passe *</label>
                <input type="password" name="mdpconnect" class="form-control" id="name="mdpconnect" placeholder="Mot de passe" >
                <p class="help-block">Enter the password that accompanies your username.</p>
              </div>
              <div class="form-group">
                <button type="submit" name="formconnexion" class="btn btn-primary pull-left">Connexion</button>
                <a href="#" class="pull-right link">Mot de passe oublié ?</a>
              </div>
              <?php
               if(isset($erreur)) {
                  echo '<font color="red">'.$erreur."</font>";
               }
               ?>
            </form>
          </div>
          <div class="panel-footer text-center">
            <p>Not a member yet? <a href="sign-up.html" class="link">Sign up</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

    <!-- FOOTER -->
    <footer >
      <!-- FOOTER INFO -->
      <div style="background-image: url(assets/img/background/bg-footer.jpg);">
        <div class="clearfix footerInfo" style="background-image: url(assets/img/background/bg-footer.jpg);">
          <div class="container">
            <div class="row">
              <div class="col-sm-7 col-xs-12">
                <div class="footerText">
                  <a href="index.html" class="footerLogo">
                    <svg class="logo-svg white" version="1" xmlns="http://www.w3.org/2000/svg" width="140" height="44">
                      <path class="path-1" fill="" d="M0 44V0h139.813v44H0zM137.346 2.467H2.467v39.065h134.879V2.467z"/>
                      <path class="path-1" fill="" d="M120.927 22.389v11.095h-4.566V22.389a371.288 371.288 0 0 0-2.086-2.888 347.047 347.047 0 0 1-2.2-3.053 386.86 386.86 0 0 0-2.201-3.053c-.7-.959-1.395-1.922-2.086-2.888h5.617l5.255 7.287 5.222-7.287h5.649c.002 0-8.604 11.882-8.604 11.882zM98.034 33.484h-4.565V15.069h-6.372v-4.562h17.244v4.562h-6.306v18.415zm-21.908 0H71.56V15.069h-6.372v-4.562h17.244v4.562h-6.306v18.415zm-17.425-1.789c-.69.623-1.511 1.116-2.463 1.477-.953.361-1.987.542-3.104.542-1.007 0-1.982-.143-2.923-.427a10.814 10.814 0 0 1-2.661-1.214h.033a9.928 9.928 0 0 1-1.577-1.215 18.73 18.73 0 0 1-.953-.952l3.416-3.151c.153.197.399.432.739.706.339.274.728.537 1.166.788.44.253.902.467 1.38.64.481.175.941.262 1.379.262.372 0 .744-.044 1.117-.131.359-.082.703-.22 1.018-.41.305-.185.564-.437.755-.739.197-.306.296-.689.296-1.149 0-.175-.06-.366-.181-.574-.12-.208-.329-.432-.624-.673-.296-.241-.706-.498-1.232-.771a20.567 20.567 0 0 0-1.971-.87 25.42 25.42 0 0 1-2.562-1.132 8.896 8.896 0 0 1-2.053-1.428 5.903 5.903 0 0 1-1.347-1.871c-.317-.7-.476-1.51-.476-2.429 0-.94.175-1.822.526-2.642a6.21 6.21 0 0 1 1.494-2.133c.646-.602 1.423-1.072 2.332-1.412.908-.339 1.911-.509 3.006-.509.591 0 1.22.077 1.889.23.668.153 1.319.35 1.954.591a12.95 12.95 0 0 1 1.79.837c.558.317 1.023.64 1.396.968l-2.825 3.545a15.71 15.71 0 0 0-1.281-.788 10.316 10.316 0 0 0-1.281-.558 4.311 4.311 0 0 0-1.478-.263c-.919 0-1.637.181-2.151.542-.515.361-.772.881-.772 1.559 0 .307.093.586.279.837.186.252.438.482.756.689.348.225.717.417 1.1.574.416.176.854.34 1.314.492 1.314.504 2.42 1.013 3.318 1.526.898.514 1.62 1.062 2.168 1.642s.936 1.204 1.166 1.871c.23.668.345 1.395.345 2.183 0 .963-.197 1.871-.591 2.724a6.803 6.803 0 0 1-1.626 2.216zM34.839 10.507h4.532v22.977h-4.532V10.507zm-20.036 0h4.566v18.415h9.263v4.563H14.803V10.507z"/>
                    </svg>
                  </a>
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor</p>
                  <ul class="list-styled list-contact">
                    <li><i class="fa fa-phone" aria-hidden="true"></i>[88] 657 524 332</li>
                    <li><i class="fa fa-envelope" aria-hidden="true"></i><a href="#">info@listy.com</a></li>
                  </ul>
                </div>
              </div>
              <div class="col-sm-3 col-xs-12">
                <div class="footerInfoTitle">
                  <h4>Links</h4>
                </div>
                <div class="useLink">
                  <ul class="list-unstyled">
                    <li><a href="dashboard.html">Dashboard</a></li>
                    <li><a href="sign-up.html">Create Account</a></li>
                    <li><a href="login.html">Login</a></li>
                    <li><a href="add-listings.html">Add Listing</a></li>
                    <li><a href="edit-listings.html">Edit Listing</a></li>
                  </ul>
                </div>
              </div>
              <div class="col-sm-2 col-xs-12">
                <div class="footerInfoTitle">
                  <h4>Company</h4>
                </div>
                <div class="useLink">
                  <ul class="list-unstyled">
                    <li><a href="contact-us.html">Contact Us</a></li>
                    <li><a href="terms-of-services.html">Terms and Conditions</a></li>
                    <li><a href="how-it-works.html">How It Works</a></li>
                    <li><a href="payment-process.html">Payment</a></li>
                    <li><a href="pricing-table.html">Pricing</a></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- COPY RIGHT -->
        <div class="clearfix copyRight">
          <div class="container">
            <div class="row">
              <div class="col-xs-12">
                <div class="copyRightWrapper">
                  <div class="row">
                    <div class="col-sm-5 col-sm-push-7 col-xs-12">
                      <ul class="list-inline socialLink">
                        <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                        <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                        <li><a href="#"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a></li>
                        <li><a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                      </ul>
                    </div>
                    <div class="col-sm-7 col-sm-pull-5 col-xs-12">
                      <div class="copyRightText">
                        <p>Copyright &copy; 2019. All Rights Reserved by <a href="http://iamabdus.com/">Abdus</a></p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </footer>
  </div>

  <!-- LOGIN  MODAL -->
  <div id="loginModal" tabindex="-1" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Log In to your Account</h4>
        </div>
        <div class="modal-body">
          <form class="loginForm">
            <div class="form-group">
              <i class="fa fa-envelope" aria-hidden="true"></i>
              <input type="email" class="form-control" id="email" placeholder="Email">
            </div>
            <div class="form-group">
              <i class="fa fa-lock" aria-hidden="true"></i>
              <input type="password" class="form-control" id="pwd" placeholder="Password">
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-primary btn-block">Log In</button>
            </div>
            <div class="checkbox">
              <label><input type="checkbox"> Remember me</label>
              <a href="#" class="pull-right link">Fogot Password?</a>
            </div>

          </form>
        </div>
        <div class="modal-footer">
          <p>Don’t have an Account? <a href="#" class="link">Sign up</a></p>
        </div>
      </div>
    </div>
  </div>

  <!-- JAVASCRIPTS -->
  <script src="assets/plugins/jquery/jquery.min.js"></script>
  <script src="assets/plugins/jquery-ui/jquery-ui.min.js"></script>
  <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
  <script src="assets/plugins/smoothscroll/SmoothScroll.min.js"></script>
  <script src="assets/plugins/waypoints/waypoints.min.js"></script>
  <script src="assets/plugins/counter-up/jquery.counterup.min.js"></script>
  <script src="assets/plugins/datepicker/bootstrap-datepicker.min.js"></script>
  <script src="assets/plugins/selectbox/jquery.selectbox-0.1.3.min.js"></script>
  <script src="assets/plugins/owl-carousel/owl.carousel.min.js"></script>
  <script src="assets/plugins/isotope/isotope.min.js"></script>
  <script src="assets/plugins/fancybox/jquery.fancybox.min.js"></script>
  <script src="assets/plugins/isotope/isotope-triger.min.js"></script>
  <script src="assets/plugins/rateyo/jquery.rateyo.min.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDU79W1lu5f6PIiuMqNfT1C6M0e_lq1ECY"></script>
  <script src="assets/plugins/map/js/rich-marker.js"></script>
  <script src="assets/plugins/map/js/infobox_packed.js"></script>
  <script src="assets/js/map.js"></script>
  <script src="assets/js/app.js"></script>

</body>

</html>

