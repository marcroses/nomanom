
function omplirModal(trSeleccionat) {
    enviar.unbind("click"); 
    var inputs = $(".input-select");
    if ($(this).text().trim() == "Afegir") {
        enviar.text("Crear");
        enviar.on("click", function () {
            var valors = '{"accio":"insertar_' + $("#title").text() + '"';
            for (var i = 0; i < inputs.length; i++) {
                var id_aux = inputs[i].id;
                var titol = id_aux.substring(0, id_aux.indexOf("_"));
                valors += ',"' + titol + '":"' + inputs[i].value + '"';
            }
            valors += "}";
            $.ajax({
                type: "GET",
                url: "query.aspx",
                data: JSON.parse(valors)
            }).done(function (data) {
                if (data.indexOf("Error") != -1) {
                    toastr.error("Error en la consulta: " + data, "Error");
                }
                else {
                    $('#modal').modal('hide');
                    toastr.success("Registre inserit correctament");
                    llistar();
                }
            }).fail(function (a, b) { });
        });
        for (var i = 0; i < inputs.length; i++) {
            if ($(inputs[i]).attr('readonly') == "readonly") inputs[i].value = " ";
            else inputs[i].value = "";
        }
    } else {
        enviar.text("Modificar");
        enviar.on("click", function () {
            var valors = '{"accio":"modificar' + $("#title").text() + '"';
            for (var i = 0; i < inputs.length; i++) {
                var id_aux = inputs[i].id;
                var titol = id_aux.substring(0, id_aux.indexOf("_"));
                valors += ',"' + titol + '":"' + inputs[i].value + '"';
            }
            valors += "}";
            $.ajax({
                type: "GET",
                url: "query.aspx",
                data: JSON.parse(valors)
            }).done(function (data) {
                if (data.indexOf("Error") != -1) {
                    toastr.error("Error en la consulta: " + data, "Error");
                }
                else {
                    $('#modal').modal('hide');
                    toastr.success("Registre modificat correctament");
                    llistar();
                }
            }).fail(function (a, b) { });
        });
        var i = 0;
        $.each(trSeleccionat, function (index, element) {
            inputs[i].value = element;
            i++;
        });
        /*
        for (var i = 0; i < inputs.length; i++) {
            inputs[i].value = trSeleccionat[i].innerHTML;
        }
        */
    }
}

function crearTaula() {
    var form = $("#form");
    var columnes = [];
    var c = resultat[0];
    form.empty();
    if ($("#title").text() == "Mapes") {
        form.css({
            "display": "grid",
            "grid-template-columns": "auto auto",
            "grid-gap": "1rem"
        });
        $(".modal-dialog").css("max-width", "900px");
    } else {
        $(".modal-dialog").css("max-width", "500px");
        form.css("display", "block");
    }
    for (var colName in c) {
        var aux = (colName.charAt(0).toUpperCase() + colName.slice(1));
        if (colName == "idGrup" || colName == "idServei" || (colName == "id" && $("#title").text() != "Serveis")) {
            form.append(`
                        <div class="form-group">
                            <label for="${colName}_nou" class="col-form-label">${aux}:</label>
                            <input type="text" class="form-control input-select" id="${colName}_nou" name="${colName}_nou" readonly >
                        </div>
                    `);
        } else if (colName == "estaDisponible") {
            $("#form").append(`
                                     <div class="form-group">
                                            <label for="${colName}_nou" class="col-form-label">${aux}:</label>
                                            <select id="${colName}_nou" class="form-control input-select" name="${colName}_nou">
                                                <option value="true">true</option>
                                                <option value"false">false</option>
                                            </select>
                                        </div>
                                        `);
        }
        else {
            form.append(`
                        <div class="form-group">
                            <label for="${colName}_nou" class="col-form-label">${aux}:</label>
                            <input type="text" class="form-control input-select" id="${colName}_nou" name="${colName}_nou">
                        </div>
                    `);
        }
        columnes.push({
            field: colName,
            title: aux
        });
    }
    $('#table').bootstrapTable({
        data: resultat
        , search: true
        , ordering: true
        , columns: [columnes]
        //, theadClasses: "thead-dark"
    });

    var $table = $('#table');
    var $search = $table.data('bootstrap.table').$toolbar.find('.search input');
    $search.attr('placeholder', 'Filtra per paraula');
    $search.attr('width', '100%');
    /*
    $("tr").on("click", function () {
        var trs = $("tr");
        if (this != trs[0]) {
            for (var i = 0; i < trs.length; i++) {
                if (this.cells[0].innerText != "Id") {
                    if (this == trs[i]) {
                        if ($("#title").text() == "Projectes") {
                            window.open("projectes.aspx?nomUsuari=admin&idProjecte=" + $(this)[0].cells[0].childNodes[0].nodeValue);
                        } else {
                            omplirModal($(this)[0].cells);
                            $('#modal').modal('show');
                        }
                    }
                }
            }
        }
    });
    */
    $('#table').on('click-row.bs.table', function (e, row, $element) {
        //alert(row.id);
        if ($("#title").text() == "Projectes") {
            window.location="projectes.aspx?nomUsuari=admin&idProjecte=" + row.id;
        } else {
            omplirModal(row);
            $('#modal').modal('show');
        }
    });
    var altura = window.innerHeight;
    altura = altura - 140;
    if (altura < 400) altura = 400;
    $('#table').bootstrapTable('resetView', { height: altura });

}
var llistatServeis = [];
var valorsInput1;
var valorsInput2;
var valorsAfegits;

