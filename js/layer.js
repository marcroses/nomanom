function getBaseLayersSource(){
  var params = {
    "action": "getProjectBaseLayersInfo"
  };

  $.ajax({
      type: "POST",
      url: "administrador/crud.php",
      data: params
  }).done(function (data) {
      if (data.trim()!="-1") {
          JSON_baseLayers = JSON.parse(data.trim());
          var params = {
            "action": "getProjectBaseLayersSource"
        };            
        $.ajax({
            type: "POST",
            url: "administrador/crud.php",
            data: params
        }).done(function (data) {
            if (data.trim()!="-1") {
              JSON_baseLayersSource = JSON.parse(data.trim());
              for (var i=0; i < JSON_baseLayers.length; i++) {
                  for (var j=0; j < JSON_baseLayersSource.length; j++) {
                      if (JSON_baseLayersSource[j].id==JSON_baseLayers[i].base_layer_source_id){
                          var styleLi='';
                          var item='';
                          if (i==0){
                              styleLi = ' style="border: 2px ' + primaryColor + ' solid;border-radius:7px"';
                          }
                          item += '<li class="tc-ctl-bms-node" data-tc-layer-name="' + JSON_baseLayers[i].base_layer_source_id + '"' + styleLi + '>';
                          item += '    <label id="bsLayerImg_' + j + '"  style="background-image: url(&quot;//ide.cime.es/test/thumbnails/base_ref.png&quot;); cursor: pointer;">';
                          item += '        <input type="radio" name="bms" value="' + JSON_baseLayers[i].base_layer_source_id + '" onclick="setBaseLayerCustom(' + JSON_baseLayers[i].base_layer_source_id + ')"><span style="border-color: rgba(255, 0, 0, 0);">' + JSON_baseLayersSource[j].title + '</span>';
                          item += '    </label>';
                          item += '</li>'
                          $("#ulBaseLayers").append(item);
                          break;
                      }
                  }
              }                    
              getUrlTile();
              mapInit();
            }
        })               
      }
  }) 

}

function getWMSSource(){
  var params = {
    "action": "getProjectOverLayersInfo"
  };

  $.ajax({
      type: "POST",
      url: "administrador/crud.php",
      data: params
  }).done(function (data) {
      if (data.trim()!="-1") {
          JSON_OverLayers = JSON.parse(data.trim());
          var params = {
            "action": "getProjectOverLayersSource"
        };            
        $.ajax({
            type: "POST",
            url: "administrador/crud.php",
            data: params
        }).done(function (data) {
            if (data.trim()!="-1") {

              JSON_OverLayersSource = JSON.parse(data.trim());
              
              for (var i=0; i < JSON_OverLayers.length; i++) {
                  for (var j=0; j < JSON_OverLayersSource.length; j++) {
                      if (JSON_OverLayers[i].wms_id==JSON_OverLayersSource[j].id){

                          var item = '<a class="list-group-item" style="padding:5px;">';
                          item += '<table style="width:100%;">';
                          item += ' <tbody><tr>';
                          item += '   <td style="width:20px;"><div>';
                          item += '     <input type="checkbox" id="cbOv_' + JSON_OverLayersSource[j].id + '" style="cursor:pointer;" onchange="addWMSLayer(' + JSON_OverLayersSource[j].id + ',' + i + ')">';
                          item += '     </div></td>';        
                          item += '   <td><div style="padding:5px;">' + JSON_OverLayersSource[j].description + '</div></td>';
                          item += '   <td style="width:150px;text-align:center;"><input type="range" min="1" max="100" value="100" class="slider" id="transpRange_' + JSON_OverLayersSource[j].id + '" onchange="transparent(' + JSON_OverLayersSource[j].id + ')" style="width:80%;"></td>';
                          item += ' </tr></tbody>';      
                          item += '</table>';      
                          item += '</a>';  

                          $("#ulOverLayers").append(item);
                          break;
                      }
                  }
              } 
              $("#arbol").css("height",(JSON_OverLayers.length * 45) + "px")
              //getUrlTile();
              //mapInit();
            }
        })               
      }
  }) 

}