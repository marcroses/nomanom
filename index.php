<?php
    require_once "connectdb.php";

    $sql = "select * from project";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $language = $row["language"];
            $title = $row["title"];
            $logo = $row["logo"];
            $photo = $row["photo"];
            $primary_color = $row["primary_color"];
            $title = $row["title"];
            $description = $row["description"];
            $color2 = $row["color2"];
        }
    }  

    list($r, $g, $b) = sscanf($primary_color, "#%02x%02x%02x");
    
    //Total users
    $sql = "select count(id) as total from auth_user";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $auth_user = $row["total"];
        }
    }    

    //Total toponyms
    $sql = "select count(id) as total from named_place";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $named_place = $row["total"];
        }
    }    

    //toponyms by user
    $sql = "select auth_user.username as informador, count(named_place.id) as numToponims from named_place inner join auth_user on auth_user.id=author_id  group by auth_user.username order by count(named_place.id) desc  limit 5";
    $labelUsers="";
    $topoUsers="";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $labelUsers=$labelUsers."'".$row["informador"]."',";
            $topoUsers=$topoUsers.$row["numToponims"].",";
        }
        $labelUsers = substr($labelUsers,0,strlen($labelUsers)-1);
        $topoUsers = substr($topoUsers,0,strlen($topoUsers)-1);
        //echo $topoUsers;
    } 

    $conn->close();     
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
    <link rel="icon" href="administrador/images/favicon.png">
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Nom a nom</title>
    <link rel="stylesheet" href="css/init.css" />

	<script src="https://www.chartjs.org/dist/2.9.3/Chart.min.js"></script>
	<script src="https://www.chartjs.org/samples/latest/utils.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/emn178/chartjs-plugin-labels/src/chartjs-plugin-labels.js"></script>

    <script type="text/javascript" src="lib/jquery/jquery-2.2.4.min.js"></script>

	<style>
	canvas {
		-moz-user-select: none;
		-webkit-user-select: none;
		-ms-user-select: none;
	}
	</style>

