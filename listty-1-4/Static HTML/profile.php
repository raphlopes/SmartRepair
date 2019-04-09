<?php
session_start();

$bdd = new PDO('mysql:host=127.0.0.1;dbname=smartrepair', 'root', '');


if(isset($_GET['idutilisateur']) AND $_GET['idutilisateur'] > 0) {
   $getid = intval($_GET['idutilisateur']);
   $requser = $bdd->prepare('SELECT * FROM utilisateur WHERE id = ?');
   $requser->execute(array($getid));
   $userinfo = $requser->fetch();
}


if(isset($_SESSION['idutilisateur'])) {
   $requser = $bdd->prepare("SELECT * FROM utilisateur WHERE id = ?");
   $requser->execute(array($_SESSION['idutilisateur']));
   $user = $requser->fetch();
   if(isset($_POST['newnom']) AND !empty($_POST['newnom']) AND $_POST['newnom'] != $user['nom']) {
      $newnom = htmlspecialchars($_POST['newnom']);
      $insertnom = $bdd->prepare("UPDATE utilisateur SET nom = ? WHERE id = ?");
      $insertnom->execute(array($newnom, $_SESSION['idutilisateur']));
      header('Location: profile.php?idutilisateur='.$_SESSION['idutilisateur']);
   }

   $requser = $bdd->prepare("SELECT * FROM utilisateur WHERE id = ?");
   $requser->execute(array($_SESSION['idutilisateur']));
   $user = $requser->fetch();
   if(isset($_POST['newprenom']) AND !empty($_POST['newprenom']) AND $_POST['newprenom'] != $user['prenom']) {
      $newprenom = htmlspecialchars($_POST['newprenom']);
      $insertprenom = $bdd->prepare("UPDATE utilisateur SET prenom = ? WHERE id = ?");
      $insertprenom->execute(array($newprenom, $_SESSION['idutilisateur']));
      header('Location: profile.php?idutilisateur='.$_SESSION['idutilisateur']);
   }



   if(isset($_POST['newmail']) AND !empty($_POST['newmail']) AND $_POST['newmail'] != $user['mail']) {
      $newmail = htmlspecialchars($_POST['newmail']);
      $insertmail = $bdd->prepare("UPDATE utilisateur SET mail = ? WHERE id = ?");
      $insertmail->execute(array($newmail, $_SESSION['idutilisateur']));
      header('Location: profile.php?idutilisateur='.$_SESSION['idutilisateur']);
   }

   /*
   $requser = $bdd->prepare("SELECT * FROM utilisateur WHERE id = ?");
   $requser->execute(array($_SESSION['id']));
   $user = $requser->fetch();
   
   */

   //ancien mdp crypté
   
   if (isset($_POST['ancienmdp']) AND !empty($_POST['ancienmdp']))
   {
      $ancienmdp = sha1($_POST['ancienmdp']);

   if ($ancienmdp == $user['mot_de_passe']) 
   {

   if(isset($_POST['newmdp1']) AND !empty($_POST['newmdp1']) AND isset($_POST['newmdp2']) AND !empty($_POST['newmdp2'])) {
      $mdp1 = sha1($_POST['newmdp1']);
      $mdp2 = sha1($_POST['newmdp2']);
      if($mdp1 == $mdp2) {
         $insertmdp = $bdd->prepare("UPDATE utilisateur SET mot_de_passe = ? WHERE id = ?");
         $insertmdp->execute(array($mdp1, $_SESSION['idutilisateur']));
         header('Location: profile.php?idutilisateur='.$_SESSION['idutilisateur']);
      } else {
         $msg = "Vos deux mdp ne correspondent pas !";
      }
   }

   } else {
         
         $msg = "ancien mot de passe incorrect";
          }
   }


   //ajout photo de profil 

   if(isset($_FILES['avatar']) AND !empty($_FILES['avatar']['name'])) {
   $tailleMax = 2097152;
   $extensionsValides = array('jpg', 'jpeg', 'gif', 'png');
   if($_FILES['avatar']['size'] <= $tailleMax) {
      $extensionUpload = strtolower(substr(strrchr($_FILES['avatar']['name'], '.'), 1));
      if(in_array($extensionUpload, $extensionsValides)) {
         $chemin = "utilisateur/avatars/".$_SESSION['idutilisateur'].".".$extensionUpload;
         $resultat = move_uploaded_file($_FILES['avatar']['tmp_name'], $chemin);
         if($resultat) {
            $updateavatar = $bdd->prepare('UPDATE utilisateur SET avatar = :avatar WHERE id = :idutilisateur');
            $updateavatar->execute(array(
               'avatar' => $_SESSION['idutilisateur'].".".$extensionUpload,
               'idutilisateur' => $_SESSION['idutilisateur']
               ));
            header('Location: profile.php?idutilisateur='.$_SESSION['idutilisateur']);
         } else {
            $msg = "Erreur durant l'importation de votre photo de profil";
         }
      } else {
         $msg = "Votre photo de profil doit être au format jpg, jpeg, gif ou png";
      }
   } else {
      $msg = "Votre photo de profil ne doit pas dépasser 2Mo";
   }
}

?>





<!DOCTYPE html>
<html lang="en">
<head>

  <!-- SITE TITTLE -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Profile - Listty</title>

  <!-- PLUGINS CSS STYLE -->
  <link href="assets/plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet">
  <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="assets/plugins/listtyicons/style.css" rel="stylesheet">
  <link href="assets/plugins/bootstrapthumbnail/bootstrap-thumbnail.css" rel="stylesheet">
  <link href="assets/plugins/datepicker/datepicker.min.css" rel="stylesheet">
  <link href="assets/plugins/selectbox/select_option1.css" rel="stylesheet">
  <link href="assets/plugins/rwdtable/css/rwd-table.css" rel="stylesheet">
  <link href="assets/plugins/owl-carousel/owl.carousel.min.css" rel="stylesheet">
  <link href="assets/plugins/fancybox/jquery.fancybox.min.css" rel="stylesheet"/>
  <link href="assets/plugins/isotope/isotope.min.css" rel="stylesheet">
  <link href="assets/plugins/map/css/map.css" rel="stylesheet">
  <link href="assets/plugins/rateyo/jquery.rateyo.min.css" rel="stylesheet">
  <link href="assets/plugins/animate/animate.css" rel="stylesheet">
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

<body id="body" class="body-wrapper boxed-menu" >
  <div class="main-wrapper">
    <!-- HEADER -->
    <header id="pageTop" class="header">

      <!-- TOP INFO BAR -->

      <div class="nav-wrapper navbarWhite">

        <!-- NAVBAR -->
        <nav id="menuBar" class="navbar navbar-default lightHeader " role="navigation">
          <div class="container">

            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="index.html"><svg class="logo-svg" version="1" xmlns="http://www.w3.org/2000/svg" width="140" height="44">
                <path class="path-1" fill="" d="M0 44V0h139.813v44H0zM137.346 2.467H2.467v39.065h134.879V2.467z"/>
                <path class="path-1" fill="" d="M120.927 22.389v11.095h-4.566V22.389a371.288 371.288 0 0 0-2.086-2.888 347.047 347.047 0 0 1-2.2-3.053 386.86 386.86 0 0 0-2.201-3.053c-.7-.959-1.395-1.922-2.086-2.888h5.617l5.255 7.287 5.222-7.287h5.649c.002 0-8.604 11.882-8.604 11.882zM98.034 33.484h-4.565V15.069h-6.372v-4.562h17.244v4.562h-6.306v18.415zm-21.908 0H71.56V15.069h-6.372v-4.562h17.244v4.562h-6.306v18.415zm-17.425-1.789c-.69.623-1.511 1.116-2.463 1.477-.953.361-1.987.542-3.104.542-1.007 0-1.982-.143-2.923-.427a10.814 10.814 0 0 1-2.661-1.214h.033a9.928 9.928 0 0 1-1.577-1.215 18.73 18.73 0 0 1-.953-.952l3.416-3.151c.153.197.399.432.739.706.339.274.728.537 1.166.788.44.253.902.467 1.38.64.481.175.941.262 1.379.262.372 0 .744-.044 1.117-.131.359-.082.703-.22 1.018-.41.305-.185.564-.437.755-.739.197-.306.296-.689.296-1.149 0-.175-.06-.366-.181-.574-.12-.208-.329-.432-.624-.673-.296-.241-.706-.498-1.232-.771a20.567 20.567 0 0 0-1.971-.87 25.42 25.42 0 0 1-2.562-1.132 8.896 8.896 0 0 1-2.053-1.428 5.903 5.903 0 0 1-1.347-1.871c-.317-.7-.476-1.51-.476-2.429 0-.94.175-1.822.526-2.642a6.21 6.21 0 0 1 1.494-2.133c.646-.602 1.423-1.072 2.332-1.412.908-.339 1.911-.509 3.006-.509.591 0 1.22.077 1.889.23.668.153 1.319.35 1.954.591a12.95 12.95 0 0 1 1.79.837c.558.317 1.023.64 1.396.968l-2.825 3.545a15.71 15.71 0 0 0-1.281-.788 10.316 10.316 0 0 0-1.281-.558 4.311 4.311 0 0 0-1.478-.263c-.919 0-1.637.181-2.151.542-.515.361-.772.881-.772 1.559 0 .307.093.586.279.837.186.252.438.482.756.689.348.225.717.417 1.1.574.416.176.854.34 1.314.492 1.314.504 2.42 1.013 3.318 1.526.898.514 1.62 1.062 2.168 1.642s.936 1.204 1.166 1.871c.23.668.345 1.395.345 2.183 0 .963-.197 1.871-.591 2.724a6.803 6.803 0 0 1-1.626 2.216zM34.839 10.507h4.532v22.977h-4.532V10.507zm-20.036 0h4.566v18.415h9.263v4.563H14.803V10.507z"/>
              </svg></a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav navbar-right mr0">
                  <li class=" dropdown singleDrop">
                    <a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">home <i class="fa fa-angle-down" aria-hidden="true"></i></a>
                    <ul class="dropdown-menu">
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
                  <li class=" dropdown singleDrop">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">pages <i class="fa fa-angle-down" aria-hidden="true"></i></a>
                    <ul class="dropdown-menu">
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
                  <li class="active dropdown singleDrop">
                    <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">admin <i class="fa fa-angle-down" aria-hidden="true"></i></a>
                    <ul class="dropdown-menu dropdown-menu-right">
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
                    </ul>
                  </li>
                </ul>
            </div>
          </div>
        </nav>
      </div>
    </header>
    <!-- Dashboard header -->
    <section class="navbar-dashboard-area">
      <nav class="navbar navbar-default lightHeader navbar-dashboard" role="navigation">
        <div class="container">

          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-dash">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
          </div>

          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse navbar-dash">
            <ul class="nav navbar-nav mr0">
              <li class="">
                <a href="dashboard.html"><i class="fa fa-tachometer icon-dash" aria-hidden="true"></i> Dashboard</a>
              </li>
              <li class="dropdown singleDro ">
                <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-list-ul icon-dash" aria-hidden="true"></i> Listings <i class="fa fa-angle-down" aria-hidden="true"></i></a>
                <ul class="dropdown-menu">
                  <li><a href="listings.html">My Listings</a></li>
                  <li><a href="add-listings.html">Add Listings</a></li>
                  <li><a href="edit-listings.html">My Listings</a></li>
                </ul>
              </li>
              <li class="">
                <a href="dashboard-reviews.html" class="scrolling"><i class="fa fa-star-o icon-dash" aria-hidden="true"></i> Reviews</a>
              </li>
              <li class="">
                <a href="oders.html"><i class="fa fa-cogs icon-dash" aria-hidden="true"></i> Orders</a>
              </li>
              <li>
                <a href="dashboard.html#message" class="scrolling">
                  <i class="fa fa-envelope icon-dash" aria-hidden="true"> </i>
                  Messages</a>
              </li>
              <li class="active">
                <a href="profile.html"><i class="fa fa-user icon-dash" aria-hidden="true"></i> Personal Details</a>
              </li>
            </ul>
            <div class="row adjustRow">
              <div class="pull-right col-xs-12 col-sm-2">
                <form class="navbar-form" role="search">
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search" name="q">
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="button"><i class="icon-listy icon-search-2"></i></button>
                    </span>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </nav>
    </section>


<!-- Dashboard breadcrumb section -->
<div class="section dashboard-breadcrumb-section bg-dark">
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <h2>My Profile</h2>
        <ol class="breadcrumb">
          <li><a href="index.html">Home</a></li>
          <li><a href="dashboard.html">Dashboard</a></li>
          <li class="active">My Profile</li>
        </ol>
      </div>
    </div>
  </div>
</div>


<!-- DASHBOARD PROFILE SECTION -->
<section class="clearfix bg-dark profileSection">
	<div class="container">
		<div class="row">
			<div class="col-md-4 col-sm-5 col-xs-12">
        <form method="POST" action="" enctype="multipart/form-data">
				<div class="dashboardBoxBg mb30">
					<div class="profileImage">


            <?php
         if(!empty($userinfo['avatar']))
         {

            ?> 
            <img src="utilisateur/avatars/<?php echo $userinfo['avatar'] ; ?>" width = "150";
            height ="150"; class="img-circle" />
            <?php
            
         }

         if(empty($userinfo['avatar']))
         {

            ?> 
            <img src="utilisateur/avatars/defaut.png<?php echo $userinfo['avatar'] ; ?>" width = "150";
            height ="150"; class="img-circle" />
            <?php
            
         }



         ?>
            <!--
						<img src="assets/img/dashboard/recent-user-5.jpg" alt="Image User" class="img-circle">
          -->
						<div class="file-upload profileImageUpload">
							<div class="upload-area">
                <input class="browse" type="file" type="submit" name="avatar" />
                <!--
								<input type="file" name="img[]" class="file">
              -->
                
                <button class="browse"  type="submit" " >Modifier la photo de profil <i class="icon-listy icon-upload"></i></button>
                <!--
								<button class="browse" type="button">Upload a Picture <i class="icon-listy icon-upload"></i></button>
              -->
							</div>
						</div>
					</div>
					<div class="profileUserInfo bt profileName">
						<p>Your Current Plan</p>
						<h2>Platinum Package</h2>
						<h5>Next Payment: <span>15/01/2017</span></h5>
						<a href="#" class="btn btn-primary">Change</a>
					</div>
				</div>
      </form>
			</div>
			<div class="col-md-8 col-sm-7 col-xs-12">
        <!--  
				<form>
          -->
				<form method="POST" action="" enctype="multipart/form-data">	
          <div class="dashboardBoxBg">
						<div class="profileIntro">
							<h2><?php echo $user['nom'];?> <?php echo " " ?> <?php echo $user['prenom']; ?> </h2>
							<p>Bienvenue sur la page de votre profil. A partir de cette page vous pouvez modifier vos informations personnelles ainsi que vos informations de connexion à tout moment.</p>
						</div>
					</div>
					<div class="dashboardBoxBg mt30">
						<div class="profileIntro">
							<h3>About You</h3>
							<div class="row">
								<div class="form-group col-sm-6 col-xs-12">
									<label for="firstNameProfile">Nom</label>
                  <input  type="text" class="form-control" name="newnom" placeholder="nom" value="<?php echo $user['nom']; ?>"/>
                  <!--  
									<input type="text" class="form-control" id="firstNameProfile" placeholder="Jane">
                -->
								</div>
								<div class="form-group col-sm-6 col-xs-12">
									<label for="lastNameProfile">Prenom</label>
                  <input type="text" class="form-control" name="newprenom" placeholder="prenom" value="<?php echo $user['prenom']; ?>"/>
                  <!--
									<input type="text" class="form-control" id="lastNameProfile" placeholder="Doe">
                -->
								</div>
								<div class="form-group col-sm-6 col-xs-12">
									<label for="emailProfile">Mail</label>
                  <input type="text" class="form-control" name="newmail" placeholder="Mail" value="<?php echo $user['mail']; ?>"/>
                  <!--
									<input type="text" class="form-control" id="emailProfile" placeholder="Jane@example.com">
                -->
								</div>
                <!--
								<div class="form-group col-sm-6 col-xs-12">
									<label for="phoneProfile">Phone</label>
									<input type="text" class="form-control" id="phoneProfile" placeholder="254 - 265 - 3265">
								</div>
              -->
              <!--
								<div class="form-group col-xs-12">
									<label for="aboutYou">About You</label>
									<textarea class="form-control" rows="5" id="aboutYou" placeholder="About You"></textarea>
								</div>
              -->
							</div>
						</div>
					</div>
          <!--
					<div class="dashboardBoxBg mt30">
						<div class="profileIntro">
							<h3>Social Network</h3>
							<div class="row">
								<div class="form-group col-sm-6 col-xs-12">
									<label for="linkedInUrl">Linked in URL</label>
									<input type="text" class="form-control" id="linkedInUrl" placeholder="http://linkedin.com/listty">
								</div>
								<div class="form-group col-sm-6 col-xs-12">
									<label for="facebookUrl">Facebook URL</label>
									<input type="text" class="form-control" id="facebookUrl" placeholder="http://facebook.com/listty">
								</div>
								<div class="form-group col-sm-6 col-xs-12">
									<label for="twitterUrl">Twitter URL</label>
									<input type="text" class="form-control" id="twitterUrl" placeholder="http://twitter.com/listty">
								</div>
								<div class="form-group col-sm-6 col-xs-12">
									<label for="youTubeUrl">You Tube URL</label>
									<input type="text" class="form-control" id="youTubeUrl" placeholder="http://youtube.com/listty">
								</div>
							</div>
						</div>
					</div>

        -->
					<div class="btn-area mt30">
            <!--
						<button class="btn btn-primary" type="button">Save Change</button>
          -->
            <input class="btn btn-primary" type="submit" value="Mettre à jour mon profil !" />
					</div>

        </form>

       <form method="POST" action="" enctype="multipart/form-data">  

					<div class="dashboardBoxBg mt30">
						<div class="profileIntro">
							<h3>Update password</h3>
							<div class="row">
								<div class="form-group col-xs-12">
									<label for="currentPassword">Current Password</label>
                  <input type="password" class="form-control" name="ancienmdp"  placeholder="Ancien mot de passe" id="ancienmdp" />
                  <!--
									<input type="password" class="form-control" id="currentPassword" placeholder="********">
                -->
								</div>
								<div class="form-group col-xs-12">
									<label for="newPassword">New Password</label>
                  <input type="password" class="form-control" name="newmdp1" placeholder="Nouveau Mot de passe"/>
                  <!--
									<input type="password" class="form-control" id="newPassword" placeholder="New Password">
                -->
								</div>
								<div class="form-group col-xs-12">
									<label for="confirmPassword">Confirm Password</label>
                  <input type="password" class="form-control" name="newmdp2" placeholder="Confirmation du mot de passe" />
                  <!--
									<input type="password" class="form-control" id="confirmPassword" placeholder="Confirm Password">
                -->
								</div>
								<div class="form-group col-xs-12">
                  <input class="btn btn-primary" type="submit" value="Modifier mot de passe" />
                  <!--
									<button class="btn btn-primary" type="button">Change Password</button>
                -->
								</div>
							</div>
						</div>
					</div>


				</form>
        <?php if(isset($msg)) { echo $msg; } ?>
			</div>
		</div>
	</div>
</section>


    <!-- FOOTER -->
    <footer class="copyRightDashboard">
      <div class="container">
        <div class="row">
          <div class="col-xs-12">
            <p>Copyright © 2016. All Rights Reserved</p>
          </div>
        </div>
      </div>
    </footer>
  </div>

  <!-- JAVASCRIPTS -->
  <script src="assets/plugins/jquery/jquery.min.js"></script>
  <script src="assets/plugins/jquery/jquery-migrate.js"></script>
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
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDU79W1lu5f6PIiuMqNfT1C6M0e_lq1ECY&libraries=places&callback=initAutocomplete"
  async defer></script>
  <!-- <script src="assets/plugins/map/js/markerclusterer.js"></script> -->
  <!-- <script src="assets/plugins/map/js/rich-marker.js"></script> -->
  <!-- <script src="assets/plugins/map/js/infobox_packed.js"></script> -->
  <script src="assets/js/map.js"></script>
  <script src="assets/js/app.js"></script>


</body>

</html>

<?php   
}
else {
   header("Location: login.php");
}
?>

