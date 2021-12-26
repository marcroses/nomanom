var activeBaseLayer = 0;

function setSpan1() {

    for (var i = 0; i < $(".tc-ctl-bms-branch").children().length; i++) {
        $(".tc-ctl-bms-branch").children()[i].children[0].children[1].style.borderColor = "rgba(255, 0, 0, 0)";
        $(".tc-ctl-bms-branch").children()[i].children[0].children[1].style.backgroundColor = "";
        $(".tc-ctl-bms-branch").children()[i].children[0].children[0].disabled = false;
        $(".tc-ctl-bms-branch").children()[i].children[0].style.cursor = "pointer";

    }

    var capa = map.getLayers().array_[0];
    for (var i = 0; i < $(".tc-ctl-bms-branch").children().length; i++) {
        if ($(".tc-ctl-bms-branch").children()[i].attributes[1].value == map.getLayers().array_[0].values_.name) {
            $("#lbl_baseLayer1").html($(".tc-ctl-bms-branch").children()[i].innerText);
            $(".tc-ctl-bms-branch").children()[i].children[0].children[1].style.backgroundColor = "rgba(122, 133, 0, 0.5)";
            $(".tc-ctl-bms-branch").children()[i].children[0].children[0].disabled = true;
            $(".tc-ctl-bms-branch").children()[i].children[0].style.cursor = "default";
            break;
        }
    }

    //Deshabilitem 2a capa base
    for (var i = 0; i < $(".tc-ctl-bms-branch").children().length; i++) {
        if ($(".tc-ctl-bms-branch").children()[i].attributes[1].value == map.getLayers().array_[1].values_.name) {
            $(".tc-ctl-bms-branch").children()[i].children[0].children[1].style.backgroundColor = "rgba(0,124,206,0.3)";
            $(".tc-ctl-bms-branch").children()[i].children[0].children[0].disabled = true;
            $(".tc-ctl-bms-branch").children()[i].children[0].style.cursor = "default";
            break;
        }
    }

    $("#rangeTransparency").val(0);
    map.getLayers().array_[0].setOpacity(1);
    map.getLayers().array_[1].setOpacity(0);
    map.render();

}

function setSpan2() {
    for (var i = 0; i < $(".tc-ctl-bms-branch").children().length; i++) {
        $(".tc-ctl-bms-branch").children()[i].children[0].children[1].style.borderColor = "rgba(255, 0, 0, 0)";
        $(".tc-ctl-bms-branch").children()[i].children[0].children[1].style.backgroundColor = "";
        $(".tc-ctl-bms-branch").children()[i].children[0].children[0].disabled = false;
        $(".tc-ctl-bms-branch").children()[i].children[0].style.cursor = "pointer";
    }

    var capa = map.getLayers().array_[0];
    for (var i = 0; i < $(".tc-ctl-bms-branch").children().length; i++) {
        //if ($(".tc-ctl-bms-branch").children()[i].attributes[1].value == map.getLayers().array_[1].getSource().layer_) {
        if ($(".tc-ctl-bms-branch").children()[i].attributes[1].value == map.getLayers().array_[1].values_.name) {
            $("#lbl_baseLayer2").html($(".tc-ctl-bms-branch").children()[i].innerText);
            $(".tc-ctl-bms-branch").children()[i].children[0].children[1].style.backgroundColor = "rgba(0,124,206,0.58)"
            $(".tc-ctl-bms-branch").children()[i].children[0].children[0].disabled = true;
            $(".tc-ctl-bms-branch").children()[i].children[0].style.cursor = "default";
            break;
        }
    }

    //Deshabilitem 1a capa base
    for (var i = 0; i < $(".tc-ctl-bms-branch").children().length; i++) {
        if ($(".tc-ctl-bms-branch").children()[i].attributes[1].value == map.getLayers().array_[0].values_.name) {
            $(".tc-ctl-bms-branch").children()[i].children[0].children[1].style.backgroundColor = "rgba(122, 133, 0, 0.3)";
            $(".tc-ctl-bms-branch").children()[i].children[0].children[0].disabled = true;
            $(".tc-ctl-bms-branch").children()[i].children[0].style.cursor = "default";
            break;
        }
    }

    $("#rangeTransparency").val(100);
    map.getLayers().array_[0].setOpacity(1);
    map.getLayers().array_[1].setOpacity(1);
    map.render();
}

