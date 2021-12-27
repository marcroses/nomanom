var JSON_Toponyms, JSON_Toponym_types;
var JSON_Toponym_status, JSON_Toponym_priority, JSON_Toponym_organization, JSON_Toponym_source;
var JSON_TOC;
var string_Toponyms;
var actionToponym;

function getToponyms(){
    var params = {
        "action": "getToponyms"
        , "language": language        
    };
    $.ajax({
        type: "POST",
        url: "administrador/crud.php",
        data: params
    }).done(function (data) {
        if (data.trim()!="-1") {
            string_Toponyms = data.trim();
            JSON_Toponyms = JSON.parse(data.trim());

            for (var i = 0; i < JSON_Toponyms.length; i++) {
                try {
                    feature = new ol.Feature({});
                    feature.id = JSON_Toponyms[i].id;
                    feature.id_named_place = JSON_Toponyms[i].id_named_place;
                    feature.spelling = JSON_Toponyms[i].spelling;
                    feature.author_id = JSON_Toponyms[i].author_id;
                    feature.username = JSON_Toponyms[i].username;
                    feature.color = JSON_Toponyms[i].color;
                    feature.id_type=JSON_Toponyms[i].local_type;
                    feature.ds_type=JSON_Toponyms[i].ds_type;

                    var coords3857 = new Array();
                    coords3857.push(JSON_Toponyms[i].longitude);
                    coords3857.push(JSON_Toponyms[i].latitude);
                    coords3857 = proj4('EPSG:4326', 'EPSG:3857', coords3857);

                    feature.longitud = coords3857[0];
                    feature.latitud = coords3857[1];
                    try {
                        //featureSeleccionada.getGeometry().setCoordinates(coordSelectFeature);
                        var point_geom = new ol.geom.Point(
                          [coords3857[0], coords3857[1]]
                        );
                        feature.setGeometry(point_geom);
                    } 
                    catch (err){ 
                    }


                    vectorSource.addFeature(feature);
                }
                catch (Err) {
                    var errMsg = Err.toString();
                }
            }

        }
        setToponym_type();       
        setToponym_status(); 
        setToponym_priority();
        setToponym_organization();
        setSearchEngine();
        if (users=="restricted") setToponym_source();
    })    
} 

function setToponym_type(){
    var params = {
        "action": "getToponym_type"
        , "language": language
    };
    $.ajax({
        type: "POST",
        url: "administrador/crud.php",
        data: params
    }).done(function (data) {
        if (data.trim()!="-1") {
            JSON_Toponym_types = JSON.parse(data.trim());
            $("#named_place_local_type_id").empty();
            var optgroup  ='';
            var lastSep = '';
            for (var i=0; i< JSON_Toponym_types.length; i++){
                if (lastSep != JSON_Toponym_types[i].type){
                    if (optgroup!=''){
                         optgroup += "</optgroup>" ;
                         $("#named_place_local_type_id").append(optgroup); 
                    }
                    optgroup = "<optgroup label='" + JSON_Toponym_types[i].type + "'>";
                    lastSep = JSON_Toponym_types[i].type;
                }
                optgroup += "<option value='" + JSON_Toponym_types[i].id + "'>" + JSON_Toponym_types[i].local_type + "</option>"                
            }
            if (optgroup!=''){
                optgroup += "</optgroup>" ;
                $("#named_place_local_type_id").append(optgroup); 
            }            
        }
    })    
} 

function setToponym_status(){
    var params = {
        "action": "getToponym_status"
    };
    $.ajax({
        type: "POST",
        url: "administrador/crud.php",
        data: params
    }).done(function (data) {
        if (data.trim()!="-1") {
            JSON_Toponym_status = JSON.parse(data.trim());
            $("#name_status_id").empty();
            var opt  ='';
            for (var i=0; i< JSON_Toponym_status.length; i++){
                opt = "<option value='" + JSON_Toponym_status[i].id + "'>" + JSON_Toponym_status[i].name + "</option>"                
                $("#name_status_id").append(opt);
            }
        }
    })    
} 


function setToponym_priority(){
    var params = {
        "action": "getToponym_priority"
    };
    $.ajax({
        type: "POST",
        url: "administrador/crud.php",
        data: params
    }).done(function (data) {
        if (data.trim()!="-1") {
            JSON_Toponym_priority = JSON.parse(data.trim());
            $("#priority_id").empty();
            var opt  ='';
            for (var i=0; i< JSON_Toponym_priority.length; i++){
                opt = "<option value='" + JSON_Toponym_priority[i].id + "'>" + JSON_Toponym_priority[i].name + "</option>"                
                $("#priority_id").append(opt);
            }
        }
    })    
} 



