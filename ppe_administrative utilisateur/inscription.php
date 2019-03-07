<?php
$bdd = new PDO('mysql:host=127.0.0.1;dbname=espace_membre', 'root', '');

if(isset($_POST['forminscription'])) {
   $nom = htmlspecialchars($_POST['nom']);
   $prenom = htmlspecialchars($_POST['prenom']);
   $mail_user = htmlspecialchars($_POST['mail_user']);
   $mail_user_confirm = htmlspecialchars($_POST['mail_user_confirm']);
   $mdp = sha1($_POST['mdp']);
   $mdp2 = sha1($_POST['mdp2']);
   if(!empty($_POST['nom']) AND !empty($_POST['prenom']) AND !empty($_POST['mail_user']) AND !empty($_POST['mail_user_confirm']) AND !empty($_POST['mdp']) AND !empty($_POST['mdp2'])) {
      $nomlength = strlen($nom);
      $prenomlength = strlen($prenom);
      if($nomlength <= 255) {
         if($prenomlength <= 255) {
         if($mail_user == $mail_user_confirm) {
            if(filter_var($mail_user, FILTER_VALIDATE_EMAIL)) {
               $reqmail = $bdd->prepare("SELECT * FROM membres WHERE mail = ?");
               $reqmail->execute(array($mail_user));
               $mailexist = $reqmail->rowCount();
               if($mailexist == 0) {
                  if($mdp == $mdp2) {
                     $insertmbr = $bdd->prepare("INSERT INTO membres(nom, prenom, mail, motdepasse) VALUES(?, ?, ?, ?)");
                     $insertmbr->execute(array($nom, $prenom, $mail_user, $mdp));
                     $msg = "Vous avez bien été enregistré. Un email de confirmation vous a été envoyé ! <a href=\"connexion.php\">Se connecter</a>";

                  
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
                                 Bonjour '.$_POST['nom']. ' '.$_POST['prenom']. ' nous sommes heureux de vous accueillir au sein de la communauté SmartRepair. <br /><br />
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
                     <label for="prenom">prenom :</label>
                  </td>
                  <td>
                     <input type="text" placeholder="Votre prenom" id="prenom" name="prenom" value="<?php if(isset($prenom)) { echo $prenom; } ?>" />
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