function selectB1() {
    for (var i = 0; i < $(".tc-ctl-bms-branch").children().length; i++) {
        $(".tc-ctl-bms-branch").children()[i].children[0].children[1].style.borderColor = "rgba(255, 0, 0, 0)";
        $(".tc-ctl-bms-branch").children()[i].children[0].children[1].style.backgroundColor = "";
        $(".tc-ctl-bms-branch").children()[i].children[0].children[0].disabled = false
    }


    for (var i = 0; i < $(".tc-ctl-bms-branch").children().length; i++) {
        if ($(".tc-ctl-bms-branch").children()[i].attributes[1].value == map.getLayers().array_[0].values_.name) {
            $("#lbl_baseLayer1").html($(".tc-ctl-bms-branch").children()[i].innerText);
            $(".tc-ctl-bms-branch").children()[i].children[0].children[1].style.backgroundColor = "rgba(122, 133, 0, 0.5)";
            $(".tc-ctl-bms-branch").children()[i].children[0].children[0].disabled = true
            break;
        }
    }

    //Deshabilitem 2a capa base
    for (var i = 0; i < $(".tc-ctl-bms-branch").children().length; i++) {
        if ($(".tc-ctl-bms-branch").children()[i].attributes[1].value == map.getLayers().array_[1].values_.name) {
            $(".tc-ctl-bms-branch").children()[i].children[0].children[1].style.backgroundColor = "rgba(0,124,206, 0.3)";
            $(".tc-ctl-bms-branch").children()[i].children[0].children[0].disabled = true
            break;
        }
    }

    $("#td_baseLayer1")[0].classList.add("activo");
    $("#td_baseLayer2")[0].classList.remove("activo");
    activeBaseLayer = 0;
    $("#td_baseLayer1")[0].style.backgroundColor = "rgb(142,154,4)";
    $("#td_baseLayer2")[0].style.backgroundColor = "rgb(166,166,167)";

}


function selectB2() {
    for (var i = 0; i < $(".tc-ctl-bms-branch").children().length; i++) {
        $(".tc-ctl-bms-branch").children()[i].children[0].children[1].style.borderColor = "rgba(255, 0, 0, 0)";
        $(".tc-ctl-bms-branch").children()[i].children[0].children[1].style.backgroundColor = "";
        $(".tc-ctl-bms-branch").children()[i].children[0].children[0].checked = false
    }


    for (var i = 0; i < $(".tc-ctl-bms-branch").children().length; i++) {
        if ($(".tc-ctl-bms-branch").children()[i].attributes[1].value == map.getLayers().array_[1].values_.name) {
            $("#lbl_baseLayer2").html($(".tc-ctl-bms-branch").children()[i].innerText);
            $(".tc-ctl-bms-branch").children()[i].children[0].children[1].style.backgroundColor = "rgba(0,124,206,0.58)"
            $(".tc-ctl-bms-branch").children()[i].children[0].children[0].checked = true
            break;
        }
    }

    //Deshabilitem 1a capa base
    for (var i = 0; i < $(".tc-ctl-bms-branch").children().length; i++) {
        if ($(".tc-ctl-bms-branch").children()[i].attributes[1].value == map.getLayers().array_[0].values_.name) {
            $(".tc-ctl-bms-branch").children()[i].children[0].children[1].style.backgroundColor = "rgba(122, 133, 0, 0.3)";
            $(".tc-ctl-bms-branch").children()[i].children[0].children[0].checked = true
            break;
        }
    }

    $("#td_baseLayer2")[0].classList.add("activo");
    $("#td_baseLayer1")[0].classList.remove("activo");
    activeBaseLayer = 1;
    $("#td_baseLayer2")[0].style.backgroundColor = "rgb(0,124,206)";
    $("#td_baseLayer1")[0].style.backgroundColor = "rgb(166,166,167)";
}



function setBaseLayerCustom(layer) {
    if (activeBaseLayer == 0) {
        map.getLayers().removeAt(0);
        map.getLayers().insertAt(0, layer);
        setSpan1();
    }
    if (activeBaseLayer == 1) {
        map.getLayers().removeAt(1);
        map.getLayers().insertAt(1, layer);
        setSpan2();
    }
}
