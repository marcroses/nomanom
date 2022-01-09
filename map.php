<?php
    require_once "connectdb.php";
    $sql = "select * from project";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $users = $row["users"];
            $language = $row["language"];
        }
    }   

    $sql = "select * from project_settings";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $captcha_web = $row["captcha_web"];
        }
    }   


    $sql = "select * from project_editable_fields";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $rowsEditable[] = $row;
        }
    }   

    $conn->close();     
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
<link rel="icon" href="administrador/images/favicon.png">
    <meta charset="UTF-8"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Nom a nom</title>
	  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <!-- ========================== -->
    <!--STYLES-->
    <!-- ========================== -->
    
    <!--Bootstrap-->
    <link rel="stylesheet" href="lib/bootstrap-4.3.1/css/bootstrap.min.css" />
    <!--toastr-->
    <link rel="stylesheet" href="lib/toastr/toastr.min.css" />
    <!--Font-awesome-->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- Ol6 -->
    <link rel="stylesheet" type="text/css" href="lib/ol6.9.0/ol.css" />
    <!-- SUMMER NOTE -->
    <link rel="stylesheet" type="text/css" href="lib/bootstrap-summernote/summernote-bs3.css">
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/codemirror.css">
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/theme/monokai.css">
    
    
    <!--custom-->
    <link rel="stylesheet" href="css/main.css" />
	<link type="text/css" rel="stylesheet" href="css/layout/tcmap.css" />
    <link type="text/css" rel="stylesheet" href="css/layout/style.css" />

    

    <!-- ========================== -->
    <!--JS-->
    <!-- ========================== -->

    <!--JQuery-->
    <script type="text/javascript" src="lib/jquery/jquery-2.2.4.min.js"></script>
    <script src="lib/popper/popper.min.js"></script>
    <!--Bootstrap-->    
    <script type="text/javascript" src="lib/bootstrap-4.3.1/js/bootstrap.min.js"></script>
    <!--Toastr-->    
    <script type="text/javascript" src="lib/toastr/toastr.min.js"></script>
    <script type="text/javascript" src="js/toastr_object.js"></script>
    <!--bootstrap-select-->    
    <script type="text/javascript" src="lib/bootstrap-select/bootstrap-select-1.13.9/dist/js/bootstrap-select.min.js"></script>
    <!--boostrap-table-->
    <script type="text/javascript" src="lib/bootstrap-table-master/dist/bootstrap-table.js"></script>
    <script type="text/javascript" src="lib/bootstrap-table-master/dist/extensions/export/bootstrap-table-export.js"></script>
    <!-- Proj4 -->
    <script type="text/javascript" src="lib/proj4/proj4.js"></script>    
    <!-- Ol5 -->
    <script type="text/javascript" src="lib/ol6.9.0/ol.js"></script>
    <!-- SUMMERNOTE -->
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/codemirror.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/mode/xml/xml.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/2.36.0/formatting.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/summernote/0.5.0/summernote.min.js"></script>     

    <link href="lib/bootstrap4-toggle-3.6.1/css/bootstrap4-toggle.css" rel="stylesheet">
    <script src="lib/bootstrap4-toggle-3.6.1/js/bootstrap4-toggle.js"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <!-- jspdf -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>



    <!--SITNA-->
    <script src="js/layout/layoutScript.js"></script>

    <!--bootstrap-table-->
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.14.2/dist/bootstrap-table.min.css">
    <script src="https://unpkg.com/bootstrap-table@1.14.2/dist/bootstrap-table.min.js"></script>
    <script src="lib/bootstrap-table/extensions/export/bootstrap-table-export.js"></script>
    <script src="lib/bootstrap-table/extensions/export/tableExport.js"></script>
    <script src="lib/bootstrap-table/extensions/toolbar/bootstrap-table-toolbar.js"></script>


    <script type="text/javascript" src="js/mapa.js"></script>
    <script type="text/javascript" src="js/tipusLocal.js"></script>
    <script type="text/javascript" src="js/project.js"></script>
    <script type="text/javascript" src="js/layer.js"></script>
    <script type="text/javascript" src="js/users.js"></script>
    <script type="text/javascript" src="js/toponym.js"></script>
    <script type="text/javascript" src="js/search.js"></script>

    <script>
        var msg='[{}]';
        /*
        var stringJsonMunicipis = JSON.parse('');
        var stringJsonNuclis = JSON.parse('');
        var stringJsonTipusGeografics = JSON.parse('');
        */
        var editor_id = '';
        var username = ''
        var users= '<?php echo $users;?>';
        var language= '<?php echo $language;?>';
        var arrayLang;
        var arrayEditableFields = new Array();
        <?php 
        for ($i=0; $i<count($rowsEditable); $i++){
            $cadena = substr($rowsEditable[$i]["name"],strrpos($rowsEditable[$i]["name"], ".")+1);
            echo 'var item = {name:"'.$cadena.'", editable:'.$rowsEditable[$i]["editable"].'};';
            echo 'arrayEditableFields.push(item);';
        }
        ?>

    </script>

