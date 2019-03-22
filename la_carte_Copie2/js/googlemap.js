var map;
var geocoder;

function loadMap() {

	//

		      	//partie markers début


		//partie markers fin


		/*
		
		var myLatlng = new google.maps.LatLng(48.851835, 2.28716);
		

        map = new google.maps.Map(document.getElementById("map"), {
          center: {lat: -34.397, lng: 150.644},
          zoom: 13
        });

        

        var marker = new google.maps.Marker({
		    position: myLatlng,
		    title:"Ece Paris"
		});

		

		marker.setMap(map);
		
		*/
		

		map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: -34.397, lng: 150.644},
          zoom: 12
        });


        

        infoWindow = new google.maps.InfoWindow;

        // Try HTML5 geolocation.
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };

            infoWindow.setPosition(pos);
            infoWindow.setContent('Vous êtes ici');
            infoWindow.open(map);
            map.setCenter(pos);
          }, function() {
            handleLocationError(true, infoWindow, map.getCenter());
          });
        } else {
          // Browser doesn't support Geolocation
          handleLocationError(false, infoWindow, map.getCenter());
        }


       
        
       /* 
       var myLatlng = new google.maps.LatLng(48.851835, 2.28716);
		

        map = new google.maps.Map(document.getElementById("map"), {
          center: {lat: -34.397, lng: 150.644},
          zoom: 13
        });

        

        var marker = new google.maps.Marker({
		    position: myLatlng,
		    title:"Moi"
		});

		

		marker.setMap(map);

		*/

		

	//



    var cdata = JSON.parse(document.getElementById('data').innerHTML);
    geocoder = new google.maps.Geocoder();  
    codeAddress(cdata);

    var allData = JSON.parse(document.getElementById('allData').innerHTML);
    showAllBoutiques(allData)
}

function showAllBoutiques(allData) {
	var infoWind = new google.maps.InfoWindow;
	Array.prototype.forEach.call(allData, function(data){
		var content = document.createElement('div');
		var strong = document.createElement('strong');
		var strong1 = document.createElement('strong');

		
		strong.textContent = data.name + " - " ;
		content.appendChild(strong);

		strong1.textContent = data.address;
		content.appendChild(strong1);




		var img = document.createElement('img');
		img.src = 'img/reparation.png';
		img.style.width = '100px';
		//content.appendChild(img);



		var marker = new google.maps.Marker({
	      position: new google.maps.LatLng(data.lat, data.lng),
	      map: map
	    });




	    marker.addListener('mouseover', function(){
	    	infoWind.setContent(content);
	    	infoWind.open(map, marker);
	    	//infoWind.close(map, marker);

	    })



	    
	})
}


function codeAddress(cdata) {
   Array.prototype.forEach.call(cdata, function(data){
    	var address = data.name + ' ' + data.address;
	    geocoder.geocode( { 'address': address}, function(results, status) {
	      if (status == 'OK') {
	        map.setCenter(results[0].geometry.location);
	        var points = {};
	        points.id = data.id;
	        points.lat = map.getCenter().lat();
	        points.lng = map.getCenter().lng();
	        updateBoutiqueWithLatLng(points);
	      } else {
	        alert('Geocode was not successful for the following reason: ' + status);
	      }
	    });
	});
}



function updateBoutiquesWithLatLng(points) {
	$.ajax({
		url:"action.php",
		method:"post",
		data: points,
		success: function(res) {
			console.log(res)
		}
	})
	
}