function setToponym_organization(){
    var params = {
        "action": "getToponym_organization"
    };
    $.ajax({
        type: "POST",
        url: "administrador/crud.php",
        data: params
    }).done(function (data) {
        if (data.trim()!="-1") {
            JSON_Toponym_organization = JSON.parse(data.trim());
            $("#competent_organization_id").empty();
            var opt  ='';
            for (var i=0; i< JSON_Toponym_organization.length; i++){
                opt = "<option value='" + JSON_Toponym_organization[i].id + "'>" + JSON_Toponym_organization[i].name + "</option>"                
                $("#competent_organization_id").append(opt);
            }
        }
    })    
} 


function setToponym_source(){
    var params = {
        "action": "getToponym_source"
    };
    $.ajax({
        type: "POST",
        url: "administrador/crud.php",
        data: params
    }).done(function (data) {
        if (data.trim()!="-1") {
            JSON_Toponym_source = JSON.parse(data.trim());
            $("#source_of_name_id").empty();
            var opt  ='';
            for (var i=0; i< JSON_Toponym_source.length; i++){
                opt = "<option value='" + JSON_Toponym_source[i].id + "'>" + JSON_Toponym_source[i].name + "</option>"                
                $("#source_of_name_id").append(opt);
            }
        }
    })    
} 


function addToponym(){
    
    $("#ModalLabel").text(arrayLang[currentLang]["mapFrm_lbl_15"]);
    $("#btnDeleteTopo").css("display","none");
    actionToponym = "insert";

    $("#btnUbicacio")[0].style.visibility="visible";
    $("#toponym_user")[0].style.visibility="hidden";

    for (var i=0; i<arrayEditableFields.length; i++){
        if (arrayEditableFields[i].editable==1){
            $("#" + arrayEditableFields[i].name )[0].disabled=false;
            $("#" + arrayEditableFields[i].name ).val("");
        }                    
    }     
    
    $("#spelling")[0].disabled=false;
    $("#named_place_local_type_id")[0].disabled=false;
    $("#longitude")[0].disabled=false;
    $("#latitude")[0].disabled=false;
    $("#longitude").val("");
    $("#latitude").val("");

    $("#modal1-foot")[0].style.visibility="visible";

    $('#ModalNomGeograficInfo').modal('show');   
} 

function personalTopo(){

    var params = {
        "action": "getFullToponyms"
        , "author_id": userId
        , "userIsAdmin": userIsAdmin
        , "language": language    
    };

    $.ajax({
        type: "POST",
        url: "administrador/crud.php",
        data: params
    }).done(function (data) {
        if (data.trim()!="-1") {
            $("#tableToponym").bootstrapTable({
                data: JSON.parse(data.trim()),
                pagination: true,
                sortable: true,
                search: true,
                icons: {
                    columns: 'fas fa-th-list',
                    export: 'fas fa-download'
                },
                buttonsClass: 'primary',
                exportTypes: ['excel'],
                tooltips: true,
                showColumns: true,
                showExport: true,
                exportOptions: {
                    fileName: 'topo'
                }
            });
        
            $("#ModalMeus").modal("show");
        
          
        }
        else{
            toastr.error(arrayLang[currentLang]["mapFrm_lbl_39"], "Error");
        }
    })   

}