</head>
<body>
    <div id="loader" name="loader" style="width:100%;height:100%;background-color: white;top:0px;position:absolute;opacity:0.9;visibility:hidden;z-index:9999;">
        <center>
            &nbsp;<br />&nbsp;<br />&nbsp;<br />&nbsp;<br />&nbsp;<br />&nbsp;<br />&nbsp;<br />&nbsp;<br />&nbsp;<br />&nbsp;<br />&nbsp;<br />&nbsp;<br />
            <img id="imgLoader" style="visibility:hidden;" src="images/ajax-loader.gif" />
            <div style="font-size:16px;color:#808080" id="lblMuni">Recuperant dades...</div>
            </p>
            <div class="progress" style="padding: 10px;  width:50%; box-sizing: initial;">
                <div class="progress-bar bg-success" style="width:0%">0%</div>
                </p>
            </div>            
        </center>
    </div>


	<div id="map" class="tc-map tc-lo">

        <div id="search" class="tc-ctl tc-ctl-search" style="box-sizing: content-box;"><h2>Búsqueda</h2>
            <div class="tc-ctl-search-content" >
                <input type="search" class="tc-ctl-search-txt" id="txtSearch1" placeholder="Cercador" title="Cercar topònims" autocomplete="true"><a id="btnSearch" title="Cercar" class="tc-ctl-btn tc-ctl-search-btn" style="border-color:#A8423D;background-color:#A8423D;"></a>
                <ul class="tc-ctl-search-list tc-hidden" id="lst_resultat"></ul>
            </div>
        </div>

        <section id="tools-panel" class="slide-panel right-panel tools-panel">
            <h1 id="tools-tab"></h1>
            <div class="panel-content">
                <section id="links" data-gn-i18n="">
                    <section class="language-links" style="padding:5px;text-align:left;">
                        <h3 style="color:#A8423D;margin:0px;padding:2px;font-weight:bold;"><img id="project_logo" style="max-width:50px; max-height:50px;"/><span id="lbl_project_name" style="position:relative; top: 4px; left: 10px;"></span></h3>
                            <div style="margin-top:5px;" id="divLoginUp">
                                    <table style="width:100%;">
                                        <tr>
                                            <td><span class="lang" key="mapFrm_lbl_1">Per a col·laborar, accedeix com a usuari</span></td>
                                            <td style="text-align:right;"><button type="button" id="btnLogInUp" class="btn btn-default" style="background-color: #A8423D; color: #fff;" aria-label="Left Align" onclick='$("#ModalLogin").modal("show")' title="Accedeix"><span class="fa fa-sign-in" aria-hidden="true"></span></button></td>
                                        </tr
                                    ></table>
                            </div>
                        </section>

                </section>

                <div id="bms" class="tc tc-ctl tc-ctl-bms tc-collapsed">
                    <h2><span class="lang" key="mapFrm_lbl_2">Capes de fons</span></h2>
                    <div class="tc-ctl-bms-tree">
                        <form>
                            <ul class="tc-ctl-bms-branch" id="ulBaseLayers">
    
                            </ul>
                        </form>
                    </div>
                </div>

                <div id="catalog" class="tc-ctl tc-ctl-lcat tc-collapsed">
                    <h2><span class="lang" key="mapFrm_lbl_3">Capes Sobreposades</span></h2>
                    <div class="tc-ctl-lcat-tree" id="arbol">
                        <ul class="list-group" id="ulOverLayers">
                                                                                    
                        </ul>

                    </div>                
                </div>         
                
                <div id="topoLeftPanel" class="tc-ctl tc-ctl-topo">
                    <h2><span class="lang" key="mapFrm_lbl_4">Topònims</span></h2>
                    <div class="tc-ctl-topo" id="tc-content-topo">
            
                    </div>                
                </div>             


            </div>
        </section>
        
        <div id="nav" class="tc-ctl tc-ctl-nav">
            <div class="ol-zoomslider ol-unselectable ol-control tc-ctl-nav-bar">
                <button type="button" class="ol-zoomslider-thumb ol-unselectable tc-ctl-btn tc-ctl-nav-btn tc-ctl-nav-slider" style="display: block;"></button>
            </div>
            <div class="ol-zoom ol-unselectable ol-control" style="background-color: rgba(255,255,255,0);top:0px;left:0px;padding:0px;opacity:0.9;">
                <button id="btnZoomIn" class="ol-zoom-in tc-ctl-btn tc-ctl-nav-btn tc-ctl-nav-btn-zoomin" type="button" title="Zoom apropar" style="display: block;background-color: rgba(0,0,0,0.9);"></button>
                <button id="btnZoomOut" class="ol-zoom-out tc-ctl-btn tc-ctl-nav-btn tc-ctl-nav-btn-zoomout" type="button" title="Zoom allunyar" style="display: block;background-color: rgba(0,0,0,0.9);"></button>
                <button id="btnZoomInit" type="button" title="Extensió inicial" class="tc-ctl-btn tc-ctl-nav-home-btn" style="display: block;background-color: rgba(0,0,0,0.9);"></button>
                <button id="btnPrint" type="button" title="Exportar a PDF" class="tc-ctl-btn tc-ctl-nav-pdf-btn" style="display: block;background-color: rgba(0,0,0,0.9);" onclick='$("#ModalPrint").modal("show")'></button>
                <button id="btnAdd" type="button" title="Afegir element" onclick="addToponym()" class="tc-ctl-btn tc-ctl-nav-add-btn" style="display: block;margin-top:10px;"></button>
            </div>

        </div>
        
        <div id="coordinates" class="tc-ctl tc-ctl-coords" style="visibility: visble;">
            <div>CRS: 
                <select name="crs" id="crs">
                    <option value="EPSG:25831">EPSG:25831</option>
                    <option value="EPSG:3857">EPSG:3857</option>
                    <option value="EPSG:4326">EPSG:4326</option>
                </select>
                <!--<span class="tc-ctl-coords-crs">EPSG:3857</span><button class="tc-ctl-coords-crs" title="Cambiar sistema de referencia de coordenadas">EPSG:3857</button>-->
            </div>
            <div class="tc-ctl-coords-xy">x: <span class="tc-ctl-coords-x">437.220</span> y: <span class="tc-ctl-coords-y">4.859.981</span> </div>
            <span class="close" style="display: none;"></span>
        </div>

        <div id="avisInicial" class="tc-ctl tc-ctl-coords" style="visibility:visble; color:#fff; width:425px;bottom:30px;left:5px;font-size:16px; background-color: rgba(168, 66, 61, 1); z-index:99999;position:absolute;opacity: 0.9;">
            <table style="width:100%;"><tr>
            <td style="cursor:pointer;" onclick='$("#ModalLogin").modal("show")'><img src="images/whiteMarker.png" style="max-height:30px;"/></td>
            <td style="cursor:pointer;" onclick='$("#ModalLogin").modal("show")'><span class="lang" key="mapFrm_lbl_1">Per a col·laborar, accedeix com a usuari</span></td>
            <td style="cursor:pointer;" onclick='$("#ModalLogin").modal("show")' style="cursor:pointer;text-align:right;"><button type="button" id="btnLoginDown" class="btn btn-default" style="background-color: #A8423D; color: #fff;" aria-label="Left Align" title="Accedeix"><span class="fa fa-sign-in" aria-hidden="true"></span></button></td>
            </tr></table>
        </div>


    </div>


    <!--MODAL ModalNomGeograficInfo-->
    <div class="modal fade" id="ModalNomGeograficInfo" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true" style="z-index:9999999;">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="ModalLabel" style="margin:0px;"><span class="lang" key="mapFrm_lbl_16">Informació del topònim</span></h3>
                    <div id="right-title">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>

                <div class="modal-body">
                    <form>
                        <div class="form-row" style="padding:5px;">
                            <div id="divInputNG" class="form-group col-6">
                                <label for="spelling"><span class="lang" key="mapFrm_lbl_17">Nom geogràfic (topònim)</span></label>
                                <input type="text" class="form-control" id="spelling" >
                            </div>
                            <div id="divTipusNom" class="form-group col-6">
                                <label for="named_place_local_type_id"><span class="lang" key="mapFrm_lbl_18">Tipus:</span></label>
                                <select class="form-control" id="named_place_local_type_id" name="named_place_local_type_id" title="Seleccionar..."></select>
                                <!--<select class="selectpicker show-tick" data-width="100%" data-live-search="true" id="named_place_local_type_id" name="named_place_local_type_id"></select>-->

                            </div>
                        </div>

                        <!--SOURCE - STATUS-->
                        <?php
                            $displayCol1=false;
                            for ($i=0; $i<count($rowsEditable); $i++){
                                if (($rowsEditable[$i]["name"]=="geographical_name.source_of_name_id") && ($rowsEditable[$i]["editable"]=="1")){
                                    $displayCol1=true;
                                    break;
                                }
                            }
                            $displayCol2=false;
                            for ($i=0; $i<count($rowsEditable); $i++){
                                if (($rowsEditable[$i]["name"]=="geographical_name.name_status_id") && ($rowsEditable[$i]["editable"]=="1")){
                                    $displayCol2=true;
                                    break;
                                }
                            }
                            if (($displayCol1==true) || ($displayCol2==true)){
                        ?>
                            <div class="form-row" style="padding:5px;">
                                <div class="col-lg-6" <?php if ($displayCol1==false) echo 'style="display:none;"'; ?>>
                                    <label for="source_of_name_id"><span class="lang" key="mapFrm_lbl_19">Font:</span></label>
                                    <?php
                                    if ($users!="public"){
                                    ?>
                                        <select class="form-control" id="source_of_name_id" name="source_of_name_id" title="Seleccionar..."></select>
                                    <?php
                                    }else{
                                    ?>
                                        <input type="text" class="form-control" id="source_of_name_id" name="source_of_name_id">
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div class="col-lg-6" <?php if ($displayCol2==false) echo 'style="display:none;"'; ?>>
                                    <label for="name_status_id"><span class="lang" key="mapFrm_lbl_20">Estatus:</span></label>
                                    <select class="form-control" id="name_status_id" name="name_status_id" title="Seleccionar..."></select>
                                </div>                            
                            </div>
                        <?php
                            }
                        ?>

                        <!--PRIORITY - ORGANIZATION-->
                        <?php
                            $displayCol3=false;
                            for ($i=0; $i<count($rowsEditable); $i++){
                                if (($rowsEditable[$i]["name"]=="geographical_name.priority_id") && ($rowsEditable[$i]["editable"]=="1")){
                                    $displayCol3=true;
                                    break;
                                }
                            }
                            $displayCol4=false;
                            for ($i=0; $i<count($rowsEditable); $i++){
                                if (($rowsEditable[$i]["name"]=="named_place.competent_organization_id") && ($rowsEditable[$i]["editable"]=="1")){
                                    $displayCol4=true;
                                    break;
                                }
                            }
                            if (($displayCol3==true) || ($displayCol4==true)){
                        ?>
                        <div class="form-row" style="padding:5px;">
                            <div class="col-lg-6" <?php if ($displayCol3==false) echo 'style="display:none;"'; ?>>
                                <label for="priority_id"><span class="lang" key="mapFrm_lbl_21">Prioritat:</span></label>
                                <select class="form-control" id="priority_id" name="priority_id" title="Seleccionar..."></select>
                            </div>
                            <div class="col-lg-6" <?php if ($displayCol4==false) echo 'style="display:none;"'; ?>>
                                <label for="competent_organization_id"><span class="lang" key="mapFrm_lbl_22">Organització competent:</span></label>
                                <select class="form-control" id="competent_organization_id" name="competent_organization_id" title="Seleccionar..."></select>
                            </div>
                        </div>
                        <?php
                            }
                        ?>                        


                        <!--BEGINLIFESPANVERSIONS - ENDLIFESPANVERSIONS-->
                        <?php
                            $displayCol8=false;
                            for ($i=0; $i<count($rowsEditable); $i++){
                                if (($rowsEditable[$i]["name"]=="named_place.beginLifespanVersion") && ($rowsEditable[$i]["editable"]=="1")){
                                    $displayCol8=true;
                                    break;
                                }
                            }
                            $displayCol9=false;
                            for ($i=0; $i<count($rowsEditable); $i++){
                                if (($rowsEditable[$i]["name"]=="named_place.endLifespanVersion") && ($rowsEditable[$i]["editable"]=="1")){
                                    $displayCol9=true;
                                    break;
                                }
                            }
                            if (($displayCol8==true) || ($displayCol9==true)){
                        ?>
                        <div class="form-row" style="padding:5px;">
                            <div class="col-lg-6" <?php if ($displayCol8==false) echo 'style="display:none;"'; ?>>
                                <label for="beginLifespanVersion"><span class="lang" key="mapFrm_lbl_31">Inici:</span></label>
                                <input type="date" class="form-control" id="beginLifespanVersion" name="beginLifespanVersion" ></input>
                            </div>
                            <div class="col-lg-6" <?php if ($displayCol9==false) echo 'style="display:none;"'; ?>>
                                <label for="endLifespanVersion"><span class="lang" key="mapFrm_lbl_32">Final:</span></label>
                                <input type="date" class="form-control" id="endLifespanVersion" name="endLifespanVersion" ></input>
                            </div>
                        </div>
                        <?php
                            }
                        ?>     

                        <!--OBSERVATION-->
                        <?php
                            $displayCol5=false;
                            for ($i=0; $i<count($rowsEditable); $i++){
                                if (($rowsEditable[$i]["name"]=="named_place.observations") ){
                                    $displayCol5=true;
                                    break;
                                }
                            }
                            if (($displayCol5==true) ){
                        ?>
                        <div class="form-row" style="padding:5px;">
                            <div class="col-lg-12" >
                                <label for="observations"><span class="lang" key="mapFrm_lbl_23">Observacions:</span></label>
                                <textarea class="form-control" id="observations" name="observations" rows="10" style="height:70px;"></textarea>
                            </div>
                        </div>
                        <?php
                            }
                        ?>  


                        <!--MIN SCALE-->
                        <?php
                            $displayCol6=false;
                            for ($i=0; $i<count($rowsEditable); $i++){
                                if (($rowsEditable[$i]["name"]=="named_place.minimum_scale_visibility") && ($rowsEditable[$i]["editable"]=="1")){
                                    $displayCol6=true;
                                    break;
                                }
                            }
                            $displayCol7=false;
                            for ($i=0; $i<count($rowsEditable); $i++){
                                if (($rowsEditable[$i]["name"]=="named_place.maximum_scale_visibility") && ($rowsEditable[$i]["editable"]=="1")){
                                    $displayCol7=true;
                                    break;
                                }
                            }
                        ?>
                        <div class="form-row" style="padding:5px;">
                            <div class="col-lg-3" >
                                <label for="longitude">Coord X:</label>
                                <input type="text" class="form-control" id="longitude" >
                            </div>
                            <div class="col-lg-3" >
                                <label for="latitude">Coord Y:</label>
                                <input type="text" class="form-control" id="latitude" >
                            </div>                        
                            <div class="col-lg-2" <?php if ($displayCol6==false) echo 'style="display:none;"'; ?>>
                                <label for="minimum_scale_visibility"><span class="lang" key="mapFrm_lbl_24">Escala mínima:</span></label>
                                <input type="text" class="form-control" id="minimum_scale_visibility" >
                            </div>
                            <div class="col-lg-2" <?php if ($displayCol7==false) echo 'style="display:none;"'; ?>>
                                <label for="maximum_scale_visibility"><span class="lang" key="mapFrm_lbl_25">Escala màxima:</span></label>
                                <input type="text" class="form-control" id="maximum_scale_visibility" >
                            </div>
                            <div class="col-lg-2" >
                                <label for="btnUbicacio"><div>&nbsp;</div></label>
                                <button type="button" name="btnUbicacio" id="btnUbicacio" onclick="setLocation()" class="btn btn-secondary canviarPosicio" title="Canviar ubicació" style="visibility:visible;"><i class="fa fa-map-marker"></i>&nbsp;&nbsp;<span class="lang" key="mapFrm_lbl_26">Ubicació al mapa</span></button>
                            </div>  
                        </div>

                        <div class="form-row" style="padding:5px;">
                            <div class="col-lg-12" >
                                <label id="toponym_user" name="toponym_user"></label>
                            </div>
                        </div>                        

                    </form>
                </div>

                <div class="modal-footer" id="modal1-foot" style="visibility:visible;">
                    <div style="position:absolute; left:20px;">
                        <button type="button" class="btn btn-light" onclick="$('#ModalNomGeograficInfo').modal('toggle');"><span class="lang" key="mapFrm_lbl_27">Cancel·la</span></button>            
                    </div>                               
                    <div style="float:right">
                        <button type="button" id="btnDeleteTopo" onclick="deleteToponym()" class="btn btn-danger eliminar">Elimina</button>
                        <button type="button" id="btnSaveTopo"  onclick="saveToponym()" class="btn btn-success" ><span class="lang" key="mapFrm_lbl_28">Guardar Canvis</span></button>
                    </div>  
                </div>
            </div>
        </div>
    </div>

    <!--MODAL ModalPrint-->
    <div class="modal fade" id="ModalPrint" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true" style="z-index:9999999;">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h3 class="modal-title" id="ModalLabel2" style="margin:0px;">Impressió a PDF</h3>
            <div id="right-title">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>

          </div>
          <div class="modal-body">

                <div class="row" style="padding:5px;text-align:left;">
                    <div class="col-lg-12">
                        <div class="form-group row" style="display: flex;">
                            <div class="col-lg-6">
                                <label for="format" class="sr-only">Tamany paper</label>
                                <select class="form-control"  id="format">
                                    <option value="a0">A0 (slow)</option>
                                    <option value="a1">A1</option>
                                    <option value="a2">A2</option>
                                    <option value="a3">A3</option>
                                    <option value="a4" selected>A4</option>
                                    <option value="a5">A5 (fast)</option>
                                </select>                            </div>
                            <div class="col-lg-6">
                                <label for="resolution" class="sr-only">Resolution</label>
                                <select class="form-control"  id="resolution" name="resolution">
                                    <option value="72">72 dpi (fast)</option>
                                    <option value="150">150 dpi</option>
                                    <option value="300">300 dpi (slow)</option>
                                </select>
                            </div>                                        
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-12">
                                <button  class="form-control" id="export-pdf">Export PDF</button>   
                            </div>
                        </div>
                    </div>
                </div>  



          </div>
        </div>
      </div>
    </div>



    <!--MODAL ModalLogin-->
    <div class="modal fade" id="ModalLogin" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true" style="z-index:9999999;">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h3 class="modal-title" id="ModalLabel" style="margin:0px;"><span class="lang" key="mapFrm_lbl_6">Benvingut al projecte Nom a nom!</span></h3>
            <div id="right-title">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>

          </div>
          <div class="modal-body">

            <form id="formLogin">

                 <div class="row">
                     <div class="col-lg-11 mx-auto">
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <label ><span class="lang" key="mapFrm_lbl_7">Per a començar a col·laborar, acredita't:</span></label>
                            </div>
                        </div>
                    </div>
                </div>
                

                 <div class="row">
                     <div class="col-lg-11 mx-auto">
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <label for="usuari" class="sr-only">Usuari</label>
                                <input type="text" id="usuari" class="form-control" placeholder="Usuari" required="" autofocus="" name="usuari" value=""/>
                            </div>
                        </div>
                    </div>
                </div>


                 <div class="row">
                     <div class="col-lg-11 mx-auto">
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <label for="pwd" class="sr-only">Password</label>
                                <input type="password" id="password" class="form-control" placeholder="Password"  name="password" value=""/>   
                            </div>
                        </div>
                    </div>
                </div>

                <center>
                    <button class="btn btn-primary btn-block" type="button" style="width:50%;background-color:#A8423D;border-color:#A8423D;" id="btnLoginModal" onclick="login()"><span class="lang" key="login">Accedeix</span></button></br>

                    <?php
                    if ($users=="public"){
                    ?>
                        <span class="lang" key="mapFrm_lbl_8">Encara no ets usuari?</span> <span  class="lang" key="mapFrm_lbl_9" id="mapFrm_lbl_9" style="color:#A8423D;font-weight:bold;">Et pots donar d'alta aquí!</span>&nbsp;&nbsp; 
                        <button type="button" class="btn btn-success" onclick='$("#ModalSignUp").modal("show")' id="btnAlta" style="background-color:#fff;color:#A8423D; border-color:#A8423D;"><span class="lang" key="mapFrm_lbl_10">Alta d'un nou usuari</span></button>
                        </br>&nbsp</br>
                        <span class="lang" key="mapFrm_lbl_11">Si no recordes el teu usuari o has perdut la contrasenya, </span><a href="#" onclick='$("#ModalLogin").modal("hide");$("#ModalPwd").modal("show")' id="link_alta" style="color:#A8423D;"><span class="lang" key="mapFrm_lbl_14">fes clic aquí!</span></a>
                        </br>&nbsp</br>
                    <?php
                    }
                    ?>

                </center>

            </form>

          </div>
        </div>
      </div>
    </div>

    <!--MODAL ModalSignUp-->
    <div class="modal fade" id="ModalSignUp" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true" style="z-index:9999999;">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h3 class="modal-title" id="ModalLabel" style="margin:0px;"><span class="lang" key="mapFrm_lbl_12">Sol·licitud d'alta de nou usuari</span></h3>
            <div id="right-title">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>

          </div>
          <div class="modal-body">

             <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label ><span class="lang" key="mapFrm_lbl_7">Per a començar a col·laborar, acredita't!:</span></label>
                    </div>
                </div>
            </div>
             <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <!--<label for="nom">Nom:</label>-->
                        <input type="text" id="nom" class="form-control" placeholder="Nom" required="" name="nom" style="background-color:#efefef;"/>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="form-group">
                        <!--<label for="llinatge1">Llinatges:</label>-->
                        <input type="text" id="llinatge1" class="form-control" placeholder="Cognoms" required="" name="llinatge1" style="background-color:#efefef;"/>
                    </div>
                </div>
                 <!--
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="llinatge2">Llinatge 2:</label>
                        <input type="text" id="llinatge2" class="form-control" placeholder="Llinatge 2" required="" name="llinatge2"/>
                    </div>
                </div>
                 -->
             </div>

              <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <!--<label for="email">Email</label>-->
                        <input id="email" type="email" name="email" class="form-control" placeholder="Email" style="background-color:#efefef;">
                    </div>
                </div>
              </div>

            <div class="row">
                <div class="col-sm-12">
                <hr />
                </div>
            </div>

             <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <!--<label for="nom">Nom d'usuari:</label>-->
                        <input type="text" id="userName" class="form-control" placeholder="User name" required="" name="userName"/>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="form-group">
                        <!--<label for="pwd">Paswword:</label>-->
                        <input type="text" id="pwd" class="form-control" placeholder="Password" required="" name="pwd"/>
                    </div>
                </div>

            </div >
              &nbsp;<br />

            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <center><div class="g-recaptcha" data-sitekey="<?php echo $captcha_web;?>"></div></center>
                    </div>
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-success" onclick='addUser()' id="btnAddUser" style="border-color:#A8423D; background-color:#A8423D;"><span class="lang" key="mapFrm_lbl_13">Començar a col·laborar</span></button>
          </div>
        </div>
      </div>
    </div>

    <!--MODAL ModalPwd-->
    <div class="modal fade" id="ModalPwd" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true" style="z-index:9999999;">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h3 class="modal-title" id="ModalLabel2" style="margin:0px;">Recupera la contrasenya</h3>
            <div id="right-title">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick='$("#ModalLogin").modal("show")'>
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>

          </div>
          <div class="modal-body">

            <form name="formPwd" id="formPwd" action="visor.aspx" method="post" >

                 <div class="row">
                     <div class="col-lg-11 mx-auto">
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <label >Si us plau, introdueix el correu electrònic amb el qual et vas donar d'alta i t'hi enviarem el teu usuari i la contrasenya:</label>
                            </div>
                        </div>
                    </div>
                </div>
                

                 <div class="row">
                     <div class="col-lg-11 mx-auto">
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <label for="email2" class="sr-only">Correu electrònic</label>
                                <input type="text" id="email2" name="email2" class="form-control" placeholder="Correu electrònic" required="" autofocus=""/>
                            </div>
                        </div>
                    </div>
                </div>
                &nbsp;<br />
                <center>
                    <button class="btn btn-primary btn-block" type="button" style="width:50%;border-color:#A8423D;background-color:#A8423D;" onclick="recuperaDades();">Enviar</button></br>
                </center>

            </form>

          </div>
        </div>
      </div>
    </div>

    <!--MODAL ModalMultiples-->
    <div class="modal fade" id="ModalMultiples" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true" style="z-index:9999999;">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h3 class="modal-title" id="ModalLabel" style="margin:0px;"><span class="lang" key="mapFrm_lbl_33">Múltiples topònims</span></h3>
            <div id="right-title">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>

          </div>
          <div class="modal-body">
             <div class="row">
                 <div class="col-lg-11 mx-auto">
                    <div class="form-group row">
                        <div class="col-lg-11">
                            <label for="filtreMultiples"><span class="lang" key="mapFrm_lbl_34">Selecciona un del múltiples topònim d'aquesta coordenada:</span></label>
                            <select class="form-control" id="filtreMultiples" name="filtreMultiples"></select>
                        </div>
                    </div>
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <span>
                <button type="button" class="btn btn-default" onclick='multiples()'><span class="lang" key="mapFrm_lbl_35">Seleccionar</sapn></button>
            </span>
          </div>
        </div>
      </div>
    </div>

    <!--MODAL ModalMeus-->
    <div class="modal fade" id="ModalMeus" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true" style="z-index:9999999;">
      <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h3 class="modal-title" id="ModalLabel" style="margin:0px;"><span class="lang" key="mapFrm_lbl_36">Els meus topònims</span></h3>
            <div id="right-title">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>

          </div>
          <div class="modal-body">
            <table id="tableToponym" data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar" data-show-columns="true">
              <thead>
                <tr>
                    <th data-field="id" data-sortable="true">Id</th>
                    <th data-field="username" data-sortable="true">Editor</th>
                    <th data-field="spelling" data-sortable="true"><span class="lang" key="mapFrm_lbl_17">Nom</span></th>
                    <th data-field="ds_type" data-sortable="true"><span class="lang" key="mapFrm_lbl_18">Tipus</span></th>
                    <th data-field="longitude" data-sortable="true">X</th>
                    <th data-field="latitude" data-sortable="true">Y</th>
                    <?php 
                    for ($i=0; $i<count($rowsEditable); $i++){
                        if ($rowsEditable[$i]["editable"]==1){
                            $cadena = substr($rowsEditable[$i]["name"],strrpos($rowsEditable[$i]["name"], ".")+1);
                            echo '<th data-field="'.$cadena.'" data-sortable="true">'.$cadena.'</th>';    
                        }
                    }
                    ?>


                </tr>
              </thead>
            </table>           
          </div>
        </div>
      </div>
    </div>


    <script>
    $(document).ready(function () {	

        preparaLayout();
        getProjectInfo();
        textCercador = $(".tc-ctl-search-txt");

        var resultat = JSON.parse(msg);
        try {
            if (resultat.correcte == "no") {
                toastr.error(resultat.missatge, "Error");
            }
        }
        catch (Err) { }

        if (editor_id == "") {
            $("#btnAdd")[0].style.display = "none"
        }
        else {
            $("#avisInicial")[0].style.display = "none";
            getFontsUsuari();
        }

        $.ajax({
                type: "get",
                url: "administrador/config/lang.json"
            }).done(function (data) {
                arrayLang = data;
                fn_translate(language);
            })    

    });



        function fn_translate(lang){
            if (lang=='ca') lang='ca-CA';
            if (lang=='es') lang='es-ES';
            if (lang=='en') lang='en-EN';
            currentLang = lang;
            $(".lang").each(function(index, element) {
                $(this).text(arrayLang[lang][$(this).attr("key")]);
            });  
            $("#txtSearch1")[0].placeholder = arrayLang[currentLang]["mapFrm_lbl_5"];   
            
        }    
    </script>
    
</body>
</html>