function crearJsonMapes() {
    var nouJson = {
        mapes: []
    };
    var mapes = $("#llistat_afegits").children();
    for (var i = 0; i < mapes.length; i++) {
        var input = mapes[i].children[0].children[0];
        var id = input.defaultValue.trim();
        var isDefault = input.checked;
        var mapa = {
            id: id,
            isDefault: isDefault
        }
        nouJson["mapes"].push(mapa);
    }
    return nouJson;
}

function omplirModal2(nom, obj) {
    $("#modal2 .modal-title").text(nom);
    $("#modal2 #title_projecte").text(obj[1].innerHTML);

    $("#modal2_content").empty();
    var resultat = `
                                        <div class="select-group">
                                            <div class="form-group row">
                                                <label class="col-sm-2 control-label" for="totLlistat">${nom}:</label>
                                                <div class="col-sm-10">
                                                    <select class="selectpicker" id="selectTots" data-live-search="true" title="Seleccionar..." name="totLlistat"></select>
                                                </div>
                                            </div>
                                        `;
    if (nom == "Serveis") {
        resultat += `<div class="form-group row">
                                                <label for="grupLlistat" class ="control-label col-sm-2">Grups:</label>
                                                <div class="col-sm-10">
                                                    <select class="selectpicker" data-live-search="true" id="grupTots" title="Seleccionar..." name="grupLlistat"></select>
                                                </div>
                                            </div>
                                        `;
    }
    resultat += `
                                            <button type="button" class="btn btn-success" id="afegirBtn">Afegir</button>
                                         </div>
                                            <h5>${nom} Disponibles</h5>
                                            <ul class ="list-group list-group-flush" id="llistat_afegits"></ul>
                                            <div class ="col-md-12 text-center">
                                                <button class ="btn btn-success guardarCanvis">Guardar Canvis</button>
                                            </div>

                                    `;
    $("#modal2_content").append(resultat);
    $('.selectpicker').selectpicker();


    var valors = '{"accio" : "' + nom + '", "id" : "' + obj[0].innerHTML + '"}';
    $.ajax({
        type: "GET",
        url: "query.aspx",
        data: JSON.parse(valors)
    }).done(function (data) {
        if (data.indexOf("Error") != -1) {
            toastr.error("Error en la consulta: " + data, "Error");
        }
        else {
            var resultats = data.split("|");

            valorsInput1 = JSON.parse(resultats[0]);
            if (nom == "Serveis") {
                valorsInput2 = JSON.parse(resultats[1]);
                valorsAfegits = JSON.parse(resultats[2]);
            } else {
                valorsAfegits = JSON.parse(resultats[1]);
            }


            tot(nom);
            $("#afegirBtn").click(function () {
                // select1
                var s1 = $("#selectTots option:selected");
                // si és servei, select2
                var s2;
                if (s1.val() != "") {
                    if (nom == "Serveis") {
                        s2 = $("#grupTots option:selected");
                        if (s2.val() != "") {
                            if (!existeixGrup(s2.val())) { // el grup seleccionat no existeix, per tant el tenim que crear
                                afegirGrupJson(s2.val(), s2.text());
                            }
                            eliminarJson1(s1.val());
                            afegirServeiJson(s2.val(), s1);

                        } else {
                            toastr.error("Seleccionar el que vols afegir", "Error");
                        }
                    } else { // no és serveis
                        eliminarJson1(s1.val());
                        afegirElement(s1, nom == "Mapes");
                    }
                    actualitzarInputs(s1);
                    tot(nom);
                } else {
                    toastr.error("Seleccionar el que vols afegir", "Error");
                }
            });

            $(".guardarCanvis").on("click", function (event) {
                // Recorrem els diferents li 'disponibles'
                //$("");
                var newJson;

                if (nom == "Serveis") {
                    newJson = crearJson();
                } else if (nom == "Mapes") {
                    var input = $('input[name=mapa]:checked');
                    if (input.length == 0) { // missatge d'error
                        toastr.error("Selecciona un mapa per defecte");
                        event.preventDefault();
                        return false;
                    }
                    newJson = crearJsonMapes();
                } else newJson = valorsAfegits;

                var valors = {
                    "accio": "actualitzar",
                    "idProjecte": idProjecte,
                    "tipus": nom,
                    "valors": JSON.stringify(newJson)
                };

                $.ajax({
                    //type: "GET",
                    //url: "query.aspx",

                    type: "POST",
                    url: "query2.aspx",
                    data: valors
                }).done(function (data) {
                    if (data.indexOf("Error") != -1) {
                        toastr.error("Error en la consulta: " + data, "Error");
                    }
                    else {
                        //('#modal').modal('hide');
                        toastr.success("Canvis modificats correctament");
                    }
                })
            });
        }
    }).fail(function (a, b) { });
}

