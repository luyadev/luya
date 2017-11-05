<?php
use luya\admin\ngrest\aw\CallbackFormWidget;

?>

<h1>Maps</h1>

<?php $form = CallbackFormWidget::begin(['callback' => 'get-coordinates', 'buttonValue' => 'Verify', 'angularCallbackFunction' => 'function($response) {
    
    initMap($response.cords);

};']); ?>

<?= $form->field('address', 'Address:'); ?>
<?php $form::end(); ?>

<div id="map" style="height:800px; width:100%;"></div>


<script>
	function initMap(cords)
	{
		var map = new google.maps.Map(document.getElementById('map'), {
    	    zoom: 16,
    	    center: cords
	  	});

		var marker = new google.maps.Marker({
            position: cords,
            map: map,
            title: 'YOU!'
        });
	}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $mapsApiKey; ?>&signed_in=true"></script>
<?php /*

<div id="map" style="height:800px; width:100%;"></div>
<script>
function initMap() {

  var uluru = {lat: -25.363, lng: 131.044};

  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 4,
    center: uluru
  });

  var contentString = '<div id="content">'+
      '<div id="siteNotice">'+
      '</div>'+
      '<h1 id="firstHeading" class="firstHeading">Uluru</h1>'+
      '<div id="bodyContent">'+
      '<p><b>Uluru</b>, also referred to as <b>Ayers Rock</b>, is a large ' +
      'sandstone rock formation in the southern part of the '+
      'Northern Territory, central Australia. It lies 335&#160;km (208&#160;mi) '+
      'south west of the nearest large town, Alice Springs; 450&#160;km '+
      '(280&#160;mi) by road. Kata Tjuta and Uluru are the two major '+
      'features of the Uluru - Kata Tjuta National Park. Uluru is '+
      'sacred to the Pitjantjatjara and Yankunytjatjara, the '+
      'Aboriginal people of the area. It has many springs, waterholes, '+
      'rock caves and ancient paintings. Uluru is listed as a World '+
      'Heritage Site.</p>'+
      '<p>Attribution: Uluru, <a href="https://en.wikipedia.org/w/index.php?title=Uluru&oldid=297882194">'+
      'https://en.wikipedia.org/w/index.php?title=Uluru</a> '+
      '(last visited June 22, 2009).</p>'+
      '</div>'+
      '</div>';

  var infowindow = new google.maps.InfoWindow({
    content: contentString
  });

  var marker = new google.maps.Marker({
    position: uluru,
    map: map,
    title: 'Uluru (Ayers Rock)'
  });

  marker.addListener('click', function() {
    infowindow.open(map, marker);
  });

}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $mapsApiKey; ?>&signed_in=true&callback=initMap"></script>
*/ ?>