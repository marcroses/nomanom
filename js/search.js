//https://nominatim.openstreetmap.org/search?q=[Tankstelle]&format=json&limit=50&viewbox=7.98435,49.40889,8.95440,48.77371&bounded=1
var resultatCerca;
var typingTimer;                //timer identifier
var doneTypingInterval = 500;  //time in ms, 5 second for example


function setSearchEngine(){
    //on keyup, start the countdown
    textCercador.on('keyup', function () {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(function() {if (textCercador.val().length>2) {cercador()}}, doneTypingInterval);
    });
    
    //on keydown, clear the countdown 
    textCercador.on('keydown', function () {
        clearTimeout(typingTimer);
    });
}
  

function cercador() {
    //textCercador.on('input', function (e) {
        if (textCercador.val().length>2){
            $("#lst_resultat").empty();

            if (JSON_Toponyms!=null){
                for (var i = 0; i < JSON_Toponyms.length; i++) {
                    try {
                        var pos = JSON_Toponyms[i].spelling.toUpperCase().indexOf(textCercador.val().trim().toUpperCase());
                        if (pos>-1){
                            var resultat =   JSON_Toponyms[i].spelling.substr(0, pos) + "<b>" + JSON_Toponyms[i].spelling.substr(pos, textCercador.val().trim().length) + "</b>" + JSON_Toponyms[i].spelling.substr(pos+textCercador.val().trim().length) + " <span style='color:#aaaaaa;'>(" + JSON_Toponyms[i].ds_type + ")</span>";
                            $("#lst_resultat").append('<li datarole="municipality" onclick=ubicaCerca(' + JSON_Toponyms[i].id + ',1)><a href="#" style="padding-left: 5px;"><span hidden="">' + JSON_Toponyms[i].spelling + '</span>' + resultat + '</a></li>');
                        }
    
                    }
                    catch (Err) {
                        var errMsg = Err.toString();
                    }
                }   
            }
         

            var bbox = map.getView().calculateExtent(map.getSize())
            var p1 = ol.proj.transform([bbox[0], bbox[1]],'EPSG:3857', 'EPSG:4326');
            var p2 = ol.proj.transform([bbox[2], bbox[3]],'EPSG:3857', 'EPSG:4326');

            $.ajax({
                type: 'GET',
                url: 'https://nominatim.openstreetmap.org/search?q=' + textCercador.val() + '&format=json&limit=50&bounded=1&viewbox=' + p1[0] + ',' + p2[1] + ',' + p2[0] + ',' + p1[1] + ',' ,
                success: function(response) {
                    resultatCerca = response;
                    for (var i = 0; i < resultatCerca.length; i++) {
                        try {
                            var pos = resultatCerca[i].display_name.toUpperCase().indexOf(textCercador.val().trim().toUpperCase());
                            var resultat =   resultatCerca[i].display_name.substr(0, pos) + "<b>" + resultatCerca[i].display_name.substr(pos, textCercador.val().trim().length) + "</b>" + resultatCerca[i].display_name.substr(pos+textCercador.val().trim().length) + " <span style='color:#aaaaaa;'>(" + resultatCerca[i].type + ")</span>";
                            $("#lst_resultat").append('<li datarole="town" onclick=ubicaCerca(' + resultatCerca[i].place_id + ',2)><a href="#" style="padding-left: 5px;"><span hidden="">' + resultatCerca[i].display_name + '</span>' + resultat + '</a></li>');

                        }
                        catch (Err) {
                            var errMsg = Err.toString();
                        }
                    }
                },
                error: function(xhr) { // if error occured
                },
                complete: function() {
                }
            });


            $("#lst_resultat")[0].style.visibility='visible';
            $('#lst_resultat').removeClass("tc-hidden");
        }
        else{
            $("#lst_resultat")[0].style.visibility='hidden';
        }
    
    //});
}


function ubicaCerca(id, origen){
    if (origen==1){
        for (var i=0; i<JSON_Toponyms.length; i++){
            if (JSON_Toponyms[i].id==parseInt(id)){
                var coords = ol.proj.transform([JSON_Toponyms[i].longitude, JSON_Toponyms[i].latitude], 'EPSG:4326',map.getView().fe.it);
                map.getView().setCenter(coords);
                map.getView().setZoom(19);   
                $('#lst_resultat').addClass("tc-hidden");
                break;
            }
        }
    }

    if (origen==2){
        for (var i=0; i<resultatCerca.length; i++){
            if (resultatCerca[i].place_id==parseInt(id)){
                var coords = ol.proj.transform([resultatCerca[i].lon, resultatCerca[i].lat], 'EPSG:4326',map.getView().fe.it);
                map.getView().setCenter(coords);
                map.getView().setZoom(19);   
                $('#lst_resultat').addClass("tc-hidden");
                break;
            }
        }
    }

        
}