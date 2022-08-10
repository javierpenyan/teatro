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
setlocale(LC_ALL, "es-ES.UTF-8");
//En caso de que esté guardada la sesión la obtengo

    if (isset($_COOKIE['mantener'])) {
        session_decode($_COOKIE['mantener']);
    }




 //introduzco el header y la cabecera dependiendo del tipo de usuario

    echo "<main>";

    echo '<div class="img-header3">
    <div class="welcome">
      <h1>Bienvenidos TodoTeatro</h1>
      <hr>
      <p>Especializada en gestión de eventos de teatro</p>
      <p>entre actores y compañías</p>
    </div>       
   </div>
';

    echo "<section>";

    // llamo a funciones

    require_once('./funciones.php');

    $hoy = fecha_hoy();

    $hoy_cal = date("Y-m-d");

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

        $datos = $_POST['dato_obra'];

        $hoy = fecha_hoy();
        // echo"$hoy<br>";

        $dias_hoy = dias_fecha($hoy);

        $datos = "%" . $datos . "%";

        //realizo las consultas necesarias

        $sentencia = "select obra.nombre, obra.imagen, 
            obra.fecha, compañia.nombre 
            from obra, compañia
            where compañia.id = obra.compañia
            and obra.nombre like ?
            and obra.fecha >= ?
            ";

        $consulta = $conexion->prepare($sentencia);

        $consulta->bind_param("ss", $datos, $hoy_cal);

        $consulta->bind_result($obra, $foto, $fecha, $c_nombre);

        $consulta->execute();


        $consulta->store_result();

        echo "<div class='container-xl'>
            <div class='row gy-0 my-5' id='centrar' >";

        while ($consulta->fetch()) {

            $dias_obra = dias_fecha($fecha);

            $resta_dias = $dias_obra - $dias_hoy; //marca de tiempo en segundos del timepo que falta hasta que empiece la obra
            // echo"$resta_dias<br>";
            $fecha = fecha($fecha);
            echo '<div class="card my-5 mx-5 target" style="width: 18rem;">
                    <img src="..' . $foto . '" class="card-img-top" alt="foto">
                    <div class="card-body">
                        <h5 class="card-title">OBRA:</h5>
                        <p class="card-text">' . $obra . '</p>
                        <h5 class="card-title">COMPAÑÍA:</h5>
                        <p class="card-text">' . $c_nombre . '</p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">' . $fecha . '</li>
                    </ul></div>
                    ';
        }

        echo "
                </div>
            </div>";

        $consulta->close();
    } else {
        $hoy = fecha_hoy();
        // echo"$hoy<br>";

        $dias_hoy = dias_fecha($hoy);


        echo'<h2 class="display-5 fw-bold" style="color: #FD9815; text-align: center; margin-bottom: 40px;">Actuaciones que tendrán lugar en los próximos 15 días:</h2>';
        $sentencia = "select obra.nombre, obra.imagen, 
            obra.fecha, compañia.nombre 
            from obra, compañia
            where compañia.id = obra.compañia
            ";

        $consulta = $conexion->prepare($sentencia);

        $consulta->bind_result($obra, $foto, $fecha, $c_nombre);

        $consulta->execute();


        $consulta->store_result();

        echo "<div class='container-xl'>
            <div class='row gy-0 my-5' id='centrar' >";

        while ($consulta->fetch()) {

            $dias_obra = dias_fecha($fecha);

            $resta_dias = $dias_obra - $dias_hoy; //marca de tiempo en segundos del timepo que falta hasta que empiece la obra
            // echo"$resta_dias<br>";

            if (($resta_dias >= 0) && ($resta_dias < 15)) {

                $fecha = fecha($fecha);

                echo '<div class="card my-5 mx-5 target" style="width: 18rem;">
                    <img src="..' . $foto . '" class="card-img-top" alt="foto">
                    <div class="card-body">
                        <h5 class="card-title">OBRA:</h5>
                        <p class="card-text">' . $obra . '</p>
                        <h5 class="card-title">COMPAÑÍA:</h5>
                        <p class="card-text">' . $c_nombre . '</p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">' . $fecha . '</li>
                    </ul>
                    </div>
                    ';
            }
        }

        echo "</div>
                </div>
            </div>";

        $consulta->close();

        echo'<h2 class="display-5 fw-bold" style="color: #FD9815; text-align: center; margin-bottom: 40px; ">Actuaciones que tuvieron lugar la última semana:</h2>';

        $sentencia = "select obra.nombre, obra.imagen, obra.fecha, compañia.nombre 
            from obra, compañia
            where obra.compañia = compañia.id 
            ";

        $consulta = $conexion->prepare($sentencia);

        $consulta->bind_result($obra, $foto, $fecha, $c_nombre);

        $consulta->execute();


        $consulta->store_result();

        echo "<div class='container-xl'>
            <div class='row gy-0 my-5' id='centrar' >";
        while ($consulta->fetch()) {

            $dias_obra = dias_fecha($fecha);

            $resta_dias = $dias_hoy - $dias_obra; //marca de tiempo en segundos del timepo que falta hasta que empiece la obra
            // echo"$resta_dias<br>";

            if (($resta_dias > 0) && ($resta_dias < 7)) {

                $fecha = fecha($fecha);

                echo '<div class="card my-5 mx-5 target" style="width: 18rem;">
                    <img src="..' . $foto . '" class="card-img-top" alt="foto">
                    <div class="card-body">
                        <h5 class="card-title">OBRA:</h5>
                        <p class="card-text">' . $obra . '</p>
                        <h5 class="card-title">COMPAÑÍA:</h5>
                        <p class="card-text">' . $c_nombre . '</p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">' . $fecha . '</li>
                    </ul></div>
                    ';
            }
        }

        echo "</div>
                </div>
            </div>";

        $consulta->close();


    }

    echo "<div class=buscar>
                    
    <form method='post' action='#' enctype='multipart/form-data'>";

    echo'<h2 class="display-5 fw-bold" style="color: #FD9815; text-align: center; margin-bottom: 40px;">Buscar actuación:</h2>';        
    echo"<label for='busqueda_compañia'>Buscar por nombre de la obra futura o que se celebre hoy:</label>
        <input type='text' name='dato_obra' id='busqueda_obra' placeholder='Introduzca nombre de la obra, solamente aparecerán obras futuras o de hoy' required ><br>
        <input type='submit' name='buscar' value = 'buscar'>
        </form>
    </div>";

    
    echo"</main></section>";

    //inserto el menú

    echo insertar_footer($parametro1, $parametro2);
    ?>

</body>

</html>