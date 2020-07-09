window.onload = function(){

    var get_url =  document.getElementById("map_custom");
    get_url = get_url.dataset.url
    api_url = "https://dx-api.thingpark.com/core/latest/api/baseStations?statistics=true&commercialDetails=true";

    var delete_url = "/gateway/delete/";

    var lat = 36.8189700;
    var lon = 10.1657900;
    var map = L.map('map_custom').setView([lat, lon], 11);
    var token_input = document.getElementById('token');
    var valid_button = document.getElementById('valid');


    valid_button.addEventListener("click", function(event){
        event.preventDefault();
        if (token_input.value == ""){
            alert("please enter your token")
        }
        else{
            window.location.href="http://127.0.0.1:8000/gateway/api/"+token_input.value;
        }

    });

    L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
                    
        // Il est toujours bien de laisser le lien vers la source des données
        attribution: 'données © <a href="//osm.org/copyright">OpenStreetMap</a>/ODbL - rendu <a href="//openstreetmap.fr">OSM France</a>',
        minZoom: 1,
        maxZoom: 20
    }).addTo(map);
    

    function fetch_data (){
    $.get( get_url, function( data ) {
        $('#hidden-table-info').DataTable({
            data: data,
            paging: true,
            columns: [
                {data:"id"},
                { data: "name" },
                { data: "lat" },
                { data: "lon" },
                { data: "lrrid" },
                { data: "state" },
            ]
        });
        /*
        $("#hidden-table-info td").on("click",function(){
            tmp_id = this.textContent;
            console.log(tmp_id.match(/^\d+$/g))
            if (tmp_id.match(/^\d+$/g)!=null){
                if (confirm("delete BSS ??")==true){
                    $.get(delete_url+tmp_id, function(data){
                        alert("deleted");
                        window.location.reload();
                    });
                }
                    
            }
        })
        */

        for( i in data ){
            button_action = "<Button class='btn btn-info' style='margin-top:0.5rem;' id='btn_info' data-toggle='popover' title='Popover title' data-content='And here's some amazing content. It's very engaging. Right?'> more actions </Button>"

            button_supp = "<Button class='btn btn-danger btn_supp '  style='margin-top:0.5rem;' id='btn_supp_"+data[i]['id']+"' onclick='supp("+data[i]['id']+")'><i class='fa fa-trash'></i> supprimer </Button>"
            marker = L.marker([data[i]['lat'], data[i]['lon']], {riseOnHover : true}).addTo(map) 
            marker.bindPopup(data[i]['name']+"<br>"+data[i]['state']+ "<br>"+ button_supp);
        }
      });
    }

    fetch_data();

    supp = function(id){
        if (confirm("delete BSS ??")==true){
            $.get(delete_url+id, function(data){
                alert("deleted");
                window.location.reload();
            });
        }
    }
}