function crearJson() {
    var nouJson = {
        "valors": []
    };
    var grups = $("#llistat_afegits").children();
    for (var i = 0; i < grups.length; i++) {
        var grup = grups[i];
        var text = grup.innerText;
        var newGrup = {
            id: grup.id.split("-")[1],
            nom: text.substring(0, text.indexOf("\n")),
            serveis: []
        };
        var aux = grup.children[1].children;
        for (var u = 0; u < aux.length; u++) {
            var textAux = aux[u].innerHTML;
            var nouServei = {
                id: aux[u].id,
                nom: textAux.substring(0, textAux.indexOf("<"))
            };
            newGrup["serveis"].push(nouServei);
        }
        nouJson["valors"].push(newGrup);
    }
    return nouJson;
}

function afegirElement(s1, isMapa) {
    if (isMapa) {
        valorsAfegits.push({
            id: s1.val(),
            nom: s1.text(),
            isDefault: null
        });
    } else {
        valorsAfegits.push({
            id: s1.val(),
            nom: s1.text(),
        });
    }

}

function tot(nom) {
    afegirContingutInput1();
    if (nom == "Serveis") afegirContingutInput2();
    $('.selectpicker').selectpicker('refresh');
    afegirContingutAfegits(nom);
    eliminarAccio();
    if (nom == "Mapes") inputRadioListener();
}

function inputRadioListener() {
    $('input[name=mapa]').change(function () {
        var id = $('input[name=mapa]:checked').val();
        for (var i = 0; i < valorsAfegits.length; i++) {
            var mapa = valorsAfegits[i];
            if (parseInt(mapa.id) == id) mapa.isDefault = true;
            else mapa.isDefault = null;
        }
    });
}

function getPosicioGrup(id) {
    for (var i = 0; i < valorsAfegits["grups"].length; i++) {
        var grup = valorsAfegits["grups"][i];
        if (grup["id"] == id) return i;
    }
}

function getPosicio1(array, id) {
    for (var i = 0; i < array.length; i++) {
        var servei = array[i].id;
        if (servei == id) return i;
    }
}

function eliminarAccio() {
    $(".eliminarBtn").click(function () {
        if ($("#H1").text() == "Serveis") {
            var v = $(this).attr('id').split("-");
            var id = getPosicioGrup(v[0]);
            var posS = getPosicio1(valorsAfegits["grups"][id]["serveis"], v[1]);
            var nom = valorsAfegits["grups"][id]["serveis"][posS]["nom"];
            //valorsAfegits["grups"][id]["serveis"].splice(posS, 1);
            eliminarDelJson(valorsAfegits["grups"][id]["serveis"], posS);
            // Si és l'ultim servei en el grup, també eliminar el grup
            if (valorsAfegits["grups"][id]["serveis"].length == 0) eliminarDelJson(valorsAfegits["grups"], id);  //valorsAfegits["grups"].splice(id, 1);
            // Afegim el servei al input
            valorsInput1.push({
                id: parseInt(v[1]),
                nom: nom
            });
        } else {
            var v = $(this).attr('id');
            var pos = getPosicio1(valorsAfegits, v);
            valorsInput1.push({
                id: v,
                nom: valorsAfegits[pos].nom
            });
            eliminarDelJson(valorsAfegits, pos);
        }
        tot($("#H1").text());
    });
}

function eliminarDelJson(array, posI) {
    array.splice(posI, 1);
}

function existeixGrup(idGrup) {
    return $("#g-" + idGrup).length ? true : false;
}

function actualitzarInputs(serveiItem) {
    var grup = $('#selectTots');
    var servei = $('#grupTots');
    grup.val('').trigger('change');
    serveiItem.remove();
    servei.selectpicker('refresh');
}

function afegirServeiJson(idGrup, serveiItem) {
    var posGrup = getPosicioGrup(idGrup);

    valorsAfegits["grups"][posGrup]["serveis"].push({
        id: serveiItem.val(),
        nom: serveiItem.text()
    });
}

