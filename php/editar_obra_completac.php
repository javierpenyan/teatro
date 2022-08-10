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
    <link href="https://fonts.googleapis.com/css2?family=Lemonada:wght@700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../asset/imagenes/logo.jpg">
    <title>Actores</title>
</head>

<?php

//En caso de que esté guardada la sesión la obtengo

if(isset($_COOKIE['mantener'])){
    session_decode($_COOKIE['mantener']);
}


require_once('./funciones.php');

$conexion = conexion();


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



            echo'<h2 class="display-5 fw-bold" style="color: #FD9815; text-align: center; margin-bottom: 40px; margin-top:50px; font-family: "Lemonada", cursive;">Editar datos de obra</h2>';



    $id = $_SESSION['id'];
    // echo"$id<br>";




    if(isset($_POST['editar'])){
    
        // echo"entra<br>";

        $id = $_SESSION['id'];
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $fecha = $_POST['fecha'];
        $duracion = $_POST['duracion'];
        $compruebo="";
        $id_obra = $_POST['id_obra'];

        $n = $_FILES['foto']['name'];
        $tipo = $_FILES['foto']['type'];
        $tmp = $_FILES['foto']['tmp_name'];
        $error = $_FILES['foto']['error'];
        $ruta = "../asset/imagenes";
        $var="";
        $reg="/asset/imagenes";
        $error_foto = true;

        // echo"$error";

        if($error === 0){

            if(!file_exists($ruta)){
                mkdir($ruta);
            }

            if(strrpos($tipo, "jpeg")!==false || strrpos($tipo, "png")!==false || strrpos($tipo, "jpg")!==false){

                // echo"entra1<br>";

                if(strrpos($tipo, "jpeg")!==false || strrpos($tipo, "jpg")!==false){
                    $extension="jpeg";
                    $var=$ruta."/".$nombre."_".$id.".jpg";
                    $reg=$reg."/".$nombre."_".$id.".jpg";

                    // echo"$var --- $reg ---<br>";

                    // echo"entra2<br>";

                }else{
                    $extension="png";
                    $var=$ruta."/".$nombre."_".$id.".png";
                    $reg=$reg."/".$nombre."_".$id.".png";

                    // echo"$var --- $reg ---<br>";

                    // echo"entra3<br>";
                }
                // echo "var -> $var<br>";
                // echo "temp -> $tmp<br>";

                move_uploaded_file($tmp, $var);
                $error_foto = false;
            }

        }

        $compruebo = comprueba_editar_obra_completac($nombre, $descripcion, $fecha, $duracion);        

        // echo"nombre - > $nombre <br>
        // descripcion -> $descripcion<br>
        // fecha -> $fecha<br>
        // duracion -> $duracion<br>
        // id_obra -> $id_obra<br>
        // ";

        if($error == 0 && $compruebo ==0){
            // $conexion = conexion();
            $sentencia = "update obra set obra.nombre = ?, obra.Descripcion = ?,
            obra.fecha = ?, obra.duracion = ?, obra.imagen = ?
            where obra.id = ?";

            $consulta = $conexion->prepare($sentencia);

            $consulta->bind_param("sssisi", $nombre, $descripcion, $fecha, $duracion, $reg, $id_obra);

            $consulta->execute();

            // $consulta->fetch();

            $consulta->close();

            echo "<h2 class='error'>Cambios realizados correctamente</h2>";
            // $spin = spin();
            // $imprimo .= $spin;
            echo'<META HTTP-EQUIV="REFRESH"CONTENT="2;URL=./mis_obrasc.php">';

        }elseif($error !=0 && $compruebo == 0){
            // $conexion = conexion();
            $sentencia = "update obra set obra.nombre = ?, obra.Descripcion = ?,
            obra.fecha = ?, obra.duracion = ?
            where obra.id = ?";

            $consulta = $conexion->prepare($sentencia);

            $consulta->bind_param("sssii", $nombre, $descripcion, $fecha, $duracion, $id_obra);

            $consulta->execute();

            // $consulta->fetch();

            $consulta->close();

            echo "<h2 class='error'>Cambios realizados correctamente</h2>";
            // $spin = spin();
            // $imprimo .= $spin;
            echo'<META HTTP-EQUIV="REFRESH"CONTENT="2;URL=./mis_obrasc.php">';
        }else{
            echo "<h2 class='error'>Error ".$compruebo."</h2>";
            // $spin = spin();
            // $imprimo .= $spin;
            echo'<META HTTP-EQUIV="REFRESH"CONTENT="2;URL=./mis_obrasc.php">';
        }
    
    }





    if(isset($_POST['modificar'])){

        $id_obra = $_POST['id_obra'];

        $sentencia = "select obra.nombre, obra.descripcion, obra.fecha, 
        obra.imagen, obra.duracion
        from obra
        where obra.id = ?
        ";
    
        $consulta = $conexion->prepare($sentencia);
    
        $consulta->bind_param("i", $id_obra);
        $consulta->bind_result($nombre, $descripcion, $fecha, $imagen, $duracion);
    
        $consulta->execute();
    
        $consulta->store_result();
    
        $consulta->fetch();
    
        $consulta->close();
    
    
    echo'

        <form action="#" method="post" enctype="multipart/form-data">
            <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" value="'.$nombre.'">
            <label for="descripcion">Descripcion</label>
                <input type="text" name="descripcion" id="descripcion" value="'.$descripcion.'">
            <label for="fecha">Fecha</label>
                <input type="date" name="fecha" id="fecha" value="'.$fecha.'">
            <label for="duracion">Duracion (minutos)</label>
                <input type="number" name="duracion" id="duracion" value="'.$duracion.'">
            <label for="foto">Fotografía</label>
                <input type="file" name="foto" id="foto">
                <input type="hidden" name="id_obra" value="'.$id_obra.'">
            <input type="submit" name="editar" value="editar">
        </form></main></section>';

        //insertar footer
        echo insertar_footer($parametro1, $parametro2);

    }

}
//muestro errores
    }else{
        echo "<h2 class='error'>NECESITA REGISTRARSE PARA ACCEDER A ESTA PÁGINA</h2>";
        // $spin = spin();
        // $imprimo .= $spin;
        echo'<META HTTP-EQUIV="REFRESH"CONTENT="2;URL=./vistaError.php">';    }
}else{
    echo "<h2 class='error'>NECESITA REGISTRARSE PARA ACCEDER A ESTA PÁGINA</h2>";
    // $spin = spin();
    // $imprimo .= $spin;
    echo'<META HTTP-EQUIV="REFRESH"CONTENT="2;URL=./vistaError.php">';
}


?>


</body>
</html>