<?php
   session_start();
    //sleep(2);   
   header('Content-Type: application/json');
   header("Access-Control-Allow-Origin: *");

    
   include "../php/funciones.php";

    
   $conexion=conexion();
   $result = 
   [
      'success' => false,
      'response' => $_POST
   ];
   
   if(isset($_SESSION['tipo'])){
      if($_SESSION['tipo'] == 'actor'){

         $id_actor = $_SESSION['id'];

         if(isset($_POST['url'])){

            $url = $_POST['url'];

            $sentencia = "insert into videos_actor (id, actor, url) values (null, ?, ?)";
        
            $consulta = $conexion->prepare($sentencia);

            $consulta->bind_param("is", $id_actor, $url );//-------------------------------------------------------------

            $consulta->execute();
            $id_video = $consulta->insert_id;

            $result = 
            [
               'success' => true,
               'response' => [
                  'id' => $id_video,
                  // 'value' => $url
               ]
            ];
            // $consulta->fetch();

            $consulta->close();

         }
      }
   }

   echo json_encode( $result, JSON_PRETTY_PRINT);
    //EL IF ES PARA PROBARLO A MANO
    //EN TEORIA EL FORMULARIO COMPRUEBA QUE LOS DATOS SON CORRECTOS 
