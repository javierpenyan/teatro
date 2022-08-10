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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../asset/imagenes/logo.jpg">
    <title>Actores</title>
</head>

<body>
    <?php

    //Usaremos en ocasiones el formato de hora español
    setlocale(LC_ALL, "es-ES.UTF-8");
    $impresion = "";

    //En caso de que esté guardada la sesión la obtengo

    if (isset($_COOKIE['mantener'])) {
        session_decode($_COOKIE['mantener']);
    }

    $id_actor = "";

    if (isset($_SESSION['tipo'])) {
        if ($_SESSION['tipo'] == 'actor') {



            if (isset($_SESSION['id'])) {

                $id_actor = $_SESSION['id'];


                $control = true; //control que representa al usuario de a pié

                //Llamo a funciones.php para poder traer las funciones a esta pagina
                require_once('./funciones.php');

                $feedback = '';

                $conexion = conexion();

                echo "<main>";

                echo '<div class="img-header10">
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



                //realizamos la conexion
                $conexion = conexion();
                // $r1 = ".";
                // $r2 =".";

                // //Aqui insertamos el menu de navegacion
                // echo insertar_menu($r1, $r2);


                //seccion principal
                echo "
            <div id=citas>
            <div id=listado_citas>
        ";

                if (isset($_GET["ano"])) {
                    $ano = $_GET['ano'];
                    $mes = $_GET['mes'];
                    $dia = $_GET['dia'];
                    if ($dia <= 9) {
                        $dia = "0$dia";
                    }
                    $fecha_consulta = "$ano-$mes-$dia";
                    $fecha_comparo = "$ano/$mes/$dia";
                    $fecha_mostrar = "$dia-$mes-$ano";
                    $hoy = date("Y/m/d");

                    //BORRAR CASTING//////////////////////////////
                    if (isset($_POST['borrar_casting'])) {
                        $id_casting = $_POST['id_casting'];

                        $sentencia = "delete from participantes_casting
                 where participantes_casting.casting=? and
                 participantes_casting.actor = ?";

                        $consulta = $conexion->prepare($sentencia);

                        $consulta->bind_param("ii", $id_casting, $id_actor);

                        echo "<h2 class = error>PRODUCTO BORRADO CORRECTAMENTE</h2>";

                        $consulta->execute();

                        // $consulta->fetch();

                        $consulta->close();
                    }

                    //BORRAR REUNIÓN//////////////////////////////
                    if (isset($_POST['borrar_reunion'])) {
                        $id_reunion = $_POST['id_reunion'];

                        echo "ID REUNION -> $id_reunion<br>";

                        $sentencia = "delete from reunion
                             where reunion.id = ?";

                        $consulta = $conexion->prepare($sentencia);

                        $consulta->bind_param("i", $id_reunion);

                        echo "<h2 class = error>REUNIÓN BORRADA CORRECTAMENTE</h2>";

                        $consulta->execute();



                        $consulta->close();
                    }

                    if (isset($_POST['borrar_cita'])) {
                        $id_cita = $_POST['id_cita'];

                        echo "ID REUNION -> $id_cita<br>";

                        $sentencia = "delete from cita_actor
                             where cita_actor.id = ?";

                        $consulta = $conexion->prepare($sentencia);

                        $consulta->bind_param("i", $id_cita);

                        echo "<h2 class = error>CITA BORRADA CORRECTAMENTE</h2>";

                        $consulta->execute();



                        $consulta->close();
                    }

                    //realizo la consulta de los datos que necesito


                    $sentencia = "select obra.nombre 
                from obra, actores, participantes_obra
                where obra.id = participantes_obra.obra and
                participantes_obra.actor = actores.id and
                actores.id = ? and
                obra.fecha = ?";

                    $consulta = $conexion->prepare($sentencia);

                    $consulta->bind_param("is", $id_actor, $fecha_consulta);
                    $consulta->bind_result($obra_nombre);
                    $consulta->execute();


                    $consulta->store_result();

                    $numero1 = $consulta->num_rows;
                    // echo "numero de actuaciones: ".$numero1."<br>";
                    if ($numero1 > 0) {
                        echo '<h5 class="display-5 fw-bold" style="color: #FD9815; text-align: center; margin-bottom: 40px; margin-top: 80px; font-family: "Lemonada", cursive;">Obras:</h5>';

                        echo "<ul>";
                        while ($consulta->fetch()) {

                            echo "<div class=confirmado>";
                            //muestro los datos
                            echo "<li><h5> - $obra_nombre</h5></li>";
                            echo "</div>";
                        }
                        echo "</ul></div>";
                    }
                    $consulta->close();




                    $sentencia = "select obra.nombre, casting.id, casting.fecha, 
                casting.hora, casting.descripcion
                from obra, actores, participantes_casting, 
                casting
                where casting.id = participantes_casting.casting
                and actores.id = participantes_casting.actor
                and casting.obra = obra.id
                and participantes_casting.actor = ?
                and casting.fecha = ?
                ";

                    $consulta = $conexion->prepare($sentencia);

                    $consulta->bind_param("is", $id_actor, $fecha_consulta);
                    $consulta->bind_result(
                        $obra_nombre,
                        $casting_id,
                        $casting_fecha,
                        $casting_hora,
                        $casting_descripcion
                    );
                    $consulta->execute();

                    $consulta->store_result();

                    $numero2 = $consulta->num_rows;

                    // echo "numero de casting: ".$numero2."<br>";

                    if ($numero2 > 0) {

                        echo '<h5 class="display-5 fw-bold" style="color: #FD9815; text-align: center; margin-bottom: 40px; margin-top: 80px; font-family: "Lemonada", cursive;">Castings:</h5>';
                        echo "<ul>";
                        while ($consulta->fetch()) {

                            echo "<div >";
                            //muestro los datos
                            echo "<li class = 'confirmado';><h5> - $obra_nombre las hora $casting_hora
                         para $casting_descripcion</h5></li>";
                            if ($fecha_comparo > $hoy) {

                                echo "<form id='confirmado' method = 'post' action = '#' enctype = 'multipart/form-data'>
                                <input type = 'submit' name = 'borrar_casting' value = 'borrar'<br>
                                <input type = 'hidden' name = 'id_casting' value = '$casting_id'>
                            </form>
                            ";
                            }
                            echo "</div>";
                        }
                        echo "</ul></div>";
                    }
                    $consulta->close();




                    $sentencia = "select obra.nombre, ensayo.fecha, 
                ensayo.hora
                from ensayo, obra
                where ensayo.actor = ?
                and ensayo.obra = obra.id 
                 and ensayo.fecha = ?
                ";

                    $consulta = $conexion->prepare($sentencia);

                    $consulta->bind_param("is", $id_actor, $fecha_consulta);
                    $consulta->bind_result(
                        $obra_nombre,
                        $ensayo_fecha,
                        $ensayo_hora
                    );
                    $consulta->execute();

                    $consulta->store_result();

                    $numero3 = $consulta->num_rows;

                    // echo "numero de ensayos: ".$numero3."<br>";
                    if ($numero3 > 0) {
                        echo '<h5 class="display-5 fw-bold" style="color: #FD9815; text-align: center; margin-bottom: 40px; margin-top: 80px; font-family: "Lemonada", cursive;">Ensayos:</h5>';

                        echo "<ul>";
                        while ($consulta->fetch()) {

                            echo "<div class=confirmado>";
                            //muestro los datos
                            echo "<li><h5> - $obra_nombre a las $ensayo_hora</li></h5>";
                            if ($fecha_comparo > $hoy) {

                                // echo"<form id='confirmado' method = 'post' action = borrar_ensayo.php enctype = 'multipart/form-data'>
                                //     <input type = 'submit' name = 'borrar_cita' value = 'borrar'<br>
                                //     <input type = 'hidden' name = 'participante_ensayo_id' value = '$ensayo_id'>
                                //     <input type = 'hidden' name = 'hora' value = '$hora'>
                                // </form>
                                // ";

                            }
                            echo "</div>";
                        }
                        echo "</ul></div>";
                    }
                    $consulta->close();







                    $sentencia = "select cita_actor.id, cita_actor.hora, cita_actor.motivo
            from cita_actor
                where cita_actor.actor = ?
                 and cita_actor.fecha = ?
                ";

                    $consulta = $conexion->prepare($sentencia);

                    $consulta->bind_param("is", $id_actor, $fecha_consulta);
                    $consulta->bind_result(
                        $id_cita,
                        $cita_hora,
                        $cita_motivo
                    );
                    $consulta->execute();

                    $consulta->store_result();

                    $numero4 = $consulta->num_rows;
                    // echo "numero de citas: ".$numero4."<br>";
                    if ($numero4 > 0) {
                        echo '<h5 class="display-5 fw-bold" style="color: #FD9815; text-align: center; margin-bottom: 40px; margin-top: 80px; font-family: "Lemonada", cursive;">Citas:</h5>';
                        echo "<ul>";
                        while ($consulta->fetch()) {

                            echo "<div >";
                            //muestro los datos
                            echo "<li class=confirmado><h5> - $cita_hora, con motivo de '$cita_motivo'</h5></li>";
                            if ($fecha_comparo > $hoy) {

                                echo "<form id='confirmado' method = 'post' action = # enctype = 'multipart/form-data'>
                            <input type = 'submit' name = 'borrar_cita' value = 'borrar'<br>
                            <input type = 'hidden' name = 'id_cita' value = '$id_cita'>
                        </form>
                        ";
                            }
                            echo "</div>";
                        }
                        echo "</ul></div>";
                    }


                    $consulta->close();






                    $sentencia = "select reunion.id, reunion.fecha, reunion.hora, 
                reunion.lugar, compañia.nombre, reunion.comentario
                from reunion, compañia
                where compañia.id = reunion.compañia
                and reunion.actor = ? 
                 and reunion.fecha = ?
                ";

                    $consulta = $conexion->prepare($sentencia);

                    $consulta->bind_param("is", $id_actor, $fecha_consulta);
                    $consulta->bind_result(
                        $reunion_id,
                        $reunion_fecha,
                        $reunion_hora,
                        $reunion_lugar,
                        $reunion_compañia,
                        $reunion_comentario
                    );
                    $consulta->execute();

                    $consulta->store_result();

                    $numero5 = $consulta->num_rows;

                    // echo "numero de reuniones: ".$numero5."<br>";

                    if ($numero5 > 0) {
                        echo '<h5 class="display-5 fw-bold" style="color: #FD9815; text-align: center; margin-bottom: 40px; margin-top: 80px; font-family: "Lemonada", cursive;">Reuniones:</h5>';
                        echo "<ul>";
                        while ($consulta->fetch()) {

                            echo "<div >";
                            //muestro los datos
                            echo "<li class=confirmado><h5> - Reunion con $reunion_compañia
                         a las $reunion_hora en $reunion_lugar para tratar '$reunion_comentario'</h5></li>";
                            if ($fecha_comparo > $hoy) {

                                echo "<form id='confirmado' method = 'post' action = # enctype = 'multipart/form-data'>
                                <input type = 'submit' name = 'borrar_reunion' value = 'borrar'<br>
                                <input type = 'hidden' name = 'id_reunion' value = '$reunion_id'>
                            </form>
                            ";
                            }
                            echo "</div>";
                        }
                        echo "</ul></div>";
                    }

                    $consulta->close();
                }

                echo "</section></main>";

                //inserto footer
                echo insertar_footer($parametro1, $parametro2);

                // echo insertar_footer();

                $conexion->close();

                //muestro errores de acceso
            } else {
                echo "<h2 class='error'>NECESITA REGISTRARSE PARA ACCEDER A ESTA PÁGINA</h2>";
                // $spin = spin();
                // $imprimo .= $spin;
                echo'<META HTTP-EQUIV="REFRESH"CONTENT="2;URL=./vistaError.php">';
            }
        } else {
            echo "<h2 class='error'>NECESITA REGISTRARSE PARA ACCEDER A ESTA PÁGINA</h2>";
            // $spin = spin();
            // $imprimo .= $spin;
            echo'<META HTTP-EQUIV="REFRESH"CONTENT="2;URL=./vistaError.php">';
        }
    } else {
        echo "<h2 class='error'>NECESITA REGISTRARSE PARA ACCEDER A ESTA PÁGINA</h2>";
        // $spin = spin();
        // $imprimo .= $spin;
        echo'<META HTTP-EQUIV="REFRESH"CONTENT="2;URL=./vistaError.php">';
    }


    ?>

</body>

</html>