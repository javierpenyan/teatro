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

 //introduzco el header y la cabecera dependiendo del tipo de usuario
if(isset($_SESSION['tipo'])){ //si está logueado
    if($_SESSION['tipo'] == 'compañia'){ //y ademas está logueado como actor
        if(isset($_SESSION['id'])){
            $id = $_SESSION['id'];

            echo "<main>";

            echo '<div class="img-header7">
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
            echo insertar_menu_compañias($parametro1, $parametro2);
            $datos = null;


            echo "<h2 class='display-5 fw-bold' style='color: #FD9815; text-align: center; margin-bottom: 40px; margin-top: 80px; '>Información completa de la obra</h2>";
        }



        //borrado del actor de la obra

        if(isset($_GET["id_obra"])){

            $id_obra = $_GET['id_obra'];

            if(isset($_POST['borrar_obra'])){

                $id_obra = $_POST['id_obra'];

                //realizo consultas necesarias

                $consulta = "select casting.id 
                from casting
                where casting.obra = $id_obra
                ";
                $resultado = $conexion->query($consulta);
                $numero_filas = $resultado->num_rows;
                // echo "Se van a borrar $numero_filas castings";
                while ($fila = $resultado->fetch_array(MYSQLI_ASSOC)) {

                    $id_casting = $fila['id'];
                    
                    $sentencia = "delete from participantes_casting 
                    where participantes_casting.casting = ?
                    ";

                    $consulta = $conexion->prepare($sentencia);

                    $consulta->bind_param("i", $id_casting);

                    echo "<h2 class='error'>Participantes de la obra borrado con éxio</h2>";
                    // $spin = spin();
                    // $imprimo .= $spin;


                    $consulta->execute();


                    $consulta->close();

                    $sentencia = "delete from casting 
                    where casting.id = ?
                    ";

                    $consulta = $conexion->prepare($sentencia);

                    $consulta->bind_param("i", $id_casting);

                    echo "<h2 class='error'>Castings de la obra borrados con éxito</h2>";
                    // $spin = spin();
                    // $imprimo .= $spin;

                    $consulta->execute();


                    $consulta->close();

                }

                $consulta = "select ensayo.id 
                from ensayo
                where ensayo.obra = $id_obra
                ";
                $resultado = $conexion->query($consulta);
                $numero_filas = $resultado->num_rows;
                // echo "Se van a borrar $numero_filas ensayos";
                while ($fila2 = $resultado->fetch_array(MYSQLI_ASSOC)) {

                    $id_ensayo = $fila2['id'];
                    
                    $sentencia = "delete from participantes_ensayo 
                    where participantes_ensayo.ensayo = ?
                    ";

                    $consulta = $conexion->prepare($sentencia);

                    $consulta->bind_param("i", $id_ensayo);

                    echo "<h2 class='error'>Participantes del ensayo de la obra borrados con éxito</h2>";
                    // $spin = spin();
                    // $imprimo .= $spin;

                    $consulta->execute();


                    $consulta->close();

                    $sentencia = "delete from ensayo 
                    where ensayo.id = ?
                    ";

                    $consulta = $conexion->prepare($sentencia);

                    $consulta->bind_param("i", $id_ensayo);

                    echo "<h2 class='error'>Ensayos de la obra borrados con éxito</h2>";
                    // $spin = spin();
                    // $imprimo .= $spin;

                    $consulta->execute();


                    $consulta->close();

                }


                $sentencia = "delete from participantes_obra 
                where participantes_obra.obra = ?
                ";

                $consulta = $conexion->prepare($sentencia);

                $consulta->bind_param("i", $id_obra);

                echo "<h2 class='error'>Participantes de la obra borrados con éxito</h2>";
                // $spin = spin();
                // $imprimo .= $spin;

                $consulta->execute();


                $consulta->close();


                $sentencia = "delete from obra 
                where obra.id = ?
                ";

                $consulta = $conexion->prepare($sentencia);

                $consulta->bind_param("i", $id_obra);

                echo "<h2 class='error'>Obra borrada con éxito</h2>";
                // $spin = spin();
                // $imprimo .= $spin;

                $consulta->execute();


                $consulta->close();




            }


            if(isset($_POST["borrar"])){


                $id_actor = $_POST['id_actor'];
                $descripcion = $_POST['descripcion'];
                $compañia = $_SESSION['id'];
                $obra = $_POST['obra'];
                $id_casting = 0;

                $sentencia = "delete from participantes_obra where participantes_obra.actor = ? and participantes_obra.obra = ?
                ";

                $consulta = $conexion->prepare($sentencia);

                $consulta->bind_param("ii", $id_actor, $obra);

                echo "<h2 class='error'>Actor borrado con éxito de la obra</h2>";
                // $spin = spin();
                // $imprimo .= $spin;
  
                $consulta->execute();


                $consulta->close();

                $consulta = "select casting.id 
                from casting 
                where casting.obra = $id_obra
                and casting.descripcion = '$descripcion'
                ";
                $resultado = $conexion->query($consulta);
                $numero_filas = $resultado->num_rows;
                $fila = $resultado->fetch_array(MYSQLI_ASSOC);

                if($fila != null){
                    $dato = $fila['id'];
                }

                

                // echo"<br>id_casting -> $dato, id_actor -> $id_actor<br>";
                $sentencia = "update participantes_casting set participantes_casting.resultado = null
                where participantes_casting.casting = ? and participantes_casting.actor = ?";
                // echo"$nombre,--- $apellidos,--- $alias,--- $tel,--- $pass,--- $id//<br>";

                $consulta = $conexion->prepare($sentencia);

                $consulta->bind_param("ii", $dato, $id_actor);

                $consulta->execute();
                echo "<h2 class='error'>El participante vuelve al estado inicial del casting</h2>";
                // $spin = spin();
                // $imprimo .= $spin;
                          // $consulta->fetch();

                $consulta->close();


                // $sentencia = "select casting.id 
                // from casting 
                // where casting.obra = ?
                // and casting.descripcion = ?";

                // $consulta = $conexion->prepare($sentencia);
        
                // $consulta->bind_result($id_casting);
                // $consulta->bind_param("is", $id_obra, $descripcion);
                // $consulta->execute();

        
                // $consulta->store_result();
                


            }


            // echo"entraaaaaaaa<br>";
            $id_obra=$_GET['id_obra'];



            if(isset($_POST['insertar_actor'])){
                $id_actor = $_POST['actor'];
                $comentario = $_POST['comentario'];
                $papel = $_POST['papel'];

                $sentencia = "insert into participantes_obra
                (obra, actor, papel, comentario)
                values (?, ?, ?, ?) 
                ";

                $consulta = $conexion->prepare($sentencia);

                $consulta->bind_param("iiss", $id_obra, $id_actor, $papel, $comentario);

                echo "<h2 class='error'>Actor insertado con éxito</h2>";
                // $spin = spin();
                // $imprimo .= $spin;
                $consulta->execute();


                $consulta->close();

            }



            $sentencia = "select obra.nombre, obra.Descripcion, obra.fecha, 
            obra.imagen, obra.duracion, compañia.nombre
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
                echo "<h6 class='display-5 fw-bold' style='color: #FD9815; text-align: center; margin-bottom: 40px; margin-top: 80px; '>Nombre de la obra:</h6>
                <h6>$nombre</h6>";
                echo "<h6 class='display-5 fw-bold' style='color: #FD9815; text-align: center; margin-bottom: 40px; margin-top: 80px;'>Fecha en la que se realiza:</h6>
                <h6>$fecha</h6>";
                echo "<h6 class='display-5 fw-bold' style='color: #FD9815; text-align: center; margin-bottom: 40px; margin-top: 80px;'>Breve descripción:</h6>
                <h6>$descripcion</h6>";
                echo "<h6 class='display-5 fw-bold' style='color: #FD9815; text-align: center; margin-bottom: 40px; margin-top: 80px;'>Duración de la obra:</h6>
                <h6>$duracion</h6>";
                echo "<h6 class='display-5 fw-bold' style='color: #FD9815; text-align: center; margin-bottom: 40px; margin-top: 80px;'>Compañía que realiza la obra:</h6>
                <h6>$compañia</h6>";
                
                echo'</div>
            </div>
          </div>
      
        </div>';





            // echo"<ul>";
            //     echo"<li>
            //         <h3>$nombre</h3>
            //         <img src= '..$imagen'>
            //         <h3>$descripcion</h3>
            //         <h3>$fecha</h3>
            //         <h3>$duracion</h3>
            //         <h3>$compañia</h3>
            //     </li>";
            // echo"</ul>";

            echo"                
            <form method='post' action='./editar_obra_completac.php' enctype='multipart/form-data'>
                <input type='submit' value='Modificar Obra' name='modificar' id='modificar'><br><br>
                <input type = 'hidden' name = id_obra value = '$id_obra'>
            </form>";

            echo"                
            <form method='post' action='#' enctype='multipart/form-data'>
                <input type='submit' value='Borrar Obra' name='borrar_obra' id='borrar_obra'><br><br>
                <input type = 'hidden' name = id_obra value = '$id_obra'>
            </form>";

            $consulta->close();


    
            
            $sentencia = "select actores.foto, actores.nombre, actores.apellidos, actores.alias, actores.id, 
            participantes_obra.papel, participantes_obra.comentario, participantes_obra.obra
            from actores, participantes_obra
            where actores.id = participantes_obra.actor
            and participantes_obra.obra = ?
            ";
    
            $consulta = $conexion->prepare($sentencia);
    
            $consulta->bind_result($foto, $nombre_actor, $apellido_actor, 
            $alias_actor, $id_actor, $papel, $comentario, $obra);
            $consulta->bind_param("i", $id_obra);
            $consulta->execute();
    
    
            $consulta->store_result();
    
            echo '
            <div id="fondo" class="bg-image shadow-2-strong" style="margin-top: 50px; height: auto;">
            <div class="mask">
            <div class="album py-5" >
            <!-- <div class="album py-5 bg-dark" > -->
            <div class="container"  >';
            ?>
            <h1 class="display-5 fw-bold" style="color: #FD9815; text-align: center; margin-bottom: 40px; ">Actores</h1>
            <?php
            echo '<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3"  >
            ';
            while ($consulta->fetch()) {
    
                echo '
                <div class="col textoCentrado">
                   <div style=" margin: 30px; margin-top: 40px; border-radius: 20px;" class="card shadow-sm">
                     <!-- <svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"/><text x="43%" y="50%" fill="#eceeef" dy=".3em">FOTOO</text></svg>-->
                     <!-- <img  src="..' . $foto . '" class="card-img-top" alt="foto"> -->
                     <img class="bd-placeholder-img rounded-circle" width="200rem" height="200rem" style="border-style: solid; border-width: 5px; border-color: white; object-fit: cover; margin: 0 auto; margin-top: -30px; box-shadow: 2px 1px 16px #000000;"  src="..' . $foto . '" class="card-img-top" alt="foto">
                     <div class="card-body text-align:center" >
                         <div style="width: 100%;>
                           <p style="text-align:center;class="card-text"><strong>' . $nombre_actor . '</strong></p>
                           <p style="text-align:center;class="card-text"><strong>Papel: ' . $papel . '</strong></p>
                           <p style="text-align:center;class="card-text"><strong>Comentario: ' . $comentario . '</strong></p>

                           ';
                           
                           echo'<div class="d-flex justify-content-between align-items-center">
                             <div style="margin: 0 auto" class="btn-group">';
    
  
                                echo'<form method="post" action="#" enctype="multipart/form-data" class = "control2">
                                    <input type="submit" value="cancelar" name="borrar" id="borrar" class="control2Input"><br><br>
                                    <input type = "hidden" name = id_actor value = "'.$id_actor.'">
                                    <input type = "hidden" name = descripcion value = "'.$papel.'">
                                    <input type = "hidden" name = obra value = "'.$obra.'">
                                </form>';
  
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
            </div>
            ';







                // echo"<li>
                //     <h3> - $nombre_actor $apellido_actor '$alias_actor'</h3> <h4>Papel: $papel Comentario: $comentario</h4>
                //     <form method='post' action='#' enctype='multipart/form-data'>
                //         <input type='submit' value='cancelar participación de actor' name='borrar' id='borrar'><br><br>
                //         <input type = 'hidden' name = id_actor value = '$id_actor'>
                //     </form>
                // </li>";
            // }
            // echo"</ul>";
    
            $consulta->close();
            $cont = 0;

            // echo"COMPROBACION:";

            // $consulta = "select actores.nombre, actores.apellidos, 
            // actores.alias, actores.id
            // from actores
            // ";
            // $resultado = $conexion->query($consulta);
            // $numero_filas = $resultado->num_rows;
            // echo"hay $numero_filas actores";
            // while($fila = $resultado->fetch_array(MYSQLI_ASSOC)){
            //     echo"$fila[nombre]<br>";
            // }
            // echo"---------------------------------";

            echo "<h2 class='display-5 fw-bold' style='color: #FD9815; text-align: center; margin-bottom: 40px; margin-top: 80px; '>Introducir actor en la obra</h2>";

            echo"
            <form method='post' action='#'>
            <select name='actor' id='actor'>";
                $consulta = "select actores.nombre, actores.apellidos, 
                actores.alias, actores.id
                from actores
                ";
                $resultado = $conexion->query($consulta);
                $numero_filas = $resultado->num_rows;
                echo"hay $numero_filas actores";
                while($fila = $resultado->fetch_array(MYSQLI_ASSOC)){
                    if($cont == 0){
                        echo"<option value='".$fila['id']."' selected>".$fila['nombre']." ".$fila['apellido']." '".$fila['alias']."'</option>";
                    }else{
                        echo"<option value='".$fila['id']."'>".$fila['nombre']." ".$fila['apellido']." '".$fila['alias']."'</option>";
                    }
                }

            echo"</select>
            <label for='papel'>Papel</label>
            <input type='text' name='papel' id='papel'>
            <label for='papel'>Comentario</label>
            <input type='text' name='comentario' id='comentario'>
                <input type='submit' value='Insertar Actor' name='insertar_actor' id='insertar'><br><br>
            </form></section></main>
            ";

            echo insertar_footer($parametro1, $parametro2);


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