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

$hoy = fecha_hoy();


$dias_hoy = dias_fecha($hoy);



if(isset($_SESSION['tipo'])){ //si está logueado
    if($_SESSION['tipo'] == 'actor'){ //y ademas está logueado como actor
        if(isset($_SESSION['id'])){
            $id = $_SESSION['id'];

        }

        echo "<main>";

        echo '<div class="img-header9">
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
        echo insertar_menu_actores($parametro1, $parametro2);

        echo "<h2 class='display-5 fw-bold' style='color: #FD9815; text-align: center; margin-bottom: 40px; margin-top: 80px; '>Obras en las que participo:</h2>";


        $sentencia = "select obra.fecha, obra.id, obra.nombre, obra.imagen, participantes_obra.papel, participantes_obra.comentario
        from obra, participantes_obra
        where participantes_obra.obra = obra.id
        and participantes_obra.actor = ?
        ";

        $consulta = $conexion->prepare($sentencia);

        $consulta->bind_result($fecha, $id_obra, $nombre, $imagen, $papel, $comentario);
        $consulta->bind_param("i", $id);
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
                <p class="card-text">'.$papel.'</p>

                
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">'.$fecha.'</li>
            </ul>
            ';

                    echo'<div class="card-body">
                    <a href="./mis_obra_completa.php?id_obra='.$id_obra.'" class="card-link">VER MAS</a>
                </div>
            </div>';


            // echo"<a href='./mis_obra_completa.php?id_obra=".$id_obra."'><li>
            //     <h3>$nombre</h3>
            //     <img src= '..$imagen'>
            //     <h3>$papel</h3>
            //     <h3>$comentario</h3>
            // </li></a>";
    }

    echo"</div></div></section></main>";

    //inserto footer
    echo insertar_footer($parametro1, $parametro2);

    $consulta->close();


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