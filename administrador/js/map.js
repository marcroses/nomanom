//================================================
//VARIABLES GLOBALS
//================================================
var map, map2;
var layerOSM, layerCarto, layerCartoDark, layerMapModal;

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




//================================================
//CONSTRUCTOR I EVENTS
//================================================

function initMap() {
    if (map==null)
    {
        setTimeout(function(){ 

            layerOSM = new ol.layer.Tile({
                title: 'OpenStreetMap',
                type: 'base',
                visible: false,
                source: new ol.source.OSM()
            }); 
            
            layerCarto = new ol.layer.Tile({ 
                title: 'Carto',
                type: 'base',
                visible: true,                
                source: new ol.source.XYZ({ 
                    url:'http://{1-4}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}.png',
                })
            })

            layerCartoDark = new ol.layer.Tile({ 
                title: 'Carto dark',
                type: 'base',
                visible: false,                
                source: new ol.source.XYZ({ 
                    url:'http://{1-4}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}.png',
                })
            });


            layerEsriImage = new ol.layer.Tile({ 
                title: 'Imatge ESRI',
                type: 'base',
                visible: false,                
                //opacity: 0.5,
                source: new ol.source.XYZ({ 
                    url:'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}'
                })
            });            

            var capesBaseLayer = new ol.layer.Group({
                title: 'Capes Base',
                layers: [
                    layerOSM, layerCarto, layerCartoDark, layerEsriImage
                ]
            });

            map = new ol.Map({
                target: 'map',
                layers: [
                    capesBaseLayer
                ],
                view: new ol.View({
                    center: [4.083, 39.952],
                    zoom: 4
                })
                , controls: new ol.control.defaults({
                    attribution: false,
                    zoom: true        
                }).extend([
                    new ol.control.ScaleLine()
                ])
            });

            //if (mapInitExtend!="") map.getView().fit(mapInitExtend, map.getSize());
            map.getView().setCenter([longitude, latitude]);
            map.getView().setZoom(zoom);

            var layerSwitcher = new ol.control.LayerSwitcher({
                tipLabel: 'Leyenda'
            });   
            
            //layerSwitcher.hidePanel()
            map.addControl(layerSwitcher);            


         }, 500);  


    }
}


function initMapModal(mapType, baseLayerIndex) {
    if (map2==null)
    {
        setTimeout(function(){ 

            var controls = [
                new ol.control.Attribution(),
                new ol.control.Zoom()
            ];            

            var layerMapModal = setLayerMapModal(mapType, baseLayerIndex);
            map2 = new ol.Map({
                target: 'map2Content',
                controls: controls, 
                layers: [layerMapModal],
                view: new ol.View({
                  center: ol.proj.fromLonLat([4, 40]),
                  zoom: 12
                })
              });

              if (longitude!=null){
                map2.getView().setCenter([longitude, latitude]);
                map2.getView().setZoom(zoom);     
              }

              /*
              var source = map2.getLayers().item(0).getSource()
              var tileUrlFunction = source.getTileUrlFunction()
              source.on('tileloadend', function (evt) {
                  console.log(evt.tile.getTileCoord());
                  console.log(tileUrlFunction(evt.tile.getTileCoord(), 1, ol.proj.get('EPSG:3857')));
              });              
              */

              var source = map2.getLayers().item(0).getSource()
              var view = map2.getView();

              /*
              if (mapType=='base')  const tileUrlFunction = source.getTileUrlFunction();
              map2.on('click', function(event) {
               const grid = source.getTileGrid();
               var coordArray= new Array();
               coordArray[0]=longitude;
               coordArray[1]=latitude;
               const tileCord = grid.getTileCoordForCoordAndZ(coordArray, view.getZoom());
               //console.log('clicked ', longitude, latitude);
               //console.log('tile z,x,y is:', tileCord[0],tileCord[1], tileCord[2]);
               console.log(tileUrlFunction(tileCord, 1, ol.proj.get('EPSG:3857')));
               
              });              
            */
         }, 500);  
    }
}

function setLayerMapModal(mapType, baseLayerIndex){
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
                });

                layerMapModal = new ol.layer.Image({
                    source: layerSource_source
                });
            }
        }          
    }    
   
    return layerMapModal
}

function getUrlTile(){
    for (var i=0; i < JSON_baseLayersSource.length; i++) {
        if (JSON_baseLayersSource[i].type!="WMS"){
            var layer = setLayerMapModal('base',JSON_baseLayersSource[i].id);
            var source = layer.getSource();
            const tileUrlFunction = source.getTileUrlFunction();
            const grid = source.getTileGrid();
            var coordArray= new Array();
            coordArray[0]=longitude;
            coordArray[1]=latitude;
            const tileCord = grid.getTileCoordForCoordAndZ(coordArray, zoom);
            console.log(tileUrlFunction(tileCord, 1, ol.proj.get('EPSG:3857')));
            $("#bsLayerImg_" + JSON_baseLayersSource[i].id)[0].src=tileUrlFunction(tileCord, 1, ol.proj.get('EPSG:3857'));
        }
        else{
            var x1=parseFloat(longitude-2500);
            var y1=parseFloat(latitude-2500);
            var x2=parseFloat(longitude)+2500;
            var y2=parseFloat(latitude)+2500;
            var url = JSON_baseLayersSource[i].url + "?request=getmap&service=wms&version=1.1.1&format=" + JSON_baseLayersSource[i].format + "&layers=" + JSON_baseLayersSource[i].layerNames + "&srs=EPSG:3857&height=256&width=256&bbox=" + x1 + "," + y1 + "," + x2 + "," + y2;
            $("#bsLayerImg_" + JSON_baseLayersSource[i].id)[0].src=url;
        }
    }    
}


function getUrlTile2(){
    for (var i=0; i < JSON_OverLayersSource.length; i++) {
            var x1=parseFloat(longitude-2500);
            var y1=parseFloat(latitude-2500);
            var x2=parseFloat(longitude)+2500;
            var y2=parseFloat(latitude)+2500;
            var url = JSON_OverLayersSource[i].url + "?request=getmap&service=wms&version=1.1.1&styles=&format=" + JSON_OverLayersSource[i].format + "&layers=" + JSON_OverLayersSource[i].layers + "&srs=EPSG:3857&height=256&width=256&bbox=" + x1 + "," + y1 + "," + x2 + "," + y2;
            $("#bsLayerImg2_" + JSON_OverLayersSource[i].id)[0].src=url;
    }    
}

