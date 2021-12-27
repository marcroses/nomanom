<?php
    require_once "../connectdb.php";
    require_once('../lib/PHPMailer_5.2.0/class.phpmailer.php');    

    $action = $_POST["action"];  
    
    //VALIDATE USER
    if ($action=="validateUserAdmin")
    {
        $user = $_POST["user"];  
        $pwd = $_POST["pwd"];  
          
        $sql = "select id, concat(first_name, ' ', last_name) as name from auth_user where username='".$user."' and aes_decrypt(password,'nomanom')='".$pwd."' and is_superuser=1";
        //echo $sql;
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
            echo json_encode($rows);
        }   
        else{
            echo "-1";
        }

        $conn->close();         
    }  
    
    //VALIDATE USER
    if ($action=="validateUser")
    {
        $user = $_POST["user"];  
        $pwd = $_POST["pwd"];  
          
        $sql = "select id, concat(first_name, ' ', last_name) as name, is_superuser from auth_user where username='".$user."' and aes_decrypt(password,'nomanom')='".$pwd."' ";
        //echo $sql;
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
            echo json_encode($rows);
        }   
        else{
            echo "-1";
        }

        $conn->close();         
    }   
    
    //USER getTopoCountByUser
    if ($action=="getTopoCountByUser")
    {
        $userId = $_POST["userId"];  
        $sql = "select count(id) as total from named_place where author_id=".$userId;
        //echo $sql;
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
            echo json_encode($rows);
        }   
        else{
            echo "0";
        }

        $conn->close();         
    }      

    //USER verifyEmail
    if ($action=="verifyEmail")
    {
        $email = $_POST["email"];  
        $sql = "select count(id) as total from auth_user where upper(email)=upper('".$email."')";
        //echo $sql;
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo $row["total"];
            }            
        }   
        $conn->close();         
    }      
        
    //USER verifyName
    if ($action=="verifyName")
    {
        $username = $_POST["username"];  
        $sql = "select count(id) as total from auth_user where upper(username)=upper('".$username."')";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo $row["total"];
            }  
        }
        $conn->close();         
    }      


    //GET PROJECT INFO
    if ($action=="getProjectInfo")
    {
        $sql = "select * from project";
        //echo $sql;
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
            echo json_encode($rows);
        }   
        else{
            echo "-1";
        }
        $conn->close();         
    }     




    //GET PROJECT SETTING
    if ($action=="getProjectSettings")
    {
        $sql = "select * from project_settings";
        //echo $sql;
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
            echo json_encode($rows);
        }   
        else{
            echo "-1";
        }
        $conn->close();         
    }      

    //GET PROJECT_BASELAYERS INFO
    if ($action=="getProjectBaseLayersInfo")
    {
        $sql = "select *  from project_base_layers";
        //echo $sql;
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
            echo json_encode($rows);
        }   
        else{
            echo "[{}]";
        }
        $conn->close();         
    }     

    //GET PROJECT_OVERLAYERS INFO
    if ($action=="getProjectOverLayersInfo")
    {
        $sql = "select *  from project_wms";
        //echo $sql;
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
            echo json_encode($rows);
        }   
        else{
            echo "[{}]";
        }
        $conn->close();         
    }      

    //GET PROJECT_BASELAYERS INFO
    if ($action=="getProjectBaseLayersSource")
    {
        $sql = "select * from project_base_layer_source";
        //echo $sql;
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
            echo json_encode($rows);
        }   
        else{
            echo "-1";
        }
        $conn->close();         
    } 
    

    //GET PROJECT_OVERLAYERS INFO
    if ($action=="getProjectOverLayersSource")
    {
        $sql = "select * from project_wms_source";
        //echo $sql;
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
            echo json_encode($rows);
        }   
        else{
            echo "-1";
        }
        $conn->close();         
    }     
        

    //GET FIELDS
    if ($action=="getFields")
    {
        $sql = "select * from project_editable_fields order by id";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
            echo json_encode($rows);
        }   
        else{
            echo "-1";
        }
        $conn->close();         
    }       


    //GET USERS
    if ($action=="getUsers")
    {
        $sql = "select id, aes_decrypt(password,'nomanom') as password, username, first_name, last_name, email, is_staff, date_joined from auth_user";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
            echo json_encode($rows);
        }   
        else{
            echo "-1";
        }
        $conn->close();         
    }   
    
    //SAVE USER
    if ($action=="saveUser")
    {
        $id = $_POST["id"];  
        $first_name = $_POST["frm_user_first_name"];  
        $last_name = $_POST["frm_user_last_name"];  
        $password = $_POST["frm_user_pwd"];  
        $email = $_POST["frm_user_mail"];  
        $is_staff = $_POST["is_staff"]; 
        $username = $_POST["frm_user_username"];  

        $sql = "update auth_user set ";
        $sql .= " first_name='".str_replace("'", "´", $first_name)."'";
        $sql .= ", last_name='".str_replace("'", "´", $last_name)."'";
        $sql .= ", username='".str_replace("'", "´", $username)."'";
        $sql .= ", password=aes_encrypt('".$password."','nomanom') ";
        $sql .= ", email='".$email."' ";
        $sql .= ", is_staff=".$is_staff." ";
        $sql .= " where id=".$id;

        //echo $sql;
        if ($conn->query($sql) === TRUE) {
            echo "ok";
        } 
        else{
            echo "-1.".$sql;
        } 
        $conn->close();        
    }      
    
    //INSERT USER
    if ($action=="insertUser")
    {
        $first_name = $_POST["frm_user_first_name"];  
        $last_name = $_POST["frm_user_last_name"];  
        $username = $_POST["frm_user_username"];  
        $password = $_POST["frm_user_pwd"];  
        $email = $_POST["frm_user_mail"];  
        $is_staff = $_POST["is_staff"]; 
        $language = $_POST["language"]; 

        $sql = "insert into auth_user (username, first_name, last_name, password, email, is_staff) values (";
        $sql .= " '".str_replace("'", "´", $username)."'";
        $sql .= ", '".str_replace("'", "´", $first_name)."'";
        $sql .= ",'".str_replace("'", "´", $last_name)."'";
        $sql .= ", aes_encrypt('".$password."','nomanom') ";
        $sql .= ", '".$email."' ";
        $sql .= ", ".$is_staff." ";
        $sql .= " )";

        //echo $sql;

        if ($conn->query($sql) === TRUE) {
            $last_id = $conn->insert_id;

            $project_domain = "";
            $email_sender = "";
            $email_sender_pwd = "";
            $sql = "select * from project_settings";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $project_domain = $row["project_domain"];
                    $email_sender = $row["email_sender"];
                    $email_sender_pwd = $row["email_sender_pwd"];
                }
            }           
            
            //echo $project_domain." ".$email_sender." ".$email_sender_pwd;

            $mail = new PHPMailer();
            $mail->IsSMTP(); 
            $mail->SMTPDebug  = 0;
            $mail->SMTPAuth = true; 
            $mail->Host = "localhost"; 
            $mail->Port = 25;          
            $mail->Username = $email_sender; 
            $mail->Password  = $email_sender_pwd;        
            $mail->SetFrom($email_sender, 'Nom a nom ');
            $mail->Subject = "Nom a nom";
            $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
            $mail->CharSet = 'UTF-8';   
            $mail->AddAddress(trim($email));
            $body="<h3>Benvingut a la plataforma Nom a nom!</h3><p><div style='text-align:justify;'>Apreciat/da ".$first_name.", <p></div>";

            if ($language=="ca")
            {
                $body= "<center><img src='".$project_domain."/images/logo4.png'></center><p>".
                "<h3>Benvingut al projecte<strong>Nom a nom</strong></h3><p>".
               "El teu registre al portal de toponímia participativa s'ha fet amb èxit!! Ja pots començar a col·laborar!!<p>".
                "Et recordem que el teu usuari és <strong>".$username."</strong> i l'adreça per accedir és ".$project_domain."<p>".
                "Esperem que gaudeixs fent la teva recerca i aportació particular al projecte!<p>".
                "Moltes gràcies pel teu interès!";            
            }
            if ($language=="es")
            {
                $body= "<center><img src='".$project_domain."/images/logo4.png'></center><p>".
                "<h3>Bienvenido al proyecto <strong>Nom a nom</strong></h3><p>".
               "Tu registro en el portal de toponimia participativa se ha hecho con éxito!! ¡Ya puedes empezar a colaborar!!<p>".
                "Te recordamos que tu usuario es <strong>".$username."</strong> y la dirección para acceder es ".$project_domain."<p>".
                "¡Esperamos que disfrutas haciendo tu búsqueda y aportación particular al proyecto!<p>".
                "¡Muchas gracias por tu interés!";            
            }
            if ($language=="en")
            {
                $body = "<center><img src='".$project_domain."/images/logo4.png'> </center> <p>".
                "<h3> Welcome to the <strong> Nom a Nom </strong> project </h3> <p>".
               "Your registration on the participatory toponymy portal has been completed successfully !! You can now start collaborating !! <p>".
               "We remind you that your username is <strong>".$username."</strong> and the login address is ".$project_domain."<p>".
               "We hope you enjoy doing your research and contributing to the project!"."<p>".
               "Thanks for your interest!";          
            }



            $mail->MsgHTML(str_replace("´","'",$body));   
            
            if(!$mail->Send()) {
                $resultatMail.=trim($email).";" ;
                $sql = "update auth_user set date_joined='".date('Y-m-d H:i:s')."' where id=".$last_id;
                $result = $conn->query($sql);                         
            }
            echo "ok";
        } 
        else{
            echo "-1.";//.$sql;
        } 
        $conn->close();        
    }        

    //DELETE USER
    if ($action=="deleteUser")
    {
        $id = $_POST["id"];  

        $sql = "delete from  auth_user ";
        $sql .= " where id=".$id;

        //echo $sql;
        if ($conn->query($sql) === TRUE) {
            echo "ok";
        } 
        else{
            echo "-1.".$sql;
        } 
        $conn->close();        
    }     
    
    
    //SAVE PROJECT INFO
    if ($action=="saveProjectInfo")
    {
        $title = $_POST["title"];  
        $description = $_POST["description"];  
        $language = $_POST["language"];  
        $longitude = $_POST["longitude"];  
        $latitude = $_POST["latitude"];  
        $zoom = $_POST["zoom"];  
        $primary_color = $_POST["primary_color"]; 
        $color_2 = $_POST["color_2"]; 
        $color_3 = $_POST["color_3"]; 
        $color_4 = $_POST["color_4"]; 
        $logo = $_POST["logo"]; 
        $photo = $_POST["photo"]; 
        $users = $_POST["users"]; 
        $project_domain = $_POST["project_domain"]; 
        $email_sender = $_POST["email_sender"]; 
        $email_sender_pwd = $_POST["email_sender_pwd"]; 

        $sql = "update project set title='".$title."'";
        $sql .= ", description='".str_replace("'", "´", $description)."'";
        $sql .= ", longitude=".$longitude;
        $sql .= ", latitude=".$latitude;
        $sql .= ", zoom=".$zoom;
        $sql .= ", primary_color='".$primary_color."' ";
        $sql .= ", color_2='".$color_2."' ";
        $sql .= ", color_3='".$color_3."' ";
        $sql .= ", color_4='".$color_4."' ";
        $sql .= ", logo='".$logo."' ";
        $sql .= ", photo='".$photo."' ";
        $sql .= ", language='".$language."' ";
        $sql .= ", users='".$users."' ";

        if ($conn->query($sql) === TRUE) {

            //project_settings
            $sql = "update project_settings set project_domain='".$project_domain."'";
            $sql .= ", email_sender='".$email_sender."' ";            
            $sql .= ", email_sender_pwd='".$email_sender_pwd."' ";
            
            $conn->query($sql);

            

            $sql="delete from project_base_layers";
            $conn->query($sql);

            $project_base_layer = $_POST["project_base_layer"];             
            $arrayBs = explode("#",$project_base_layer);
            foreach($arrayBs as $bs) {
                $layer = explode("|",$bs);
                $sql="insert into project_base_layers (project_id, base_layer_source_id, position) values (1,".$layer[0].",".$layer[1].")";
                $conn->query($sql);
            }


            $sql="delete from project_wms";
            $conn->query($sql);

            $project_over_layer = $_POST["project_over_layer"];             
            $arrayBs = explode("#",$project_over_layer);
            foreach($arrayBs as $bs) {
                $layer = explode("|",$bs);
                $sql="insert into project_wms (project_id, wms_id) values (1,".$layer[0].")";
                //echo $sql;
                $conn->query($sql);
            }            
            

            $project_fields = $_POST["project_fields"];             
            $arrayFields = explode("#",$project_fields);
            $sql="update project_editable_fields set editable=0";
            $conn->query($sql);
            foreach($arrayFields as $pf) {
                $sql="update project_editable_fields set editable=1 where id=".$pf;
                $conn->query($sql);
            }


            echo "ok";
        } 
        else{
            echo "-1.".$sql;
        } 
        $conn->close();         
    }    
    
    
    //SAVE BASE_LAYERS_SOURCE
    if ($action=="saveBaseLayerSource")
    {

        $id = $_POST["id"];  
        $title = $_POST["frm_bs_title"];  
        $name = $_POST["frm_bs_name"];  
        $url = $_POST["frm_bs_url"];  
        $attribution = $_POST["frm_bs_attribution"];  
        $matrixSet = $_POST["frm_bs_matrixSet"]; 
        $layerNames = $_POST["frm_bs_layerNames"]; 
        $type = $_POST["frm_bs_type"]; 
        $format = $_POST["frm_bs_format"]; 

        $sql = "update project_base_layer_source set name='".$name."'";
        $sql .= ", title='".str_replace("'", "´", $title)."'";
        $sql .= ", url='".$url."'";
        $sql .= ", attribution='".str_replace("'", "´", $attribution)."'";
        $sql .= ", matrixSet='".$matrixSet."' ";
        $sql .= ", layerNames='".$layerNames."' ";
        $sql .= ", type='".$type."' ";
        $sql .= ", format='".$format."' ";
        $sql .= " where id=".$id;

        //echo $sql;
        if ($conn->query($sql) === TRUE) {
            echo "ok";
        } 
        else{
            echo "-1.".$sql;
        } 
        $conn->close();        
    }    
    
    //INSERT BASE_LAYERS_SOURCE
    if ($action=="insertBaseLayerSource")
    {

        $id = $_POST["id"];  
        $title = $_POST["frm_bs_title"];  
        $name = $_POST["frm_bs_name"];  
        $url = $_POST["frm_bs_url"];  
        $attribution = $_POST["frm_bs_attribution"];  
        $matrixSet = $_POST["frm_bs_matrixSet"]; 
        $layerNames = $_POST["frm_bs_layerNames"]; 
        $type = $_POST["frm_bs_type"]; 
        $format = $_POST["frm_bs_format"]; 
        

        $sql = "insert into project_base_layer_source (name, title, url, attribution, matrixSet, layerNames, type, format ) values (";
        $sql .= "'".str_replace("'", "´", $name)."'";
        $sql .= ",'".str_replace("'", "´", $title)."'";
        $sql .= ",'".$url."'";
        $sql .= ",'".str_replace("'", "´", $attribution)."'";
        $sql .= ",'".$matrixSet."' ";
        $sql .= ",'".$layerNames."' ";
        $sql .= ",'".$type."' ";
        $sql .= ",'".$format."') ";

        //echo $sql;
        if ($conn->query($sql) === TRUE) {
            echo "ok";
        } 
        else{
            echo "-1.".$sql;
        } 
        $conn->close();        
    }      


    //SAVE WMS_SOURCE
    if ($action=="saveWMSSource")
    {
        $id = $_POST["id"];  
        $description = $_POST["frm_Overlay_title"];  
        $name = $_POST["frm_Overlay_name"];  
        $url = $_POST["frm_Overlay_url"];  
        $format = $_POST["frm_Overlay_format"]; 
        $layers = $_POST["frm_Overlay_layers"]; 
        

        $sql = "update project_wms_source set name='".$name."'";
        $sql .= ", description='".str_replace("'", "´", $description)."'";
        $sql .= ", url='".$url."'";
        $sql .= ", layers='".$layers."' ";
        $sql .= ", format='".$format."' ";
        $sql .= " where id=".$id;

        //echo $sql;
        if ($conn->query($sql) === TRUE) {
            echo "ok";
        } 
        else{
            echo "-1.".$sql;
        } 
        $conn->close();        
    
    }  

    //INSERT WMS_SOURCE
    if ($action=="insertWMSSource")
    {
        $description = $_POST["frm_Overlay_title"];  
        $name = $_POST["frm_Overlay_name"];  
        $url = $_POST["frm_Overlay_url"];  
        $format = $_POST["frm_Overlay_format"]; 
        $layers = $_POST["frm_Overlay_layers"]; 
        

        $sql = "insert into project_wms_source (name, description, url, format, layers ) values (";
        $sql .= "'".str_replace("'", "´", $name)."'";
        $sql .= ",'".str_replace("'", "´", $description)."'";
        $sql .= ",'".$url."'";
        $sql .= ",'".$format."' ";
        $sql .= ",'".$layers."') ";

        echo $sql;
        if ($conn->query($sql) === TRUE) {
            echo "ok";
        } 
        else{
            echo "-1.".$sql;
        } 
        $conn->close();        
    }  

    //GET TOPONIYMS
    if ($action=="getToponyms")
    {
        $language = $_POST["language"]; 
        
        $sql = "select geographical_name.id, named_place.id as id_named_place, geographical_name.author_id, geographical_name.spelling, named_place.named_place_local_type_id, named_place.longitude,  named_place.latitude,  named_place_local_type.named_place_local_type_id as local_type,  named_place_local_type.name_".$language." as ds_type, named_place_type.color from geographical_name  inner join named_place on named_place.id=geographical_name.named_place_id  inner join named_place_local_type on named_place_local_type.id=named_place.named_place_local_type_id inner join named_place_type on named_place_local_type.named_place_local_type_id=named_place_type.id";
        //echo $sql;
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
            echo json_encode($rows);
        }   
        else{
            echo "-1";
        }
        $conn->close();         
    }  
    


    //GET TOPONIYM_TYPE
    if ($action=="getToponym_type")
    {
        $language = $_POST["language"];  

        $sql = "SELECT npl.id, npl.name_".$language." as local_type, npt.name_".$language." as type, npt.color FROM named_place_local_type npl inner join named_place_type npt on npl.named_place_local_type_id = npt.id order by npt.name_".$language.", npl.name_".$language;
        //echo $sql;
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
            echo json_encode($rows);
        }   
        else{
            echo "-1";
        }
        $conn->close();         
    }  
      

    //GET TOPONIYM_STATUS
    if ($action=="getToponym_status")
    {
        $sql = "SELECT * FROM name_status where id>0 order by id";
        //echo $sql;
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
            echo json_encode($rows);
        }   
        else{
            echo "-1";
        }
        $conn->close();         
    }     


    //GET TOPONIYM_PRIORITY
    if ($action=="getToponym_priority")
    {
        $sql = "SELECT * FROM priority  where id>0 order by id";
        //echo $sql;
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
            echo json_encode($rows);
        }   
        else{
            echo "-1";
        }
        $conn->close();         
    }     
    

    //GET TOPONIYM_ORGANIZATION
    if ($action=="getToponym_organization")
    {
        $sql = "SELECT * FROM competent_organization where id>0 order by id";
        //echo $sql;
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
            echo json_encode($rows);
        }   
        else{
            echo "-1";
        }
        $conn->close();         
    }   

    //GET TOPONIYM_SOURCE
    if ($action=="getToponym_source")
    {
        $sql = "SELECT id, source_of_name as name FROM source_of_name where id>0 order by id";
        //echo $sql;
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
            echo json_encode($rows);
        }   
        else{
            echo "-1";
        }
        $conn->close();         
    }       
    
    
    

    //GET TOC
    if ($action=="getTOC")
    {
        $language = $_POST["language"];  
        //$sql = "(select tipus.id as id_tipus, tipus.name_".$language." as ds_tipus, 1 as visible, tipus.color as color from named_place_type as tipus where id < 8 order by name_".$language.") union all select tipus.id as id_tipus, tipus.name_".$language." as ds_tipus, 1 as visible, tipus.color as color from named_place_type as tipus where id = 8";

        $sql = "select tipus.id as id_tipus, tipus.name_".$language." as ds_tipus, 1 as visible, tipus.color as color from named_place_type as tipus order by name_".$language;        
        //echo $sql;
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
            echo json_encode($rows);
        }   
        else{
            echo "-1";
        }
        $conn->close();         
    }      
    
    
    //GET TOPONIYM_ORGANIZATION
    if ($action=="addToponym")
    {
        $spelling = $_POST["spelling"];  
        $named_place_local_type_id = $_POST["named_place_local_type_id"];  
        $minimum_scale_visibility = $_POST["minimum_scale_visibility"];  
        $maximum_scale_visibility = $_POST["maximum_scale_visibility"];  
        $longitude = $_POST["longitude"];  
        $latitude = $_POST["latitude"];  
        $author_id = $_POST["author_id"];  

        $source_of_name_id = $_POST["source_of_name_id"];  
        $name_status_id = $_POST["name_status_id"];  
        $priority_id = $_POST["priority_id"];  
        $competent_organization_id = $_POST["competent_organization_id"];  
        $observations = $_POST["observations"];  
        $beginLifespanVersion = $_POST["beginLifespanVersion"];  
        $endLifespanVersion = $_POST["endLifespanVersion"];  

        if ($minimum_scale_visibility=="") $minimum_scale_visibility=500;
        if ($maximum_scale_visibility=="") $maximum_scale_visibility=25000;

        $sql = "select CAST(inspire_id AS UNSIGNED)+1 as id from named_place order by CAST(inspire_id AS UNSIGNED) desc limit 1";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $last_id_inspire = $row["id"];
            }
        }
        else{
            $last_id_inspire='1';
        }   


        $SQL_observations = "";
        $SQL_beginLifespanVersion = "";
        $SQL_endLifespanVersion = "";
        $SQL_competent_organization_id = "";

        $field_observations = "";
        $field_beginLifespanVersion = "";
        $field_endLifespanVersion = "";
        $field_competent_organization_id = "";
        
        
        if ($observations != ""){
            $SQL_observations = ",'".str_replace("'", "´", $observations)."'";  
            $field_observations = ", observations";
        }  
        if ($competent_organization_id != ""){
            $SQL_competent_organization_id = ", ".$competent_organization_id;  
            $field_competent_organization_id = ", competent_organization_id";
        }  
        if ($beginLifespanVersion != "") {
            $SQL_beginLifespanVersion = ", '".$beginLifespanVersion."'";  
            $field_beginLifespanVersion = ", beginLifespanVersion";
        } 
        if ($endLifespanVersion != "") {
            $SQL_endLifespanVersion = ", '".$endLifespanVersion."'";  
            $field_endLifespanVersion = ", endLifespanVersion";
        } 
        


        $sql = "insert into named_place (inspire_id".$field_beginLifespanVersion.$field_observations.", author_id".$field_competent_organization_id.", named_place_local_type_id, longitude, latitude, minimum_scale_visibility, maximum_scale_visibility) values (".$last_id_inspire.$SQL_beginLifespanVersion.$SQL_observations.",".$author_id.$SQL_competent_organization_id.",".$named_place_local_type_id.",".$longitude.",".$latitude.",".$minimum_scale_visibility.",".$maximum_scale_visibility.")";


        if ($conn->query($sql) === TRUE) {
            //echo $sql;
            $last_id = $conn->insert_id;

            /*
            $SQL_source_of_name_id = "";
            $SQL_priority_id = "";
            $SQL_name_status_id = "";

            $field_source_of_name_id = "";
            $field_priority_id = "";
            $field_name_status_id = "";
            */

            $SQL_source_of_name_id = ",-1";
            $SQL_priority_id = ",-1";
            $SQL_name_status_id = ",-1";

            $field_source_of_name_id = ", source_of_name_id";
            $field_priority_id = ", priority_id";
            $field_name_status_id = ", name_status_id";

            if ($source_of_name_id != "") {
                $SQL_source_of_name_id = ",'".str_replace("'", "´", $source_of_name_id)."'";  
                //$field_source_of_name_id = ", source_of_name_id";
            } 

            if ($priority_id != "") {
                $SQL_priority_id = ", ".$priority_id;  
                //$field_priority_id = ", priority_id";
            }             
            
            if ($name_status_id != ""){
                $SQL_name_status_id = ", ".$name_status_id;  
                //$field_name_status_id = ", name_status_id";
            }  

            

            $sql2 = "insert into geographical_name (spelling".$field_observations.", author_id".$field_name_status_id.$field_source_of_name_id.$field_priority_id.", named_place_id) values('".str_replace("'", "´", $spelling)."'".$SQL_observations.",".$author_id.$SQL_name_status_id.$SQL_source_of_name_id.$SQL_priority_id.",".$last_id.")";
            
            if ($conn->query($sql2) === TRUE) {

                //echo $sql2;
                $last_id2 = $conn->insert_id;

                $sql3 = "select geographical_name.id, named_place.id as id_named_place, geographical_name.author_id, geographical_name.spelling, named_place.named_place_local_type_id, named_place.longitude,  named_place.latitude,  named_place_local_type.named_place_local_type_id as local_type, named_place_type.color from geographical_name  inner join named_place on named_place.id=geographical_name.named_place_id  inner join named_place_local_type on named_place_local_type.id=named_place.named_place_local_type_id inner join named_place_type on named_place_local_type.named_place_local_type_id=named_place_type.id where geographical_name.id=".$last_id2;    
                
                $result = $conn->query($sql3);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $rows[] = $row;
                    }
                    echo json_encode($rows);
                }   
                else{
                    echo "-3: ".$sql3;
                }                

            }
            else{
                echo "-2: ".$sql2;
            }            
        }
        else{
            echo "-1: ".$sql;
        }
        $conn->close();  
    }     
    

 
    //UPDATE TOPONYM
    if ($action=="updateToponym")
    {
        $id = $_POST["id"];  
        $spelling = $_POST["spelling"];  
        $named_place_local_type_id = $_POST["named_place_local_type_id"];  
        $longitude = $_POST["longitude"];  
        $latitude = $_POST["latitude"];  
        $author_id = $_POST["author_id"];  

        $source_of_name_id = $_POST["source_of_name_id"];  
        $name_status_id = $_POST["name_status_id"];  
        $priority_id = $_POST["priority_id"];  
        $competent_organization_id = $_POST["competent_organization_id"];  
        $observations = $_POST["observations"];  
        $minimum_scale_visibility = $_POST["minimum_scale_visibility"];  
        $beginLifespanVersion = $_POST["beginLifespanVersion"];  
        $endLifespanVersion = $_POST["endLifespanVersion"];  

        $SQL_source_of_name_id = "";
        $SQL_name_status_id = "";
        $SQL_priority_id = "";

        if ($source_of_name_id != "") $SQL_source_of_name_id = ", source_of_name_id='".str_replace("'", "´", $source_of_name_id)."'";
        if ($name_status_id != "")  $SQL_name_status_id = ", name_status_id=".$name_status_id;  
        if ($priority_id != "")  $SQL_priority_id = ", priority_id=".$priority_id;  

        if ($minimum_scale_visibility=="") $minimum_scale_visibility=500;
        if ($maximum_scale_visibility=="") $maximum_scale_visibility=25000;

        $sql = "update geographical_name set spelling='".str_replace("'", "´", $spelling)."', observations='".str_replace("'", "´", $observations)."', author_id=".$author_id." ".$SQL_source_of_name_id." ".$SQL_name_status_id." ".$SQL_priority_id." where id=".$id;

        //echo $sql;

        if ($conn->query($sql) === TRUE) {

            //echo $sql;

            $sql = "select named_place_id from geographical_name where id=".$id;
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $named_place_id = $row["named_place_id"];
                }
            }   

            $SQL_observations = "";
            $SQL_beginLifespanVersion = "";
            $SQL_endLifespanVersion = "";
            $SQL_competent_organization_id = "";
            
            if ($observations != "")  $SQL_observations = ", observations='".str_replace("'", "´", $observations)."'";  
            if ($competent_organization_id != "")  $SQL_competent_organization_id = ",  competent_organization_id=".$competent_organization_id;  
            
            if ($beginLifespanVersion != "")  $SQL_beginLifespanVersion = ", beginLifespanVersion='".$beginLifespanVersion."'";  
            if ($endLifespanVersion != "")  $SQL_endLifespanVersion = ", endLifespanVersion='".$endLifespanVersion."'";  
    
    

            $sql = "update named_place set author_id=".$author_id.", named_place_local_type_id=".$named_place_local_type_id.", longitude=".$longitude.", latitude=".$latitude.", minimum_scale_visibility=".$minimum_scale_visibility.", maximum_scale_visibility=".$maximum_scale_visibility." ".$SQL_competent_organization_id." ".$SQL_observations." ".$SQL_beginLifespanVersion." ".$SQL_endLifespanVersion." where id=".$named_place_id;  
            
            //echo $sql;

            if ($conn->query($sql) === TRUE) {
                
                //echo $sql;

                $sql3 = "select geographical_name.id, named_place.id as id_named_place, geographical_name.author_id, geographical_name.spelling, named_place.named_place_local_type_id, named_place.longitude,  named_place.latitude,  named_place_local_type.named_place_local_type_id as local_type, named_place_type.color from geographical_name  inner join named_place on named_place.id=geographical_name.named_place_id  inner join named_place_local_type on named_place_local_type.id=named_place.named_place_local_type_id inner join named_place_type on named_place_local_type.named_place_local_type_id=named_place_type.id where geographical_name.id=".$id;    
                
                $result = $conn->query($sql3);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $rows[] = $row;
                    }
                    echo json_encode($rows);
                }   
                else{
                    echo "-3: ".$sql3;
                } 

            }            

        }

        $conn->close();  
    }     
        

    //DELETE TOPONYM
    if ($action=="deleteToponym")
    {
        $id = $_POST["id"];  

        $sql = "select named_place_id from geographical_name where id=".$id;
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $named_place_id = $row["named_place_id"];
            }
        }         
        $sql1 = "delete from geographical_name where id=".$id;
        //echo $sql1;

        if ($conn->query($sql1) === TRUE) {
            $sql2 = "delete from named_place where id=".$named_place_id;
            //echo $sql2;
            if ($conn->query($sql2) === TRUE) {
                echo "ok";
            }            
        }

        $conn->close();  
    }     
            

    //GET SINGLE TOPONIYMS
    if ($action=="getSingleToponym")
    {
        $id = $_POST["id"];  

        $sql = "select geographical_name.id, named_place.id as id_named_place, geographical_name.spelling, geographical_name.observations, geographical_name.name_status_id, geographical_name.source_of_name_id, geographical_name.priority_id, named_place.inspire_id, named_place.competent_organization_id, named_place.named_place_local_type_id, named_place.longitude,  named_place.latitude, named_place.minimum_scale_visibility, named_place.maximum_scale_visibility, named_place_local_type.named_place_local_type_id as local_type, auth_user.username, named_place.beginLifespanVersion, named_place.endLifespanVersion from geographical_name  inner join named_place on named_place.id=geographical_name.named_place_id  inner join named_place_local_type on named_place_local_type.id=named_place.named_place_local_type_id inner join named_place_type on named_place_local_type.named_place_local_type_id=named_place_type.id  inner join auth_user on auth_user.id=geographical_name.author_id where geographical_name.id=".$id;
        //echo $sql;
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
            echo json_encode($rows);
        }   
        else{
            echo "-1";
        }
        $conn->close();         
    }      

    //GET SINGLE TOPONIYMS
    if ($action=="getFullToponyms")
    {
        $author_id = $_POST["author_id"];
        $userIsAdmin = $_POST["userIsAdmin"];
        $language = $_POST["language"]; 
        
        if ($userIsAdmin==1){
            $sql = "select geographical_name.id, auth_user.username, named_place.id as id_named_place, geographical_name.spelling, geographical_name.observations, geographical_name.name_status_id, geographical_name.source_of_name_id, geographical_name.priority_id, named_place.inspire_id, named_place.competent_organization_id, named_place.named_place_local_type_id, named_place.longitude,  named_place.latitude, named_place.minimum_scale_visibility, named_place.maximum_scale_visibility, named_place_local_type.named_place_local_type_id as local_type,  named_place_local_type.name_".$language." as ds_type, auth_user.username, named_place.beginLifespanVersion, named_place.endLifespanVersion from geographical_name  inner join named_place on named_place.id=geographical_name.named_place_id  inner join named_place_local_type on named_place_local_type.id=named_place.named_place_local_type_id inner join named_place_type on named_place_local_type.named_place_local_type_id=named_place_type.id  inner join auth_user on auth_user.id=geographical_name.author_id";
        }
        else{
            $sql = "select geographical_name.id, auth_user.username, named_place.id as id_named_place, geographical_name.spelling, geographical_name.observations, geographical_name.name_status_id, geographical_name.source_of_name_id, geographical_name.priority_id, named_place.inspire_id, named_place.competent_organization_id, named_place.named_place_local_type_id, named_place.longitude,  named_place.latitude, named_place.minimum_scale_visibility, named_place.maximum_scale_visibility, named_place_local_type.named_place_local_type_id as local_type,  named_place_local_type.name_".$language." as ds_type, auth_user.username, named_place.beginLifespanVersion, named_place.endLifespanVersion from geographical_name  inner join named_place on named_place.id=geographical_name.named_place_id  inner join named_place_local_type on named_place_local_type.id=named_place.named_place_local_type_id inner join named_place_type on named_place_local_type.named_place_local_type_id=named_place_type.id  inner join auth_user on auth_user.id=geographical_name.author_id where geographical_name.author_id=".$author_id;
        }


        //echo $sql;
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
            echo json_encode($rows);
        }   
        else{
            echo "-1";
        }
        $conn->close();         
    }     
    
    
    
        

?>



