//================================================
//VARIABLES GLOBALS
//================================================
    var textCercador,
        map,
        feature,
        featureClick,
        tipusLocalArray = [],
        select,
        jsonResponse,
        feature,
        llistatNomsGeografics,
        llistatEstatus,
        llistatFonts,
        llistatPrioritat,
        novaUbicacio = false,
        currentScale = 1;

    var longitude, latitude, zoom;     
    var TOC = new Array();   

    var featureSeleccionada;
    var coordSelectFeature;
    var percent = 1
    var idInterval;
    var JSON_baseLayersSource, JSON_baseLayers;
    var JSON_OverLayersSource, JSON_OverLayers;
    

    proj4.defs('EPSG:25831', '+proj=utm +zone=31 +ellps=GRS80 +units=m +no_defs');
    ol.proj.proj4.register(proj4);

    const projection = ol.proj.get('EPSG:3857');
    const projectionExtent = projection.getExtent();
    const size = ol.extent.getWidth(projectionExtent) / 256;
    const resolutions = new Array(20);
    const matrixIds = new Array(20);
    var matrixId="";
    for (let z = 0; z < 20; ++z) {
         resolutions[z] = size / Math.pow(2, z);
         matrixIds[z] = matrixId + z;
    }
    const tileGrid = new ol.tilegrid.WMTS({
        origin: ol.extent.getTopLeft(projectionExtent),
        resolutions: resolutions,
        matrixIds: matrixIds
    });

    const dims = {
        a2: [594, 420],
        a3: [420, 297],
        a4: [297, 210]
      };

//================================================
//CAPES
//================================================

var vectorSource = new ol.source.Vector({});

var cluster = new ol.source.Cluster({
    distance: 20,
    source: vectorSource
});

var toponims = new ol.layer.Vector({
    title: 'Topònims'
    , source: cluster
    , visible: true
    , style: styleToponim
});


function styleToponim(feature) {
    if (!novaUbicacio) {
        var size = sizeF = feature.get('features').length;
        var style;

        var sizeF = size;
        for (var i = 0; i < size; i++) {
            var aux = feature.A.features[0];
            
            if (JSON_TOC.length>0){
                for (var j=0; j<JSON_TOC.length; j++){
                    if (JSON_TOC[j].id_tipus==aux.id_type){
                        if (JSON_TOC[j].visible==0) {
                            sizeF--;
                            break;
                        }
                    }
                }
            }
        }

        if (sizeF == 1) {
            var aux = feature.A.features[0];
            var colorFeature= aux.color
            if (JSON_TOC.length>0){
                for (var j=0; j<JSON_TOC.length; j++){
                    if (JSON_TOC[j].id_tipus==aux.id_type){
                        colorFeature = JSON_TOC[j].color;
                        if (JSON_TOC[j].visible==0) {
                            return false;
                        }
                        break;
                    }
                }
            }

            style = new ol.style.Style({
                text: new ol.style.Text({
                    text: "" + aux.spelling,
                    fill: new ol.style.Fill({ color: 'black' }),
                    font: '15px sans-serif',
                    stroke: new ol.style.Stroke({
                        color: '#fff',
                        width: 4
                    }),
                    offsetY: -15
                }),
                image: new ol.style.Circle({
                    radius: 6,
                    stroke: new ol.style.Stroke({
                        color: 'white',
                        width: 2
                    }),
                    fill: new ol.style.Fill({
                        color: colorFeature
                    })
                })
            });
        } else if (sizeF > 1) {
            style = new ol.style.Style({
                image: new ol.style.Circle({
                    radius: 15,
                    stroke: new ol.style.Stroke({
                        color: '#fff'
                    }),
                    fill: new ol.style.Fill({
                        color: '#3399CC'
                    })
                }),
                text: new ol.style.Text({
                    text: sizeF.toString(),
                    fill: new ol.style.Fill({
                        color: '#fff'
                    })
                })
            });
        }
        if (style == null) console.log("buit");
        return style;
    }
    return null;
}


