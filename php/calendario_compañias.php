<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">

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

    //Usaremos en ocasiones el formato de hora español
    setlocale(LC_ALL, "es-ES.UTF-8");
    $impresion = "";


    if (isset($_COOKIE['mantener'])) {
        session_decode($_COOKIE['mantener']);
    }

    $id_compañia = "";

    if (isset($_SESSION['tipo'])) {
        if ($_SESSION['tipo'] == 'compañia') {


            if (isset($_SESSION['id'])) {

                $id_compañia = $_SESSION['id'];

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
                echo insertar_menu_compañias($parametro1, $parametro2);


                if (isset($_POST['reunion'])) {

                    $compañia = $_SESSION['id'];
                    $fecha = $_POST['fecha'];
                    $hora = $_POST['hora'];
                    $lugar = $_POST['lugar'];
                    $actor = $_POST['actor'];
                    $comentario = $_POST['comentario'];

                    $sentencia = "insert into reunion
                    (fecha, hora, lugar, actor, compañia, comentario)
                    values (?, ?, ?, ?, ?, ?) 
                    ";

                    $consulta = $conexion->prepare($sentencia);

                    $consulta->bind_param("sssiis", $fecha, $hora, $lugar, $actor, $compañia, $comentario);

                    echo "<h2 class='error'>Reunión añadida con éxito</h2>";
                    // $spin = spin();
                    // $imprimo .= $spin;

                    $consulta->execute();


                    $consulta->close();
                }

                if (isset($_POST['ensayo'])) {

                    $compañia = $_SESSION['id'];
                    $fecha = $_POST['fecha'];
                    $hora = $_POST['hora'];
                    $obra = $_POST['obra'];
                    $actor = $_POST['actor'];




                    $sentencia = "SELECT `AUTO_INCREMENT` FROM  INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'teatro' AND   TABLE_NAME = 'ensayo';";
        
                    $consulta=$conexion->query($sentencia);
                    $fila=$consulta->fetch_array(MYSQLI_ASSOC);

                    $siguienteId = $fila["AUTO_INCREMENT"];
           
                    // $consulta->close();





                    $sentencia = "insert into ensayo
                    (id, fecha, hora, obra, actor)
                    values (?, ?, ?, ?, ?) 
                    ";

                    $consulta = $conexion->prepare($sentencia);

                    $consulta->bind_param("issii", $siguienteId, $fecha, $hora, $obra, $actor);

                    echo "<h2 class='error'>Ensayo añadido con éxito</h2>";
                    $consulta->execute();


                    $consulta->close();

                    $sentencia = "insert into participantes_ensayo
                    (ensayo, actor)
                    values (?, ?) 
                    ";

                    $consulta = $conexion->prepare($sentencia);

                    $consulta->bind_param("ii", $siguienteId, $actor);

                    // echo "<h2 class='error'>Participante de ensayo añadido con éxito</h2>";
                    $consulta->execute();


                    $consulta->close();
                }


                if (isset($_POST['cita'])) {

                    $compañia = $_SESSION['id'];
                    $fecha = $_POST['fecha'];
                    $hora = $_POST['hora'];
                    $motivo = $_POST['motivo'];

                    $sentencia = "insert into cita_compañia
                    (fecha, hora, motivo, compañia)
                    values (?, ?, ?, ?) 
                    ";

                    $consulta = $conexion->prepare($sentencia);

                    $consulta->bind_param("sssi", $fecha, $hora, $motivo, $compañia);

                    echo "<h2 class='error'>Cita añadida con éxito</h2>";
                    $consulta->execute();


                    $consulta->close();
                }





                
                echo'<h2 class="display-5 mask album fw-bold" style="color: #FD9815; text-align: center; margin-bottom: 80px; margin-top: 80px;">Calendario de la compañía:</h2>';

                echo"<section>

                    <div id=citas>
                    <div id=listado_citas>
                ";

                $conexion = conexion();
                //creo un array que guarde el horario al que se le puede pedir cita
                $horarios = array("09:00", "09:30", "10:00", "10:30", "11:00", "11:30", "12:00", "12:30", "13:00", "13:30", "14:00", "16:00", "16:30", "17:00", "17:30", "18:00", "18:30", "19:00", "19:30", "20:00", "20:30", "21:00", "21:30");

                //voy a añadir la cita con los datos introducidos anteriormente
                /////////////////////////////////////////////////////////////////////////////////////////
                /////////////////////////////////////////////////////////////////////////////////////////

                //controlo el mes en el que estoy
                if (isset($_POST['siguiente'])) {
                    $mes = $_POST['mes_actual'];
                    $cont = 0;
                    $ano2 = date("Y", $mes);
                    $mes2 = date("n", $mes);
                    $dia2 = date("j", $mes);
                    $hoy = date("Y-m-d");
                    if ($mes2 == 12) {
                        $dia1 = 1;
                        $mes1 = 1;
                        $ano1 = $ano2 + 1;
                    } else {
                        $dia1 = 1;
                        $mes1 = $mes2 + 1;
                        $ano1 = $ano2;
                    }
                } elseif (isset($_POST['anterior'])) {
                    $mes = $_POST['mes_actual'];
                    $cont = 0;
                    $ano2 = date("Y", $mes);
                    $mes2 = date("n", $mes);
                    $dia2 = date("j", $mes);
                    $hoy = date("Y-m-d");
                    // echo"actual = $dia2, $mes2, $ano2";
                    if ($mes2 == 1) {
                        $dia1 = 1;
                        $mes1 = 12;
                        $ano1 = $ano2 - 1;
                        echo "anterior = $dia1, $mes1, $ano1";
                    } else {
                        $dia1 = 1;
                        $mes1 = $mes2 - 1;
                        $ano1 = $ano2;
                        // echo"anterior = $dia1, $mes1, $ano1";
                    }
                } else {

                    $cont = 0;
                    $hoy = time();
                    $ano1 = date("Y", $hoy);
                    $mes1 = date("n", $hoy);
                    $dia1 = date("j", $hoy);
                    $hoy = date("Y-m-d");
                }

                $mi_mes = mktime(0, 0, 0, $mes1, $dia1, $ano1); //marca temporal del mes en el que estoy

                //Consulta para capturar las obras que tengo este mes:
                $today = date("Y,m,d");
                $este_mes_obra = date("Y/m/d", $mi_mes);
                $mes_mes = date('m', $mi_mes);
                $anio_mes = date('Y', $mi_mes);
                $array_obra = [];

                $sentencia = "select 
                obra.nombre, obra.id, obra.fecha, obra.duracion
                from obra
                where 
                obra.compañia = ?";

                $consulta = $conexion->prepare($sentencia);
                $consulta->bind_param("i", $id_compañia);
                $consulta->bind_result(
                    $obra_nombre,
                    $obra_id,
                    $obra_fecha,
                    $obra_duracion
                );
                // $consulta->bind_param("s",$este_mes_cita);
                $consulta->execute();


                $consulta->store_result();


                while ($consulta->fetch()) {


                    $marca_tiempo_obra = strtotime($obra_fecha); //marca de timepo y datos de la fecha de la obra
                    $dia_obra = date('j', $marca_tiempo_obra);
                    $mes_obra = date('m', $marca_tiempo_obra);
                    $anio_obra = date('Y', $marca_tiempo_obra);



                    if ($mes_mes == $mes_obra && $anio_mes == $anio_obra) {

                        //los datos de la cita los voy a introducir en un array para evitar tener que hacer una consulta para cada dia en el calendario

                        if (!isset($array_obra[$dia_obra])) {
                            $array_obra[$dia_obra] = [];
                        }

                        array_push($array_obra[$dia_obra], array(
                            "obra_nombre" => $obra_nombre,
                            "obra_id" => $obra_id,
                            "obra_fehca" => $obra_fecha,
                            "obra_duracion" => $obra_duracion
                            // "fech" => $fecha
                        ));
                    }
                }


                //Consulta para capturar los casting que tengo este mes:
                $today = date("Y,m,d");
                $este_mes_casting = date("Y/m/d", $mi_mes);
                $mes_mes = date('m', $mi_mes);
                $anio_mes = date('Y', $mi_mes);
                $array_casting = [];

                $sentencia = "select 
                obra.nombre, casting.id, casting.fecha, casting.hora
                from obra, casting
                where obra.id = casting.obra and
                obra.compañia = ?";

                $consulta = $conexion->prepare($sentencia);
                $consulta->bind_param("i", $id_compañia);
                $consulta->bind_result(
                    $obra_nombre,
                    $casting_id,
                    $casting_fecha,
                    $casting_hora
                );
                // $consulta->bind_param("s",$este_mes_cita);
                $consulta->execute();


                $consulta->store_result();


                while ($consulta->fetch()) {


                    $marca_tiempo_casting = strtotime($casting_fecha); //marca de timepo y datos de la fecha de la obra
                    $dia_casting = date('j', $marca_tiempo_casting);
                    $mes_casting = date('m', $marca_tiempo_casting);
                    $anio_casting = date('Y', $marca_tiempo_casting);



                    if ($mes_mes == $mes_casting && $anio_mes == $anio_casting) {

                        //los datos de la cita los voy a introducir en un array para evitar tener que hacer una consulta para cada dia en el calendario

                        if (!isset($array_casting[$dia_casting])) {
                            $array_casting[$dia_casting] = [];
                        }

                        array_push($array_casting[$dia_casting], array(
                            "obra_nombre" => $obra_nombre,
                            "casting_id" => $casting_id,
                            "casting_fehca" => $casting_fecha,
                            "casting_hora" => $casting_hora
                            // "fech" => $fecha
                        ));
                    }
                }

                //////////////////////////?????????????????????????/////////////////////////
                //Consulta para capturar los ensayos que tengo este mes:
                $today = date("Y,m,d");
                $este_mes_ensayo = date("Y/m/d", $mi_mes);
                $mes_mes = date('m', $mi_mes);
                $anio_mes = date('Y', $mi_mes);
                $array_ensayo = [];

                $sentencia = "select compañia.nombre,
                obra.nombre, ensayo.id, ensayo.fecha, ensayo.hora
                from compañia, obra, ensayo
                where obra.id = ensayo.obra
                and obra.compañia = compañia.id
                and obra.compañia = ?";

                $consulta = $conexion->prepare($sentencia);
                $consulta->bind_param("i", $id_compañia);
                $consulta->bind_result(
                    $compañia_nombre,
                    $ensayo_nombre,
                    $ensayo_id,
                    $ensayo_fecha,
                    $ensayo_hora
                );
                // $consulta->bind_param("s",$este_mes_cita);
                $consulta->execute();


                $consulta->store_result();


                while ($consulta->fetch()) {


                    $marca_tiempo_ensayo = strtotime($ensayo_fecha); //marca de timepo y datos de la fecha de la obra
                    $dia_ensayo = date('j', $marca_tiempo_ensayo);
                    $mes_ensayo = date('m', $marca_tiempo_ensayo);
                    $anio_ensayo = date('Y', $marca_tiempo_ensayo);



                    if ($mes_mes == $mes_ensayo && $anio_mes == $anio_ensayo) {

                        //los datos de la cita los voy a introducir en un array para evitar tener que hacer una consulta para cada dia en el calendario

                        if (!isset($array_ensayo[$dia_ensayo])) {
                            $array_ensayo[$dia_ensayo] = [];
                        }

                        array_push($array_ensayo[$dia_ensayo], array(

                            "compañia_nombre" => $compañia_nombre,
                            "obra_nombre" => $ensayo_nombre,
                            "obra_id" => $ensayo_id,
                            "ensayo_fehca" => $ensayo_fecha,
                            "ensayo_hora" => $ensayo_hora
                            // "fech" => $fecha
                        ));
                    }
                }



                //Consulta para capturar las citas que tengo este mes:
                $today = date("Y,m,d");
                $este_mes_cita_compañia = date("Y/m/d", $mi_mes);
                $mes_mes = date('m', $mi_mes);
                $anio_mes = date('Y', $mi_mes);
                $array_cita_compañia = [];

                $sentencia = "select 
                                cita_compañia.id, cita_compañia.fecha, cita_compañia.hora,
                                cita_compañia.motivo
                                from cita_compañia
                                where 
                                cita_compañia.compañia = ?";

                $consulta = $conexion->prepare($sentencia);
                $consulta->bind_param("s", $id_compañia);
                $consulta->bind_result(
                    $cita_compañia_id,
                    $cita_compañia_fecha,
                    $cita_compañia_hora,
                    $cita_compañia_motivo,

                );
                // $consulta->bind_param("s",$este_mes_cita);
                $consulta->execute();


                $consulta->store_result();


                while ($consulta->fetch()) {


                    $marca_tiempo_cita_compañia = strtotime($cita_compañia_fecha); //marca de timepo y datos de la fecha de la obra
                    $dia_cita_compañia = date('j', $marca_tiempo_cita_compañia);
                    $mes_cita_compañia = date('m', $marca_tiempo_cita_compañia);
                    $anio_cita_compañia = date('Y', $marca_tiempo_cita_compañia);



                    if ($mes_mes == $mes_cita_compañia && $anio_mes == $anio_cita_compañia) {

                        //los datos de la cita los voy a introducir en un array para evitar tener que hacer una consulta para cada dia en el calendario

                        if (!isset($array_cita_compañia[$dia_cita_compañia])) {
                            $array_cita_compañia[$dia_cita_compañia] = [];
                        }

                        array_push($array_cita_compañia[$dia_cita_compañia], array(

                            "fecha_cita_compañia " => $cita_compañia_fecha,
                            "hora_cita_compañia" => $cita_compañia_hora,
                            "motivo_cita_compañia" => $cita_compañia_motivo,

                            // "fech" => $fecha
                        ));
                    }
                }


                //Consulta para capturar las reuniones que tengo este mes:
                $today = date("Y,m,d");
                $este_mes_reunion = date("Y/m/d", $mi_mes);
                $mes_mes = date('m', $mi_mes);
                $anio_mes = date('Y', $mi_mes);
                $array_reunion = [];

                $sentencia = "select reunion.fecha, reunion.hora
                from reunion
                where 
                reunion.compañia = ?";

                $consulta = $conexion->prepare($sentencia);
                $consulta->bind_param("s", $id_compañia);
                $consulta->bind_result($reunion_fecha, $reunion_hora);
                // $consulta->bind_param("s",$este_mes_cita);
                $consulta->execute();


                $consulta->store_result();


                while ($consulta->fetch()) {


                    $marca_tiempo_reunion = strtotime($reunion_fecha); //marca de timepo y datos de la fecha de la obra
                    $dia_reunion = date('j', $marca_tiempo_reunion);
                    $mes_reunion = date('m', $marca_tiempo_reunion);
                    $anio_reunion = date('Y', $marca_tiempo_reunion);



                    if ($mes_mes == $mes_reunion && $anio_mes == $anio_reunion) {

                        //los datos de la cita los voy a introducir en un array para evitar tener que hacer una consulta para cada dia en el calendario

                        if (!isset($array_reunion[$dia_reunion])) {
                            $array_reunion[$dia_reunion] = [];
                        }

                        array_push($array_reunion[$dia_reunion], array(

                            "reunion_fehca" => $reunion_fecha,
                            "reunion_hora" => $reunion_hora
                            // "fech" => $fecha
                        ));
                    }
                }


                // foreach($array_citas as $clave => $valor){

                //     for($i=0; $i<count($valor); $i++){

                //     }
                // }



                $numero_dias = date("t", $mi_mes); //numero de dias que tiene el mes
                // echo"numero dias
                $dia_empieza_marca = mktime(0, 0, 0, $mes1, 1, $ano1); //marca temporal del dia que empieza el mes
                $dia_empieza = strftime("%u", $dia_empieza_marca) - 1; //numero de dia por el que empieza el mes




                $cont = 0;

                $nombre_mes = strftime("%B", $mi_mes);

                echo "<table border-collapse:collapse>";
                echo "<tr><td colspan='7'>$nombre_mes</td></tr>";
                //dibujo los dias de la semana en el calendario
                echo "<tr><th>Lunes</th><th>Martes</th><th>Miercoles</th><th>Jueves</th><th>Viernes</th><th>Sabado</th><th>Domingo</th></tr>";
                echo "<tr>";

                //pinto las celdas en blanco correspondientes a los dias de la semana antes de que empiece el mes

                for ($i = 1; $i <= $dia_empieza; $i++) {
                    echo "<td> </td>";
                }

                $cont = $dia_empieza;

                //realizo el pintado del calendario con los dias del mes y las citas

                for ($i = 1; $i <= $numero_dias; $i++) {
                    if ($cont == 0) {
                        echo "<tr>";
                    }
                    if ($cont == 7) {
                        echo "</tr>";
                        $cont = 0;
                    } else {


                        /////////////////////////////////////////////////////////
                        if (
                            isset($array_obra[$i]) || isset($array_casting[$i]) || isset($array_ensayo[$i]) || isset($array_reunion[$i]) || isset($array_cita_compañia[$i])
                            //  || isset($array_reunion)
                        ) {

                            echo "<td class=color_celda><a href='./ver_cita_compañia.php?ano=" . $anio_mes . "&mes=" . $mes_mes . "&dia=" . $i . "'>" . $i; //....
                            //si el dia del mes existen citas, se pinta la celda de color verde y pongo un enlace que me permita acceder a una pagina independiente donde poder ver las citas existentes ese dia
                            echo "<br>";

                            echo "</a></td>";
                        } else {
                            echo "<td>$i </td>";
                        }



                        $cont++;
                    }

                    if ($cont == 7) {
                        echo "</tr>"; //cierro tabla al 7 dia
                        $cont = 0;
                    }
                }
                echo "</table></div>";


                
                echo "<form id='f_c' method = 'post' action = # enctype = 'multipart/form-data'>
                        <input type = 'submit' name = 'siguiente' value = 'siguiente'<br>
                        <input type = 'submit' name = 'anterior' value = 'anterior'<br>
                        <input type = 'hidden' name = 'mes_actual' value = '$mi_mes'> 
                    </form>";

                    

                echo'<h2 class="display-5 mask album fw-bold" style="color: #FD9815; text-align: center; margin-bottom: 80px; margin-top: 80px; ">Inserte una reunión</h2>';

                echo '
                    <form action="#" method="post" enctype="multipart/form-data">
                        <label for="fecha">Fecha</label>
                            <input type="date" name="fecha" id="fecha">
                        <label for="hora">Hora</label>
                            <input type="time" name="hora" id="hora">
                        <label for="lugar">Lugar</label>
                            <input type="text" name="lugar" id="lugar">
                        <label for="compañia">Compañía</label>';
                echo "<select name='actor' id='actor'>";
                $consulta = "select actores.nombre, 
                        actores.id
                        from actores
                        ";
                $resultado = $conexion->query($consulta);
                $numero_filas = $resultado->num_rows;
                echo "hay $numero_filas actores";
                while ($fila = $resultado->fetch_array(MYSQLI_ASSOC)) {
                    if ($cont == 0) {
                        echo "<option value='" . $fila['id'] . "' selected>" . $fila['nombre'] . "'</option>";
                    } else {
                        echo "<option value='" . $fila['id'] . "'>" . $fila['nombre'] . "'</option>";
                    }
                }
                echo "</select>";
                echo '<label for="comentario">Comentario</label>
                            <input type="text" name="comentario" id="comentario">
                        <input type="submit" name="reunion" value="Añadir Reunión" >
                    </form>';


                    echo'<h2 class="display-5 mask album fw-bold" style="color: #FD9815; text-align: center; margin-bottom: 80px; margin-top: 80px; ">Inserte un ensayo</h2>';

                    echo '
                    <form action="#" method="post" enctype="multipart/form-data">
                        <label for="fecha">Fecha</label>
                            <input type="date" name="fecha" id="fecha">
                        <label for="hora">Hora</label>
                            <input type="time" name="hora" id="hora">';
                echo "<select name='actor' id='actor'>";
                $consulta = "select actores.nombre, 
                        actores.id
                        from actores, obra, compañia, participantes_obra
                        where actores.id = participantes_obra.actor
                        and obra.compañia = compañia.id
                        and participantes_obra.obra = obra.id
                        and compañia.id = $id_compañia
                        ";
                $resultado = $conexion->query($consulta);
                $numero_filas = $resultado->num_rows;
                echo "hay $numero_filas actores";
                while ($fila = $resultado->fetch_array(MYSQLI_ASSOC)) {
                    if ($cont == 0) {
                        echo "<option value='" . $fila['id'] . "' selected>" . $fila['nombre'] . "'</option>";
                    } else {
                        echo "<option value='" . $fila['id'] . "'>" . $fila['nombre'] . "'</option>";
                    }
                }
                echo "</select>";
                echo "<select name='obra' id='obra'>";
                $consulta = "select obra.nombre, 
                        obra.id
                        from obra
                        where obra.compañia = $id_compañia
                        ";
                $resultado = $conexion->query($consulta);
                $numero_filas = $resultado->num_rows;
                echo "hay $numero_filas actores";
                while ($fila = $resultado->fetch_array(MYSQLI_ASSOC)) {
                    if ($cont == 0) {
                        echo "<option value='" . $fila['id'] . "' selected>" . $fila['nombre'] . "'</option>";
                    } else {
                        echo "<option value='" . $fila['id'] . "'>" . $fila['nombre'] . "'</option>";
                    }
                }
                echo "</select>";
                echo '
                        <input type="submit" name="ensayo" value="Añadir Ensayo" >
                    </form>';


                echo'<h2 class="display-5 mask album fw-bold" style="color: #FD9815; text-align: center; margin-bottom: 80px; margin-top: 80px; ">Inserte una cita</h2>';

                echo '
                    <form action="#" method="post" enctype="multipart/form-data">
                        <label for="fecha">Fecha</label>
                            <input type="date" name="fecha" id="fecha">
                        <label for="hora">Hora</label>
                            <input type="time" name="hora" id="hora">';
                echo '<label for="motivo">Motivo</label>
                            <input type="text" name="motivo" id="motivo">
                        <input type="submit" name="cita" value="Añadir Cita" >
                    </form></section></main>';

                echo insertar_footer($parametro1, $parametro2);

            } else {
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
    }else{
        echo "<h2 class='error'>NECESITA REGISTRARSE PARA ACCEDER A ESTA PÁGINA</h2>";
        // $spin = spin();
        // $imprimo .= $spin;
        echo'<META HTTP-EQUIV="REFRESH"CONTENT="2;URL=./vistaError.php">';
    }





    ?>
</body>

</html>