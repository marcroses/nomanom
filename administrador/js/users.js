var currentUserAction ='saveUser';
function getUsers(){
    var params = {
        "action": "getUsers"
    };
    $.ajax({
        type: "POST",
        url: "crud.php",
        data: params
    }).done(function (data) {
        if (data.trim()!="-1") {
            JSON_Users = JSON.parse(data.trim());
            initUsers();
            
        }
    })    
}  


function initUsers(){
  $('#listUsers').empty()
    if (JSON_Users!=null){
      for (var i=0; i < JSON_Users.length; i++) {
        var item = '<a class="list-group-item">';
        item += '<table style="width:100%;">';
        item += ' <tbody><tr>';
        item += '   <td><div style="padding:10px;">  <h5 class="list-group-item-heading">' + JSON_Users[i].username + '</h5>  <span>' + JSON_Users[i].first_name + ' ' + JSON_Users[i].last_name + '</span></div></td>';
        item += '   <td style="text-align:right;width:60px;"><button type="button" class="btn btn-primary" style="background-color: #bbbbbb;border: 1px #999999 solid;" onclick="userConfig('+ JSON_Users[i].id + ')"><i class="fa fa-cog"></i>&nbsp;</button></td>'
        item += '   <td style="text-align:right;width:60px;"><button type="button" class="btn btn-danger" onclick="deleteUser(' + JSON_Users[i].id + ')"><i class="fa fa-remove"></i>&nbsp;</button></td>'
  /*
        <td style="text-align:right;width:250px;"><div><button type="button" class="btn btn-default" onclick="window.open('r1_2019.php?idJugador=1697&amp;full=true', '_blank')">Fitxa Inicial</button>&nbsp;&nbsp;</div></td>
        
  
  */
        item += ' </tr></tbody>';      
        item += '</table>';      
        item += '</a>';      
  
        $("#listUsers").append(item);
      }

    }
  
}

function userConfig(id){
  currentUserAction = "saveUser";
  if (JSON_Users!=null){
    for (var i=0; i < JSON_Users.length; i++) {
      if (JSON_Users[i].id==id){
        $("#currentUserModal").val(JSON_Users[i].id);
        $("#frm_user_first_name").val(JSON_Users[i].first_name);
        $("#frm_user_last_name").val(JSON_Users[i].last_name);
        $("#frm_user_username").val(JSON_Users[i].username);
        $("#frm_user_pwd").val(JSON_Users[i].password);
        $("#frm_user_mail").val(JSON_Users[i].email);
        $("#is_staff").prop( "checked", false );
        if (JSON_Users[i].is_staff==1) $("#is_staff").prop( "checked", true );

        break;
      }
    }
  }  
  $('#userConfigModal').modal('show');
}

function userAddConfig(){
  currentUserAction = "insertUser";
  $("#frm_user_first_name").val('');
  $("#frm_user_last_name").val('');
  $("#frm_user_username").val('');
  $("#frm_user_pwd").val('');
  $("#frm_user_mail").val('');
  $("#is_staff").prop( "checked", false );
  $('#userConfigModal').modal('show');
}


function saveUser(){
  var params = {
    "action": currentUserAction
    , "id": $("#currentUserModal").val()
    , "frm_user_first_name": $("#frm_user_first_name").val()
    , "frm_user_last_name": $('#frm_user_last_name').val()
    , "frm_user_username": $('#frm_user_username').val()
    , "frm_user_pwd": $("#frm_user_pwd").val()
    , "frm_user_mail": $("#frm_user_mail").val()
    , "is_staff": $("#is_staff").prop( "checked")
    };
    $.ajax({
        type: "POST",
        url: "crud.php",
        data: params
    }).done(function (data) {
        if (data.trim()=="ok") {
            toastr.success("Dades guardades", "Correcte!");
            $('#userConfigModal').modal('hide');
            getUsers();
        }
        else{
            toastr.error(data, "Error");
        }
    })   
}


function insertUser(){
  var params = {
    "action": currentUserAction
    , "frm_user_first_name": $("#frm_user_first_name").val()
    , "frm_user_last_name": $('#frm_user_last_name').val()
    , "frm_user_pwd": $("#frm_user_pwd").val()
    , "frm_user_username": $('#frm_user_username').val()
    , "frm_user_mail": $("#frm_user_mail").val()
    , "is_staff": $("#is_staff").prop( "checked")
    };
    $.ajax({
        type: "POST",
        url: "crud.php",
        data: params
    }).done(function (data) {
        if (data.trim()=="ok") {
            toastr.success("Dades guardades", "Correcte!");
            $('#userConfigModal').modal('hide');
            getUsers();
        }
        else{
            toastr.error(data, "Error");
        }
    })   
}

function deleteUser(id){
  var params = {
    "action": "deleteUser"
    , "id": id
    };
    $.ajax({
        type: "POST",
        url: "crud.php",
        data: params
    }).done(function (data) {
        if (data.trim()=="ok") {
            toastr.success("Dades guardades", "Correcte!");
            $('#userConfigModal').modal('hide');
            getUsers();
        }
        else{
            toastr.error(data, "Error");
        }
    })   
}