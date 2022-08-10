
<?php
    session_start();

	//Cabeceras
	header('Content-Type: application/json');
	header("Access-Control-Allow-Origin: *");
    include "../php/funciones.php";

    $conexion = conexion();$datos=[];

    if(isset($_SESSION['tipo']) && isset($_GET['id'])){
        
        $id_actor = $_GET['id'];
        $sentencia=$conexion->prepare("SELECT * FROM videos_actor where videos_actor.actor = $id_actor");

        $sentencia->execute();
            
        $resultado=$sentencia->get_result();
            
        while($fila=$resultado->fetch_assoc()){ 
                $datos[]=$fila;
        }
    }
    
    echo json_encode($datos);
 ?>