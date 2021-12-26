var currentBs, currentOv;
var currentAction;

function getBaseLayersSource(){
  var params = {
    "action": "getProjectBaseLayersInfo"
  };

  $.ajax({
      type: "POST",
      url: "crud.php",
      data: params
  }).done(function (data) {
      if (data.trim()!="-1") {
          JSON_baseLayers = JSON.parse(data.trim());
          var params = {
            "action": "getProjectBaseLayersSource"
        };            
        $.ajax({
            type: "POST",
            url: "crud.php",
            data: params
        }).done(function (data) {
            if (data.trim()!="-1") {
                JSON_baseLayersSource = JSON.parse(data.trim());
                initLayers();
            }
        })               
      }
  }) 

}

function getOverLayersSource(){
  var params = {
    "action": "getProjectOverLayersInfo"
  };

  $.ajax({
      type: "POST",
      url: "crud.php",
      data: params
  }).done(function (data) {
      if (data.trim()!="-1") {
          JSON_OverLayers = JSON.parse(data.trim());
          var params = {
            "action": "getProjectOverLayersSource"
        };            
        $.ajax({
            type: "POST",
            url: "crud.php",
            data: params
        }).done(function (data) {
            if (data.trim()!="-1") {
                JSON_OverLayersSource = JSON.parse(data.trim());
                initLayers2();
            }
        })               
      }
  }) 
}


function initLayers(){
  $('#listBL').empty()
    if (JSON_baseLayersSource!=null){
      for (var i=0; i < JSON_baseLayersSource.length; i++) {
        var checkLayer="";
        for (var j=0; j < JSON_baseLayers.length; j++) {
          if (JSON_baseLayers[j].base_layer_source_id == JSON_baseLayersSource[i].id){
            checkLayer = "checked";
            break;
          }
        }
        var item = '<a class="list-group-item">';
        item += '<table style="width:100%;">';
        item += ' <tbody><tr>';
        item += '   <td style="width:75px;"><div class="custom-control form-control-lg custom-checkbox">';
        item += '     <input type="checkbox" class="form-control" id="cbBs_' + JSON_baseLayersSource[i].id + '" style="height: 20px; top: 5px; position: relative; left: -5px;" ' + checkLayer + '>';
        item += '     </div></td>';        
        item += '   <td style="width:75px;"><img id="bsLayerImg_' + JSON_baseLayersSource[i].id + '" style="max-width:60px;max-height:60px;cursor:pointer;" onclick="showMap(\'base\',' + JSON_baseLayersSource[i].id + ')"></td>';
        item += '   <td><div style="padding:10px;">  <h5 class="list-group-item-heading">' + JSON_baseLayersSource[i].title + '</h5>  <span>' + JSON_baseLayersSource[i].type + '</span></div></td>';
        item += '   <td style="text-align:right;"><button type="button" class="btn btn-primary" style="background-color: #bbbbbb;border: 1px #999999 solid;" onclick="layerConfig(\'base\','+ JSON_baseLayersSource[i].id + ')"><i class="fa fa-cog"></i>&nbsp;</button></td>'
  /*
        <td style="text-align:right;width:250px;"><div><button type="button" class="btn btn-default" onclick="window.open('r1_2019.php?idJugador=1697&amp;full=true', '_blank')">Fitxa Inicial</button>&nbsp;&nbsp;</div></td>
        <td style="text-align:right;width:250px;"><div class="elimina" style="visibility:hidden;"><button type="button" class="btn btn-danger" onclick="esborrar = true;baixa(" 10105")"="">Donar de baixa</button>&nbsp;&nbsp;<button type="button" class="btn btn-danger" onclick="esborrar = true;eliminar(10105)">Eliminar</button></div></td>
  
  */
        item += ' </tr></tbody>';      
        item += '</table>';      
        item += '</a>';      
  
        $("#listBL").append(item);
      }
      getUrlTile();
      getOverLayersSource();

    }
  
}




