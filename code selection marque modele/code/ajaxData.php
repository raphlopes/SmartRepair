<?php
//Include database configuration file
include('dbConfig.php');

if(isset($_POST["marque_id"]) && !empty($_POST["marque_id"])){
    //Get all modele data
    $query = $db->query("SELECT * FROM modele WHERE marque_id = ".$_POST['marque_id']." ORDER BY modele_name ASC");
    
    //Count total number of rows
    $rowCount = $query->num_rows;
    
    //Display modeles list
    if($rowCount > 0){
        echo '<option value="">Select modele</option>';
        while($row = $query->fetch_assoc()){ 
            echo '<option value="'.$row['modele_id'].'">'.$row['modele_name'].'</option>';
        }
    }else{
        echo '<option value="">modele not available</option>';
    }
}

/*
if(isset($_POST["modele_id"]) && !empty($_POST["modele_id"])){
    //Get all city data
    $query = $db->query("SELECT * FROM cities WHERE modele_id = ".$_POST['modele_id']." AND status = 1 ORDER BY city_name ASC");
    
    //Count total number of rows
    $rowCount = $query->num_rows;
    
    //Display cities list
    if($rowCount > 0){
        echo '<option value="">Select city</option>';
        while($row = $query->fetch_assoc()){ 
            echo '<option value="'.$row['city_id'].'">'.$row['city_name'].'</option>';
        }
    }else{
        echo '<option value="">City not available</option>';
    }
}

*/

?>