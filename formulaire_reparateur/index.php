
<?php
class GmapApi {

    private static $apikey = 'AIzaSyCUuEI5R2OBqsu1qj2iv2CnbznI0N-X6M4';

    public static function geocodeAddress($address) {
        //valeurs vide par défaut
        $data = array('address' => '', 'lat' => '', 'lng' => '', 'city' => '', 'department' => '', 'region' => '', 'country' => '', 'postal_code' => '');
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
                if ($component->types[0] == 'locality') {
                    $data['city'] = $component->long_name;
                }
                //départment
                if ($component->types[0] == 'administrative_area_level_2') {
                    $data['department'] = $component->long_name;
                }
                //région
                if ($component->types[0] == 'administrative_area_level_1') {
                    $data['region'] = $component->long_name;
                }
                //pays
                if ($component->types[0] == 'country') {
                    $data['country'] = $component->long_name;
                }
                //code postal
                if ($component->types[0] == 'postal_code') {
                    $data['postal_code'] = $component->long_name;
                }
            }
        }
        return $data;
    }

}

?>









<?php
$bdd = new PDO('mysql:host=127.0.0.1;dbname=reparateur', 'root', '');

if(isset($_POST['forminscription'])) {
   $nom = htmlspecialchars($_POST['nom']);
   $adresse = htmlspecialchars($_POST['adresse']);
   

   if(!empty($_POST['nom']) AND !empty($_POST['adresse'])) {
      $nomlength = strlen($nom);
      $adresselength = strlen($adresse);
      if($nomlength <= 255) {
         if($adresselength <= 255) {
         
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
                                 Bonjour '.$_POST['nom']. ' '.$_POST['adresse']. ' nous sommes heureux de vous accueillir au sein de la communauté SmartRepair. <br /><br />
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




               $data = GmapApi::geocodeAddress($_POST['adresse']);
               //on affiche les différente infos
               echo '<ul>';
               foreach ($data as $key=>$value){
                   echo '<li>'.$key.' : '.$value.'</li>';
               }
               echo '</ul>';
            


               /* va afficher
               address : 151 Avenue du Pont-Trinquat, 34000 Montpellier, France
               lat : 43.6008177
               lng : 3.8873392
               city : Montpellier
               department : Hérault
               region : Occitanie
               country : France
               postal_code : 34000
               */

               $type="reparateur";

               $insertmbr = $bdd->prepare("INSERT INTO boutiques(name, address, type, lat, lng) VALUES(?, ?, ?, ?, ?)");
                     //$insertmbr->execute(array("toto", "toto", "toto", "48.859798","48.859798");
                     $insertmbr->execute(array($nom, $data['address'], $type, $data['lat'],$data['lng']));
                     $msg = "Vous avez bien été enregistré. Un email de confirmation vous a été envoyé ! <a href=\"connexion.php\">Se connecter</a>";


               

                  
      } else {
         $msg = "Le nombre de caractère pour votre prénom a été dépassé";
      }

   } else {
         $msg = "Le nombre de caractère pour votre prénom a été dépassé";
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
                     <label for="adresse">adresse :</label>
                  </td>
                  <td>
                     <input type="text" placeholder="Votre adresse" id="adresse" name="adresse" value="<?php if(isset($adresse)) { echo $adresse; } ?>" />
                  </td>
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