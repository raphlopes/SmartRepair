<?php
class GmapApi {

    private static $apikey = 'AIzaSyCUuEI5R2OBqsu1qj2iv2CnbznI0N-X6M4';

    public static function geocodeAddress($address) {
        //valeurs vide par défaut
        $data = array('address' => '', 'lat' => '', 'lng' => '');
        //on formate l'adresse
        $address = str_replace(" ", "+", $address);
        //on fait l'appel à l'API google map pour géocoder cette adresse
        $json = file_get_contents("https://maps.google.com/maps/api/geocode/json?key=" . self::$apikey . "&address=$address&sensor=false&region=fr");
        $json = json_decode($json);
        //on enregistre les résultats recherchés
        if ($json->status == 'OK' && count($json->results) > 0) {
            $res = $json->results[0];
            //adresse complète et latitude/longitude
            $data['address'] = $res->formatted_address;
            $data['lat'] = $res->geometry->location->lat;
            $data['lng'] = $res->geometry->location->lng;
            foreach ($res->address_components as $component) {
                //ville
               
                //départment
               
                //région
                
                //pays
                
                //code postal
                
            }
        }




        return $data;
    }

}

?>


<?php
$bdd = new PDO('mysql:host=127.0.0.1;dbname=smartrepair', 'root', '');


      /*Récupération des infos concernant ta table*/




          




