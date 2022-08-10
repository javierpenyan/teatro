
<?php
    session_start();

    // if(isset($_COOKIE['mantener'])){
    //     session_decode($_COOKIE['mantener']);
    // }

    // if($_SESSION['tipo'] == 'actor'){

    //     $actor = $_SESSION['id'];

    // }

	//Cabeceras
	header('Content-Type: application/json');
	header("Access-Control-Allow-Origin: *");
    include "../php/funciones.php";

    $conexion = conexion();

    $actor = $_SESSION['id'];

    if(isset($_SESSION['tipo'])){
        if($_SESSION['tipo'] == 'actor'){

        }
    }

    
    //PARA SIMULAR EL RETARDO DEL SERVIDOR
    
    $datos=[];
    $sentencia=$conexion->prepare("SELECT * FROM videos_actor where videos_actor.actor = $actor");

    $sentencia->execute();
        
    $resultado=$sentencia->get_result();
        
    while($fila=$resultado->fetch_assoc()){ 
        	$datos[]=$fila;
    }
    
    echo json_encode($datos);
 ?>