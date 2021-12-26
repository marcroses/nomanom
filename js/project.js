
function getProjectInfo(){
    var params = {
        "action": "getProjectInfo"
    };
    $.ajax({
        type: "POST",
        url: "administrador/crud.php",
        data: params
    }).done(function (data) {
        if (data.trim()!="-1") {
            $("#lbl_project_name").text(JSON.parse(data.trim())[0].title);
            if (JSON.parse(data.trim())[0].logo==""){
                $("#project_logo").attr("src","administrador/images/logo5.png");
            }
            else{
                $("#project_logo").attr("src",JSON.parse(data.trim())[0].logo);
            }
            
            //$('#frm_description').code(JSON.parse(data.trim())[0].description);
            longitude = JSON.parse(data.trim())[0].longitude;
            latitude = JSON.parse(data.trim())[0].latitude;
            zoom = JSON.parse(data.trim())[0].zoom;
            primaryColor = JSON.parse(data.trim())[0].primary_color;
            /*
            $("#frm_color2").val(JSON.parse(data.trim())[0].color_2);
            $("#frm_color3").val(JSON.parse(data.trim())[0].color_3);
            $("#frm_color4").val(JSON.parse(data.trim())[0].color_4);
            $("#logoImage").attr("src",JSON.parse(data.trim())[0].logo);
            */
            getBaseLayersSource();
            getWMSSource();
            setStyle();
        }
    })    
}

function isEmpty(camp) {
    return camp.val() == "";
}

function ValidateEmail(contenidor)
{
    var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    if(document.getElementById(contenidor).value.match(mailformat))
    {
        return true;
    }
    else
    {
        return false;
    }
}

function setStyle(){
    $("#lbl_project_name").css("color",primaryColor);
    $("#btnLogInUp").css("background-color",primaryColor);
    $("#btnLoginDown").css("background-color",primaryColor);
    $("#btnLoginModal").css("background-color",primaryColor);
    $("#btnLoginModal").css("border-color",primaryColor);
    $("#avisInicial").css("background-color",primaryColor);
    $("#btnSearch").css("background-color",primaryColor);
    $("#btnSearch").css("border-color",primaryColor);
    $("#mapFrm_lbl_9").css("color",primaryColor);
    $("#btnAlta").css("color",primaryColor);
    $("#btnAlta").css("border-color",primaryColor);
    $("#link_alta").css("color",primaryColor);
    $("#btnAddUser").css("background-color",primaryColor);
    $("#btnAddUser").css("border-color",primaryColor);

}