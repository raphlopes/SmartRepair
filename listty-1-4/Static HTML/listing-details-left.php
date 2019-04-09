<!DOCTYPE html>
<?php
$bdd = new PDO('mysql:host=127.0.0.1;dbname=smartrepair', 'root', '');

$id_rep= $_GET['id'];
$_SESSION['id'] = "1"; //à supprimer quand le site est op 


if(isset($_POST['poster'])) {
   $accueil = htmlspecialchars($_POST['accueil']);
   $rapport = htmlspecialchars($_POST['rapport']);
   $temps = htmlspecialchars($_POST['temps']);
   $fiabilite = htmlspecialchars($_POST['fiabilite']);
   $commentaire = htmlspecialchars($_POST['commentaire']);
   $date = date("Y/m/d");
   //if(!empty($_POST['accueil']) AND !empty($_POST['rapport']) AND !empty($_POST['temps']) AND !empty($_POST['fiabilite']) AND !empty($_POST['commentaire']) )
   {
	   $insertmbr = $bdd->prepare("INSERT INTO note(prix, amabilite, temps, fiabilite, description, date_poster) VALUES(?, ?, ?, ?, ?, ?)");
       $insertmbr->execute(array($rapport, $accueil, $temps, $fiabilite, $commentaire, $date));
	   
	   $last_id = $bdd->lastInsertId();
	   $insertmbr1 = $bdd->prepare("INSERT INTO concordance_note_reparateur_utilisateur(id_utilisateur_ref, id_reparateur_ref, id_note_ref) VALUES(?, ?, ?)");
       $insertmbr1->execute(array($_SESSION['id'], $id_rep, $last_id));
	   
	   
	   //mettre à jour la note moyenne du réparateur
	   //récuperer la valeur de note 
	   $sql4="SELECT id_note_ref FROM concordance_note_reparateur_utilisateur WHERE id_reparateur_ref=" .$id_rep;
	  $stmt4=$bdd->prepare($sql4);
	  $stmt4->execute();
	  $list4=$stmt4->fetchALL();
	   $sum_note = 0;
	   $number_note = 0;
	   $note = 0;
	    foreach($list4 as $value)
      	{
	   		$sql5="SELECT * FROM note WHERE id_note=" .$value['id_note_ref'];
		  	$stmt5=$bdd->prepare($sql5);
		  	$stmt5->execute();
		  	$value2=$stmt5->fetchALL();
			
		  	$sum_note = $sum_note + ($value2[0][1] + $value2[0][2]+ $value2[0][3]+ $value2[0][4])/4;
		  	$number_note++;
			
		}
	   $note = round($sum_note/$number_note);
	   $insertmbr2 = $bdd->prepare("UPDATE reparateur SET note= '$note' WHERE id_reparateur= '$id_rep'");
       $insertmbr2->execute();
	   
   }
}
?>

<html lang="en">
<head>

  <!-- SITE TITTLE -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Listing Details Left - Listty</title>

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
                  <li class="active dropdown megaDropMenu">
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


<!-- LISTINGS DETAILS TITLE SECTION -->
<section class="clearfix paddingAdjustBottom" id="listing-details">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<div class="listingTitleArea">
					<h2>Glory Hole Doughnuts</h2>
					<p>1150 Queen Street West Toronto <br>Ontario M6J 1J3, Canada</p>
					<div class="listingReview">
						<ul class="list-inline rating">
							<li><i class="fa fa-star" aria-hidden="true"></i></li>
							<li><i class="fa fa-star" aria-hidden="true"></i></li>
							<li><i class="fa fa-star" aria-hidden="true"></i></li>
							<li><i class="fa fa-star" aria-hidden="true"></i></li>
							<li><i class="fa fa-star-o" aria-hidden="true"></i></li>
						</ul>
						<span>( 5 Reviews )</span>
						<ul class="list-inline captionItem">
							<li><i class="fa fa-heart-o" aria-hidden="true"></i> 10 k</li>
						</ul>
						<a href="dashboard-reviews.html" class="btn btn-primary">Write a review</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- LISTINGS DETAILS IMAGE SECTION -->
