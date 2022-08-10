<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../estilos/estilo.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../asset/imagenes/logo.jpg">
    <title>Document</title>
</head>
<body>

<?php

//llamo a funciones

require_once('./funciones.php');

$conexion = conexion();

    //En caso de que esté guardada la sesión la obtengo
if(isset($_COOKIE['mantener'])){
    session_decode($_COOKIE['mantener']);
}


if(isset($_SESSION['tipo'])){ //si está logueado
    if($_SESSION['tipo'] == 'actor'){ //y ademas está logueado como actor
        if(isset($_SESSION['id'])){
            $id = $_SESSION['id'];

        }

         //introduzco el header y la cabecera dependiendo del tipo de usuario
        echo "<main>";

        echo '<div class="img-header9">
        <div class="welcome">
          <h1>Bienvenidos TodoTeatro</h1>
          <hr>
          <p>Especializada en gestión de eventos de teatro</p>
          <p>entre actores y compañías</p>
        </div>       
        </div>
            ';
        
        echo "<section>";

        $parametro1="./";
        $parametro2="../";
        echo insertar_menu_actores($parametro1, $parametro2);


        echo "<h2 class='display-5 fw-bold' style='color: #FD9815; text-align: center; margin-bottom: 40px; margin-top: 80px; font-family: 'Lemonada', cursive;'>Información completa de la obra</h2>";


        if(isset($_GET["id_obra"])){
            $id_obra=$_GET['id_obra'];
            // echo"$id_obra<br>";

            $sentencia = "select obra.nombre, obra.Descripcion, obra.fecha, obra.imagen, obra.duracion, compañia.nombre
            from obra, compañia
            where obra.compañia = compañia.id and obra.id = ?
            ";

            $consulta = $conexion->prepare($sentencia);

            $consulta->bind_result($nombre, $descripcion, $fecha, $imagen, $duracion, $compañia);
            $consulta->bind_param("i", $id_obra);
            $consulta->execute();


            $consulta->store_result();


            $consulta->fetch();


            $fecha = fecha($fecha);
            echo'<div class="info">
            <div class="left-info">
                <figure><img src="..'.$imagen.'"></figure>
                <div class="info-text">';
                echo "<h6 class='display-5 fw-bold' style='color: #FD9815; text-align: center; margin-bottom: 40px; margin-top: 80px; font-family: 'Lemonada', cursive;'>Nombre de la obra:</h6>
                <h6>$nombre</h6>";
                echo "<h6 class='display-5 fw-bold' style='color: #FD9815; text-align: center; margin-bottom: 40px; margin-top: 80px; font-family: 'Lemonada', cursive;'>Fecha en la que se realiza:</h6>
                <h6>$fecha</h6>";
                echo "<h6 class='display-5 fw-bold' style='color: #FD9815; text-align: center; margin-bottom: 40px; margin-top: 80px; font-family: 'Lemonada', cursive;'>Breve descripción:</h6>
                <h6>$descripcion</h6>";
                echo "<h6 class='display-5 fw-bold' style='color: #FD9815; text-align: center; margin-bottom: 40px; margin-top: 80px; font-family: 'Lemonada', cursive;'>Duración de la obra:</h6>
                <h6>$duracion</h6>";
                echo "<h6 class='display-5 fw-bold' style='color: #FD9815; text-align: center; margin-bottom: 40px; margin-top: 80px; font-family: 'Lemonada', cursive;'>Compañía que realiza la obra:</h6>
                <h6>$compañia</h6>";
                
                echo'</div>
            </div>
          </div>
      
        </div></main></section>';

        //inserto footer
        echo insertar_footer($parametro1, $parametro2);


        }

        $consulta->close();

        //muestro errores de acceso
        }else{
            echo "<h2 class='error'>NECESITA REGISTRARSE PARA ACCEDER A ESTA PÁGINA</h2>";
            // $spin = spin();
            // $imprimo .= $spin;
            echo'<META HTTP-EQUIV="REFRESH"CONTENT="2;URL=./vistaError.php">';
        }
    }else{
        echo "<h2 class='error'>NECESITA REGISTRARSE PARA ACCEDER A ESTA PÁGINA</h2>";
        // $spin = spin();
        // $imprimo .= $spin;
        echo'<META HTTP-EQUIV="REFRESH"CONTENT="2;URL=./vistaError.php">';
    }

?>

</body>
</html>