</head>
<body>
    <form id="form1" runat="server">
        <div class="DivCaja">
            <div class="DivDalt">
                <div class="DivDalt1"><div class="div1200 relative">
                    <a href="#" target="_blank" id="logo1" class="DivDaltLogo1">&nbsp;</a>
                    <div class="DivDalt1b">
                        <a href="#" target="_blank" class="DivDaltLogo2">&nbsp;</a>
                    </div>
                </div></div>
                <div class="DivDalt2"><div class="div1200">
                    <a href="#ancla1" target="_self"><span class="lang" key="index_lbl_1"></span></a>
                    <a href="#ancla2" target="_self"><span class="lang" key="index_lbl_2"></span></a>
                </div></div>
            </div>
            <div class="DivCab">
                <!--<div class="DivCab1" style="background-image:url(images/foto1-min.jpg);">-->
                <div class="DivCab1" style="background-image:url(<?php echo $photo;?>);">
                    <div class="DivCab2">
                        <span class="DivCabTit"><?php echo $title;?> nom a nom</span>
                        <span class="DivCabTex"><span class="lang" key="index_lbl_3"></span> <?php echo $title;?></span>
                        <a href="map.php" target="_blank" class="DivCabBot"><span class="lang" key="index_lbl_4"></span></a>
                    </div>
                    <a href="#ancla1" target="_self" class="DivCabBaix">&nbsp;</a>
                </div>
            </div>
            <div class="DivCentre">
                <!--T'interessa la goografia, la llengua o la història de Menorca?</p>-->
                <div class="ancla" id="ancla1">&nbsp;</div>
                <div class="PLA_ntilla">
                    <div class="div1200">
                    <div class="PLA_titol"><h3><span class="lang" id="ancla1_label" key="index_lbl_1">Benvinguda</span></h3></div>
                        <div class="PLA_texte"><p>
                            <?php echo $description;?>
                        </p></div>
                    </div>
                </div>
                <div class="ancla" id="ancla2">&nbsp;</div>
                <div class="PLA_ntilla">
                    <div class="div1200">
                        <div class="PLA_titol"><h3><span class="lang" id="ancla2_label" key="nomanom5"></span></h3></div>
                        <div class="PLA_texte"><p>
                            <span class="lang" key="nomanom1"></span>
                            <br /><br />
                            <span class="lang" key="nomanom2"></span>
                            <br /><br />
                            <span class="lang" key="nomanom3"></span>
                            <br /><br />
                            <span class="lang" key="nomanom4"></span>
                            </p>
                            <br />

                            <div class="PLA_col3">
                                <span style="font-family:Roboto-Medium;" class="lang" key="nomanom6">Topònims aportats</span><br />&nbsp;</br>
	                            <span style="font-family:Roboto-Medium;font-size:35px;font-weight:bold;"><?php echo $named_place; ?></span><br />
                                <span style="font-family:Roboto-Medium;"><span class="lang" id="ancla1_label" key="mapFrm_lbl_4">topònims</span></span><br />&nbsp;</br>

                            </div>
                            <div class="PLA_col3">
                                <span style="font-family:Roboto-Medium;" class="lang" key="nomanom7">Informadors</span><br />&nbsp;</br>
	                            <span style="font-family:Roboto-Medium;font-size:35px;font-weight:bold;"><?php echo $auth_user; ?></span><br />
                                <span style="font-family:Roboto-Medium;" class="lang" key="nomanom7">informadors</span><br />
                            </div>


                            <div class="PLA_col3">
	                            <span style="font-family:Roboto-Medium;" class="lang" key="nomanom8">Topònims per informador</span><br />&nbsp;</br>
                                <div id="canvas-holder" style="width:100%;height:150px;">
                                    <canvas id="chart1"></canvas>		                            
	                            </div>                                
                            </div>


                        <p style="text-align:center;">
                            <br /><br />
                            <strong><span style="font-family:Roboto-Medium;" class="lang" key="nomanom9">Ajuda'ns a aconseguir que no es perdin!</span></strong>
                            <br /><br />
                            <a href="map.php" target="_blank" class="PLA_boton"><span style="font-family:Roboto-Medium;" class="lang" key="index_lbl_4">Explora i col·labora!</span></a>
                        </p></div>
                    </div>
                </div>
            </div>
            <div class="DivBaix">
                <div class="div1200 relative">
                    <p><span id="nomanom10"></span></p>
                </div>
            </div>
        </div>

    </form>

    <script>

    var language = '<?php echo $language;?>';
    var urlImage = "<?php echo $logo;?>";
    var primaryColor = "<?php echo $primary_color;?>";
    document.title = "<?php echo $title;?>: Nom a nom";


    function fn_translate(lang){
        if (lang=='ca') lang='ca-CA';
        if (lang=='es') lang='es-ES';
        if (lang=='en') lang='en-EN';
        currentLang = lang;
        $(".lang").each(function(index, element) {
            $(this).text(arrayLang[lang][$(this).attr("key")]);
        });     

        //$("#logo1").css("background-image", "url('" + urlImage + "')");
        $(".DivDaltLogo1").css("background-image", "url('" + urlImage + "')");
        $(".DivDalt2").css("background-color",primaryColor);
        $(".DivCabBot").css("background-color",primaryColor);
        $(".PLA_boton").css("background-color",primaryColor);
        $(".DivBaix").css("background-color",primaryColor);
        $("#ancla2_label").css("color",primaryColor);
        $("#ancla1_label").css("color",primaryColor);
        $(".PLA_texte strong").css("color",primaryColor);
        $(".PLA_col3").css("color",primaryColor);
        $("#nomanom10").html(arrayLang[lang]["nomanom10"]);
    }  


    $(document).ready(function () {	

        $.ajax({
                type: "get",
                url: "administrador/config/lang.json"
            }).done(function (data) {
                arrayLang = data;
                fn_translate(language);
        });

        var barChartData1 = {
            labels: [<?php echo $labelUsers;?>],
            datasets: [{
                label: 'Infomradors',
                backgroundColor: "rgba(<?php echo $r.",".$g.",".$b;?>,0.5)",
                borderColor: "rgb(<?php echo $r.",".$g.",".$b;?>)",
                borderWidth: 1,
                data: [<?php echo $topoUsers;?>]
            }]
        };

        var ctx3 = document.getElementById('chart1').getContext('2d');
        window.myBar = new Chart(ctx3, {
            type: 'horizontalBar',
            data: barChartData1,
            options: {
                responsive: true,
                maintainAspectRatio: true,
                scales: {
                    xAxes: [{
                        ticks: {
                            min: 0,
                            stepSize: 1
                        }
                    }]
                },
                legend: {
                    display: false,
                    position: 'top',
                },
                plugins: {
                    labels: [
                        {
                            render: 'label',
                            position: 'outside',
                            outsidePadding: 4,
                            textShadow: true,
                            fontSize: 25,
                            textMargin: 4
                        },
                        {
                            render: 'percentage',
                            fontColor: ['white', 'white', 'white', 'white', 'white', 'white', 'white', 'white']
                        }
                    ]
                }
            }
        });      

    });

    </script>

</body>
</html>
