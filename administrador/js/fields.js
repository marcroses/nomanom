function getFields(){
  var params = {
      "action": "getFields"
  };
  $.ajax({
      type: "POST",
      url: "crud.php",
      data: params
  }).done(function (data) {
      if (data.trim()!="-1") {
          JSON_Fields = JSON.parse(data.trim());
          initFields();
          
      }
  })    
} 



function initFields(){
  $('#listFields').empty()
    if (JSON_Fields!=null){
      for (var i=0; i < JSON_Fields.length; i++) {
        var checkField = "";
        if (JSON_Fields[i].editable==1) checkField="checked";

        var item = '<a class="list-group-item">';
        item += '<table style="width:100%;">';
        item += ' <tbody><tr>';
        item += '   <td style="width:75px;"><div class="custom-control form-control-lg custom-checkbox">';
        item += '     <input type="checkbox" class="form-control" id="cbField_' + JSON_Fields[i].id + '" style="height: 20px; top: 5px; position: relative; left: -5px;" ' + checkField + '>';
        item += '     </div></td>'; 
        item += '   <td><div style="padding:10px;">  <h6 class="list-group-item-heading">' + JSON_Fields[i].name + '</h6></div></td>';
        item += ' </tr></tbody>';      
        item += '</table>';      
        item += '</a>';      
  
        $("#listFields").append(item);
      }

    }
}