if(isset($_POST['forminscription'])) {


                   if(isset($_POST['paiement'])){

                      foreach($_POST['paiement'] as $valeur)
                      {
                         echo "<br/>";
                         echo "La checkbox $valeur a été <br>";
                      }
                

              }

      //code du captcha api google

     require('recaptcha/autoload.php');
    if(isset($_POST['g-recaptcha-response'])) {
      $recaptcha = new \ReCaptcha\ReCaptcha('6LcrVpYUAAAAAD3hbk7Jq1_aDwmyn-9Lee0rLJEW');
      $resp = $recaptcha->verify($_POST['g-recaptcha-response']);
      if ($resp->isSuccess()) {
          //var_dump('Captcha Valide');
      } else {
          //$errors = $resp->getErrorCodes();
          //var_dump('Captcha Invalide');
          //var_dump($errors);
      }
    } else {
      var_dump('Captcha non rempli');
    }

    //code pour mettre une image par défaut 


   $nom = htmlspecialchars($_POST['nom']);
   $description = htmlspecialchars($_POST['description']);
   $site_internet = htmlspecialchars($_POST['site_internet']);
   $numero_telephone = htmlspecialchars($_POST['numero_telephone']);
   $adresse = htmlspecialchars($_POST['adresse']);
   $heure_semaine = htmlspecialchars($_POST['heure_semaine']);
   $heure_samedi = htmlspecialchars($_POST['heure_samedi']);
   $heure_dimanche = htmlspecialchars($_POST['heure_dimanche']);
   $mail_user = htmlspecialchars($_POST['mail_user']);
   //$mail_user_confirm = htmlspecialchars($_POST['mail_user_confirm']);
   $mdp = sha1($_POST['mdp']);
   $mdp2 = sha1($_POST['mdp2']);



   if(!empty($_POST['nom']) AND !empty($_POST['description']) AND !empty($_POST['site_internet']) AND !empty($_POST['numero_telephone']) AND !empty($_POST['mail_user'])  AND !empty($_POST['mdp']) AND !empty($_POST['mdp2']) AND !empty($_POST['adresse']) ) {






      $nomlength = strlen($nom);
      $descriptionlength = strlen($description);
      $site_internetlength = strlen($site_internet);
      $numero_telephonelength = strlen($numero_telephone);
      $adresselength = strlen($numero_telephone);
      //$heure_semaine = strlen($heure_semaine);
      //$heure_samedi = strlen($heure_samedi);
      //$heure_dimanche = strlen($heure_dimanche);





      if($nomlength <= 255) {
         if($descriptionlength <= 255) {
          if($site_internetlength <= 255) {
            if($adresselength <= 255){
              if($numero_telephonelength <= 255){


            if(filter_var($mail_user, FILTER_VALIDATE_EMAIL)) {
               $reqmail = $bdd->prepare("SELECT * FROM reparateur WHERE mail = ?");
               $reqmail->execute(array($mail_user));
               $mailexist = $reqmail->rowCount();
               if($mailexist == 0) {
                  if($mdp == $mdp2) {

                     if(1==1){

                      // les heures d'ouvertures 

                      if (empty($_POST['heure_semaine'])){

                        $heure_semaine = "Fermé";
                      }

                      if (empty($_POST['heure_samedi'])){

                        $heure_samedi = "Fermé";
                      }


                      if (empty($_POST['heure_dimanche'])){

                        $heure_dimanche = "Fermé";
                      }



                      // code pour les cases de paiement 

                      if(isset($_POST['paiement'])){
                      echo "case coché";

                      foreach($_POST['paiement'] as $valeur)
                      {
                         echo "<br/>";
                         echo "La checkbox $valeur a été cochée<br>";
                      }
                

                      }







                     $data = GmapApi::geocodeAddress($_POST['adresse']);
                     //on affiche les différente infos
                     echo '<ul>';
                     foreach ($data as $key=>$value){
                         //echo '<li>'.$key.' : '.$value.'</li>';
                     }
                     //echo '</ul>';


                     $type="reparateur";
                  
                     try{


                     $insertmbr = $bdd->prepare("INSERT INTO adresse(adresse, type, lat, lng) VALUES(?, ?, ?, ?)");
                     //$insertmbr = $bdd->prepare("INSERT INTO adresse("caca", "caca", 1, 1)";
                     $insertmbr->execute(array($data['address'],$type, $data['lat'] ,$data['lng']));
                     //$insertmbr->execute(array($data['address'], $type, $data['lat'],$data['lng']));

                        }catch (Exception $e)

                        {

                                die('Erreur : ' . $e->getMessage());

                        }
                  
                   //  $recup_id_adresse = $bdd->prepare("SELECT id_adresse FROM adresse WHERE adresse = ?");
                     //$insertmbr->execute(array("toto", "toto", "toto", "48.859798","48.859798");
                     //$recup_id_adresse->execute(array($data['address']));
                     $adresse_info =$bdd->lastInsertID();
                     echo '<li>'.$bdd->lastInsertID() .'</li>';


                              //inscription dans la table de concordance

                              foreach($_POST["marque"] as $marquee) {

                                $insertmbr = $bdd->prepare("INSERT INTO concordance_marque_reparateur(id_marque_ref, id_reparateur_ref ) VALUES(?, ?)");
                                $insertmbr->execute(array($marquee ,$adresse_info));
                                 
                              }



                              if(isset($_POST['paiement1'])){

                                $paiement1 = "1";
                              } else {

                                 $paiement1 = "0";
                              }


                              if(isset($_POST['paiement2'])){

                                $paiement2 = "1";
                              } else {

                                 $paiement2 = "0";
                              }


                              if(isset($_POST['paiement3'])){

                                $paiement3 = "1";
                              } else {

                                 $paiement3 = "0";
                              }
                            
                                



                     $insertmbr = $bdd->prepare("INSERT INTO reparateur(nom, id_adresse_ref, description, moyen_paiement_cash, moyen_paiement_carte, moyen_paiement_cheque, note, site_internet, mail, mot_de_passe, numero_telephone, heure_ouverture_semaine, heure_ouverture_samedi, heure_ouverture_dimanche) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                     $insertmbr->execute(array($nom, $adresse_info, $description, $paiement1, $paiement2, $paiement3, "0", $site_internet, $mail_user, $mdp, $numero_telephone, $heure_semaine, $heure_samedi, $heure_dimanche) );
                     $msg = "Vous avez bien été enregistré. Un email de confirmation vous a été envoyé ! <a href=\"connexion.php\">Se connecter</a>";



                     // inscription de l'adresse 

                   

                  
                       /*
                        $header="MIME-Version: 1.0\r\n";
                        $header.='From:"SmartRepair"<test.raspberry2018@gmail.com>'."\n";
                        $header.='Content-Type:text/html; charset="uft-8"'."\n";
                        $header.='Content-Transfer-Encoding: 8bit';
                        $message='
                        <html>
                           <body>
                              <div align="center">
                                 <img src="https://image.noelshack.com/fichiers/2019/09/5/1551470933-logo1-copie.png"/>
                                 <br />
                                 Bonjour '.$_POST['nom']. ' '.$_POST['description']. ' nous sommes heureux de vous accueillir au sein de la communauté SmartRepair. <br /><br />
                                 Pour pouvoir bénéficier dès maintenant de notre site voici vos informations concernant votre comtpe <br /><br />
                                 <u>Votre ID de connexion : </u>'.$_POST['mail_user'].'<br />
                                 <u>Votre mot de passe : </u>'.$_POST['mdp'].'<br />
                                 <br />
                                 <br />
                                 A bientôt !
                                 <img src="http://www.primfx.com/mailing/separation.png"/>
                              </div>
                           </body>
                        </html>
                        ';
                        mail($mail_user, "SmartRepair vous souhaite la bienvienue", $message, $header);
                        $msg="Nous vous avons envoyé un mail de confirmation";
                     
                        */

               } else {
                  $msg = "Veuillez valider votre captcha";
               }

                  } else {
                     $msg = "Veuillez entrer un mot de passe valide";
                  }
               } else {
                  $msg = "Cet E-mail est déjà utilisé. <br/> Veuillez en utiliser un nouveau";
               }
            } else {
               $msg = "E-mail non valide";
            }



         } else {
         $msg = "Le nombre de caractère pour votre telephone a été dépassé";
      }

      } else {
         $msg = "Le nombre de caractère pour votre adresse a été dépassé";
      }

       } else {
         $msg = "Le nombre de caractère pour votre site a été dépassé";
      }

      } else {
         $msg = "Le nombre de caractère pour votre description a été dépassé";
      }

   } else {
         $msg = "Le nombre de caractère pour votre nom a été dépassé";
      }

   } else {
      $msg = "Complétez toutes les informations";
   }
}
?>





<!-- image magasin -->

<?php


       //if(isset($_FILES['avatar']) AND !empty($_FILES['avatar']['name'])) {


    $last_id = $bdd->query("SELECT max(id_reparateur) FROM reparateur");

    //nouvel id
    $result = $last_id->fetch();
    $count = $result[0]  ;
    //echo $count;

   $tailleMax = 2097152;
   $extensionsValides = array('jpg', 'jpeg', 'gif', 'png');
  // if($_FILES['avatar']['size'] <= $tailleMax) {
      $extensionUpload = strtolower(substr(strrchr($_FILES['avatar']['name'], '.'), 1));
      if(in_array($extensionUpload, $extensionsValides)) {
         $chemin = "reparateurs/avatars/".$count.".".$extensionUpload;
         $resultat = move_uploaded_file($_FILES['avatar']['tmp_name'], $chemin);
         if($resultat) {
            $updateavatar = $bdd->prepare('UPDATE reparateur SET avatar = :avatar WHERE id_reparateur = :id');
            $updateavatar->execute(array(
               'avatar' => $count.".".$extensionUpload,
               'id' => $count
               ));
           // header('Location: profile.php?id='.$count['id']);
         } else {
            $msg = "Erreur durant l'importation de votre photo de profil";
         }
      } else {
         $msg = "Votre photo de profil doit être au format jpg, jpeg, gif ou png";
      }
   
   //} else {
     // $msg = "Votre photo de profil ne doit pas dépasser 2Mo";
   //}
//}


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
	<script src="https://raw.githubusercontent.com/lewagon/google-place-autocomplete/gh-pages/autocomplete.js"></script>
<script> google.maps.event.addDomListener(window, 'load', function() {  
  initializeAutocomplete('user_input_autocomplete_address');
});
		</script>
	
</head>

<body id="body" class="body-wrapper boxed-menu" >
  <div class="main-wrapper">
    <!-- HEADER -->
    <header id="pageTop" class="header">

      <div class="nav-wrapper navbarWhite"> 
      <!-- NAVBAR -->
      <nav id="menuBar" class="navbar navbar-default lightHeader animated " role="navigation">
        <div class="container"> 
          
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
            <a class="navbar-brand" href="index.html">
            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="150px" height="85px" viewBox="0 0 253 202" enable-background="new 0 0 253 202" xml:space="preserve" style="margin-top: -14%">  <image id="image0" width="253" height="202" x="0" y="0"
    href="data:image/png;base64,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" />
</svg>
            </a> </div>
          
          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav navbar-right">
              <li class="active dropdown singleDrop"> <a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Accueil</a> </li>
              <li class=" dropdown megaDropMenu"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Liste<i class="fa fa-angle-down" aria-hidden="true"></i></a>
                <ul class="row dropdown-menu">
                  <li class="col-sm-6 col-xs-12">
                    <ul class="list-unstyled">
                      <li class="list-item-heading"><a href="listing-list-left-sidebar.html">Liste des Réparateurs</a></li>
                    </ul>
                  </li>
                  <li class="col-sm-6 col-xs-12">
                    <ul class="list-unstyled">
                      <li class="list-item-heading"><a href="listings-half-screen-map-list.html">Map</a></li>
                    </ul>
                  </li>
                </ul>
              </li>
              <li class=" dropdown singleDrop"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">pages <em class="fa fa-angle-down" aria-hidden="true"></em></a>
                <ul class="dropdown-menu">
                  <li><a href="contact-us.html">Nous contacter</a></li>
                  <li><a href="terms-of-services.html">Conditions de Service</a></li>
                  <li><a href="how-it-works.html">Aide</a></li>
                  <li><a href="comming-soon.html">A Venir</a></li>
                </ul>
              </li>
              <li class=""><a href="blog.html">blog </a></li>
              <li class=" dropdown singleDrop"> <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Compte<i class="fa fa-angle-down" aria-hidden="true"></i></a>
                <ul class="dropdown-menu">
                  <li><a href="add-listings.html">Ajout</a></li>
                  <li><a href="edit-listings.html">Edition</a></li>
                  <li><a href="booking-list.html">Rendez-vous</a></li>
                  <li><a href="dashboard-reviews.html">Avis</a></li>
                  <li><a href="listings.html">Mes Ajouts</a></li>
				  <li><a href="user-profile.html">Profil</a></li>
                  <li><a href="profile.html">Edition du profil</a></li>
                  <li><a href="oders.html">Mes Rendez-vous</a></li>
				  <li><a href="sign-up.php">Creer un compte</a></li>
                  
                  <li><a href="index.html">Deconnexion</a></li>
                </ul>
              </li>
            </ul>
          </div>
          <a class="btn btn-default navbar-btn" href="add-listings.html"> + <span>Ajouter</span></a> </div>
      </nav>
    </div>
    </header>
    
<!-- Dashboard breadcrumb section -->
<div class="section dashboard-breadcrumb-section bg-dark">
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <h2>Ajout de Commerce</h2>
        <ol class="breadcrumb">
			<li><a href="index.html">Accueil</a></li>
          <li class="active">Ajout</li>
        </ol>
      </div>
    </div>
  </div>
</div>


<!-- DASHBOARD ORDERS SECTION -->
<section class="clearfix bg-dark listingSection" id="listing-add-edit">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<form action="" method="POST" class="listing__form" enctype="multipart/form-data">
					<div class="dashboardBoxBg mb30">
						<div class="profileIntro paraMargin">
							<h3>A Propos</h3>
							<p>Fiche de renseignements.</p>
							<div class="row">
								<div class="form-group col-sm-6 col-xs-12">
									<label for="listingTitle">Nom du magasin</label>
                   <input class="form-control" id="listingTitle" type="text" placeholder="Nom de votre boutique" id="nom" name="nom" value="<?php if(isset($nom)) { echo $nom; } ?>" />
								</div>
								<div class="form-group col-xs-12">
									<label for="discribeTheListing">Description</label>
                  <input size="30" class="form-control" rows="3" type="text" placeholder="Décrivez vos services" id="description" name="description" value="<?php if(isset($description)) { echo $description; } ?>" />
								</div>
								<div class="form-group col-xs-12">
									<label for="addTags">Tags</label>
									<input type="text" class="form-control" id="addTags" placeholder="Tags">
								</div>
							</div>
						</div>
					</div>
					<div class="dashboardBoxBg mb30">
						<div class="profileIntro paraMargin">
							<h3>Contact</h3>
							<p>La fiche de contact vous permettra d'être contacter par des potentiels clients.</p>
							<div class="row">
								<div class="form-group col-sm-6 col-xs-12">
									<label for="listingWebsite">URL du site</label>
                  <input type="text"  class="form-control" id="listingWebsite" placeholder="http://" id="site_internet" name="site_internet" value="<?php if(isset($site_internet)) { echo $site_internet; } ?>" />
								</div>
								<div class="form-group col-sm-6 col-xs-12">
									<label for="listingAddress">Adresse</label>
                  <input type="text" class="form-control" placeholder="Localisation" id="listingAddress" name="adresse" value="<?php if(isset($adresse)) { echo $adresse; } ?>" />
								</div>

								<div class="form-group col-sm-6 col-sm-push-6 col-xs-12">
									<div class="mapArea clearfix">
										<div id="map-add-edit"></div>
										<span class="help-block">Entrez l'adresse ou cliquer sur la map <strong>Location: <span id="location">(..., ...)</span> </strong></span>
									</div>
								</div>

								<div class="form-group col-sm-6 col-sm-pull-6 col-xs-12">
									<label for="listingPhone">Téléphone</label>
                  <input type="text"  class="form-control" id="listingPhone" placeholder="00.00.00.00.00" id="numero_telephone" name="numero_telephone" value="<?php if(isset($numero_telephone)) { echo $numero_telephone; } ?>" />
								</div>
					
								<div class="form-group col-sm-6 col-sm-pull-6 col-xs-12">
									<label for="listingEmail">Email</label>
                  <input type="email" class="form-control" placeholder="test@exemple.fr" id="mail_user" name="mail_user" value="<?php if(isset($mail_user)) { echo $mail_user; } ?>" />
								</div>

								<div class="form-group col-sm-6 col-sm-pull-6 col-xs-12">
									<label for="password">Mot de passe</label>
                  <input type="password" class="form-control" placeholder="Votre mot de passe" id="mdp" name="mdp" />
								</div>

								<div class="form-group col-sm-6 col-sm-pull-6 col-xs-12">
									<label for="password">Confirmation Mot de passe</label>
                  <input type="password" class="form-control" placeholder="Confirmez votre mdp" id="mdp2" name="mdp2" />
								</div>
							</div>
						</div>
					</div>
					<div class="dashboardBoxBg mb30">
						<div class="profileIntro paraMargin">
							<h3>Image</h3>
							<p>Nous vous conseillons de mettre une image de la devanture de votre magasin ou de l'intérieur afin de faciliter l'accès aux clients.</p>
							<div class="row">
								<div class="form-group col-xs-12">
									<div class="imageUploader text-center">
										<div class="file-upload">
											<div class="upload-area">
												<input type="file" name="img[]" class="file">
                       <!-- <button class="browse" type="file" id="avatar" name="avatar">Image de couverture </button> -->
                        <input  type="file" id="avatar" name="avatar"></input> 

											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="dashboardBoxBg mb30">
						<div class="profileIntro paraMargin">
							<h3>Heures d'ouverture</h3>
							<p>Exemple: 10.00 - 17.00</p>
							<div class="row">
								<div class="form-group col-md-4 col-sm-6 col-xs-12">
									<label for="fridayTime">En semaine</label>
                  <input type="text" class="form-control" placeholder="09h00 - 20h00" id="heure_semaine" name="heure_semaine" value="<?php if(isset($heure_semaine)) { echo $heure_semaine; } ?>" />
								</div>

								<div class="form-group col-md-4 col-sm-6 col-xs-12">
									<label for="saturdayTime">Samedi</label>
                  <input type="text" class="form-control"  placeholder="09h00 - 20h00" id="heure_samedi" name="heure_samedi" value="<?php if(isset($heure_samedi)) { echo $heure_samedi; } ?>" />
								</div>

								<div class="form-group col-md-4 col-sm-6 col-xs-12">
									<label for="sundayTime">Dimanche</label>
                  <input type="text" class="form-control" placeholder="09h00 - 20h00" id="heure_dimanche" name="heure_dimanche" value="<?php if(isset($heure_dimanche)) { echo $heure_dimanche; } ?>" />
								</div>


							</div>
						</div>
					</div>


          <div class="dashboardBoxBg mb30">
            <div class="profileIntro paraMargin">

              <h3>Marque(s) pris en chage</h3>
              <tr>
                  <td align="right">
                      
                      <?php


                      


                      try
                        {
                            $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;


                         
                          $subjectName = $bdd->query('SELECT id_nom FROM marque');

 
                          while ($data = $subjectName->fetch())
                           {
                               //On affiche l'id et le nom du client en cours
                               echo "<input type='checkbox' name='marque[]' id='test' value='{$data['id_nom']}'>" . $data['id_nom'] . '</br>';


                           }




                           $subjectName->closeCursor();
                           }
                           catch(Exception $e)
                           {
                               die('Erreur : '.$e->getMessage());
                           }

                           //if(isset($_POST['checkbox'])) {


                        while ($data = $subjectName->fetch()){
                           if (isset($_POST['marque'])){

                              foreach($data as $element){
                              echo $element . '<br />';
                           }

                           }

                        }

                           
                        //} 

                      
                         $agreg=false;
                        if(isset($_POST["forminscription"])) {

                           if(!empty($_POST["marque"])) {

                              foreach($_POST["marque"] as $marquee) {
                                 //echo '<p>'.$marquee.'</p>';
                                  $agreg=true;
                              }
                           }

                           else {

                           echo "aucune case cochée";
                            $agreg= false;
                           }

                        }

                                                                          
                          ?>



                  </td>
               </tr>

             </div>
           </div>

          <div class="dashboardBoxBg mb30">
            <div class="profileIntro paraMargin">

              <h3>Confirmation de sécurité</h3>
              <tr>
                  <td align="right">
                  </td>
                  <td>
                     <script src="https://www.google.com/recaptcha/api.js" async defer></script>
                     <div class="g-recaptcha" data-sitekey="6LcrVpYUAAAAADj8XZ-2v569vN6aSHA3VtKBwBGa"></div>
                     <br/>
                  </td>
               </tr>

             </div>
           </div>


					<div class="form-footer text-center">
             <input type="submit" class="btn-submit" name="forminscription" value="Je m'inscris" />
					</div>
				</form>
			</div>
		</div>
	</div>
</section>

<?php
         if(isset($msg)) {
            echo '<font>'.$msg."</font>";
         }
         ?>

    <!-- FOOTER -->
    <footer class="copyRightDashboard">
      <div class="container">
        <div class="row">
          <div class="col-xs-12">
            <p>SmartRepair @2019. </p>
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
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCUuEI5R2OBqsu1qj2iv2CnbznI0N-X6M4&libraries=places&callback=initAutocomplete"
  async defer></script>
  <!-- <script src="assets/plugins/map/js/markerclusterer.js"></script> -->
  <!-- <script src="assets/plugins/map/js/rich-marker.js"></script> -->
  <!-- <script src="assets/plugins/map/js/infobox_packed.js"></script> -->
  <script src="assets/js/map.js"></script>
  <script src="assets/js/app.js"></script>


</body>

</html>

