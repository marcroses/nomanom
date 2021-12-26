var userId = '';
var username = '';
var userIsAdmin = 0;

function login(){
  var params = {
      "action": "validateUser"
      , "user": $("#usuari").val()
      , "pwd": $("#password").val()
  };
  $.ajax({
      type: "POST",
      url: "administrador/crud.php",
      data: params
  }).done(function (data) {
      if (data.trim()!="-1") {
        username = JSON.parse(data.trim())[0].name;
        userId = JSON.parse(data.trim())[0].id;
        userIsAdmin = parseInt(JSON.parse(data.trim())[0].is_superuser);
        $('#ModalLogin').modal('hide');

        var content = '<table style="width:100%;"><tr>';
        content += '    <td><span id="username_sp1">' + username + '</span>, <span class="lang" key="mapFrm_lbl_29">' + arrayLang[currentLang]["mapFrm_lbl_29"] + '</span> <strong><span id="numToponims"></span> <span class="lang" key="mapFrm_lbl_4">' + arrayLang[currentLang]["mapFrm_lbl_4"] + '</span></strong></td>';
        content += '    <td style="text-align:right;"><button type="button" id="btnFilter" class="btn btn-default" aria-label="Left Align" onclick="personalTopo()" title="' + arrayLang[currentLang]["mapFrm_lbl_36"] + '" style="background-color: ' + primaryColor + '; color: #fff;"><span class="fa fa-filter" aria-hidden="true"></span></button>&nbsp;';
        content += '      <button type="button" class="btn btn-default" aria-label="Left Align"  id="btnLogOut" onclick="logOut()" title="Log out" style="background-color: ' + primaryColor + '; color: #fff;"><span class="fa fa-sign-out" aria-hidden="true"></span></button>';
        content += '    </td></tr></table>';

        $("#divLoginUp").html(content);
        $("#avisInicial").css("visibility","hidden");
        $("#btnAdd")[0].style.display = "block"
        getTopoCountByUser();

      }
      else{
        toastr.error(arrayLang[currentLang]["mapFrm_lbl_44"], "Error");
      }
  })    
} 

function logOut(){
  var content = '<table style="width:100%;">';
  content += '  <tr><td>Per a col·laborar, accedeix com a usuari</td>';
  content += '  <td style="text-align:right;"><button type="button" class="btn btn-default" style="background-color: ' + primaryColor + '; color: #fff;" aria-label="Left Align" onclick=\'$("#ModalLogin").modal("show")\' title="Accedeix"><span class="fa fa-sign-in" aria-hidden="true"></span></button></td>';
  content += ' </tr></table>';
  
  $("#divLoginUp").html(content);
  $("#avisInicial").css("visibility","visible");
  $("#btnAdd")[0].style.display = "none";

  userId = '';
  username = '';
  userIsAdmin = 0;  
}

function getTopoCountByUser(){
  var params = {
      "action": "getTopoCountByUser"
      , "userId":userId
  };
  $.ajax({
      type: "POST",
      url: "administrador/crud.php",
      data: params
  }).done(function (data) {
      if (data.trim()!="0") {
        $("#numToponims").text(JSON.parse(data.trim())[0].total);
      }
      else{
        $("#numToponims").text('0');
      }
  })    
} 


function addUser() {
  totOk = true;
  if (isEmpty($("#nom")) || isEmpty($("#llinatge1")) || isEmpty($("#llinatge2")) || isEmpty($("#userName")) || isEmpty($("#pwd")) || isEmpty($("#email"))) {
      toastr.error(arrayLang[currentLang]["mapFrm_lbl_37"], "Error");
      totOk = false;
  }
  else {
      if (grecaptcha.getResponse() == "") {
          toastr["error"](arrayLang[currentLang]["mapFrm_lbl_40"]);
          totOk = false;
      }
      else {
          if (ValidateEmail("email")==false){
              toastr["error"](arrayLang[currentLang]["mapFrm_lbl_41"]);
          }
          else{
              $.ajax({
                  url: 'administrador/crud.php',
                  data: { action: "verifyEmail", email: $("#email").val()},
                  type: 'POST',
                  success: function (data) {
                      if (data.trim() == 1) {
                          toastr.error(arrayLang[currentLang]["mapFrm_lbl_42"], "Error");
                      }
                      else {
                          $.ajax({
                              url: 'administrador/crud.php',
                              data: { action: "verifyName", username: $("#userName").val() },
                              type: 'POST',
                              success: function (data) {
                                  if (data.trim() == 1) {
                                      toastr.error(arrayLang[currentLang]["mapFrm_lbl_43"], "Error");
                                  }
                                  else {
                                      $.ajax({
                                          url: 'administrador/crud.php',
                                          data: {
                                            action: "insertUser"
                                              , frm_user_pwd: $("#pwd").val()
                                              , frm_user_username: $("#userName").val()
                                              , frm_user_first_name: $("#nom").val()
                                              , frm_user_last_name: $("#llinatge1").val() 
                                              , frm_user_mail: $("#email").val()
                                              , is_staff: 0
                                              , language: language
                                          },
                                          type: 'POST',
                                          success: function (data) {
                                              if (data.trim() != "ok") {
                                                  toastr.error("Errada en la creació de l'usuari", "Error");
                                              }
                                              else {
                                                  $("#usuari").val($("#userName").val());
                                                  $("#password").val($("#pwd").val());
                                                  toastr.success(arrayLang[currentLang]["mapFrm_lbl_45"]);
                                                  setTimeout(function () {
                                                      login();
                                                      $('#ModalSignUp').modal('hide');
                                                  }, 4000);
                                                  
                                              }
                                          }
                                      });
                                  }
                              }
                          });


                      }
                  }
              });
          }

      }
  }

}