function createTOC(){

    var params = {
        "action": "getTOC"
        , "language": language
    };
    $.ajax({
        type: "POST",
        url: "administrador/crud.php",
        data: params
    }).done(function (data) {
        if (data.trim()!="-1") {
            JSON_TOC = JSON.parse(data.trim());
            var last_Node_1="";
            var last_Node_2="";
            var last_Node_3="";
    
            var resultat = '<ul class="tc-ctl-lcat-branch" id="arbrePral">';
            resultat += '</ul>';
            $("#tc-content-topo").html(resultat);  
            
            for (var i=0;i <JSON_TOC.length; i++){
                var nodeAdded = '<li class="tc-ctl-lcat-node tc-ctl-lcat-leaf  tc-checked" data-layer-name="" data-layer-uid="' + i + '" id=""><span class="circleType1" style="height:5px;border: solid 0px;background-color:' + JSON_TOC[i].color + '; margin-left:30px; padding: 0px; padding-left: 15px;"></span><span class="tc-selectable"  id="TOC_' + JSON_TOC[i].id_tipus + '" style="margin-left: 10px;font-weight:100;">' + JSON_TOC[i].ds_tipus + '</span></li>';
                $("#arbrePral").append(nodeAdded);
            }

            last_Node_1="";
            for (var i=0;i <JSON_TOC.length; i++){
                if (JSON_TOC[i].id_tipus!=last_Node_1){
                    last_Node_1=JSON_TOC[i].id_tipus;
                    $('#cb_' + JSON_TOC[i].id_tipus).bootstrapToggle();
                    $('#cb_' + JSON_TOC[i].id_tipus).change(function() {
                        var node = $(this)[0].id.substring(3);
                        for (var j=0; j<$("#ul_node_" + node).children().length; j++){
                            if ($(this).prop('checked')==false){
                                $("#ul_node_" + node).children()[j].classList.remove("tc-checked");
                                for (var k=0; k<JSON_TOC.length; k++){
                                    if (JSON_TOC[k].id_tipus==node){
                                        JSON_TOC[k].visible=0;
                                        break;
                                    }
                                }
                            }
                            if ($(this).prop('checked')==true){
                                $("#ul_node_" + node).children()[j].classList.add("tc-checked");
                                for (var k=0; k<JSON_TOC.length; k++){
                                    if (JSON_TOC[k].id_tipus==node){
                                        JSON_TOC[k].visible=1;
                                        break;
                                    }
                                }
                            }
    
                        }
                        toponims.getSource().changed();
                    })
    
                }
            }

            $(".tc-ctl-lcat-node").click(function (e) { //onCollapseButtonClick
                e.target.blur();
                e.stopPropagation();
                const li = e.target;
                if (li.tagName === 'LI'){
                    if (!li.classList.contains(self.CLASS + '-leaf')) {
                        if (li.classList.contains("tc-collapsed")) {
                            li.classList.remove("tc-collapsed");
                        }
                        else {
                            li.classList.add("tc-collapsed");
                        }
                        const ul = li.querySelector('ul');
                        if (ul.classList.contains("tc-collapsed")) {
                            ul.classList.remove("tc-collapsed");
                        }
                        else {
                            ul.classList.add("tc-collapsed");
                        }
                    }
                }
    
                if (li.tagName === 'SPAN'){
                    try{
                        if (li.id.substring(0,4)=="TOC_"){
                            if (li.classList.contains('tc-selectable')) {
                                li.classList.remove("tc-selectable");
                                li.parentElement.classList.remove("tc-checked");
                                for (var i=0; JSON_TOC.length; i++){
                                    if (JSON_TOC[i].id_tipus==li.id.substring(4)){
                                        JSON_TOC[i].visible=0;
                                        break;
                                    }
                                }
                            }
                            else{
                                li.classList.add("tc-selectable");
                                li.parentElement.classList.add("tc-checked");
                                for (var i=0; JSON_TOC.length; i++){
                                    if (JSON_TOC[i].id_tipus==li.id.substring(4)){
                                        JSON_TOC[i].visible=1;
                                        break;
                                    }
                                }
                            }
                            toponims.getSource().changed();
                        }
    
                    }
                    catch(Err){
    
                    }
                }
            });

        }
    }) 

}