<section class="clearfix paddingAdjustTopBottom">
	<ul class="list-inline listingImage">
		<li><img src="assets/img/listing/listing-details-1.jpg" alt="Image Listing" class="img-responsive"></li>
		<li><img src="assets/img/listing/listing-details-2.jpg" alt="Image Listing" class="img-responsive"></li>
		<li><img src="assets/img/listing/listing-details-3.jpg" alt="Image Listing" class="img-responsive"></li>
		<li><img src="assets/img/listing/listing-details-4.jpg" alt="Image Listing" class="img-responsive"></li>
	</ul>
</section>

<!-- LISTINGS DETAILS INFO SECTION -->
<section class="clearfix paddingAdjustTop">
	<div class="container">
		<div class="row">
			<div class="col-sm-4 col-xs-12">
				<div class="clearfix map-sidebar map-right">
					<div id="map" style="position:relative; margin: 0;padding: 0;height: 538px; max-width: none;"></div>
				</div>
				<div class="listSidebar">
					<h3>Location</h3>
					<div class="contactInfo">
						<ul class="list-unstyled list-address">
							<li>
								<i class="fa fa-map-marker" aria-hidden="true"></i>
								16/14 Babor Road, Mohammad pur <br> Dhaka, Bangladesh
							</li>
							<li>
								<i class="fa fa-phone" aria-hidden="true"></i>
								+55 654 545 122 <br> +55 654 545 123
							</li>
							<li>
								<i class="fa fa-envelope" aria-hidden="true"></i>
								<a href="#">info @example.com</a> <a href="#">info@startravelbangladesh.com</a>
							</li>
						</ul>
					</div>
				</div>
				<div class="listSidebar">
					<h3>Opening Hours</h3>
					<ul class="list-unstyled sidebarList">
						<li>
							<span class="pull-left">Monday</span>
							<span class="pull-right">08.00am - 05.00pm</span>
						</li>
						<li>
							<span class="pull-left">Tuesday</span>
							<span class="pull-right">08.00am - 05.00pm</span>
						</li>
						<li>
							<span class="pull-left">Wednesday</span>
							<span class="pull-right">08.00am - 05.00pm</span>
						</li>
						<li>
							<span class="pull-left">Thrusday</span>
							<span class="pull-right">08.00am - 05.00pm</span>
						</li>
						<li>
							<span class="pull-left">Friday</span>
							<span class="pull-right">08.00am - 05.00pm</span>
						</li>
						<li>
							<span class="pull-left">Saturday</span>
							<span class="pull-right"><a href="#">Closed</a></span>
						</li>
						<li>
							<span class="pull-left">Sunday</span>
							<span class="pull-right"><a href="#">Closed</a></span>
						</li>
					</ul>
				</div>
			</div>
			<div class="col-sm-8 col-xs-12">
				<div class="listDetailsInfo">
					<div class="detailsInfoBox">
						<h3>About This Hotel</h3>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed eiusmod tempor incididunt  labore et dolore magna aliqua.Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident. sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam. </p>
						<p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est. </p>
						<p>Qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui </p>
					</div>
					<div class="detailsInfoBox">
						<h3>Features</h3>
						<ul class="list-inline featuresItems">
							<li><i class="fa fa-check-circle-o" aria-hidden="true"></i>  Wi-Fi</li>
							<li><i class="fa fa-check-circle-o" aria-hidden="true"></i>  Street Parking</li>
							<li><i class="fa fa-check-circle-o" aria-hidden="true"></i>  Alcohol</li>
							<li><i class="fa fa-check-circle-o" aria-hidden="true"></i>  Vegetarian</li>
							<li><i class="fa fa-check-circle-o" aria-hidden="true"></i>  Reservations</li>
							<li><i class="fa fa-check-circle-o" aria-hidden="true"></i>  Pets Friendly</li>
							<li><i class="fa fa-check-circle-o" aria-hidden="true"></i>  Accept Credit Card</li>
						</ul>
					</div>
					<div class="detailsInfoBox">
						<h3>Avis</h3>
						<?php
      $bdd = new PDO('mysql:host=127.0.0.1;dbname=smartrepair', 'root', '');
      $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $sql="SELECT * FROM concordance_note_reparateur_utilisateur WHERE id_reparateur_ref = '4'"; // à modifier en fonction de la page sur laquelle on est co 
      $stmt=$bdd->prepare($sql);
      $stmt->execute();
      $list=$stmt->fetchALL();
      foreach($list as $value)
      {

?>
						
						<div class="media media-comment">
							<?php
							 $sql2="SELECT * FROM utilisateur where id=" .$value['id_utilisateur_ref'];
							  $stmt2=$bdd->prepare($sql2);
							  $stmt2->execute();
							  $list2=$stmt2->fetchALL();
		  
		  					  $sql3="SELECT * FROM note where id_note=" .$value['id_note_ref'];
							  $stmt3=$bdd->prepare($sql3);
							  $stmt3->execute();
							  $list3=$stmt3->fetchALL();
							 ?>
							<div class="media-left">
							<img src="<?php echo $list2[0][5];?>" class="media-object img-circle" alt="Image User">
							</div>
							
							<div class="media-body">
								<h4 class="media-heading">
									<?php echo $list2[0][1];echo "  "; echo $list2[0][2]; ?>
								</h4>
								<h5 class="text-right"> <?php echo $list3[0][6];?> </h5>
								<ul>
									<li>Rapport qualité/prix: <?php echo $list3[0][1] ?>/5  </li>
									<li>Accueil: <?php echo $list3[0][2] ?>/5  </li>
									<li>Temps de prise en charge: <?php echo $list3[0][3] ?>/5  </li>
									<li>Fiabilité : <?php echo $list3[0][4] ?>/5  </li>
								</ul>
								
							
		  						</br>
								<p style="font-size: 20px;"> <?php echo $list3[0][5];?> </p>
							</div>
						</div>
						<hr>
						<?php } ?>
					</div>
					<?php 
						if ($_SESSION['id'])
						{ ?>
			
					<div class="detailsInfoBox">
						<h3>Ecrire un avis </h3>
						<form method="POST" action="#">
						<div class="listingReview">
							<hr>
							<ul >
								<li> Rapport qualité/prix 
									
										<div class="searchSelectboxes" >
										<select class="select-drop" id="rapport" name="rapport">
											<option value="0">0</option>
											<option value="1">1</option>
											<option value="2">2</option>
											<option value="3">3</option>
											<option value="4">4</option>
											<option value="5">5</option>
											<option value="5"><?php echo $note ?></option>
										</select>
										
									</div>
									
								</li>
								<li> Accueil 
									<div class="searchSelectboxes" >
										<select class="select-drop" id="accueil" name="accueil">
											<option value="0">0</option>
											<option value="1">1</option>
											<option value="2">2</option>
											<option value="3">3</option>
											<option value="4">4</option>
											<option value="5">5</option>
										</select>
									</div>
								</li>
								<li> Temps de prise en charge 
									<div class="searchSelectboxes" >
										<select class="select-drop" id="temps"  name="temps">
											<option value="0">0</option>
											<option value="1">1</option>
											<option value="2">2</option>
											<option value="3">3</option>
											<option value="4">4</option>
											<option value="5">5</option>
										</select>
									</div>
								</li>
								<li> Fiabilité 
									<div class="searchSelectboxes" >
										<select class="select-drop" id="fiabilite" name="fiabilite">
											<option value="0">0</option>
											<option value="1">1</option>
											<option value="2">2</option>
											<option value="3">3</option>
											<option value="4">4</option>
											<option value="5">5</option>
										</select>
									</div>
								</li>
							</ul>
						</div>
							<div class="formSection formSpace">
								<div class="form-group">
									<textarea class="form-control" rows="3" placeholder="Comment" name="commentaire"></textarea>
								</div>
								<div class="form-group mb0">
									<button type="submit" class="btn btn-primary" name="poster">Poster son avis</button>
								</div>
							</div>
						</form>
					</div>
					<?php } ?>
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

