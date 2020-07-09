
window.onload = function(){

    var get_url =  document.getElementById("map_custom");
    get_url = get_url.dataset.url

    var date_search = "";

    var lat = 36.8189700;
    var lon = 10.1657900;
    var marker ;
    var total = 0;
    var tmp_total = 0;
    var actual_date = document.getElementById("actual_date");
    var number_dates = document.getElementById("number_dates");
    var previous_button = document.getElementById("previous");
    var next_button = document.getElementById("next");
    var date_button = document.getElementById("valid");
    var date_input = document.getElementById("date_picker");

    previous_button.disabled= true;
    next_button.disabled= true;

    $("#date_picker").flatpickr({});
    

    var cfg = {
        "radius": .02,
        "maxOpacity": .8,
        "scaleRadius": true,
        "useLocalExtrema": false,
        latField: 'lat',
        lngField: 'lng',
        valueField: 'count',
       
      };
      
      
    var heatmapLayer = new HeatmapOverlay(cfg);
    var map = L.map('map_custom').setView([lat, lon], 11);
    L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
                    
        // Il est toujours bien de laisser le lien vers la source des données
        attribution: 'données © <a href="//osm.org/copyright">OpenStreetMap</a>/ODbL - rendu <a href="//openstreetmap.fr">OSM France</a>',
        minZoom: 1,
        maxZoom: 20
    }).addTo(map);
    heatmapLayer.addTo(map);

    fetch_data();

    function fetch_data (){
    $.get( get_url, function( data) {
        total = Number(data[1]["total"]);
        tmp_total = total ;
        data = data[0];
        actual_date.textContent= data['Timestamp'];
        number_dates.textContent = total+" measures found in total";
        map.setView([data['Latitude'], data['Longitude']], 14);
        var testData = {
            data: [{lat: data["Latitude"], lng:data["Longitude"], count: 2}]
          };

          marker = L.marker([data['Latitude'], data['Longitude']], {riseOnHover : true}).addTo(map) 
          marker.bindPopup("id: "+ data['bestlrrid']+"<br> uplink"+data['uplink']+"<br> distance : "+data['Distance']).openPopup();

          heatmapLayer.setData(testData); 

          if (total >0)
            previous_button.disabled= false;
          
      });
    }

    function fetch_data_second(){
        tmp_get_url = "";
        if (get_url.search("date")!=-1){
            tmp_get_url = get_url+date_search+"&index=";
        }
        else{
            tmp_get_url = get_url+"?index=";
        }
        $.get( tmp_get_url+(total-tmp_total), function( data) {
            
            data = data[0];
            console.log(data)
            actual_date.textContent= data['Timestamp'];
            var testData = {
                data: [{lat: data["Latitude"], lng:data["Longitude"], count: 2}]
              };
    
              marker.setLatLng([data['Latitude'], data['Longitude']]); 
              marker.bindPopup("id: "+ data['bestlrrid']+"<br> uplink"+data['uplink']+"<br> distance : "+data['Distance']).openPopup();
            
              heatmapLayer.setData(testData); 

          });
    }

    function fetch_data_third (){
        $.get( get_url+date_search, function( data) {
            total = Number(data[1]["total"]);
            tmp_total = total ;
            data = data[0];
            actual_date.textContent= data['Timestamp'];
            number_dates.textContent = total+" measures found in total";
            map.setView([data['Latitude'], data['Longitude']], 14);
            var testData = {
                data: [{lat: data["Latitude"], lng:data["Longitude"], count: 2}]
              };
    
              marker = L.marker([data['Latitude'], data['Longitude']], {riseOnHover : true}).addTo(map) 
              marker.bindPopup("id: "+ data['bestlrrid']+"<br> uplink"+data['uplink']+"<br> distance : "+data['Distance']).openPopup();
    
              heatmapLayer.setData(testData); 
    
              if (total >0)
                previous_button.disabled= false;
              
          })
        }
        

    date_button.addEventListener("click", function(event){
        event.preventDefault(); 
        previous_button.disabled= true;
        next_button.disabled=true;
        date_search = date_input.value;
        if (get_url.search("date")==-1){
            get_url = get_url+="?date=";
        }
        fetch_data_third();
    })

    previous_button.addEventListener("click", function(){
        if (next_button.disabled = true)
            next_button.disabled = false;
        tmp_total -= 1 ;
        fetch_data_second();
        
        if (tmp_total == 0){
            previous_button.disabled = true;
        }
        
        
        
    })

    next_button.addEventListener("click", function(){
        if (previous_button.disabled = true)
            previous_button.disabled = false;
        tmp_total += 1 ;
        
        fetch_data_second();
        
        if (tmp_total == total){
            next_button.disabled = true;
        }
        
        
    })


}

