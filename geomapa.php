<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="/assets/css/map2.css">
<script src="https://unpkg.com/@googlemaps/markerclusterer/dist/index.min.js"></script>

</head>
<body>
<div id='demo'></div>

<!--The div element for the map -->
<div id="map"></div>
<script>
var x=document.getElementById("demo");
// ciudad de mexico
var latit = '19.426773';
var longit = '-99.133421';


function getLocation()
  {
  if (navigator.geolocation)
    {
      //navigator.geolocation.getCurrentPosition(showPosition);
    }
  else{x.innerHTML="O seu navegador não suporta Geolocalização.";}
  }
function showPosition(position)
  {
    latit = position.coords.latitude; 
    longit = position.coords.longitude;
  }
  getLocation();
  

  //alert('lat:'+latit+'\nlong:'+longit);
// Initialize and add the map
function initMap() {
  // The location of Uluru
  const myLatLng = { lat: 19.426773, lng: -99.133421 };
  // map options
  const mapOptions = {
    zoom: 10,
    center: myLatLng
  };
  // The map, centered at Uluru
  const map = new google.maps.Map(document.getElementById("map"), mapOptions);

  // calculo valor total comissão = total / margem_requerida

  // HTML MAP
  const contentString = 
    '<div id="content">' +
    '<div id="siteNotice">' +
    "</div>" +
    '<h1 id="firstHeading" class="firstHeading">GNOG 1</h1>' +
    '<div id="bodyContent">' +
    "<p><b>TESTING GNOG</b>, blablabla <b>blabla</b>, blablabla " +
    "sandstone rock formation in the southern part of the " +
    "Northern Territory, central Australia. It lies 335&#160;km (208&#160;mi) " +
    "south west of the nearest large town, Alice Springs; 450&#160;km " +
    "(280&#160;mi) by road. Kata Tjuta and Uluru are the two major " +
    "features of the Uluru - Kata Tjuta National Park. Uluru is " +
    "sacred to the Pitjantjatjara and Yankunytjatjara, the " +
    "Aboriginal people of the area. It has many springs, waterholes, " +
    "rock caves and ancient paintings. Uluru is listed as a World " +
    "Heritage Site.</p>" +
    '<p>Attribution: Uluru, <a href="https://en.wikipedia.org/w/index.php?title=Uluru&oldid=297882194">' +
    "https://en.wikipedia.org/w/index.php?title=Uluru</a> " +
    "(last visited June 22, 2009).</p>" +
    "</div>" +
    "</div>";
    

  const image = "/public/billboards/utils/cartelera.png";

  labels = ['Teste1','Teste2','Mais','Outro','Aquele','Copia'];
  // The markers
  const markers = locations.map((position, i) => {
    const label = labels[i];
    const marker = new google.maps.Marker({
      position,
      label,
      icon: image,
    });

    const infowindow = new google.maps.InfoWindow({
      content: locations.description,
      ariaLabel: "Gnog Label - Cartelera",
    });

    //marker.setMap(map);
    // markers open info window when marker is clicked

    google.maps.event.addListener(marker, "click", () => {
      infowindow.setContent(position.description);
      infowindow.open(map, marker);
    });
    return marker;
  });

  //MarkerClusterer({ map, markers });

  // Add a marker clusterer to manage the markers
  const markerCluster = new markerClusterer.MarkerClusterer({map, markers});
}

