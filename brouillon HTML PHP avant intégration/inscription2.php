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

if(isset($_POST['forminscription'])) {

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
   $mail_user = htmlspecialchars($_POST['mail_user']);
   $mail_user_confirm = htmlspecialchars($_POST['mail_user_confirm']);
   $mdp = sha1($_POST['mdp']);
   $mdp2 = sha1($_POST['mdp2']);
   if(!empty($_POST['nom']) AND !empty($_POST['description']) AND !empty($_POST['site_internet']) AND !empty($_POST['numero_telephone']) AND !empty($_POST['mail_user']) AND !empty($_POST['mail_user_confirm']) AND !empty($_POST['mdp']) AND !empty($_POST['mdp2']) AND !empty($_POST['adresse'])) {

      $nomlength = strlen($nom);
      $descriptionlength = strlen($description);
      $site_internetlength = strlen($site_internet);
      $numero_telephonelength = strlen($numero_telephone);
      $adresselength = strlen($numero_telephone);



      if($nomlength <= 255) {
         if($descriptionlength <= 255) {
         if($site_internetlength <= 255) {
            if($adresselength <= 255){
         if($numero_telephonelength <= 255){

         if($mail_user == $mail_user_confirm) {
            if(filter_var($mail_user, FILTER_VALIDATE_EMAIL)) {
               $reqmail = $bdd->prepare("SELECT * FROM reparateur WHERE mail = ?");
               $reqmail->execute(array($mail_user));
               $mailexist = $reqmail->rowCount();
               if($mailexist == 0) {
                  if($mdp == $mdp2) {

                     if(1==1){


                     $data = GmapApi::geocodeAddress($_POST['adresse']);
                     //on affiche les différente infos
                     echo '<ul>';
                     foreach ($data as $key=>$value){
                         echo '<li>'.$key.' : '.$value.'</li>';
                     }
                     echo '</ul>';


                     $type="reparateur";
                  
                     try{


                     $insertmbr = $bdd->prepare("INSERT INTO adresse(adresse, type, lat, lng) VALUES(?, ?, ?, ?)");
                     //$insertmbr = $bdd->prepare("INSERT INTO adresse("caca", "caca", 1, 1)";
                     $insertmbr->execute(array($data['address'],$type, $data['lat'] ,$data['lat']));
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



                     $insertmbr = $bdd->prepare("INSERT INTO reparateur(nom, id_adresse_ref, description, moyen_paiement_cash, moyen_paiement_carte, moyen_paiement_cheque, note, site_internet, mail, mot_de_passe, numero_telephone) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                     $insertmbr->execute(array($nom, $adresse_info, $description, "1", "1", "1","0", $site_internet, $mail_user, $mdp, "0"));
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

               }else {
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
            $msg = "Veuillez confirmer votre e-mail";
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


<html>
   <head>
      <title>TUTO PHP</title>
      <meta charset="utf-8">
   </head>
   <body>
      <div align="center">
         <h2>Inscription compte utilsateur</h2>
         <br /><br />
         <form method="POST" action="">
            <table>
               <tr>
                  <td align="right">
                     <label for="nom">nom :</label>
                  </td>
                  <td>
                     <input type="text" placeholder="Votre nom" id="nom" name="nom" value="<?php if(isset($nom)) { echo $nom; } ?>" />
                  </td>
               </tr>
               <tr>
                  <td align="right">
                     <label for="description">description :</label>
                  </td>
                  <td>
                     <input type="text" placeholder="Votre description" id="description" name="description" value="<?php if(isset($description)) { echo $description; } ?>" />
                  </td>
               </tr>
               <tr>
                  <td align="right">
                     <label for="description">site internet :</label>
                  </td>
                  <td>
                     <input type="text" placeholder="Votre site" id="site_internet" name="site_internet" value="<?php if(isset($site_internet)) { echo $site_internet; } ?>" />
                  </td>
               </tr>
               <tr>
                  <td align="right">
                     <label for="description">Telephone :</label>
                  </td>
                  <td>
                     <input type="text" placeholder="Votre telephone" id="numero_telephone" name="numero_telephone" value="<?php if(isset($numero_telephone)) { echo $numero_telephone; } ?>" />
                  </td>
               </tr>

               <tr>
                  <td align="right">
                     <label for="adresse">adresse :</label>
                  </td>
                  <td>
                     <input type="text" placeholder="Votre adresse" id="adresse" name="adresse" value="<?php if(isset($adresse)) { echo $adresse; } ?>" />
                  </td>
               </tr>

               <tr>
                  <td align="right">
                     <label for="mail">Mail :</label>
                  </td>
                  <td>
                     <input type="email" placeholder="Votre mail" id="mail_user" name="mail_user" value="<?php if(isset($mail_user)) { echo $mail_user; } ?>" />
                  </td>
               </tr>
               <tr>
                  <td align="right">
                     <label for="mail2">Confirmation du mail :</label>
                  </td>
                  <td>
                     <input type="email" placeholder="Confirmez votre mail" id="mail_user_confirm" name="mail_user_confirm" value="<?php if(isset($mail_user_confirm)) { echo $mail_user_confirm; } ?>" />
                  </td>
               </tr>
               <tr>
                  <td align="right">
                     <label for="mdp">Mot de passe :</label>
                  </td>
                  <td>
                     <input type="password" placeholder="Votre mot de passe" id="mdp" name="mdp" />
                  </td>
               </tr>
               <tr>
                  <td align="right">
                     <label for="mdp2">Confirmation du mot de passe :</label>
                  </td>
                  <td>
                     <input type="password" placeholder="Confirmez votre mdp" id="mdp2" name="mdp2" />
                  </td>
               </tr>

               <tr>
                  <td align="right">
                     <label for="mdp2">Confirmation de la sécurité</label>
                  </td>
                  <td>
                     <script src="https://www.google.com/recaptcha/api.js" async defer></script>
                     <div class="g-recaptcha" data-sitekey="6LcrVpYUAAAAADj8XZ-2v569vN6aSHA3VtKBwBGa"></div>
                     <br/>
                  </td>
               </tr>
<tr>
 

 



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

                        /*

                        if(isset($_POST["forminscription"])) {

                           if(!empty($_POST["marque"]) {

                              foreach($_POST["marque"] as $marquee) {
                                 echo '<p>'.$marquee.'</p>';
                              }
                           }

                           else {

                           echo "cest la der";
                           }

                        }

                        */






                           echo "toto";

                        
                          //if (isset($_POST['marque']) && is_array($_POST['marque']))

                        






                           //$id_reparateur =$bdd->lastInsertID();
                           //echo $id_reparateur;


                 

                           while ($data = $subjectName->fetch())
                           {

                             echo  $data['id_nom']  ;

                     //$insertmbr = $bdd->prepare("INSERT INTO concordance_marque_reparateur(id_marque_ref, id_reparateur_ref ) VALUES(?, ?)");
                     $insertmbr = $bdd->prepare("INSERT INTO concordance_marque_reparateur( id_marque_ref, id_reparateur_ref) VALUES (?, ?)");
                     $insertmbr->execute(array($data['id_nom'],$id_reparateur));

                          // }

                           }
                                                                          
                          ?>




</tr>

               <tr>
                  <td></td>
                  <td align="center">
                     <br />
                     <input type="submit" name="forminscription" value="Je m'inscris" />
                  </td>
               </tr>
            </table>
         </form>
         <?php
         if(isset($msg)) {
            echo '<font>'.$msg."</font>";
         }
         ?>
      </div>
   </body>
</html>