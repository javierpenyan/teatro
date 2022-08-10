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

//En caso de que esté guardada la sesión la obtengo
if (isset($_COOKIE['mantener'])) {
    session_decode($_COOKIE['mantener']);
}

 //introduzco el header y la cabecera dependiendo del tipo de usuario



echo "<main>";

echo '<div class="img-header4">
<div class="welcome">
  <h1>Bienvenidos TodoTeatro</h1>
  <hr>
  <p>Especializada en gestión de eventos de teatro</p>
  <p>entre actores y compañías</p>
</div>       
</div>
    ';

echo "<section>";

        echo "<h2 class='display-5 fw-bold' style='color: #FD9815; text-align: center; margin-bottom: 40px; margin-top: 80px; '>Casting futuros:</h2>";


    require_once('./funciones.php');

    $hoy = fecha_hoy();

    if (isset($_SESSION['tipo'])) {
        $tipo = $_SESSION['tipo'];
    }


    $conexion = conexion();



    if (isset($_SESSION['tipo'])) {

        if ($_SESSION['tipo'] == 'compañia') {

            $parametro1 = "./";
            $parametro2 = "../";
            echo insertar_menu_compañias($parametro1, $parametro2);
        } elseif ($_SESSION['tipo'] == 'actor') {

            $parametro1 = "./";
            $parametro2 = "../";
            echo insertar_menu_actores($parametro1, $parametro2);
        }
    } else {

        $parametro1 = "./";
        $parametro2 = "../";
        echo insertar_menu($parametro1, $parametro2);
    }


    if (isset($_POST['buscar'])) {

        $datos = $_POST['dato_casting'];

        // echo "entraaaaaa<br>";

        $datos = "%".$datos."%";

        //realizo las consultas necesarias

        $sentencia = "select casting.id, obra.nombre, obra.imagen, casting.fecha, casting.descripcion 
    from casting, obra
    where obra.id = casting.obra
    and obra.fecha > ? and 
    casting.fecha > ?
    and obra.nombre like ?
    
";

        $consulta = $conexion->prepare($sentencia);

        $consulta->bind_result($casting_id, $obra, $foto, $fecha, $papel);
        $consulta->bind_param("sss", $hoy, $hoy, $datos);
        $consulta->execute();


        $consulta->store_result();

        echo "<div class='container-xl'>
<div class='row gy-0 my-5' id='centrar' >";

        while ($consulta->fetch()) {

            $fecha = fecha($fecha);

            echo '<div class="card my-5 mx-5 target" style="width: 18rem;">
    <img src="..' . $foto . '" class="card-img-top" alt="foto">
        <div class="card-body">
            <h5 class="card-title">CASTING:</h5>
            <p class="card-text">' . $obra . '</p>
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">' . $papel . '</li>
            <li class="list-group-item">' . $fecha . '</li>
        
    
';
            if (isset($_SESSION['tipo'])) {
                if ($_SESSION['tipo'] == 'actor') {
                    echo '<li class="list-group-item">
                <a href="./casting_completo_actor.php?id_casting=' . $casting_id . '" class="card-link">VER MAS</a>
            </div>
';
                }else {
                    echo "</ul></div>";}
            } else {
                echo "</ul></div>";
            }
        }
        echo "</div>
</div>
</div>";

echo"<div class=buscar>
                    
<form method='post' action='#' enctype='multipart/form-data'>";
        echo'<h2 class="display-5 fw-bold" style="color: #FD9815; text-align: center; margin-bottom: 40px; ">Buscar casting</h2>';
    echo"
    <label for='busqueda_compañia'>Buscar por nombre de la obra</label>
    <input type='text' name='dato_casting' id='busqueda_casting' placeholder='Introduzca nombre de la obra' required ><br>
    <input type='submit' name='buscar' value = 'buscar'>
    </form>
</div>";
        $consulta->close();
    } else {/////////////////////////////////////////////////

        // echo "entraaaaaa<br>";


        $sentencia = "select casting.id, obra.nombre, obra.imagen, casting.fecha, casting.descripcion 
    from casting, obra
    where obra.id = casting.obra
    and obra.fecha > ? and 
    casting.fecha > ?
    order by rand()
    limit 20;
";

        $consulta = $conexion->prepare($sentencia);

        $consulta->bind_result($casting_id, $obra, $foto, $fecha, $papel);
        $consulta->bind_param("ss", $hoy, $hoy);
        $consulta->execute();


        $consulta->store_result();

        echo "<div class='container-xl'>
<div class='row gy-0 my-5' id='centrar' >";

        while ($consulta->fetch()) {

            $fecha = fecha($fecha);

            echo '<div class="card my-5 mx-5 target" style="width: 18rem;">
    <img src="..' . $foto . '" class="card-img-top" alt="foto">
        <div class="card-body">
            <h5 class="card-title">CASTING:</h5>
            <p class="card-text">' . $obra . '</p>
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">' . $papel . '</li>
            <li class="list-group-item">' . $fecha . '</li>
        
    
';
            if (isset($_SESSION['tipo'])) {
                if ($_SESSION['tipo'] == 'actor') {
                    echo '<li class="list-group-item">
                <a href="./casting_completo_actor.php?id_casting=' . $casting_id . '" class="card-link">VER MAS</a>
            </div>
';
                }else {
                    echo "</ul></div>";}
            } else {
                echo "</ul></div>";
            }
        }
        echo "</div>
</div>
</div>";

        $consulta->close();

        echo"<div class=buscar>
                    
        <form method='post' action='#' enctype='multipart/form-data'>";
        echo'<h2 class="display-5 fw-bold" style="color: #FD9815; text-align: center; margin-bottom: 40px; ">Buscar casting</h2>';

            echo"
            <label for='busqueda_compañia'>Buscar por nombre de la obra</label>
            <input type='text' name='dato_casting' id='busqueda_casting' placeholder='Introduzca nombre de la obra' required ><br>
            <input type='submit' name='buscar' value = 'buscar'>
            </form>
        </div>";
    }

    echo"</main></section>";

    //introduzco el footer

    echo insertar_footer($parametro1, $parametro2);


    ?>

</body>

</html>