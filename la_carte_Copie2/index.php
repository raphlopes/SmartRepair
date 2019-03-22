<!DOCTYPE html>
<html>
<head>
	<title>Carte Smart-Repair</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="js/googlemap.js"></script>
	<style type="text/css">

			.container {
			height: 450px;
		}
		#map {
        height: 100%;
      }



      		#data, #allData {
			display: none;
		}
	</style>
</head>
<body>
	<div class="container">
		<center><h1>Carte SmartRepair</h1></center>
		<?php 
			require 'magasin.php';
			$mag = new magasin;
			$coll = $mag->getBoutiquesBlankLatLng();
			$coll = json_encode($coll, true);
			echo '<div id="data">' . $coll . '</div>';

			$allData = $mag->getAllBoutiques();

			$allData = json_encode($allData, true);
			echo '<div id="allData">' . $allData . '</div>';	
			echo $allData;
			echo "<br/>";


			$contenu_json = $allData;

			// Nom du fichier à créer
			$nom_du_fichier = 'listings.json';

			// Ouverture du fichier
			$fichier = fopen($nom_du_fichier, 'w+');

			// Ecriture dans le fichier
			fwrite($fichier, $contenu_json);

			// Fermeture du fichier
			fclose($fichier);


		 ?>
		<div id="map"></div>
	</div>
</body>
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCUuEI5R2OBqsu1qj2iv2CnbznI0N-X6M4&callback=loadMap">
</script>
</html>