function saveToponym() {

    var spelling = $("#spelling").val();
    var named_place_local_type_id = $("#named_place_local_type_id option:selected").val();
    var longitude = $("#longitude").val();
    var latitude = $("#latitude").val();    


    var name_status_id = "";
    var source_of_name_id = "";
    var priority_id = "";
    var competent_organization_id = "";
    var observations = "";
    var minimum_scale_visibility = "";
    var maximum_scale_visibility = "";
    var beginLifespanVersion = "";
    var endLifespanVersion = "";

    for (var i=0; i<arrayEditableFields.length; i++){
        if (arrayEditableFields[i].editable==1){
            if (arrayEditableFields[i].name=="name_status_id") name_status_id = $("#name_status_id").val();
            if (arrayEditableFields[i].name=="source_of_name_id") {
                if (users=="public"){
                    source_of_name_id = $("#source_of_name_id").val();    
                }else{
                    source_of_name_id = $("#source_of_name_id option:selected").val();    
                }                
            }

            if (arrayEditableFields[i].name=="priority_id") priority_id = $("#priority_id").val();
            if (arrayEditableFields[i].name=="competent_organization_id") competent_organization_id = $("#competent_organization_id").val();
            if (arrayEditableFields[i].name=="observations") observations = $("#observations").val();
            
            if (arrayEditableFields[i].name=="minimum_scale_visibility") minimum_scale_visibility = $("#minimum_scale_visibility").val();
            if (arrayEditableFields[i].name=="maximum_scale_visibility") maximum_scale_visibility = $("#maximum_scale_visibility").val();
            
            if (arrayEditableFields[i].name=="beginLifespanVersion") beginLifespanVersion = $("#beginLifespanVersion").val();
            if (arrayEditableFields[i].name=="endLifespanVersion") endLifespanVersion = $("#endLifespanVersion").val();

        }                    
    } 

    // Revisem que no estiguin buits
    var totOk=true;
    if (spelling == "" || named_place_local_type_id == ""  || longitude == "" || latitude == "" ) {
        totOk = false;
    }

    for (var i=0; i<arrayEditableFields.length; i++){
        if (arrayEditableFields[i].editable==1) {
            if (($("#" + arrayEditableFields[i].name ).val()=="") || ($("#" + arrayEditableFields[i].name ).val()==null)){
                if ( (arrayEditableFields[i].name!="minimum_scale_visibility") &&  (arrayEditableFields[i].name!="maximum_scale_visibility") && (arrayEditableFields[i].name!="endLifespanVersion") && (arrayEditableFields[i].name!="observations") ) {
                    totOk = false;
                    break;
                }
            }
        } 
    } 

    if (totOk==false){
        toastr.error(arrayLang[currentLang]["mapFrm_lbl_37"], "Error");
    } else {
        var accio;
        var missMC;
        var missCC;
        var is;
        if (actionToponym == "update") {
            is = true;
            accio = "updateToponym";
            missMC = "El lloc s'ha actualitzat correctament";

        } 
        if (actionToponym == "insert") { 
            accio = "addToponym";
            featureSeleccionada = new ol.Feature({});
            missCC = "El lloc s'ha creat correctament";
            is = false;
        }

        $.ajax({
            url: 'administrador/crud.php',
            data: {
                action: accio
                , id: featureSeleccionada.id
                , spelling: spelling
                , named_place_local_type_id: named_place_local_type_id
                , source_of_name_id: source_of_name_id
                , name_status_id: name_status_id
                , priority_id: priority_id
                , competent_organization_id: competent_organization_id
                , observations: observations
                , minimum_scale_visibility: minimum_scale_visibility
                , maximum_scale_visibility: maximum_scale_visibility
                , beginLifespanVersion: beginLifespanVersion
                , endLifespanVersion: endLifespanVersion
                , longitude: longitude
                , latitude: latitude
                , author_id: userId
                //, imatge64: imatge64
                //, so64: so64
            },
            type: 'POST',
            success: function (data) {
                if (data.indexOf("Error") != -1) {
                    toastr.error("Error en la consulta: " + data, "Error");
                }
                else {

                    var newToponymData  = JSON.parse(data.trim());
                    
                    if (actionToponym == "insert") { 
                        featureSeleccionada = new ol.Feature({});
                    }

                    featureSeleccionada.id = newToponymData[0].id;
                    featureSeleccionada.id_named_place = newToponymData[0].id_named_place;
                    featureSeleccionada.spelling = newToponymData[0].spelling;
                    featureSeleccionada.author_id = newToponymData[0].author_id;;
                    featureSeleccionada.color = newToponymData[0].color;
                    featureSeleccionada.id_type=newToponymData[0].local_type;

                    var coords3857 = new Array();
                    coords3857.push(newToponymData[0].longitude);
                    coords3857.push(newToponymData[0].latitude);
                    coords3857 = proj4('EPSG:4326', 'EPSG:3857', coords3857);

                    featureSeleccionada.longitud = coords3857[0];
                    featureSeleccionada.latitud = coords3857[1];

                    try {
                        var point_geom = new ol.geom.Point(
                          [coords3857[0], coords3857[1]]
                        );
                        featureSeleccionada.setGeometry(point_geom);
                    } 
                    catch (err){ 
                    }      


                    if (actionToponym == "insert") {     
                        try {
                            vectorSource.addFeature(featureSeleccionada);
                        }
                        catch (err) {
                        }                        
                    }

                    toponims.getSource().changed();
                    $("#ModalNomGeograficInfo").modal("hide");

                }
            }
        });

    
    }
}



