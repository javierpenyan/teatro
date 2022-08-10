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

//En caso de que esté guardada la sesión la obtengo

if (isset($_COOKIE['mantener'])) {
    session_decode($_COOKIE['mantener']);
}

//llamo a las funciones

require_once('./funciones.php');
$conexion = conexion();
    if(isset($_SESSION['tipo'])){

        if(isset($_POST['fotos_completas'])){

            $id_actor = $_POST['actor'];

            if($_SESSION['tipo'] == 'compañia'){

                $parametro1="./";
                $parametro2="../";

                echo insertar_menu_compañias($parametro1, $parametro2);
    
            }elseif($_SESSION['tipo'] == 'actor'){

                $parametro1="./";
                $parametro2="../";
                echo insertar_menu_actores($parametro1, $parametro2);
    
            }

        //introduzco el header y la cabecera dependiendo del tipo de usuario

            echo "<main>";

            echo '<div class="img-header2">
            <div class="welcome">
              <h1>Bienvenidos TodoTeatro</h1>
              <hr>
              <p>Especializada en gestión de eventos de teatro</p>
              <p>entre actores y compañías</p>
            </div>       
           </div>
                ';
        
            echo "<section>";

            echo "<h2 class='display-5 fw-bold' style='color: #FD9815; text-align: center; margin-bottom: 40px; margin-top: 80px; '>Fotografias del actor:</h2>";

            echo"<div class='fotocontenedor'>";
            //realizo las consultas
                    $sentencia = "select fotos_actor.url, fotos_actor.id
                    from fotos_actor
                    where fotos_actor.actor = ?";
            
                    $consulta = $conexion->prepare($sentencia);
            
                    $consulta->bind_result($url, $id_foto);
                    $consulta->bind_param("i", $id_actor);
                    $consulta->execute();
            
            
                    $consulta->store_result();
    
                    while($consulta->fetch()){
    
                        echo"<div class = 'fotoContenedor2'>";
                       
                            echo'<a href="./foto_completa.php?foto='.$id_foto.'&url='.$url.'" class ="enlaceFoto"><img src="..'.$url.'" class="fotoActor" alt="foto"> </a>';
                        echo"</div>";
                    }
    
                echo"
            </div>";
    

            $conexion = conexion();

            //introduzco footer
            echo insertar_footer($parametro1, $parametro2);

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