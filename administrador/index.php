<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head >
    <meta charset="UTF-8"/> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="icon" href="images/favicon.png">
    <link rel="stylesheet" href="../lib/bootstrap-4.3.1/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../lib/toastr/toastr.min.css" />

    <link rel="stylesheet" href="css/default_style.css" />
    <link rel="stylesheet" href="css/main.css" />

    <script type="text/javascript" src="../lib/jquery/jquery-2.2.4.min.js"></script>
    <script type="text/javascript" src="../lib/popper/popper.min.js"></script>
    <script type="text/javascript" src="../lib/bootstrap-4.3.1/js/bootstrap.min.js"></script>
    
    <script type="text/javascript" src="../lib/toastr/toastr.min.js"></script>
    <script type="text/javascript" src="js/toastr_object.js"></script>
    <title>Administrador Nom a nom</title>

    <script langauge="javascript">
        var arrayLang
    </script>
</head>
<body>
    <nav class="navbar navbar-expand-lg fixed-top">
        <a class="navbar-brand" href="#" style="padding-top: 0; padding-bottom: 0;"><img src="images/logo4.png" style="max-height:50px;"/>&nbsp;&nbsp;&nbsp;Administrador Nom a nom</a>
        <span style="position:absolute; right:40px;color:#ffffff;">
            <a href="#" style="color:#ffffff" onclick="fn_translate('ca-CA')">ca</a> |
            <a href="#" style="color:#ffffff" onclick="fn_translate('es-ES')">es</a> |
            <a href="#" style="color:#ffffff" onclick="fn_translate('en-EN')">en</a>
        </span>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">  
            <span class="navbar-toggler-icon"></span>
        </button>
    </nav>

    <header class="header">
        <div class="overlay"></div>
            <div class="container">
                <div class="contact-form">
                    <center><img src="images/logo.png" /></center>
                    <form>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                               <div class="form-group">
                                 <h4><span class="lang" key="welcome">Benvingut a l'Administrador Nom a nom</span></h4>
                                 <h6><span class="lang" key="loginlbl">Si us plau, acredita't:</span></h6>
                               </div>
                               <div class="form-group">
                                 <input type="text" class="form-control form-control-lg" placeholder="user" name="user" id="user" value="">
                               </div>
                               <div class="form-group">
                                 <input type="password" class="form-control form-control-lg" placeholder="password" name="pwd" id="pwd" value="">
                               </div>
                               <input type="button" class="btn btn-secondary btn-block" id="btnLogin" value="Validar" onclick="fn_validate()">
                            </div>
                        </div>
                    </form>
                    <form name='formPanel' id='formPanel' action='panel.php' method='post'>
                        <input type='hidden' name='userId' id='userId' value=''>
                        <input type='hidden' name='userName' id='userName' value=''>
                     </form>
                </div>
            </div>
    </header> 


     <script type="text/javascript">
        
         $(document).ready(function () {
            $('.header').height($(window).height());

            $.ajax({
                type: "get",
                url: "config/lang.json"
            }).done(function (data) {
                arrayLang = data;
            })        
         })

        // enter -> enviar formulari
        $("#pwd").keyup(function(event){
            if(event.keyCode === 13){
                event.preventDefault();
                fn_validate();
            }
        });

        function fn_translate(lang){
            $(".lang").each(function(index, element) {
                $(this).text(arrayLang[lang][$(this).attr("key")]);
            });     
            $('#btnLogin').attr('value',arrayLang[lang]["login"]);       
        }

        function fn_validate(){
            if (($("#user").val()=="") || ($("#pwd").val()=="")){
                toastr.error("Cal introduir usuari i password", "Warning");
                return;
            }
            var params = {
                "action": "validateUserAdmin",
                "user": $("#user").val(),
                "pwd": $("#pwd").val()
            };
            $.ajax({
                type: "POST",
                url: "crud.php",
                data: params
            }).done(function (data) {
                if (data.trim()=="-1") {
                    toastr.error("Usuari incorrecte", "Error");
                }
                else if (data.indexOf("Warning")!=-1){
                    toastr.error("Error de connexió a la BBDD", "Error");
                }
                else {
                    toastr.success("Usuari validat");
                    $("#userId").val(JSON.parse(data)[0].id);
                    $("#userName").val(JSON.parse(data)[0].name);
                    document.getElementById("formPanel").submit();
                }
            })

        }


    </script>
</body>
</html>
