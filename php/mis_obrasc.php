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

require_once('./funciones.php');

$conexion = conexion();

if(isset($_COOKIE['mantener'])){
    session_decode($_COOKIE['mantener']);
}

$hoy = fecha_hoy();




$dias_hoy = dias_fecha($hoy);

if(isset($_SESSION['tipo'])){ //si está logueado
    if($_SESSION['tipo'] == 'compañia'){ //y ademas está logueado como actor

        if(isset($_SESSION['id'])){

            $id = $_SESSION['id'];
            // echo"entraaa -> $id<br>";
        }

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

        

        if(isset($_POST['insertar'])){

            $sentencia = "SELECT `AUTO_INCREMENT` FROM  INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'teatro' AND   TABLE_NAME = 'obra';";
            

            $consulta=$conexion->query($sentencia);
            $fila=$consulta->fetch_array(MYSQLI_ASSOC);

            $siguiente_id = $fila['AUTO_INCREMENT'];
            $id_compañia = $_SESSION['id'];
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $fecha = $_POST['fecha'];
            $duracion = $_POST['duracion'];

            $n = $_FILES['foto']['name'];
            $tipo = $_FILES['foto']['type'];
            $tmp = $_FILES['foto']['tmp_name'];
            $ruta = "../asset/imagenes";
            $var="";
            $reg="/asset/imagenes";
            $error_foto = true;

            if(!file_exists($ruta)){
                mkdir($ruta);
            }
    
            if(strrpos($tipo, "jpeg")!==false || strrpos($tipo, "png")!==false || strrpos($tipo, "jpg")!==false){
    
                // echo"entra1<br>";
    
                if(strrpos($tipo, "jpeg")!==false || strrpos($tipo, "jpg")!==false){
                    $extension="jpeg";
                    $var=$ruta."/".$nombre."_".$siguiente_id.".jpg";
                    $reg=$reg."/".$nombre."_".$siguiente_id.".jpg";
    
                    // echo"$var --- $reg ---<br>";
    
                    // echo"entra2<br>";
    
                }else{
                    $extension="png";
                    $var=$ruta."/".$nombre."_".$siguiente_id.".png";
                    $reg=$reg."/".$nombre."_".$siguiente_id.".png";
    
                    // echo"$var --- $reg ---<br>";
    
                    // echo"entra3<br>";
                }
                // echo "var -> $var<br>";
                // echo "temp -> $tmp<br>";
    
                move_uploaded_file($tmp, $var);
                $error_foto = false;
            }

            $compruebo = comprueba_obras($nombre, $descripcion, $duracion, $fecha);

        // echo"$compruebo<br>";

        if(!$error_foto && $compruebo == 0){
            //aqui subo cliente
            //introduzca mensaje de registrado correctamente logueese a continuación
            //nos lleve a la página de logueo
            // echo"entra<br>";

            $sentencia = "insert into obra (id, nombre, Descripcion, fecha, imagen, duracion, compañia) values (?, ?, ?, ?, ?, ?, ?)";
        
            $consulta = $conexion->prepare($sentencia);

            $consulta->bind_param("isssssi", $siguiente_id, $nombre, $descripcion, $fecha, $reg, $duracion, $id_compañia);//-------------------------------------------------------------

            $consulta->execute();
        
            // $consulta->fetch();

            $consulta->close();
            // Header("refresh:1;url=../index.php");


        }else{
            // echo"$compruebo";
            //recargue la página
        }

    }

        



    echo "<h2 class='display-5 fw-bold' style='color: #FD9815; text-align: center; margin-bottom: 40px; margin-top: 80px; '>Actuaciones futuras de la compañía:</h2>";


        $sentencia = "select obra.id, obra.nombre, obra.imagen,obra.fecha
        from obra
        where
        obra.compañia = ? and
        obra.fecha >= ? order by obra.fecha desc
        ";

        $consulta = $conexion->prepare($sentencia);

        $consulta->bind_result( $id_obra, $nombre, $imagen, $fecha);
        $consulta->bind_param("is", $id, $hoy);
        $consulta->execute();


        $consulta->store_result();

        echo"<div class='container-xl'>
        <div class='row gy-0 my-5' id='centrar' >";
        while($consulta->fetch()){

            $fecha = fecha($fecha);
            echo'<div class="card my-5 target mx-5" style="width: 18rem;">
            <img src="..'.$imagen.'" class="card-img-top" alt="foto">
            <div class="card-body">
                <h5 class="card-title">OBRA:</h5>
                <p class="card-text">'.$nombre.'</p>

                
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">'.$fecha.'</li>
            </ul>
            ';

                    echo'<div class="card-body">
                    <a href="./mis_obra_completa_c.php?id_obra='.$id_obra.'" class="card-link">VER MAS</a>
                </div>
            </div>';


            // echo"<a href='./mis_obra_completa_c.php?id_obra=".$id_obra."'>";
            // echo'<div class="card my-5 mx-5" style="width: 18rem;">
            //     <img src="..'.$imagen.'" class="card-img-top" alt="foto">
            //     <div class="card-body">
            //         <h5 class="card-title">OBRA:</h5>
            //         <p class="card-text">'.$nombre.'</p>
            //         <p class="card-text">'.$fecha.'</p>
            //     </div>';


            // echo"</a>";
    }

        echo"</div></div>";

    $consulta->close();


    echo "<h2 class='display-5 fw-bold' style='color: #FD9815; text-align: center; margin-bottom: 40px; margin-top: 80px; '>Actuaciones que ha realizado la compañía:</h2>";

        $sentencia = "select obra.id, obra.nombre, obra.imagen,obra.fecha
        from obra
        where
        obra.compañia = ? and
        obra.fecha < ? order by obra.fecha desc
        ";


        $consulta = $conexion->prepare($sentencia);

        $consulta->bind_result( $id_obra, $nombre, $imagen, $fecha);
        $consulta->bind_param("is",$id, $hoy);
        $consulta->execute();


        $consulta->store_result();
        echo"<div class='container-xl'>
        <div class='row gy-0 my-5' id='centrar' >";
        while($consulta->fetch()){
            $fecha = fecha($fecha);
            echo'<div class="card my-5 target mx-5" style="width: 18rem;">
            <img src="..'.$imagen.'" class="card-img-top" alt="foto">
            <div class="card-body">
                <h5 class="card-title">OBRA:</h5>
                <p class="card-text">'.$nombre.'</p>

                
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">'.$fecha.'</li>
            </ul>
            ';

                    echo'<div class="card-body">
                    <a href="./mis_obra_completa_c.php?id_obra='.$id_obra.'" class="card-link">VER MAS</a>
                </div>
            </div>';
    }

        echo"</div></div>";

    $consulta->close();

    echo "<h2 class='display-5 fw-bold' style='color: #FD9815; text-align: center; margin-bottom: 40px; margin-top: 80px; '>Insertar actuación:</h2>";

    echo'
    <form action="#" method="post" enctype="multipart/form-data">
        <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre">
        <label for="descripcion">Descripcion</label>
            <input type="text" name="descripcion" id="descripcion">
        <label for="fecha">fecha</label>
            <input type="date" name="fecha" id="fecha">
        <label for="duracion">duracion (minutos)</label>
            <input type="number" name="duracion" id="duracion">';
            
        echo'<label for="foto">Fotografía</label>
            <input type="file" name="foto" id="foto">
        <input type="submit" name="insertar" value="Insertar" id="insertar">
    </form></section></main>';

    echo insertar_footer($parametro1, $parametro2);


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