//================================================
//CONSTRUCTOR I EVENTS
//================================================
function setLayerMap(mapType, baseLayerIndex){
    var layerMapModal;   
    if (mapType=='base') {
        for (var i=0; i < JSON_baseLayersSource.length; i++) {
            if (JSON_baseLayersSource[i].id == baseLayerIndex){
                //OSM
                if (JSON_baseLayersSource[i].type == "OSM"){
                    layerMapModal = new ol.layer.Tile({
                        source: new ol.source.OSM(),
                        attributions: JSON_baseLayersSource[i].attribution
                    })
                }
                //XYZ
                if (JSON_baseLayersSource[i].type == "XYZ"){
                    layerMapModal = new ol.layer.Tile({ 
                        title: JSON_baseLayersSource[i].title,
                        type: 'base',
                        source: new ol.source.XYZ({ 
                            url: JSON_baseLayersSource[i].url,
                            attributions: JSON_baseLayersSource[i].attribution
                            ,crossOrigin: "Anonymous"
                        })
                    });
                }
                //WMTS
                if (JSON_baseLayersSource[i].type == "WMTS"){
    
                    var layerSource_source = new ol.source.WMTS({
                        url: JSON_baseLayersSource[i].url,
                        layer: JSON_baseLayersSource[i].layerNames,
                        matrixSet: JSON_baseLayersSource[i].matrixSet,
                        format: JSON_baseLayersSource[i].format,
                        projection: projection,
                        tileGrid: tileGrid,
                        style: 'normal',
                        attributions: JSON_baseLayersSource[i].attribution
                        ,crossOrigin: "Anonymous"
                    });
                
                    if (JSON_baseLayersSource[i].matrixSet.substring(0,4).toUpperCase()=="EPSG"){
                        //matrixId =JSON_baseLayersSource[i].matrixSet + ":";
                    }
                    for (let z = 0; z < 20; ++z) {
                        resolutions[z] = size / Math.pow(2, z);
                        matrixIds[z] = matrixId + z;
                    }
    
                    layerMapModal = new ol.layer.Tile({
                       source: layerSource_source
                    });
                }
    
                //WMS
                if (JSON_baseLayersSource[i].type == "WMS"){
    
                    var layerSource_source = new ol.source.ImageWMS({
                        url: JSON_baseLayersSource[i].url,
                        params: {'LAYERS':JSON_baseLayersSource[i].layerNames},
                        format: JSON_baseLayersSource[i].format,
                        attributions: JSON_baseLayersSource[i].attribution
                        ,crossOrigin: "Anonymous"
                    });
    
                    layerMapModal = new ol.layer.Image({
                       source: layerSource_source
                    });
                }            
                break;
            }
        }  
    }
    if (mapType=='overlay') {
        for (var i=0; i < JSON_OverLayersSource.length; i++) {
            if (JSON_OverLayersSource[i].id == baseLayerIndex){
                var layerSource_source = new ol.source.ImageWMS({
                    url: JSON_OverLayersSource[i].url,
                    params: {'LAYERS':JSON_OverLayersSource[i].layers},
                    format: JSON_OverLayersSource[i].format,
                    transparent:true,
                    attributions: ''
                    ,crossOrigin: "Anonymous"
                });

                layerMapModal = new ol.layer.Image({
                    source: layerSource_source,
                    id: JSON_OverLayersSource[i].id
                });
            }
        }          
    }    
   
    return layerMapModal
}

