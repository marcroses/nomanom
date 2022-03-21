<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
    $userId = $_POST["userId"];  
    $userName = $_POST["userName"];  
    if ( ($userId=="") || ($userId==null) ){
      header("Location: index.php"); 
      exit();
    }
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head > 

    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="icon" href="images/favicon.png">
    
    <!-- ========================== -->
    <!--STYLES-->
    <!-- ========================== -->
    
    <!--Bootstrap-->
    <link rel="stylesheet" href="../lib/bootstrap-4.3.1/css/bootstrap.min.css" />
    
    <!--toastr-->
    <link rel="stylesheet" href="../lib/toastr/toastr.min.css" />
    <!--Font-awesome-->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <!--boostrap-select-->
    <link rel="stylesheet" href="../lib/bootstrap-select/bootstrap-select-1.13.9/dist/css/bootstrap-select.min.css" />
    <!--boostrap-table-->
    <link rel="stylesheet" href="../lib/bootstrap-table-master/dist/bootstrap-table.css">
    <!--custom-->
    <link rel="stylesheet" href="css/main.css" />
    <!-- Summernote -->
    

    <!-- ========================== -->
    <!--JS-->
    <!-- ========================== -->

    <!--JQuery-->
    <!--<script type="text/javascript" src="../lib/jquery/jquery-2.2.4.min.js"></script>-->
    <script src="../lib/jquery-3.6/jquery-3.6.0.min.js"></script>
    <script src="../lib/jquery-ui-1.12.1/jquery-ui.min.js"></script>    

    <!--Popper-->    
    <script type="text/javascript" src="../lib/popper/popper.min.js"></script>
    <!--Bootstrap-->    
    <script type="text/javascript" src="../lib/bootstrap-4.3.1/js/bootstrap.min.js"></script>
    <!--Toastr-->    
    <script type="text/javascript" src="../lib/toastr/toastr.min.js"></script>
    <script type="text/javascript" src="js/toastr_object.js"></script>
    <!--bootstrap-select-->    
    <script type="text/javascript" src="../lib/bootstrap-select/bootstrap-select-1.13.9/dist/js/bootstrap-select.min.js"></script>
    <!--boostrap-table-->
    <script type="text/javascript" src="../lib/bootstrap-table-master/dist/bootstrap-table.js"></script>
    <script type="text/javascript" src="../lib/bootstrap-table-master/dist/extensions/export/bootstrap-table-export.js"></script>
    <!-- Ol5 -->
    <link rel="stylesheet" type="text/css" href="../lib/ol6.9.0/ol.css" />
    <script type="text/javascript" src="../lib/ol3-layerswitcher-master/src/ol3-layerswitcher.js"></script>
    <!-- Proj4 -->
    <!--<script type="text/javascript" src="lib/proj4/proj4.js"></script>    -->
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/proj4js/2.4.3/proj4.js"></script>-->
    
    <!--Custom-->    
    <script type="text/javascript" src="js/script.js"></script>
    <script type="text/javascript" src="js/FileSaver.min.js"></script>

    <!-- Proj4 -->
    <script type="text/javascript" src="../lib/proj4/proj4.js"></script>    
    <!-- Ol5 -->
    <script type="text/javascript" src="../lib/ol6.9.0/ol.js"></script>
    
	<!-- ol3-layerswitcher -->
	<link rel="stylesheet" href="../lib/ol-layerswitcher-master/src/ol-layerswitcher.css" type="text/css"/>
	<script src="../lib/ol-layerswitcher-master/dist/ol-layerswitcher.js"></script>    
    

    <!--summer note-->
    <link rel="stylesheet" type="text/css" href="../lib/bootstrap-summernote/summernote-050.css">
    <link rel="stylesheet" type="text/css" href="../lib/bootstrap-summernote/summernote-bs3.css">

    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/codemirror.css">
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/theme/monokai.css">

    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/codemirror.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/mode/xml/xml.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/2.36.0/formatting.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/summernote/0.5.0/summernote.min.js"></script>     


    <!-- Custom -->
    <script type="text/javascript" src="js/map.js"></script> 
    <script type="text/javascript" src="js/layers.js"></script> 
    <script type="text/javascript" src="js/users.js"></script> 
    <script type="text/javascript" src="js/fields.js"></script> 

    <title>Administrador Nom a nom</title>

    <script langauge="javascript">
        var arrayLang;
        var currentLang="ca-CA";
        var longitude = 0;
        var latitude = 0;
        var zoom = 10;
        var language='ca';
        var foto64;
        var foto64_b;
        var altura;
        var JSON_baseLayers, JSON_baseLayersSource;
        var JSON_OverLayers, JSON_OverLayersSource;
        var JSON_Users;
        var JSON_Fields;
        var JSON_Toponyms;
    </script>    

