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

// llamo a funciones

    require_once('./funciones.php');

    $conexion = conexion();

        //En caso de que esté guardada la sesión la obtengo

    if (isset($_COOKIE['mantener'])) {
        session_decode($_COOKIE['mantener']);
    }


    if (isset($_SESSION['tipo'])) { //si está logueado
        if ($_SESSION['tipo'] == 'compañia') { //y ademas está logueado como actor
            if (isset($_SESSION['id'])) {
                $id = $_SESSION['id'];
            }

            echo "<main>";

            echo '<div class="img-header8">
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
            echo insertar_menu_compañias($parametro1, $parametro2);



            echo "<h2 class='display-5 fw-bold' style='color: #FD9815; text-align: center; margin-bottom: 40px; margin-top: 80px; font-family: 'Lemonada', cursive;'>Información completa del casting</h2>";

            //borrado del actor de la obra

            if (isset($_GET["id_casting"])) {

                $id_casting = $_GET['id_casting'];

                if (isset($_POST['borrar_casting'])) {


                    $sentencia = "delete from participantes_casting 
                    where participantes_casting.casting = ?
                    ";

                    $consulta = $conexion->prepare($sentencia);

                    $consulta->bind_param("i", $id_casting);

                    echo "<h2 class='error'>PARTICIPANTES DEL CASTING DE LA OBRA BORRADOS</h2>";
                    // $spin = spin();
                    // $imprimo .= $spin;

                    

                    $consulta->execute();


                    $consulta->close();

                    $sentencia = "delete from casting 
                    where casting.id = ?
                    ";

                    $consulta = $conexion->prepare($sentencia);

                    $consulta->bind_param("i", $id_casting);

                    

                    echo "<h2 class='error'>CASTINGS DE LA OBRA BORRADOS</h2>";
                    echo'<META HTTP-EQUIV="REFRESH"CONTENT="2;URL=./mis_castingc.php">';
                    $consulta->execute();


                    $consulta->close();
                }

                if (isset($_POST["estado"])) {
                    $id_actor = $_POST['id_actor'];
                    $descripcion_casting = $_POST['descripcion_casting'];
                    $observaciones = $_POST['observaciones'];
                    $id_obra = $_POST['id_obra'];

                    // echo "obra->$id_obra actor ->$id_actor casting-> $id_casting<br>";

                    $sentencia = "update participantes_casting set participantes_casting.resultado = 1 
                where participantes_casting.actor = ? and participantes_casting.casting = ?
                ";

                    $consulta = $conexion->prepare($sentencia);

                    $consulta->bind_param("ii", $id_actor, $id_casting);

                    echo "<h2 class='error'>ESTADO CAMBIADO CORRECTAMENTE</h2>";

                    $consulta->execute();


                    $consulta->close();

                    // echo "obra->$id_obra actor ->$id_actor papel-> $descripcion_casting, observaciones -> $observaciones
                    // <br>";
                    $sentencia = "insert into participantes_obra (obra, actor, papel, comentario) 
                values (?, ?, ?, ?) 
                ";
                    // echo"obra -> $id_obra, actor -> $id_actor, papel -> $descripcion_casting, observaciones ->$observaciones <br>";
                    $consulta = $conexion->prepare($sentencia);

                    $consulta->bind_param("iiss", $id_obra, $id_actor, $descripcion_casting, $observaciones);

                    echo "<h2 class='error'>EL ACTOR SE AÑADIO CORRECTAMENTE A LA OBRA</h2>";

                    $consulta->execute();


                    $consulta->close();
                }


                $sentencia = "select obra.nombre, casting.fecha, casting.hora,
            casting.fecha_resolucion, casting.descripcion, casting.ciudad, 
            obra.imagen
            from casting, obra
            where casting.obra = obra.id
            and casting.id = ?
            ";

                $consulta = $conexion->prepare($sentencia);

                $consulta->bind_result(
                    $nombre_obra,
                    $fecha,
                    $hora,
                    $fecha_resolucion,
                    $descripcion,
                    $ciudad,
                    $imagen
                );
                $consulta->bind_param("i", $id_casting);
                $consulta->execute();


                $consulta->store_result();


                $consulta->fetch();

                $fecha_r = fecha($fecha_resolucion);
                $fec = fecha($fecha);

                echo'<div class="info">
                <div class="left-info">
                    <figure><img src="..'.$imagen.'"></figure>
                    <div class="info-text">';
                    echo "<h6 class='display-5 fw-bold' style='color: #FD9815; text-align: center; margin-bottom: 40px; margin-top: 80px; font-family: 'Lemonada', cursive;'>Nombre de la obra:</h6>
                    <h6>$nombre_obra</h6>";
                    echo "<h6 class='display-5 fw-bold' style='color: #FD9815; text-align: center; margin-bottom: 40px; margin-top: 80px; font-family: 'Lemonada', cursive;'>Fecha en la que se realiza:</h6>
                    <h6>$fec</h6>";
                    echo "<h6 class='display-5 fw-bold' style='color: #FD9815; text-align: center; margin-bottom: 40px; margin-top: 80px; font-family: 'Lemonada', cursive;'>Hora del casting:</h6>
                    <h6>$hora</h6>";
                    echo "<h6 class='display-5 fw-bold' style='color: #FD9815; text-align: center; margin-bottom: 40px; margin-top: 80px; font-family: 'Lemonada', cursive;'>Fecha de resolución:</h6>
                    <h6>$fecha_r</h6>";
                    echo "<h6 class='display-5 fw-bold' style='color: #FD9815; text-align: center; margin-bottom: 40px; margin-top: 80px; font-family: 'Lemonada', cursive;'>Ciudad en la que se realiza:</h6>
                    <h6>$ciudad</h6>";
                    echo "<h6 class='display-5 fw-bold' style='color: #FD9815; text-align: center; margin-bottom: 40px; margin-top: 80px; font-family: 'Lemonada', cursive;'>Descripción del papel buscado:</h6>
                    <h6>$descripcion</h6>";
                    
                    echo'</div>
                </div>
              </div>
          
            </div>';


                echo "                
            <form method='post' action='./editar_casting_completac.php' enctype='multipart/form-data'>
                <input type='submit' value='Modificar Casting' name='modificar' id='modificar'><br><br>
                <input type = 'hidden' name = 'id_casting' value = '$id_casting'>
            </form>";

                echo "                
            <form method='post' action='#' enctype='multipart/form-data'>
                <input type='submit' value='Borrar Casting' name='borrar_casting' id='borrar'><br><br>
                <input type = 'hidden' name = 'id_casting' value = '$id_casting'>
            </form>";

                $consulta->close();




                $sentencia = "select actores.foto, casting.obra, casting.descripcion, actores.nombre, actores.apellidos, actores.alias, actores.id, 
            participantes_casting.resultado, participantes_casting.observaciones
            from actores, participantes_casting, casting
            where actores.id = participantes_casting.actor
            and participantes_casting.casting = casting.id
            and participantes_casting.casting = ?
            ";

                $consulta = $conexion->prepare($sentencia);

                $consulta->bind_result(
                    $foto_actor,
                    $id_obra,
                    $descripcion_casting,
                    $nombre_actor,
                    $apellido_actor,
                    $alias_actor,
                    $id_actor,
                    $resultado,
                    $observaciones
                );
                $consulta->bind_param("i", $id_casting);
                $consulta->execute();


                $consulta->store_result();


            echo "</div><h2 class='display-5 fw-bold' style='color: #FD9815; text-align: center; margin-bottom: 40px; margin-top: 80px; font-family: 'Lemonada', cursive;'>Actores que participan en el casting</h2>";

            echo '
            <div id="fondo" class="bg-image shadow-2-strong" style="margin-top: 50px; height: auto;">
            <div class="mask">
            <div class="album py-5" >
            <!-- <div class="album py-5 bg-dark" > -->
            <div class="container"  >';

            echo '<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3"  >
            ';

                while ($consulta->fetch()) {



                    echo '
                    <div class="col textoCentrado">
                       <div style=" margin: 30px; margin-top: 40px; border-radius: 20px;" class="card shadow-sm">
                         <!-- <svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"/><text x="43%" y="50%" fill="#eceeef" dy=".3em">FOTOO</text></svg>-->
                         <!-- <img  src="..' . $foto_actor . '" class="card-img-top" alt="foto"> -->
                         <img class="bd-placeholder-img rounded-circle" width="200rem" height="200rem" style="border-style: solid; border-width: 5px; border-color: white; object-fit: cover; margin: 0 auto; margin-top: -30px; box-shadow: 2px 1px 16px #000000;"  src="..' . $foto_actor . '" class="card-img-top" alt="foto">
                         <div class="card-body text-align:center" >
                             <div style="width: 100%;>
                               <p style="text-align:center;class="card-text"><strong>' . $nombre_actor . '</strong></p>
                               <p style="text-align:center;class="card-text"><strong> "' . $alias_actor . '"</strong></p>
                               <p style="text-align:center;class="card-text"><strong> ' . $observaciones . '</strong></p>
                               <p style="text-align:center;class="card-text"><strong> ' . $descripcion_casting . '</strong></p>
    
                               ';
                               
                               echo'<div class="d-flex justify-content-between align-items-center">
                                 <div style="margin: 0 auto" class="btn-group">';
        
                                 if ($resultado == 0) {
                                    echo "<form method='post' action='#' class = 'control2' enctype='multipart/form-data'>
                                <input type = 'hidden' name = 'id_actor' value = '$id_actor'>
                                <input type = 'hidden' name = 'id_obra' value = '$id_obra'>
                                <input type = 'hidden' name = 'observaciones' value = '$observaciones'>
                                <input type = 'hidden' name = 'descripcion_casting' value = '$descripcion_casting'>
                                <input type='submit' value='Aceptar' name='estado' id='estado'><br><br>
                                
                            </form>";

      
                                 echo'</div>';
                               echo'</div>
                             </div>
                         </div>
                       </div>
                     </div>
                 ';
                };
                echo '
                </div><!-- /.row -->
                </div></div></div></div>
                ';

                }
                echo "</ul></section></main>";

                echo insertar_footer($parametro1, $parametro2);

                $consulta->close();
                $cont = 0;


            }

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