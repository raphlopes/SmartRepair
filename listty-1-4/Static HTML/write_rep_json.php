<?php
   	
   $myFile = "assets/js/listings.json";
   $arr_data = array(); // create empty array
   $bdd = new PDO('mysql:host=127.0.0.1;dbname=smartrepair', 'root', '');
   $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $sql="SELECT * FROM reparateur INNER JOIN adresse ON reparateur.id_adresse_ref=adresse.id_adresse";
      $stmt=$bdd->prepare($sql);
      $stmt->execute();
      $list=$stmt->fetchALL();
      $test=array();
      foreach($list as $value)
      {
      	echo $value['id_reparateur'];




  try
  {
	   //Get form data
	   $formdata = array(
	      "id"=> $value['id_reparateur'],
	      'description'=> $value['description'],
	      'title'=>$value['nom'],
	      'address'=> $value['adresse'],
	      'thumbnail'=> "reparateurs/avatars/".$value['avatar'],
	      'verified'=> false,
	      'category'=> $value['type'],
	      'likes'=> $value['note'] ,
	      'lat'=> $value['lat'],
	      'lng'=> $value['lng'],
	   );
	   if(empty($value['avatar'])){
	   	$formdata = array(
	      "id"=> $value['id_reparateur'],
	      'description'=> $value['description'],
	      'title'=>$value['nom'],
	      'address'=> $value['adresse'],
	      'thumbnail'=> "assets/img/smartrepair.jpg",
	      'verified'=> false,
	      'category'=> $value['type'],
	      'likes'=> $value['note'] ,
	      'lat'=> $value['lat'],
	      'lng'=> $value['lng'],
	   );
	   }
	  

	   //Get data from existing json file
	  // $jsondata = file_get_contents($myFile);

	   // converts json data into array
	  // $arr_data = json_decode($jsondata, true);

	   // Push user data to array
	 //  array_push($arr_data,$formdata);

       //Convert updated array to JSON
       array_push($test, $formdata);
	   
	   //write json data into data.json file
	   
	   // 
}catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
   }
	   

   }
   $jsondata = json_encode($test, JSON_PRETTY_PRINT);

   if(file_put_contents($myFile, $jsondata)) {
	        echo 'Data successfully saved';
	    }
	   else 
	        echo "error";
   

?>

