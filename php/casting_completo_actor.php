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
    //lamo a funciones
    require_once('./funciones.php');

    $conexion = conexion();

    if (isset($_COOKIE['mantener'])) {
        session_decode($_COOKIE['mantener']);
    }


    if (isset($_SESSION['tipo'])) { //si está logueado
        if ($_SESSION['tipo'] == 'actor') { //y ademas está logueado como actor
            if (isset($_SESSION['id'])) {
                $id = $_SESSION['id'];
            }


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


            $parametro1 = "./";
            $parametro2 = "../";
            echo insertar_menu_actores($parametro1, $parametro2);

            echo "<h2 class='display-5 fw-bold' style='color: #FD9815; text-align: center; margin-bottom: 40px; margin-top: 80px; '>Información completa del casting</h2>";


            if (isset($_POST['Inscribirse'])) {
                $id_casting = $_POST['id_casting'];
                $id = $_POST['id'];


                //hago inserciones y consultas
                $sentencia = "insert into participantes_casting (actor, casting , resultado, observaciones)
                 values (?, ?, null, null)";

                $consulta = $conexion->prepare($sentencia);

                $consulta->bind_param("ii", $id, $id_casting); //-------------------------------------------------------------

                $consulta->execute();

                // $consulta->fetch();

                $consulta->close();
                // Header("refresh:1;url=../index.php");
                echo "<h2 class = 'error'>Inscrito correctamente</h2>>";
            }


            if (isset($_POST['Borrarse'])) {
                $id_casting = $_POST['id_casting'];
                $id = $_POST['id'];



                $sentencia = "delete from participantes_casting
                where participantes_casting.actor = ?
                and participantes_casting.casting = ?";

                $consulta = $conexion->prepare($sentencia);

                $consulta->bind_param("ii", $id, $id_casting); //-------------------------------------------------------------

                $consulta->execute();

                // $consulta->fetch();

                $consulta->close();
                // Header("refresh:1;url=../index.php");
                echo "<h2 class = 'error'>Borrado correctamente</h2>";
            }




            if (isset($_GET["id_casting"])) {

                $id_casting = $_GET['id_casting'];


                $sentencia = "select casting.fecha, obra.nombre,
            compañia.nombre nombreCompañia, obra.imagen, casting.descripcion,
            obra.fecha fechaObra, casting.ciudad
            from casting, obra, compañia
            where compañia.id = obra.compañia
            and obra.id = casting.obra
            and casting.id = ?
            ";

                $consulta = $conexion->prepare($sentencia);

                $consulta->bind_result(
                    $fecha_casting,
                    $obraNombre,
                    $compañiaNombre,
                    $obraImagen,
                    $castingDescripcion,
                    $obraFecha,
                    $castingCiudad
                );
                $consulta->bind_param("i", $id_casting);
                $consulta->execute();


                $consulta->store_result();


                $consulta->fetch();

                $fecha_mostrar = fecha($obraFecha);
                $fecha_mostrar2 = fecha($fecha_casting);

                echo'<div class="info">
                <div class="left-info">
                    <figure><img src="..'.$obraImagen.'"></figure>
                    <div class="info-text">';
                    echo "<h6 class='display-5 fw-bold' style='color: #FD9815; text-align: center; margin-bottom: 40px; margin-top: 80px; '>Nombre de la obra:</h6>
                    <h6>$obraNombre</h6>";
                    echo "<h6 class='display-5 fw-bold' style='color: #FD9815; text-align: center; margin-bottom: 40px; margin-top: 80px; '>Fecha en la que se realiza el casting:</h6>
                    <h6>$fecha_mostrar2</h6>";
                    echo "<h6 class='display-5 fw-bold' style='color: #FD9815; text-align: center; margin-bottom: 40px; margin-top: 80px; '>Ciudad en la que se realiza el casting:</h6>
                    <h6>$castingCiudad</h6>";
                    echo "<h6 class='display-5 fw-bold' style='color: #FD9815; text-align: center; margin-bottom: 40px; margin-top: 80px; '>Fecha en la que tendría lugar la obra:</h6>
                    <h6>$fecha_mostrar</h6>";
                    echo "<h6 class='display-5 fw-bold' style='color: #FD9815; text-align: center; margin-bottom: 40px; margin-top: 80px; '>Breve descripción:</h6>
                    <h6>$castingDescripcion</h6>";
                    echo "<h6 class='display-5 fw-bold' style='color: #FD9815; text-align: center; margin-bottom: 40px; margin-top: 80px; '>Compañía que realiza la obra:</h6>
                    <h6>$compañiaNombre</h6>";
                    
                    echo'</div>
                </div>
              </div>
          
            </div>';

            }

            $consulta->close();


            $sentencia = $conexion->prepare("select participantes_casting.actor 
        from participantes_casting
        where participantes_casting.actor = ?
        and participantes_casting.casting = ?");
            //foto de actores 

            $sentencia->bind_result($actor);
            $sentencia->bind_param("ii", $id, $id_casting);
            $sentencia->execute();
            $sentencia->store_result();

            $numero = $sentencia->num_rows();

            if ($numero == 0) {
                echo "<h2 class='display-5 fw-bold' style='color: #FD9815; text-align: center; margin-bottom: 40px; margin-top: 80px; '>No participas en este casting aún, ¿Te apuntas?</h2>";
                echo '<form action="#" method="post" enctype="multipart/form-data">

                <input type="hidden" name="id" value = "' . $id . '">
                <input type="hidden" name="id_casting" value = "' . $id_casting . '">
                <input type="submit" name="Inscribirse" value="Inscribirse" id="inscribirse">
            </form>';
            } else {
                echo "<h2 class='display-5 fw-bold' style='color: #FD9815; text-align: center; margin-bottom: 40px; margin-top: 80px; '>Praticiparás en este casting</h2>";
                echo '<form action="#" method="post" enctype="multipart/form-data">

                <input type="hidden" name="id" value = "' . $id . '">
                <input type="hidden" name="id_casting" value = "' . $id_casting . '">
                <input type="submit" name="Borrarse" value="Borrarse" id="Borrarse">
            </form>';
            }


            $sentencia->close();
            echo"</section></main>";
            //inserto el footer
            echo insertar_footer($parametro1, $parametro2);

            //muestro los errores de acceso
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