const locations = [
  {lat: 19.426773, lng: -99.133421, 
    description: '<div id="content">' +
    '<div id="siteNotice">' +
    "</div>" +
    '<h1 id="firstHeading" class="firstHeading">GNOG 1</h1>' +
    '<div id="bodyContent">' +
    "<p><b>TESTING GNOG</b>, blablabla <b>blabla</b>, blablabla " +
    "sandstone rock formation in the southern part of the " +
    "Northern Territory, central Australia. It lies 335&#160;km (208&#160;mi) " +
    "south west of the nearest large town, Alice Springs; 450&#160;km " +
    "(280&#160;mi) by road. Kata Tjuta and Uluru are the two major " +
    "features of the Uluru - Kata Tjuta National Park. Uluru is " +
    "sacred to the Pitjantjatjara and Yankunytjatjara, the " +
    "Aboriginal people of the area. It has many springs, waterholes, " +
    "rock caves and ancient paintings. Uluru is listed as a World " +
    "Heritage Site.</p>" +
    '<p>Attribution: Uluru, <a href="https://en.wikipedia.org/w/index.php?title=Uluru&oldid=297882194">' +
    "https://en.wikipedia.org/w/index.php?title=Uluru</a> " +
    "(last visited June 22, 2009).</p>" +
    "</div>" +
    "</div>"},
  {lat: 19.426173, lng: -99.133411, 
    description: '<div id="content">' +
    '<div id="siteNotice">' +
    "</div>" +
    '<h1 id="firstHeading" class="firstHeading">GNOG 2</h1>' +
    '<div id="bodyContent">' +
    "<p><b>TESTING GNOG</b>, blablabla <b>blabla</b>, blablabla " +
    "sandstone rock formation in the southern part of the " +
    "Northern Territory, central Australia. It lies 335&#160;km (208&#160;mi) " +
    "south west of the nearest large town, Alice Springs; 450&#160;km " +
    "(280&#160;mi) by road. Kata Tjuta and Uluru are the two major " +
    "features of the Uluru - Kata Tjuta National Park. Uluru is " +
    "sacred to the Pitjantjatjara and Yankunytjatjara, the " +
    "Aboriginal people of the area. It has many springs, waterholes, " +
    "rock caves and ancient paintings. Uluru is listed as a World " +
    "Heritage Site.</p>" +
    '<p>Attribution: Uluru, <a href="https://en.wikipedia.org/w/index.php?title=Uluru&oldid=297882194">' +
    "https://en.wikipedia.org/w/index.php?title=Uluru</a> " +
    "(last visited June 22, 2009).</p>" +
    "</div>" +
    "</div>"},
  {lat: 19.423773, lng: -99.132421, 
    description: '<div id="content">' +
    '<div id="siteNotice">' +
    "</div>" +
    '<h1 id="firstHeading" class="firstHeading">GNOG 3</h1>' +
    '<div id="bodyContent">' +
    "<p><b>TESTING GNOG</b>, blablabla <b>blabla</b>, blablabla " +
    "sandstone rock formation in the southern part of the " +
    "Northern Territory, central Australia. It lies 335&#160;km (208&#160;mi) " +
    "south west of the nearest large town, Alice Springs; 450&#160;km " +
    "(280&#160;mi) by road. Kata Tjuta and Uluru are the two major " +
    "features of the Uluru - Kata Tjuta National Park. Uluru is " +
    "sacred to the Pitjantjatjara and Yankunytjatjara, the " +
    "Aboriginal people of the area. It has many springs, waterholes, " +
    "rock caves and ancient paintings. Uluru is listed as a World " +
    "Heritage Site.</p>" +
    '<p>Attribution: Uluru, <a href="https://en.wikipedia.org/w/index.php?title=Uluru&oldid=297882194">' +
    "https://en.wikipedia.org/w/index.php?title=Uluru</a> " +
    "(last visited June 22, 2009).</p>" +
    "</div>" +
    "</div>"},
  {lat: 19.426753, lng: -99.133521, 
    description: '<div id="content">' +
    '<div id="siteNotice">' +
    "</div>" +
    '<h1 id="firstHeading" class="firstHeading">GNOG 4</h1>' +
    '<div id="bodyContent">' +
    "<p><b>TESTING GNOG</b>, blablabla <b>blabla</b>, blablabla " +
    "sandstone rock formation in the southern part of the " +
    "Northern Territory, central Australia. It lies 335&#160;km (208&#160;mi) " +
    "south west of the nearest large town, Alice Springs; 450&#160;km " +
    "(280&#160;mi) by road. Kata Tjuta and Uluru are the two major " +
    "features of the Uluru - Kata Tjuta National Park. Uluru is " +
    "sacred to the Pitjantjatjara and Yankunytjatjara, the " +
    "Aboriginal people of the area. It has many springs, waterholes, " +
    "rock caves and ancient paintings. Uluru is listed as a World " +
    "Heritage Site.</p>" +
    '<p>Attribution: Uluru, <a href="https://en.wikipedia.org/w/index.php?title=Uluru&oldid=297882194">' +
    "https://en.wikipedia.org/w/index.php?title=Uluru</a> " +
    "(last visited June 22, 2009).</p>" +
    "</div>" +
    "</div>"},
  {lat: 19.426795, lng: -99.133921, 
    description: '<div id="content">' +
    '<div id="siteNotice">' +
    "</div>" +
    '<h1 id="firstHeading" class="firstHeading">GNOG 5</h1>' +
    '<div id="bodyContent">' +
    "<p><b>TESTING GNOG</b>, blablabla <b>blabla</b>, blablabla " +
    "sandstone rock formation in the southern part of the " +
    "Northern Territory, central Australia. It lies 335&#160;km (208&#160;mi) " +
    "south west of the nearest large town, Alice Springs; 450&#160;km " +
    "(280&#160;mi) by road. Kata Tjuta and Uluru are the two major " +
    "features of the Uluru - Kata Tjuta National Park. Uluru is " +
    "sacred to the Pitjantjatjara and Yankunytjatjara, the " +
    "Aboriginal people of the area. It has many springs, waterholes, " +
    "rock caves and ancient paintings. Uluru is listed as a World " +
    "Heritage Site.</p>" +
    '<p>Attribution: Uluru, <a href="https://en.wikipedia.org/w/index.php?title=Uluru&oldid=297882194">' +
    "https://en.wikipedia.org/w/index.php?title=Uluru</a> " +
    "(last visited June 22, 2009).</p>" +
    "</div>" +
    "</div>"},
  {lat: 19.426793, lng: -99.133921, 
    description: '<div class="md-12" style="width:100%; display: flex;">'+
    '<div id="content" style="width:48%">' +
    '<div id="siteNotice">' +
    "</div>" +
    '<h1 id="firstHeading" class="firstHeading">GNOG 6</h1>' +
    '<div id="bodyContent">' +
    "<p><b>TESTING GNOG</b>, blablabla <b>blabla</b>, blablabla " +
    "sandstone rock formation in the southern part of the " +
    "Northern Territory, central Australia. It lies 335&#160;km (208&#160;mi) " +
    "south west of the nearest large town, Alice Springs; 450&#160;km " +
    "(280&#160;mi) by road. Kata Tjuta and Uluru are the two major " +
    "features of the Uluru - Kata Tjuta National Park. Uluru is " +
    "sacred to the Pitjantjatjara and Yankunytjatjara, the " +
    "Aboriginal people of the area. It has many springs, waterholes, " +
    "rock caves and ancient paintings. Uluru is listed as a World " +
    "Heritage Site.</p>" +
    '<p>Attribution: Uluru, <a href="https://en.wikipedia.org/w/index.php?title=Uluru&oldid=297882194">' +
    "https://en.wikipedia.org/w/index.php?title=Uluru</a> " +
    "(last visited June 22, 2009).</p>" +
    "</div>" +
    "</div>" + 
    "<div style='width:4%'>&nbsp;&nbsp;</div>"+
    '<div id="content" style="width:48%">' +
    '<div id="siteNotice">' +
    "</div>" +
    '<h1 id="firstHeading" class="firstHeading">GNOG 5</h1>' +
    '<div id="bodyContent">' +
    "<p><b>TESTING GNOG</b>, blablabla <b>blabla</b>, blablabla " +
    "sandstone rock formation in the southern part of the " +
    "Northern Territory, central Australia. It lies 335&#160;km (208&#160;mi) " +
    "south west of the nearest large town, Alice Springs; 450&#160;km " +
    "(280&#160;mi) by road. Kata Tjuta and Uluru are the two major " +
    "features of the Uluru - Kata Tjuta National Park. Uluru is " +
    "sacred to the Pitjantjatjara and Yankunytjatjara, the " +
    "Aboriginal people of the area. It has many springs, waterholes, " +
    "rock caves and ancient paintings. Uluru is listed as a World " +
    "Heritage Site.</p>" +
    '<p>Attribution: Uluru, <a href="https://en.wikipedia.org/w/index.php?title=Uluru&oldid=297882194">' +
    "https://en.wikipedia.org/w/index.php?title=Uluru</a> " +
    "(last visited June 22, 2009).</p>" +
    "</div>" +
    "</div>"+
    "</div>"},
]
/*
declare global {
  interface Window {
    initMap: () => void;
  }
}*/

initMap();

</script>
</body>
</html>

<script async
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAh0CRvF_GoQflq2OxsMeAk7GRN5ljY5fA&callback=initMap&v=weekly" defer>
</script>