</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <a class="navbar-brand" href="index.php" style="padding-top: 0; padding-bottom: 0;"><img src="images/logo4.png" style="max-height:50px;"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="lang" key="titol">Administrador Nom a nom</span></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">  
            <span class="navbar-toggler-icon"></span>
        </button>
        <span style="position:absolute; right:110px;color:#ffffff;">
            <a href="#" style="color:#ffffff" onclick="fn_translate('ca-CA')">ca</a> |
            <a href="#" style="color:#ffffff" onclick="fn_translate('es-ES')">es</a> |
            <a href="#" style="color:#ffffff" onclick="fn_translate('en-EN')">en</a>
        </span>        
        <span style="position:absolute; right:10px;color:#cccccc;" id="userName" ><?php echo $userName;?></span>
    </nav>

    <div id="container" style="padding:5px;">

        <center>
            <div id="content" style="width:95%;top:25px;position:relative;">
            
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#tab1" role="tab" ><span class="lang" key="tab1">Nom i descripció</span></tab></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#tab2" role="tab" onclick="initMap();" ><span class="lang" key="tab2">Extensió</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#tab3" role="tab" ><span class="lang" key="tab3" onclick="getBaseLayersSource()">Capes del projecte</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#tab4" role="tab" ><span class="lang" key="tab4">Colors i logos</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#tab5" role="tab" ><span class="lang" key="tab5">Usuaris</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#tab6" role="tab" ><span class="lang" key="tab6">Fitxa del topònim</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#tab7" role="tab" ><span class="lang" key="tab7">Configuració tècnica</span></a>
                    </li>                    

                </ul>

                <div class="tab-content" id="myTabContent">
                    <!-- TAB 1-->
                    <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="home-tab" >
                        <div id="content_tab1" style="width:100%;padding:20px;">
                            <div class="row" style="padding:5px;text-align:left;">
                                <div class="col-lg-12">
                                    <div class="form-group row" id="filaFont2" style="display: flex;">
                                        <div class="col-lg-9">
                                            <label for="frm_title"><span class="lang" key="frm_title">Títol del projecte:</span></label>
                                            <input type="text" class="form-control" id="frm_title" name="frm_title">
                                        </div>
                                        <div class="col-lg-3">
                                            <label for="frm_language"><span class="lang" key="frm_language">Idioma:</span></label>
                                            <select class="form-control" id="frm_language" name="frm_language">
                                                <option value="ca">Català</option>
                                                <option value="es">Español</option>
                                                <option value="en">English</option>
                                            </select>
                                        </div>                                        
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-lg-12">
                                            <label for="frm_description"><span class="lang" key="frm_description">Descipció</span></label>
                                            <textarea class="summernote" id="frm_description" name="frm_description" rows="10" style="height:70px;"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>             
                        </div>
                    </div>

                    <!-- TAB 2-->
                    <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="profile-tab">
                        <div id="map" style="width:100%;background-color:#eeeeee;height:550px;"></div>
                    </div>

                    <!-- TAB 3-->
                    <div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="contact-tab">
                        <div id="content_tab3" style="width:100%;padding:20px;text-align:left;">
                            <div id="accordion">
                                <div class="card">
                                    <div class="card-header" id="headingOne">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                <img src="images/layer_background64.png" style="max-height:35px;margin-right:20px;"/><span class="lang" key="layerBackground_lbl">Capes de fons</span>
                                            </button>
                                            <div style="float:right;">
                                                <button type="button" class="btn btn-light" onclick="addBaseLayer()"><span class="lang" key="btnAddLayer"><i class="fa fa-plus"></i>&nbsp;&nbsp;Crear capa</span></button>    
                                            </div>
                                        </h5>
                                    </div>

                                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion" style="overflow:auto;">
                                            <ul class="list-group" id="listBL">
                                                                                
                                            </ul>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="headingTwo">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                <img src="images/layer_overlay64.png" style="max-height:35px;margin-right:20px;"/><span class="lang" key="layerOverlay_lbl">Capes sobreposades</span>
                                            </button>
                                            <div style="float:right;">
                                                <button type="button" class="btn btn-light" onclick="addOverlayLayer()"><span class="lang" key="btnAddLayer"><i class="fa fa-plus"></i>&nbsp;&nbsp;Crear capa</span></button>    
                                            </div>
                                        </h5>

                                    </div>
                                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                        <ul class="list-group" id="listOL">
                                                                               
                                        </ul>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- TAB 4-->
                    <div class="tab-pane fade" id="tab4" role="tabpanel" aria-labelledby="contact-tab">
                        <div id="content_tab4" style="width:100%;padding:20px;text-align:left;">
                            <div class="row" style="padding:5px;text-align:left;">
                                <div class="col-lg-12">
                                    <div class="form-group row" style="display: flex;">
                                        <div class="col-lg-3">
                                            <label for="frm_primary_color"><span class="lang" key="frm_primary_color">Color principal:</label>
                                            <input type="color" class="form-control" id="frm_primary_color" name="frm_primary_color" value="#9B0409"/>
                                        </div>
                                        <div class="col-lg-3">
                                            <label for="frm_color2"><span class="lang" key="frm_color2">Segon color:</label>
                                            <input type="color" class="form-control" id="frm_color2" name="frm_color2" value="#049b96"/>
                                        </div>
                                        <div class="col-lg-3">
                                            <label for="frm_color3"><span class="lang" key="frm_color3">Tercer color:</label>
                                            <input type="color" class="form-control" id="frm_color3" name="frm_color3" value="#9b9604"/>
                                        </div>
                                        <div class="col-lg-3">
                                            <label for="frm_color4"><span class="lang" key="frm_color4">Quart color:</label>
                                            <input type="color" class="form-control" id="frm_color4" name="frm_color4" value="#04099b"/>
                                        </div>
                                    </div>
                                    &nbsp;</br>
                                    <div class="form-group row" style="display: flex;">
                                        <div class="col-lg-3">
                                            <label for="btnfileLogo"><span>Logo:</span></label>
                                            <input type="file" name="btnfileLogo" class="form-control" id="btnfileLogo" accept="image/*" />    
                                        </div>
                                        <div class="col-lg-3">
                                            <img id="logoImage" name="logoImage" style="max-height:300px;max-width:100%;background-color:#eeeeee" />                            
                                        </div> 
                                        <div class="col-lg-3">
                                            <label for="btnfileLogo2"><span class="lang" key="frm_imatgeFons">Imatge de portada:</span></label>
                                            <input type="file" name="btnfileLogo2" class="form-control" id="btnfileLogo2" accept="image/*" />    
                                        </div>
                                        <div class="col-lg-3">
                                            <img id="logoImage2" name="logoImage2" style="max-height:300px;max-width:100%;background-color:#eeeeee" />                            
                                        </div>                                         
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- TAB 5-->
                    <div class="tab-pane fade" id="tab5" role="tabpanel" aria-labelledby="contact-tab">
                        <div id="content_tab5" style="width:100%;padding:30px;text-align: justify;">
                            <label class="radio-inline"><input type="radio" value="public" name="optradioUser" id="optradioUser" checked>&nbsp;<span class="lang" key="public_users_lbl">Usuaris públics</span></label>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <label class="radio-inline"><input type="radio" value="restricted" name="optradioUser" id="optradioUser" >&nbsp;<span class="lang" key="restricted_users_lbl">Usuaris restringits</span></label>                        
                            &nbsp;</p>
                                <div class="card" id="divRestrcictedUsers">
                                    <div class="card-header" id="headingThree">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                <img src="images/user.png" style="max-height:35px;margin-right:20px;"/><span class="lang" key="registered_users_lbl">Usuaris registrats</span>
                                            </button>
                                            <div style="float:right;">
                                                <button type="button" class="btn btn-light" onclick="userAddConfig()"><span class="lang" key="btnAddUser"><i class="fa fa-user-plus"></i>&nbsp;&nbsp;<span class="lang" key="add_users_lbl">Afegir usuaris</span></span></button>    
                                            </div>
                                        </h5>
                                    </div>

                                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion" style="overflow:auto;">
                                            <ul class="list-group" id="listUsers">
                                                                                
                                            </ul>
                                    </div>
                                </div>      
                                &nbsp;<p>
                                &nbsp;<p>                                                                           
                        </div>
                    </div>

                    <!-- TAB 6-->
                    <div class="tab-pane fade" id="tab6" role="tabpanel" aria-labelledby="contact-tab">
                        <div id="content_tab6" style="width:100%;padding:30px;text-align: justify;">
                        <div class="card">
                            <div class="card-header" id="headingFour">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            <img src="images/edit.png" style="max-height:35px;margin-right:20px;"/><span class="lang" key="layerEditField_lbl">Camps de la fitxa de topònims</span>
                                        </button>
                                    </h5>
                                </div>

                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion" style="overflow:auto;">
                                        <ul class="list-group" id="listFields">
                                                                            
                                        </ul>
                                </div>
                            </div>                           
                            &nbsp;<p>
                            &nbsp;<p>                              
                        </div>
                    </div>

                    <!-- TAB 7-->
                    <div class="tab-pane fade" id="tab7" role="tabpanel" aria-labelledby="contact-tab">
                        <div id="content_tab7" style="width:100%;padding:30px;text-align: justify;">

                            <div class="row" style="padding:5px;text-align:left;">
                                <div class="col-lg-12">
                                    <div class="form-group row" style="display: flex;">
                                        <div class="col-lg-12">
                                            <label for="frm_project_domain"><span class="lang" key="frm_project_domain">Domini on està allotjat:</span></label>
                                            <input type="text" class="form-control" id="frm_project_domain" name="frm_project_domain">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-lg-6">
                                            <label for="frm_email_sender"><span class="lang" key="frm_email_sender">Email de notificacions:</span></label>
                                            <input type="text" class="form-control" id="frm_email_sender" name="frm_email_sender">
                                        </div>
                                        <div class="col-lg-6">
                                            <label for="frm_email_sender_pwd"><span class="lang" key="frm_email_sender_pwd">Password:</span></label>
                                            <input type="password" class="form-control" id="frm_email_sender_pwd" name="frm_email_sender_pwd">
                                        </div>

                                    </div>
                                </div>
                            </div>                         

                        </div>
                    </div>                    

                </div>    

            </div>
        </center>

    </div>    


    <footer class="bg-light text-center text-lg-start">
        <div class="container" style="width:100%;">
            <div style="position: absolute;right: 60px; bottom: 10px;">
                <button type="button" class="btn btn-secondary" ><span class="lang" key="btnUpdate" onclick="saveProjectInfo()"><i class="fa fa-save"></i>&nbsp;&nbsp;Actualitzar</span></button>
            </div>
        </div>
    </footer>

    <!-- The Map Modal -->
    <div class="modal" id="mapModal">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title"><span id="mapTitle"></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div id="map2Content" style="width:100%;height:500px;background-color:#eeeeee;"></div>
                </div>

            </div>
        </div>
    </div>     


    <!-- The LayerOverlayConfig Modal -->
    <div class="modal" id="layerOverlayConfigModal">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title"><span id="layerOverlayConfigTitle"></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row" style="padding:5px;text-align:left;">
                        <div class="col-lg-12">
                            <div class="form-group row" style="display: flex;">
                                <div class="col-lg-9">
                                    <label for="frm_Overlay_title"><span class="lang" key="frm_Overlay_title">Títol:</span></label>
                                    <input type="text" class="form-control" id="frm_Overlay_title" name="frm_Overlay_title"/>
                                </div>
                                <div class="col-lg-3">
                                    <label for="frm_Overlay_name"><span class="lang" key="frm_Overlay_name">Identificador:</span></label>
                                    <input type="text" class="form-control" id="frm_Overlay_name" name="frm_Overlay_name" />
                                </div>
                            </div>
                            
                            <div class="form-group row" style="display: flex;">
                                <div class="col-lg-9">
                                    <label for="frm_Overlay_url">URL:</label>
                                    <input type="text" class="form-control" id="frm_Overlay_url" name="frm_Overlay_url"/>
                                </div>
                                <div class="col-lg-3">
                                    <label for="frm_Overlay_format">format:</label>
                                    <input type="text" class="form-control" id="frm_Overlay_format" name="frm_Overlay_format" />
                                </div>
                            </div>
      
                            
                            <div class="form-group row" style="display: flex;" >
                                <div class="col-lg-12">
                                    <label for="frm_Overlay_layers">Layers:</label>
                                    <input type="text" class="form-control" id="frm_Overlay_layers" name="frm_Overlay_layers" />
                                </div>
                            </div>          
                            
                        </div>
                    </div>                    
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-light"  data-dismiss="modal"><span class="lang" key="btnCancel"><i class="fa fa-close"></i>&nbsp;&nbsp;Cancel·lar</span></button>    
                    <button type="button" class="btn btn-secondary" ><span class="lang" key="btnUpdateLayer" onclick="saveOverLayerSource()"><i class="fa fa-save"></i>&nbsp;&nbsp;Actualitzar</span></button>
                </div>            

            </div>
        </div>
    </div> 


    <!-- The LayerConfig Modal -->
    <div class="modal" id="layerConfigModal">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title"><span id="layerConfigTitle"></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row" style="padding:5px;text-align:left;">
                        <div class="col-lg-12">
                            <div class="form-group row" style="display: flex;">
                                <div class="col-lg-9">
                                    <label for="frm_bs_title"><span class="lang" key="frm_bs_title">Títol:</span></label>
                                    <input type="text" class="form-control" id="frm_bs_title" name="frm_bs_title"/>
                                </div>
                                <div class="col-lg-3">
                                    <label for="frm_bs_name"><span class="lang" key="frm_bs_name">Identificador:</span></label>
                                    <input type="text" class="form-control" id="frm_bs_name" name="frm_bs_name" />
                                </div>
                            </div>
                            
                            <div class="form-group row" style="display: flex;">
                                <div class="col-lg-6">
                                    <label for="frm_bs_url">URL:</label>
                                    <input type="text" class="form-control" id="frm_bs_url" name="frm_bs_url"/>
                                </div>
                                <div class="col-lg-6">
                                    <label for="frm_bs_attribution"><span class="lang" key="frm_bs_attribution">Atribució:</span></label>
                                    <input type="text" class="form-control" id="frm_bs_attribution" name="frm_bs_attribution" />
                                </div>
                            </div>

                            <div class="form-group row" style="display: flex;">
                                <div class="col-lg-6">
                                    <label for="frm_bs_type"><span class="lang" key="frm_bs_type">Tipus:</span></label>
                                    <select class="form-control" id="frm_bs_type" name="frm_bs_type" onchange="prepareInputLayers()">
                                        <option value="OSM">OSM (OpenStreep Map)</option>
                                        <option value="XYZ">XYZ</option>
                                        <option value="WMTS">WMTS (Web Map Tile Service)</option>
                                        <option value="WMS">WMS (Web Map Service)</option>
                                    </select>
                                </div>
                                <div class="col-lg-6">
                                    <label for="frm_bs_format">format:</label>
                                    <input type="text" class="form-control" id="frm_bs_format" name="frm_bs_format" />
                                </div>                                
                            </div>       
                            
                            <div class="form-group row" style="display: flex;" id="grid_frm_bs_layerName">
                                <div class="col-lg-12">
                                    <label for="frm_bs_layerNames">LayerName:</label>
                                    <input type="text" class="form-control" id="frm_bs_layerNames" name="frm_bs_layerNames" />
                                </div>
                            </div>          
                            
                            <div class="form-group row" style="display: flex;" id="grid_frm_bs_matrixSet">
                                <div class="col-lg-12">
                                    <label for="frm_bs_matrixSet">MatrixSet:</label>
                                    <input type="text" class="form-control" id="frm_bs_matrixSet" name="frm_bs_matrixSet" />
                                </div>
                            </div>                            
                        </div>
                    </div>                    
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-light"  data-dismiss="modal"><span class="lang" key="btnCancel"><i class="fa fa-close"></i>&nbsp;&nbsp;Cancel·lar</span></button>    
                    <button type="button" class="btn btn-secondary" ><span class="lang" key="btnUpdateLayer" onclick="saveBaseLayerSource()"><i class="fa fa-save"></i>&nbsp;&nbsp;Actualitzar</span></button>
                </div>            

            </div>
        </div>
    </div>   


    <!-- The userConfigModal Modal -->
    <div class="modal" id="userConfigModal">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title"><span id="userConfigTitle" class="lang" key="userConfigTitle">Gestió d'usuaris</span></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row" style="padding:5px;text-align:left;">
                        <input type="hidden" id="currentUserModal">
                        <div class="col-lg-12">
                            <div class="form-group row" style="display: flex;">
                                <div class="col-lg-6">
                                    <label for="frm_user_first_name"><span class="lang" key="frm_user_first_name">Nom:</span></label>
                                    <input type="text" class="form-control" id="frm_user_first_name" name="frm_user_first_name"/>
                                </div>
                                <div class="col-lg-6">
                                    <label for="frm_user_last_name"><span class="lang" key="frm_user_last_name">Cognoms:</span></label>
                                    <input type="text" class="form-control" id="frm_user_last_name" name="frm_user_last_name" />
                                </div>
                            </div>
                            
                            <div class="form-group row" style="display: flex;">
                                <div class="col-lg-6">
                                    <label for="frm_user_username">User name:</label>
                                    <input type="text" class="form-control" id="frm_user_username" name="frm_user_username"/>
                                </div>
                                <div class="col-lg-6">
                                    <label for="frm_user_pwd">Password:</label>
                                    <input type="text" class="form-control" id="frm_user_pwd" name="frm_user_pwd" />
                                </div>
                            </div>
      
                            
                            <div class="form-group row" style="display: flex;" >
                                <div class="col-lg-6">
                                    <label for="frm_user_mail">Email:</label>
                                    <input type="text" class="form-control" id="frm_user_mail" name="frm_user_mail" />
                                </div>                            
                                <div class="col-lg-6">
                                    <label for="is_staff">&nbsp;<p></label><p>
                                    <input type="checkbox" value="" id="is_staff"><span class="lang" key="frm_user_is_staff">&nbsp;&nbsp;Membre tècnic</span>
                                </div>
                            </div>          
                            
                        </div>
                    </div>                    
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-light"  data-dismiss="modal"><span class="lang" key="btnCancel"><i class="fa fa-close"></i>&nbsp;&nbsp;Cancel·lar</span></button>    
                    <button type="button" class="btn btn-secondary" ><span class="lang" key="btnUpdateLayer" onclick="saveUser()"><i class="fa fa-save"></i>&nbsp;&nbsp;Actualitzar</span></button>
                </div>            

            </div>
        </div>
    </div>  
       
    




