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
    //inserto funciones
    require_once('./funciones.php');

    $conexion = conexion();

        //En caso de que esté guardada la sesión la obtengo

    if (isset($_COOKIE['mantener'])) {
        session_decode($_COOKIE['mantener']);
    }


    if (isset($_SESSION['tipo'])) { //si está logueado
        if ($_SESSION['tipo'] == 'actor') { //y ademas está logueado como actor
            if (isset($_SESSION['id'])) {
                $id = $_SESSION['id'];
            }

            echo "<main>";

            echo '<div class="img-header6">
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


            //Comportamiento de CURIOSIDADES

            if (isset($_POST['insertar_curiosidades'])) {

                $curiosidad = $_POST['curiosidad'];

                $sentencia = "update actores set actores.curiosidades = ? where actores.id = ?";

                $consulta = $conexion->prepare($sentencia);

                $consulta->bind_param("si", $curiosidad, $id);

                $consulta->execute();

                $consulta->store_result();

                // $consulta->fetch();

                $consulta->close();
            }

            if (isset($_POST['modificacion_curiosidades'])) {
                $curiosidad = $_POST['curiosidad'];

                $sentencia = "update actores set actores.curiosidades = ? where actores.id = ?";

                $consulta = $conexion->prepare($sentencia);

                $consulta->bind_param("si", $curiosidad, $id);

                $consulta->execute();

                $consulta->store_result();

                // $consulta->fetch();

                $consulta->close();
            }


            //Comportamiento de BIOGRAFÍA

            if (isset($_POST['insertar_biografia'])) {

                echo "ENTRRRRRAAAA<br>";

                $biografia = $_POST['biografia'];

                $sentencia = "update actores set actores.biografia = ? where actores.id = ?";

                $consulta = $conexion->prepare($sentencia);

                $consulta->bind_param("si", $biografia, $id);

                $consulta->execute();

                $consulta->store_result();

                // $consulta->fetch();

                $consulta->close();
            }

            if (isset($_POST['modificacion_biografia'])) {
                echo "entraaa<br>";
                $biografia = $_POST['biografia'];

                $sentencia = "update actores set actores.biografia = ? where actores.id = ?";

                $consulta = $conexion->prepare($sentencia);

                $consulta->bind_param("si", $biografia, $id);

                $consulta->execute();

                $consulta->store_result();

                // $consulta->fetch();

                $consulta->close();
            }




            //Comportamiento de TRABAJOS

            if (isset($_POST['insertar_trabajos'])) {

                echo "ENTRRRRRAAAA<br>";

                $trabajos = $_POST['trabajos'];

                $sentencia = "update actores set actores.trabajos = ? where actores.id = ?";

                $consulta = $conexion->prepare($sentencia);

                $consulta->bind_param("si", $trabajos, $id);

                $consulta->execute();

                $consulta->store_result();

                // $consulta->fetch();

                $consulta->close();
            }

            if (isset($_POST['modificacion_trabajos'])) {
                echo "entraaa<br>";
                $trabajos = $_POST['trabajos'];

                $sentencia = "update actores set actores.trabajos = ? where actores.id = ?";

                $consulta = $conexion->prepare($sentencia);

                $consulta->bind_param("si", $trabajos, $id);

                $consulta->execute();

                $consulta->store_result();

                // $consulta->fetch();

                $consulta->close();
            }





            $sentencia = "select actores.nombre, actores.apellidos, actores.f_nacimiento,
        actores.curiosidades, actores.telefono, actores.correo,
        actores.contraseña, actores.alias, actores.biografia, actores.trabajos,
        actores.foto
        from actores where actores.id = ?";

            $consulta = $conexion->prepare($sentencia);

            $consulta->bind_param("i", $id);
            $consulta->bind_result(
                $nombre,
                $apellidos,
                $nacimiento,
                $curiosidades,
                $tel,
                $corr,
                $pass,
                $alias,
                $biografia,
                $trabajos,
                $foto
            );

            $consulta->execute();

            $consulta->store_result();

            $consulta->fetch();

            $consulta->close();

            echo'<h2 class="display-5 fw-bold" style="color: #FD9815; text-align: center; margin-bottom: 40px; margin-top: 80px; ">Datos Personales del actor</h2>';

            $nacimiento = fecha($nacimiento);

            echo '<section class="testimonies-section">
        <div class="testimonies">
            <div class="img-people"><img src="..' . $foto . '"></div>
            <div class="txt-people">
                <h3>' . $nombre . ' ' . $apellidos . ' "' . $alias . '"</h3>
                <h5>Nacido el ' . $nacimiento . '</h5>
                <h5>Teléfono ' . $tel . '</h5>
                <h5>Correo Electrónico ' . $corr . '</h5>

                <form action="./editar_perfil_actor.php" method="post" enctype="multipart/form-data">
                <input type="submit" name="modificar" value="modificar" >
            </form>';

            echo '</div>';

            // echo"<p>Fotografía</p><img src='..$foto'><br>";
            // echo"<h3>$nombre $apellidos</h3>";
            // echo"<h4>Alias: $alias</h4>";
            // echo"<h4>Fecha de nacimiento: $nacimiento</h4>";
            // echo"<h4>Teléfono: $tel</h4>";
            // echo"<h4>Correo: $corr</h4>
            // ";

            echo '<div class="txt-people">';
            if ($curiosidades != null) {

                if (isset($_POST['modificar_curiosidades'])) {
                    echo '<h2>Modificar Curiosidad:</h2>
                <form action="#" method="post" enctype="multipart/form-data">
                    <label for="w3review">Inserte Curiosidades</label>
                    <textarea id="curiosidad" name="curiosidad" rows="4" cols="50" values = "' . $curiosidades . '">
                    </textarea>
                    <input type="submit" name="modificacion_curiosidades" value="Modificar" id="modificacion_curiosidades">
                </form>';
                } else {
                    echo "<h4>Curiosidades:</h4>";
                    echo"<h5>$curiosidades</h5>";
                    echo ' 
                <form action="#" method="post" enctype="multipart/form-data">
                    <input type="submit" name="modificar_curiosidades" value="Modificar Curiosidades" id="modificar_curiosidades">
                </form>';
                }
            } else {

                echo ' <h2>Insertar curiosidades:</h2>
            <form action="#" method="post" enctype="multipart/form-data">
                <label for="w3review">Inserte Curiosidades</label>
                <textarea id="curiosidad" name="curiosidad" rows="4" cols="50">
                </textarea>
                <input type="submit" name="insertar_curiosidades" value="Insertar" id="insertar_curiosidades">
            </form>';
            }
            echo '</div>';
            echo '<div class="txt-people">';
            if ($biografia != null) {
                if (isset($_POST['modificar_biografia'])) {
                    echo '<h2>Modificar Biografia:</h2>
                <form action="#" method="post" enctype="multipart/form-data">
                    <label for="w3review">Inserte Biografia</label>
                    <textarea id="biografia" name="biografia" rows="4" cols="50" values = "' . $biografia . '">
                    </textarea>
                    <input type="submit" name="modificacion_biografia" value="Modificar" id="modificacion_biografia">
                </form>';
                } else {
                    echo "<h4>Biografía:</h4>";
                    echo"<h5>$biografia</h5>";
                    echo ' 
                <form action="#" method="post" enctype="multipart/form-data">
                    <input type="submit" name="modificar_biografia" value="Modificar Biografia" id="modificar_biografia">
                </form>';
                }
            } else {

                echo ' <h2>Insertar Biografia:</h2>
            <form action="#" method="post" enctype="multipart/form-data">
                <label for="w3review">Inserte Biografia</label>
                <textarea id="biografia" name="biografia" rows="4" cols="50">
                </textarea>
                <input type="submit" name="insertar_biografia" value="Insertar" id="insertar_biografia">
            </form>';
            }
            echo '</div>';
            // if($trabajos != null){
            //     echo"<h4>Trabajos: $Trabajos</h4>";
            // }else{
            //     echo'<button type="button">Insertar Trabajos</button>';
            // }
            echo '<div class="txt-people">';
            if ($trabajos != null) {
                if (isset($_POST['modificar_trabajos'])) {
                    echo '<h2>Modificar Trabajos:</h2>
                <form action="#" method="post" enctype="multipart/form-data">
                    <label for="w3review">Inserte Trabajos</label>
                    <textarea id="trabajos" name="trabajos" rows="4" cols="50" values = "' . $trabajos . '">
                    </textarea>
                    <input type="submit" name="modificacion_trabajos" value="Modificar" id="modificacion_trabajos">
                </form>';
                } else {
                    echo "<h4>Trabajos:</h4>";
                    echo"<h5>$trabajos</h5>";
                    echo ' 
                <form action="#" method="post" enctype="multipart/form-data">
                    <input type="submit" name="modificar_trabajos" value="Modificar Trabajos" id="modificar_trabajos">
                </form>';
                }
            } else {

                echo ' <h2>Insertar Trabajos:</h2>
            <form action="#" method="post" enctype="multipart/form-data">
                <label for="w3review">Inserte Trabajos</label>
                <textarea id="trabajos" name="trabajos" rows="4" cols="50">
                </textarea>
                <input type="submit" name="insertar_trabajos" value="Insertar" id="insertar_trabajos">
            </form>';
            }
            echo '</div>';
            echo "</div></section></div></main>";

            echo insertar_footer($parametro1, $parametro2);
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