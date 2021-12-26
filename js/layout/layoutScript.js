var tocHeightBefore;
var primaryColor = '#A8423D';

function preparaLayout() {
	
    var $ovPanel = $('.ovmap-panel');
    var map = $ovPanel.parent().data('map');
    var ovmap;
    var ctlLcatNum = -1; 

    if (window.innerWidth < 760) {
        $('#tools-panel').addClass("right-collapsed");  
    }

    $('.right-panel > h1').on("click", function (e) {
        e.preventDefault();
        e.stopPropagation();
        var $tab = $(e.target);
        var $panel = $tab.parent();
        $panel.toggleClass('right-collapsed');

        if (window.innerWidth < 760 || window.innerHeight < 550){
            if (!$('#silme-panel').hasClass("left-collapsed")){
                $('#silme-panel').toggleClass("left-collapsed");
                $('#silme-panel').removeClass("left-collapsed-silme");
                $('#silme-panel').removeClass("left-collapsed-legend");
                $('#silme-panel').removeClass("left-collapsed-ovmap");
            }
            if ($panel.hasClass("right-collapsed")) {
                $('#silme-panel').removeClass("left-opacity");
                $('.tc-ctl-nav-home').removeClass("tc-hidden");
                $('.tc-ctl-sv-btn').removeClass("tc-hidden");
                $('.tc-ctl-sb').css("visibility", "visible");
                $('.tc-ctl-scl').css("visibility", "visible");
            } else {
                $('#silme-panel').addClass("left-opacity");
                $('.tc-ctl-nav-home').addClass("tc-hidden");
                $('.tc-ctl-sv-btn').addClass("tc-hidden");
                $('.tc-ctl-sb').css("visibility", "hidden");
                $('.tc-ctl-scl').css("visibility", "hidden");
            }
        }
    });



    $('.measure > h2').on("click", function (e) {
        e.preventDefault();
        e.stopPropagation();
        var $tab = $(e.target);
        var $panel = $tab.parent();
        $panel.toggleClass('tc-collapsed');
    });

    $('.tools-panel').on("click", function (e) {
        var $tab = $(e.target);
        var $sv = $('.tc-ctl-sv'); 
        var $navHome = $('.tc-ctl-nav-home');

        if (ctlLcatNum == -1) { 
            var childs = $(e.target).parent().parent().children();
            for (var i = 0; i < childs.length; i++) {
                if ($(e.target).parent().parent().children()[i].classList.contains('tc-ctl-lcat')) {
                    ctlLcatNum = i;
                    break;
                }
            }
        }

        if ($tab.is('h2')) {
            var $ctl = $tab.parent();
            //if (map && map.layout) { // la opcio accordion ja no existeix && map.layout.accordion) {
                if ($ctl.hasClass("tc-collapsed")) {
                    //var $ctls = $(this).find('h2').parent().not('.tc-ctl-search');
                    var $ctls = $(this).find('h2').parent().not('.tc-ctl-search').not($(e.target).parent().parent().children()[ctlLcatNum]);
                    $ctls.not($ctl).addClass("tc-collapsed");
                }
            //}
            $ctl.toggleClass("tc-collapsed");

        }

        if ($tab.is('.tc-ctl-wlm-del') || $tab.is('.tc-ctl-wlm-del-all'))
        {
            if (!$('tc-ctl-wlm-empty').hasClass('tc-hidden') && $('#silme-panel').hasClass('left-collapsed-legend'))
            {
                $('#silme-panel').removeClass('left-collapsed-legend');
                $('#silme-panel').addClass('left-collapsed');
                
                $sv.addClass('tc-ctl-sv-coll');
                $sv.removeClass('tc-ctl-sv-exp');
                $navHome.addClass('tc-ctl-nav-home-coll');
                $navHome.removeClass('tc-ctl-nav-home-exp');
                //
                $('#search').toggleClass('search-left-collapsed');
                $('#links').toggleClass('links-collapsed');
            }
        }
    });

    $('.silme-panel').on("click", function (e) {
        var $tab = $(e.target);
        if ($tab.is('h2')) {
            var $ctl = $tab.parent();
            if (map && map.layout) { //la opció accordion ja no existeix && map.layout.accordion) {
                if ($ctl.hasClass("tc-collapsed")) {
                    var $ctls = $(this).find('h2').parent().not('.tc-ctl-search');
                    $ctls.not($ctl).addClass("tc-collapsed");
                }
            }
            $ctl.toggleClass("tc-collapsed");
        }
    });


    $(".tc-ctl-lcat-node").click(function (e) { //onCollapseButtonClick
        e.target.blur();
        e.stopPropagation();
        const li = e.target;
        if (li.tagName === 'LI'){
            if (!li.classList.contains(self.CLASS + '-leaf')) {
                if (li.classList.contains("tc-collapsed")) {
                    li.classList.remove("tc-collapsed");
                }
                else {
                    li.classList.add("tc-collapsed");
                }
                const ul = li.querySelector('ul');
                if (ul.classList.contains("tc-collapsed")) {
                    ul.classList.remove("tc-collapsed");
                }
                else {
                    ul.classList.add("tc-collapsed");
                }
            }
            else {
                var fulla = "1";
            }
        }
    });
}

function buildMark(valor){
    var listItems = $("#ulBaseLayers li");
    listItems.each(function(idx, li) {
        var product = $(li);
        product.css({'border' : 'none'});
        product.css({'border-radius' : '0px'});
    });    
    listItems.each(function(idx, li) {
        var product = $(li);
        if (product.data('tcLayerName')==valor){
            product.css({'border' : '2px ' + primaryColor + ' solid'});
            product.css({'border-radius' : '7px'});
        }
    });    

}