</body>


 

    <script type="text/javascript">
        $(document).ready(function(){

            document.getElementById("btnfileLogo").addEventListener("change", readFile);   
            document.getElementById("btnfileLogo2").addEventListener("change", readFile2);

            altura = window.innerHeight;
            altura = altura - 200;
            if (altura < 400) altura = 400;
            $('#map').css("height",altura + "px");
            $('#content_tab1').css("height",altura + "px");
            $('#content_tab3').css("height",altura + "px");
            $('#content_tab4').css("height",altura + "px");
            $('#content_tab5').css("height",altura + "px");
            $('#content_tab6').css("height",altura + "px");
            $('#content_tab7').css("height",altura + "px");
            $('#collapseOne').css("height",(altura-200) + "px");
            $('#map2Content').css("height",(altura-50) + "px");
            


            $(window).resize(function () {
                var altura = window.innerHeight;
                altura = altura - 200;
                if (altura < 400) altura = 400;
                $('#map').css("height",altura + "px");
                $('#content_tab1').css("height",altura + "px");
                $('#frm_description').summernote({
                    height: parseInt(altura) - 225
                });                
                $('#content_tab3').css("height",altura + "px");
                $('#content_tab4').css("height",altura + "px");
                $('#content_tab5').css("height",altura + "px");
                $('#collapseOne').css("height",(altura-200) + "px");

            });

            $.ajax({
                type: "get",
                url: "config/lang.json"
            }).done(function (data) {
                arrayLang = data;
            }) 

            $('#frm_description').summernote({
                height: parseInt(altura) - 225
            });

            getProjectInfo();
            //getBaseLayersSource();

            $( "#listBL" ).sortable();
        });

        function fn_translate(lang){
            currentLang = lang;
            $(".lang").each(function(index, element) {
                $(this).text(arrayLang[lang][$(this).attr("key")]);
            });     
        }

        function getProjectInfo(){
            var params = {
                "action": "getProjectInfo"
            };
            $.ajax({
                type: "POST",
                url: "crud.php",
                data: params
            }).done(function (data) {
                if (data.trim()!="-1") {
                    $("#frm_title").val(JSON.parse(data.trim())[0].title);
                    $('#frm_description').code(JSON.parse(data.trim())[0].description);
                    longitude = JSON.parse(data.trim())[0].longitude;
                    latitude = JSON.parse(data.trim())[0].latitude;
                    zoom = JSON.parse(data.trim())[0].zoom;
                    foto64 = JSON.parse(data.trim())[0].logo;
                    foto64_b = JSON.parse(data.trim())[0].photo;
                    language = JSON.parse(data.trim())[0].language;
                    $("#frm_primary_color").val(JSON.parse(data.trim())[0].primary_color);
                    $("#frm_color2").val(JSON.parse(data.trim())[0].color_2);
                    $("#frm_color3").val(JSON.parse(data.trim())[0].color_3);
                    $("#frm_color4").val(JSON.parse(data.trim())[0].color_4);
                    $("#logoImage").attr("src",JSON.parse(data.trim())[0].logo);
                    $("#logoImage2").attr("src",JSON.parse(data.trim())[0].photo);
                    $("#frm_language").val(language);
                    $("input[name=optradioUser][value=" + JSON.parse(data.trim())[0].users + "]").prop('checked', true);
                    

                    getProjectSettings();
                    getBaseLayersSource();
                    getUsers();
                    getFields();
                }
            })    
        }


        function getProjectSettings(){
            var params = {
                "action": "getProjectSettings"
            };
            $.ajax({
                type: "POST",
                url: "crud.php",
                data: params
            }).done(function (data) {
                if (data.trim()!="-1") {
                    $("#frm_project_domain").val(JSON.parse(data.trim())[0].project_domain);
                    $("#frm_email_sender").val(JSON.parse(data.trim())[0].email_sender);
                    $("#frm_email_sender_pwd").val(JSON.parse(data.trim())[0].email_sender_pwd);
                }
            })    
        }

                

        function saveProjectInfo(){
            if (map!=null) {
                longitude = map.getView().getCenter()[0];
                latitude = map.getView().getCenter()[1];
                zoom = map.getView().getZoom();
            }
            var project_base_layer="";
            var j=0;
            for (var i=0; i < JSON_baseLayersSource.length +1 ; i++){
                try{
                    if ($("#cbBs_" + i).is(":checked")) project_base_layer = project_base_layer + i + "|" + JSON_baseLayersSource[i].id + "#";
                }
                catch(Err){}
                j++;
            }

            var project_over_layer="";
            var j=0;
            for (var i=0; i < JSON_OverLayersSource.length; i++){
                try{
                    if ($("#cbOl_" + JSON_OverLayersSource[i].id).is(":checked")) {
                        project_over_layer = project_over_layer + i + "|" + JSON_OverLayersSource[i].id + "#";
                    }
                }
                catch(Err)
                {
                    var a =1;
                }
                j++;
            }            

            var project_fields="";
            var j=0;
            for (var i=1; i < JSON_Fields.length +1 ; i++){
                if ($("#cbField_" + i).is(":checked")) project_fields = project_fields + i + "#";
            }            

            var params = {
                "action": "saveProjectInfo"
                , "title": $("#frm_title").val()
                , "description": $('#frm_description').code()
                , "longitude": longitude
                , "latitude": latitude
                , "zoom": zoom
                , "primary_color": $("#frm_primary_color").val()
                , "color_2": $("#frm_color2").val()
                , "color_3": $("#frm_color3").val()
                , "color_4": $("#frm_color4").val()
                , "logo": foto64
                , "photo": foto64_b
                , "project_base_layer": project_base_layer
                , "project_over_layer": project_over_layer
                , "language": $("#frm_language").val()
                , "users": $('input[name=optradioUser]:checked').val()
                , "project_fields": project_fields
                , "project_domain":  $("#frm_project_domain").val()
                , "email_sender":  $("#frm_email_sender").val()
                , "email_sender_pwd":  $("#frm_email_sender_pwd").val()
            };
            $.ajax({
                type: "POST",
                url: "crud.php",
                data: params
            }).done(function (data) {
                if (data.trim()=="ok") {
                    toastr.success(arrayLang[currentLang]["success_lbl"], "Correcte!");
                }
                else{
                    toastr.error(data, "Error");
                }
            }) 
        }        

        function readFile() {
            if (this.files && this.files[0]) {
                var FR= new FileReader();
                FR.addEventListener("load", function(e) {
                    foto64 = e.target.result;
                    document.getElementById("logoImage").src = foto64;
                }); 
                if (this.files[0].size<1500000){
                    FR.readAsDataURL( this.files[0] );    
                }
                else{
                    alert("imatge massa gran. Si us plau reduiu el tamany...")
                }
            }
        }  


        function readFile2() {
            if (this.files && this.files[0]) {
                var FR= new FileReader();
                FR.addEventListener("load", function(e) {
                    foto64_b = e.target.result;
                    document.getElementById("logoImage2").src = foto64_b;
                }); 
                if (this.files[0].size<1500000){
                    FR.readAsDataURL( this.files[0] );    
                }
                else{
                    alert("imatge massa gran. Si us plau reduiu el tamany...")
                }
            }
        }          

    </script>
</html>

