<?php
    
	//Cabeceras
	header('Content-Type: application/json');
	header("Access-Control-Allow-Origin: *");
	include "functions.php";
	include "config.php";
    
    //PARA SIMULAR EL RETARDO DEL SERVIDOR
    sleep(1);  
    
    $conexion=conectarBD($dbhost,$dbuser,$dbpass);
    $conexion->select_db($dbname);
    
    $datos=[];
    $sentencia=$conexion->prepare("SELECT * FROM LIBROS");

    $sentencia->execute();
        
    $resultado=$sentencia->get_result();
        
    while($fila=$resultado->fetch_assoc()){ 
        	$datos[]=$fila;
    }
    
    echo json_encode($datos);
 ?>

 