function eliminarJson1(id) {
    for (var i = 0; i < valorsInput1.length; i++) {
        if (valorsInput1[i].id = id) {
            valorsInput1.splice(i, 1);
            return;
        }
    }
}

function getPosicioGrup(id) {
    for (var i = 0; i < valorsAfegits["grups"].length; i++) {
        var grup = valorsAfegits["grups"][i];
        if (grup["id"] == id) return i;
    }
}

function afegirGrupJson(id, nom) {
    valorsAfegits["grups"].push({
        id: id,
        nom: nom,
        serveis: []
    });
}

function afegirContingutInput1() {
    $("#selectTots").empty();

    if (valorsInput1.length != 0) {
        valorsInput1.sort(function (a, b) { return a.nom.localeCompare(b.nom) });
        for (var i = 0; i < valorsInput1.length; i++) {
            $("#selectTots").append('<option value="' + valorsInput1[i].id + '">' + valorsInput1[i].nom + '</option>');
        }
        $("#afegirBtn").attr("disabled", false);
    } else {
        $("#afegirBtn").attr("disabled", true);
    }
}

function afegirContingutInput2() {
    $("#grupTots").empty();
    for (var i = 0; i < valorsInput2.length; i++) {
        $("#grupTots").append('<option value="' + valorsInput2[i].id + '">' + valorsInput2[i].nom + '</option>');
    }
}

function afegirSortEvent() {
    $("#llistat_afegits").sortable({
        axis: "y",
        containment: "parent",
        connectWith: "#llistat"
    });
    $(".serveis").sortable({
        axis: "y",
        containment: "parent",
        connectWith: ".serveis"
    });
}

function afegirContingutAfegits(nom) {
    $("#llistat_afegits").empty();

    if (valorsAfegits.length != 0) {
        if (nom == "Serveis") {
            var grups = valorsAfegits["grups"];
            for (var i = 0; i < grups.length; i++) {
                var grup = grups[i];
                crearGrup(grup["id"], grup["nom"]);

                var serveis = grup["serveis"];
                for (var u = 0; u < serveis.length; u++) {
                    var servei = serveis[u];
                    crearServei(grup["id"], servei["id"], servei["nom"]);
                }
            }

            // drag
            afegirSortEvent();

        } else if (nom == "Mapes") {
            for (var i = 0; i < valorsAfegits.length; i++) {
                var cont = `
                                                <li class="list-group-item">
                                                    <div>
                                                        <input type="radio" name="mapa" value="${valorsAfegits[i].id} "
                                                `;
                if (valorsAfegits[i].isDefault != null) {
                    cont += `checked`;
                }
                cont += `>${valorsAfegits[i].nom}
                                                    </div>
                                                    <button type="button" class="btn btn-danger eliminarBtn" id="${valorsAfegits[i].id}">Eliminar</button></li>`;
                $("#llistat_afegits").append(cont);
            }
            afegirSortEvent();
        } else {
            for (var i = 0; i < valorsAfegits.length; i++) {
                $("#llistat_afegits").append(`
                            <li class="list-group-item">
                                    ${valorsAfegits[i].nom}<button type="button" class="btn btn-danger eliminarBtn" id="${valorsAfegits[i].id}">Eliminar</button></li>
                            `);
            }
        }
    }
}

function crearGrup(idGrup, nomGrup) {
    var contingut = `<div id="g-${idGrup}" class="grup" >
                <div class="title">${nomGrup}</div>
                <ul class="serveis"></ul></div>`;

    $("#llistat_afegits").append(contingut);
}

function crearServei(idGrup, idServei, nomServei) {
    var contingut = `<li class="list-group-item" id=${idServei} name=${idServei}>${nomServei}<button type="button" class ="btn btn-danger eliminarBtn" style="right:20px;position:absolute;top:8px;font-size:14px;padding:5px;" id='${idGrup}-${idServei}'>Eliminar</button></li>`;
    $("#g-" + idGrup + " .serveis").append(contingut);
}

function getNomTaula(nom) {
    if (nom == "Eines") return "eina";
    if (nom == "Mapes") return "projecte_mapa_de_fons";
    else return "servei";
}

function llistar() {
    $.ajax({
        type: "GET",
        url: "query.aspx",
        data: {
            accio: "llistar_" + $("#title").text()
        }
    }).done(function (data) {
        if (data.indexOf("Error") != -1) {
            //toastr["warning"]("Error el la consulta: " + data);
        }
        else {
            resultat = JSON.parse(data);
            content.empty();
            content.append(`<table id="table" data-toggle="table" data-search="true"  data-show-columns="true"></table>`);
            crearTaula();
            $('#table').bootstrapTable('refresh', { data: resultat });
        }
    }).fail(function (a, b) {

    });
}