function mapInit() {
    textCercador = $(".tc-ctl-search-txt");

    var layerMapModal = setLayerMap('base', 1);

    map = new ol.Map({
        target: 'map',
        layers: [
            layerMapModal, toponims
        ],
        view: new ol.View({
            center: [4.083, 39.952],
            zoom: 4
        })
        , controls: new ol.control.defaults({
            attribution: false,
            zoom: false        
        }).extend([
            new ol.control.ScaleLine(),
            /*
            new ol.control.MousePosition({
                coordinateFormat: ol.coordinate.createStringXY(0),
                projection: 'EPSG:25831',
                className: 'custom-mouse-position',
                target: document.getElementById('mouse-position'),
                undefinedHTML: '&nbsp;'
            })
            */
        ])
    });

    map.getView().setCenter([longitude, latitude]);
    map.getView().setZoom(zoom);    

    map.on('pointermove', function (evt) {
        // When user was dragging map, then coordinates didn't change and there's
        // no need to continue
        if (evt.dragging) {
            return;
        }
        var coords = ol.proj.transform([evt.coordinate[0], evt.coordinate[1]], 'EPSG:3857', $("#crs").val());
        var x = coords[0].toFixed(0);
        var y = coords[1].toFixed(0);
        if ($("#crs").val() == "EPSG:4326") {
            var x = coords[0].toFixed(5);
            var y = coords[1].toFixed(5);
        }
        $(".tc-ctl-coords-x").html(x)
        $(".tc-ctl-coords-y").html(y)
        // You can access coordinates from evt.coordinate now
    });

    map.on('singleclick', function (evt) {
        if (novaUbicacio) {
            novaUbicacio = false;
            var coordConvertides = proj4('EPSG:3857', 'EPSG:4326', evt.coordinate);
            coordSelectFeature = evt.coordinate;

            $("#longitude").val(coordConvertides[0].toFixed(6));
            $("#latitude").val(coordConvertides[1].toFixed(6));
            toponims.setVisible(true);
            $("#ModalNomGeograficInfo").modal("show");
        }
    });    

    select = new ol.interaction.Select({});
    map.addInteraction(select);

    select.on('select', function (e) {

        var feature = e.selected[0];
        featureClick = feature;
        if (feature) {
            if (feature.A.features.length == 1) {
                featureSeleccionada = feature.A.features[0];

                $("#spelling")[0].disabled=true;
                $("#named_place_local_type_id")[0].disabled=true;
                $("#longitude")[0].disabled=true;
                $("#latitude")[0].disabled=true;

                for (var i=0; i<arrayEditableFields.length; i++){
                    if (arrayEditableFields[i].editable==1){
                        $("#" + arrayEditableFields[i].name)[0].disabled=true;
                    }
                    
                }                

                $("#modal1-foot")[0].style.visibility="hidden";
                $("#btnUbicacio")[0].style.visibility="hidden";
                

                if ((featureSeleccionada.author_id==userId) || (userIsAdmin==1)){
                    
                    $("#modal1-foot")[0].style.visibility="visible";
                    $("#btnUbicacio")[0].style.visibility="visible";
                    $("#btnDeleteTopo").css("display","inline");

                    $("#spelling")[0].disabled=false;
                    $("#named_place_local_type_id")[0].disabled=false;
                    $("#longitude")[0].disabled=false;
                    $("#latitude")[0].disabled=false;

                    for (var i=0; i<arrayEditableFields.length; i++){
                        if (arrayEditableFields[i].editable==1){
                            $("#" + arrayEditableFields[i].name)[0].disabled=false;
                        }                    
                    }
                }                

                actionToponym = "update";
                obrirDetallModal(featureSeleccionada);
            }
            else {
                $("#filtreMultiples").empty();

                /*
                var opt  ='';
                for (var i=0; i< JSON_Toponym_status.length; i++){
                    opt = "<option value='" + JSON_Toponym_status[i].id + "'>" + JSON_Toponym_status[i].name + "</option>"                
                    $("#name_status_id").append(opt);
                }
                */

                for (var i=0; i<feature.A.features.length; i++){
                    $("#filtreMultiples").append('<option value="' + feature.A.features[i].id + '">' + feature.A.features[i].spelling + ' (' + feature.A.features[i].ds_type + ')</option>');
                }
                $("#ModalMultiples").modal("show");

            }
        }

    });    


    zooms();
    createTOC();
    getToponyms();    


    const exportButton = document.getElementById('export-pdf');

    exportButton.addEventListener(
      'click',
      function () {
        exportButton.disabled = true;
        document.body.style.cursor = 'progress';
    
        const format = document.getElementById('format').value;
        const resolution = document.getElementById('resolution').value;
        const dim = dims[format];
        const width = Math.round((dim[0] * resolution) / 25.4);
        const height = Math.round((dim[1] * resolution) / 25.4);
        const size = map.getSize();
        const viewResolution = map.getView().getResolution();
    
        map.once('rendercomplete', function () {
          const mapCanvas = document.createElement('canvas');
          mapCanvas.width = width;
          mapCanvas.height = height;
          const mapContext = mapCanvas.getContext('2d');
          Array.prototype.forEach.call(
            document.querySelectorAll('.ol-layer canvas'),
            function (canvas) {
              if (canvas.width > 0) {
                const opacity = canvas.parentNode.style.opacity;
                mapContext.globalAlpha = opacity === '' ? 1 : Number(opacity);
                const transform = canvas.style.transform;
                // Get the transform parameters from the style's transform matrix
                const matrix = transform
                  .match(/^matrix\(([^\(]*)\)$/)[1]
                  .split(',')
                  .map(Number);
                // Apply the transform to the export map context
                CanvasRenderingContext2D.prototype.setTransform.apply(
                  mapContext,
                  matrix
                );
                mapContext.drawImage(canvas, 0, 0);
              }
            }
          );
          const pdf = new jspdf.jsPDF('landscape', undefined, format);
          pdf.addImage(
            mapCanvas.toDataURL('image/jpeg'),
            'JPEG',
            0,
            0,
            dim[0],
            dim[1]
          );
          pdf.save('map.pdf');
          // Reset original map size
          map.setSize(size);
          map.getView().setResolution(viewResolution);
          exportButton.disabled = false;
          document.body.style.cursor = 'auto';
        });
    
        // Set print size
        const printSize = [width, height];
        map.setSize(printSize);
        const scaling = Math.min(width / size[0], height / size[1]);
        map.getView().setResolution(viewResolution / scaling);
      },
      false
    );
/*
    initCustomMap();
    */
}


function getUrlTile(){
    for (var i=0; i < JSON_baseLayersSource.length; i++) {
        if (JSON_baseLayersSource[i].type!="WMS"){
            var layer = setLayerMap('base',JSON_baseLayersSource[i].id);
            var source = layer.getSource();
            const tileUrlFunction = source.getTileUrlFunction();
            const grid = source.getTileGrid();
            var coordArray= new Array();
            coordArray[0]=longitude;
            coordArray[1]=latitude;
            const tileCord = grid.getTileCoordForCoordAndZ(coordArray, zoom);
            console.log(tileUrlFunction(tileCord, 1, ol.proj.get('EPSG:3857')));
            //$("#bsLayerImg_" + i)[0].src=tileUrlFunction(tileCord, 1, ol.proj.get('EPSG:3857'));
            $("#bsLayerImg_" + i).css('background-image', 'url(' + tileUrlFunction(tileCord, 1, ol.proj.get('EPSG:3857')) + ')');
        }
        else{
            var x1=parseFloat(longitude-2500);
            var y1=parseFloat(latitude-2500);
            var x2=parseFloat(longitude)+2500;
            var y2=parseFloat(latitude)+2500;
            var url = JSON_baseLayersSource[i].url + "?request=getmap&service=wms&version=1.1.1&format=" + JSON_baseLayersSource[i].format + "&layers=" + JSON_baseLayersSource[i].layerNames + "&srs=EPSG:3857&height=256&width=256&bbox=" + x1 + "," + y1 + "," + x2 + "," + y2;
            $("#bsLayerImg_" + i).css('background-image', 'url('  + url + ')');
        }
    }    
}

function setBaseLayerCustom(layer) {
    map.getLayers().removeAt(0);
    map.getLayers().insertAt(0, setLayerMap('base',layer));
    buildMark(layer);
}

function addWMSLayer(id, position){
    if($("#cbOv_" + id).prop('checked') == true){
        var layerMapModal = setLayerMap('overlay', id);
        map.getLayers().insertAt(map.getLayers().getArray().length-1, layerMapModal);
        //map.addLayer(layerMapModal);     
    }
    else{
        if (map.getLayers().getArray().length>1){
            for (var i=0; i<map.getLayers().getArray().length; i++){
                for (var j=0; j<JSON_OverLayersSource.length; j++){
                    try{
                        if (map.getLayers().getArray()[i].getSource().rc.LAYERS==JSON_OverLayersSource[j].layers){
                            if (map.getLayers().getArray()[i].getSource().Ii==JSON_OverLayersSource[j].url){
                                map.removeLayer(map.getLayers().getArray()[i]); 
                                break;
                            }
                        }
                    }
                    catch(Err){
                        var msg = Err.toString();
                    }
                }
        
            }
        }  
    }
}

function transparent(id){
    var layerMap = setLayerMap('overlay', id);
    //layerMap.setOpacity($("#transpRange_" + id).val()/100)
    for (var i=0; i<map.getLayers().getArray().length; i++){
        try{
            if (map.getLayers().getArray()[i].getProperties().id==id){
                map.getLayers().getArray()[i].setOpacity($("#transpRange_" + id).val()/100)
                break;
            }
        }
        catch(Err){}
    }
}


function zooms() {
/*
    map.getView().on('propertychange', function (e) {
        currentScale = getScale();
        $("#scale-numeric").html("1 : " + currentScale.toFixed(0));
    });

    */
    $("#btnZoomIn").click(function () {
        map.getView().setZoom(map.getView().getZoom() + 1);
    });

    $("#btnZoomOut").click(function () {
        map.getView().setZoom(map.getView().getZoom() + -1);
    });

    $("#btnZoomInit").click(function () {
        map.setView(
            new ol.View({
                center: [longitude, latitude],
                zoom: zoom
            })
        );
    });

};

function unselect() {
    select.getFeatures().clear();
}

function setLocation() {
    novaUbicacio = true;
    $("#ModalNomGeograficInfo").modal("hide");

    unselect();
    toponims.setVisible(false);
    toastr.warning(arrayLang[currentLang]["mapFrm_lbl_38"]);//toastr.info
}


function multiples(){

    for (var i =0; i< featureClick.A.features.length; i++){
        if (featureClick.A.features[i].id==$("#filtreMultiples").val()){
            featureSeleccionada =featureClick.A.features[i];

            $("#spelling")[0].disabled=true;
            $("#named_place_local_type_id")[0].disabled=true;
            $("#longitude")[0].disabled=true;
            $("#latitude")[0].disabled=true;

            for (var i=0; i<arrayEditableFields.length; i++){
                if (arrayEditableFields[i].editable==1){
                    $("#" + arrayEditableFields[i].name)[0].disabled=true;
                }
                
            }                

            $("#modal1-foot")[0].style.visibility="hidden";
            $("#btnUbicacio")[0].style.visibility="hidden";
            

            if ((featureSeleccionada.author_id==userId) || (userIsAdmin==1)){
                
                $("#modal1-foot")[0].style.visibility="visible";
                $("#btnUbicacio")[0].style.visibility="visible";

                $("#spelling")[0].disabled=false;
                $("#named_place_local_type_id")[0].disabled=false;
                $("#longitude")[0].disabled=false;
                $("#latitude")[0].disabled=false;

                for (var i=0; i<arrayEditableFields.length; i++){
                    if (arrayEditableFields[i].editable==1){
                        $("#" + arrayEditableFields[i].name)[0].disabled=false;
                    }                    
                }
            }                

            actionToponym = "update";
            obrirDetallModal(featureSeleccionada);
            break;
        }
    }
    $('#ModalMultiples').modal('hide');
}