function deleteToponym() {
    
    accio = "deleteToponym";

    $.ajax({
        url: 'administrador/crud.php',
        data: {
            action: accio
            , id: featureSeleccionada.id
        },
        type: 'POST',
        success: function (data) {
            if (data.indexOf("Error") != -1) {
                toastr.error("Error en la consulta: " + data, "Error");
            }
            else {
                var params = {
                    "action": "getToponyms"
                    , "language": language        
                };
                $.ajax({
                    type: "POST",
                    url: "administrador/crud.php",
                    data: params
                }).done(function (data) {
                    if (data.trim()!="-1") {
                        string_Toponyms = data.trim();
                        JSON_Toponyms = JSON.parse(data.trim());

                        vectorSource.clear();
            
                        for (var i = 0; i < JSON_Toponyms.length; i++) {
                            try {
                                feature = new ol.Feature({});
                                feature.id = JSON_Toponyms[i].id;
                                feature.id_named_place = JSON_Toponyms[i].id_named_place;
                                feature.spelling = JSON_Toponyms[i].spelling;
                                feature.author_id = JSON_Toponyms[i].author_id;
                                feature.username = JSON_Toponyms[i].username;
                                feature.color = JSON_Toponyms[i].color;
                                feature.id_type=JSON_Toponyms[i].local_type;
                                feature.ds_type=JSON_Toponyms[i].ds_type;
            
                                var coords3857 = new Array();
                                coords3857.push(JSON_Toponyms[i].longitude);
                                coords3857.push(JSON_Toponyms[i].latitude);
                                coords3857 = proj4('EPSG:4326', 'EPSG:3857', coords3857);
            
                                feature.longitud = coords3857[0];
                                feature.latitud = coords3857[1];
                                try {
                                    //featureSeleccionada.getGeometry().setCoordinates(coordSelectFeature);
                                    var point_geom = new ol.geom.Point(
                                      [coords3857[0], coords3857[1]]
                                    );
                                    feature.setGeometry(point_geom);
                                } 
                                catch (err){ 
                                }
            
            
                                vectorSource.addFeature(feature);
                            }
                            catch (Err) {
                                var errMsg = Err.toString();
                            }
                        }
            
                    }
                })   




                $("#ModalNomGeograficInfo").modal("hide");
            }
        }
    });
    
}



function obrirDetallModal(feature) {
    $("#ModalLabel").text(arrayLang[currentLang]["mapFrm_lbl_16"]);
    $("#toponym_user")[0].style.visibility="visible";
    
    $("#spelling").val(feature.spelling);
    var coords4326 = new Array();
    coords4326.push(feature.longitud);
    coords4326.push(feature.latitud);
    coords4326 = proj4('EPSG:3857', 'EPSG:4326', coords4326);
    $("#longitude").val(coords4326[0].toFixed(6));
    $("#latitude").val(coords4326[1].toFixed(6));

    for (var i=0; i<arrayEditableFields.length; i++){
        if (arrayEditableFields[i].editable==1){
            $("#" + arrayEditableFields[i].name).val("");
        }                    
    }

    var params = {
        "action": "getSingleToponym"
        , "id": feature.id
    };
    $.ajax({
        type: "POST",
        url: "administrador/crud.php",
        data: params
    }).done(function (data) {
        if (data.trim()!="-1") {
            var JSON_Toponym_detail = JSON.parse(data.trim());
                $("#spelling").val(JSON_Toponym_detail[0].spelling);
                $("#named_place_local_type_id").val(JSON_Toponym_detail[0].named_place_local_type_id)

                for (var i=0; i<arrayEditableFields.length; i++){
                    if (arrayEditableFields[i].editable==1){
                        if (arrayEditableFields[i].name=="name_status_id") $("#name_status_id").val(JSON_Toponym_detail[0].name_status_id);
                        if (arrayEditableFields[i].name=="source_of_name_id") $("#source_of_name_id").val(JSON_Toponym_detail[0].source_of_name_id);
                        if (arrayEditableFields[i].name=="observations") $("#observations").val(JSON_Toponym_detail[0].observations);
                        if (arrayEditableFields[i].name=="competent_organization_id") $("#competent_organization_id").val(JSON_Toponym_detail[0].competent_organization_id);
                        if (arrayEditableFields[i].name=="minimum_scale_visibility") $("#minimum_scale_visibility").val(JSON_Toponym_detail[0].minimum_scale_visibility);
                        if (arrayEditableFields[i].name=="maximum_scale_visibility") $("#maximum_scale_visibility").val(JSON_Toponym_detail[0].maximum_scale_visibility);
                        if (arrayEditableFields[i].name=="priority_id") $("#priority_id").val(JSON_Toponym_detail[0].priority_id);
                        if (arrayEditableFields[i].name=="beginLifespanVersion") $("#beginLifespanVersion").val(JSON_Toponym_detail[0].beginLifespanVersion);
                        if (arrayEditableFields[i].name=="endLifespanVersion") $("#endLifespanVersion").val(JSON_Toponym_detail[0].endLifespanVersion);

                    }                    
                }                

                $("#toponym_user").html(arrayLang[currentLang]["mapFrm_lbl_30"] + '<strong>' + JSON_Toponym_detail[0].username + '</strong>');
            }
        }
    );
    $("#ModalNomGeograficInfo").modal("show");

}