function initLayers2(){
  $('#listOL').empty()
    if (JSON_OverLayersSource!=null){
      for (var i=0; i < JSON_OverLayersSource.length; i++) {
        var checkLayer="";
        for (var j=0; j < JSON_OverLayers.length; j++) {
          if (JSON_OverLayers[j].wms_id == JSON_OverLayersSource[i].id){
            checkLayer = "checked";
            break;
          }
        }
        var item = '<a class="list-group-item">';
        item += '<table style="width:100%;">';
        item += ' <tbody><tr>';
        item += '   <td style="width:75px;"><div class="custom-control form-control-lg custom-checkbox">';
        item += '     <input type="checkbox" class="form-control" id="cbOl_' + JSON_OverLayersSource[i].id + '" style="height: 20px; top: 5px; position: relative; left: -5px;" ' + checkLayer + '>';
        item += '     </div></td>';        
        item += '   <td style="width:75px;"><img id="bsLayerImg2_' + JSON_OverLayersSource[i].id + '" src="images/map.png" style="max-width:60px;max-height:60px;cursor:pointer;" onclick="showMap(\'overlay\',' + JSON_OverLayersSource[i].id + ')"></td>';
        item += '   <td><div style="padding:10px;">  <h5 class="list-group-item-heading">' + JSON_OverLayersSource[i].description + '</h5>  <span>' + JSON_OverLayersSource[i].url + '</span></div></td>';
        item += '   <td style="text-align:right;"><button type="button" class="btn btn-primary" style="background-color: #bbbbbb;border: 1px #999999 solid;" onclick="layerConfig(\'overlay\','+ JSON_OverLayersSource[i].id + ')"><i class="fa fa-cog"></i>&nbsp;</button></td>'
  /*
        <td style="text-align:right;width:250px;"><div><button type="button" class="btn btn-default" onclick="window.open('r1_2019.php?idJugador=1697&amp;full=true', '_blank')">Fitxa Inicial</button>&nbsp;&nbsp;</div></td>
        <td style="text-align:right;width:250px;"><div class="elimina" style="visibility:hidden;"><button type="button" class="btn btn-danger" onclick="esborrar = true;baixa(" 10105")"="">Donar de baixa</button>&nbsp;&nbsp;<button type="button" class="btn btn-danger" onclick="esborrar = true;eliminar(10105)">Eliminar</button></div></td>
  
  */
        item += ' </tr></tbody>';      
        item += '</table>';      
        item += '</a>';      
  
        $("#listOL").append(item);
      }
      //getUrlTile2();

    }
  
}

function showMap(mapType,id){
  if (mapType=='base'){
    for (var i=0; i < JSON_baseLayersSource.length; i++) {
      if (JSON_baseLayersSource[i].id == id){
        $("#mapTitle").text(JSON_baseLayersSource[i].title);
        break;
      }
    }  
  }
  if (mapType=='overlay'){
    for (var i=0; i < JSON_OverLayersSource.length; i++) {
      if (JSON_OverLayersSource[i].id == id){
        $("#mapTitle").text(JSON_OverLayersSource[i].description);
        break;
      }
    }  
  }

  if (map2==null){
    $('#map2').css("height",parseInt(altura-20) + "px");
    $('#mapModal').modal('show');
    initMapModal(mapType, id);
        
  }
  else{
    $('#mapModal').modal('show');
    var layerMapModal = setLayerMapModal(mapType, id);
    map2.removeLayer(map2.getLayers().getArray()[0]);
    map2.addLayer(layerMapModal);    
  }
  
}

function showMap2(id){

  for (var i=0; i < JSON_OverLayersSource.length; i++) {
    if (JSON_OverLayersSource[i].id == id){
      $("#mapTitle").text(JSON_OverLayersSource[i].name);
      break;
    }
  }  

  if (map2==null){
    $('#map2').css("height",parseInt(altura-20) + "px");
    $('#mapModal').modal('show');
    initMapModal2(id);
        
  }
  else{
    $('#mapModal').modal('show');
    var layerMapModal = setLayerMapModal2(id);
    map2.removeLayer(map2.getLayers().getArray()[0]);
    map2.addLayer(layerMapModal);    
  }
  
}

function layerConfig(mapType, id){
  if (mapType=='base'){
    currentBs = id;
    id=id-1;
    currentAction="saveBaseLayerSource";
    $('#layerConfigTitle').text(JSON_baseLayersSource[id].title);
    $('#frm_bs_title').val(JSON_baseLayersSource[id].title);
    $('#frm_bs_name').val(JSON_baseLayersSource[id].name);
    $('#frm_bs_url').val(JSON_baseLayersSource[id].url);
    $('#frm_bs_attribution').val(JSON_baseLayersSource[id].attribution);
    $('#frm_bs_format').val(JSON_baseLayersSource[id].format);
    $('#frm_bs_layerNames').val(JSON_baseLayersSource[id].layerNames);
    $('#frm_bs_matrixSet').val(JSON_baseLayersSource[id].matrixSet);
    $("#frm_bs_type").val(JSON_baseLayersSource[id].type).change();
    $('#layerConfigModal').modal('show');
    prepareInputLayers();
  }
  if (mapType=='overlay'){
    currentOv = id;
    id=id-1;
    currentAction="saveWMSSource";
    $('#layerOverlayConfigTitle').text(JSON_OverLayersSource[id].description);
    $('#frm_Overlay_title').val(JSON_OverLayersSource[id].description);
    $('#frm_Overlay_name').val(JSON_OverLayersSource[id].name);
    $('#frm_Overlay_url').val(JSON_OverLayersSource[id].url);
    $('#frm_Overlay_format').val(JSON_OverLayersSource[id].format);
    $('#frm_Overlay_layers').val(JSON_OverLayersSource[id].layers);
    $('#layerOverlayConfigModal').modal('show');
  }  
}

