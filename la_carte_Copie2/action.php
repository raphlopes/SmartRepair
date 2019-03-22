<?php 
	require 'magasin.php';
	$mag = new magasin;
	$mag->setId($_REQUEST['id']);
	$mag->setLat($_REQUEST['lat']);
	$mag->setLng($_REQUEST['lng']);
	$status = $mag->updateBoutiquesWithLatLng();
	if($status == true) {
		echo "Updated...";
	} else {
		echo "Failed...";
	}
 ?>