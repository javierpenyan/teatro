<?php
session_start();
//sleep(2);   
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

include "../php/funciones.php";

$conexion = conexion();
$result =
    [
        'success' => false
    ];

//if (isset($_SESSION['tipo'])) {
    //if ($_SESSION['tipo'] == 'actor') {

        //$id_actor = $_SESSION['id'];

        if (isset($_GET['id'])) {

            $id_video = $_GET['id'];

            $sentencia = "delete from videos_actor where videos_actor.id = ?";

            $consulta = $conexion->prepare($sentencia);

            $consulta->bind_param("i", $id_video); //-------------------------------------------------------------

            $consulta->execute();

            $result =
            [
                'success' => $consulta->affected_rows > 0
            ];

            $consulta->close();
        }
    //}
//}

echo json_encode($result, JSON_PRETTY_PRINT);
    //EL IF ES PARA PROBARLO A MANO
    //EN TEORIA EL FORMULARIO COMPRUEBA QUE LOS DATOS SON CORRECTOS 