function prepareInputLayers(){
  $("#frm_bs_format").prop( "disabled", false );
  $("#frm_bs_layerNames").prop( "disabled", false );
  $("#frm_bs_matrixSet").prop( "disabled", false );

  if (($("#frm_bs_type").val()=="XYZ") || ($("#frm_bs_type").val()=="OSM")){
    $("#frm_bs_format").prop( "disabled", true );
    $("#frm_bs_layerNames").prop( "disabled", true );
    $("#frm_bs_matrixSet").prop( "disabled", true );
  }
  if ($("#frm_bs_type").val()=="WMS"){
    $("#frm_bs_matrixSet").prop( "disabled", true );
  }
}

function saveBaseLayerSource(){
  var params = {
    "action": currentAction
    , "id": currentBs
    , "frm_bs_title": $("#frm_bs_title").val()
    , "frm_bs_name": $('#frm_bs_name').val()
    , "frm_bs_url": $("#frm_bs_url").val()
    , "frm_bs_attribution": $("#frm_bs_attribution").val()
    , "frm_bs_layerNames": $("#frm_bs_layerNames").val()
    , "frm_bs_matrixSet": $("#frm_bs_matrixSet").val()
    , "frm_bs_type": $("#frm_bs_type").val()
    , "frm_bs_format": $("#frm_bs_format").val()
    };
    $.ajax({
        type: "POST",
        url: "crud.php",
        data: params
    }).done(function (data) {
        if (data.trim()=="ok") {
            toastr.success("Dades guardades", "Correcte!");
            $('#layerConfigModal').modal('hide');
            getBaseLayersSource();
        }
        else{
            toastr.error(data, "Error");
        }
    })   
}


function saveOverLayerSource(){
  var params = {
    "action": currentAction
    , "id": currentOv
    , "frm_Overlay_title": $("#frm_Overlay_title").val()
    , "frm_Overlay_name": $('#frm_Overlay_name').val()
    , "frm_Overlay_url": $("#frm_Overlay_url").val()
    , "frm_Overlay_layers": $("#frm_Overlay_layers").val()
    , "frm_Overlay_format": $("#frm_Overlay_format").val()
    };
    $.ajax({
        type: "POST",
        url: "crud.php",
        data: params
    }).done(function (data) {
        if (data.trim()=="ok") {
            toastr.success("Dades guardades", "Correcte!");
            $('#layerOverlayConfigModal').modal('hide');
            getOverLayersSource();
        }
        else{
            toastr.error(data, "Error");
        }
    })   
}


function addBaseLayer(){
  currentAction="insertBaseLayerSource";
  $('#layerConfigTitle').text("");
  $('#frm_bs_title').val("");
  $('#frm_bs_name').val("");
  $('#frm_bs_url').val("");
  $('#frm_bs_attribution').val("");
  $('#frm_bs_format').val("");
  $('#frm_bs_layerNames').val("");
  $('#frm_bs_matrixSet').val("");
  $("#frm_bs_type").val("OSM").change();
  $('#layerConfigTitle').text(arrayLang[currentLang]["frm_layerConfigTitle"]);  
  $('#layerConfigModal').modal('show');
  prepareInputLayers();  
  
}

function addOverlayLayer(){
  currentAction="insertWMSSource";
  $('#frm_Overlay_title').val("");
  $('#frm_Overlay_name').val("");
  $('#frm_Overlay_url').val("");
  $('#frm_Overlay_format').val("");
  $('#frm_Overlay_layers').val("");
  $('#layerOverlayConfigTitle').text(arrayLang[currentLang]["frm_OverlayerConfigTitle"]);  
  $('#layerOverlayConfigModal').modal('show');
}