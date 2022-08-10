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
    <script src="../js/app_mostrar_toast.js" defer></script>
    <link rel="stylesheet" href="../estilos/estilo.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../asset/imagenes/logo.jpg">
    <title>Actores Completo</title>
</head>
<body>

<?php
setlocale(LC_ALL, "es-ES.UTF-8");
//En caso de que esté guardada la sesión la obtengo
if (isset($_COOKIE['mantener'])) {
    session_decode($_COOKIE['mantener']);
}


// llamo a funciones
   
require_once('./funciones.php');
    if(isset($_SESSION['tipo'])){

        // echo $_SESSION['tipo']."<br>";

        if(isset($_GET['a_id'])){
            // echo $_GET['a_id']."entra2<br>";

            $a_id = $_GET['a_id'];
            
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


        echo "</div><h2 class='display-5 fw-bold' style='color: #FD9815; text-align: center; margin-bottom: 40px; margin-top: 80px;'>Perfil completo del actor:</h2>";

            $conexion = conexion();

            if($_SESSION['tipo'] == 'compañia'){

                $parametro1="./";
                $parametro2="../";
                echo insertar_menu_compañias($parametro1, $parametro2);
    
            }elseif($_SESSION['tipo'] == 'actor'){
    
                $parametro1="./";
                $parametro2="../";
                echo insertar_menu_actores($parametro1, $parametro2);
    
            }

            //realizo las consultas requeridas

            $sentencia = $conexion->prepare("select actores.nombre, actores.apellidos, 
            actores.alias, actores.foto, actores.correo, actores.telefono, actores.f_nacimiento, 
            actores.curiosidades, actores.biografia, actores.trabajos
            from actores
            where actores.id = ?");

        
            $sentencia->bind_result($a_nombre, $a_apellidos, $a_alias, $a_foto, $a_correo, $a_telefono, $a_nacimiento,
            $a_curiosidades, $a_biografia, $a_trabajos);
            $sentencia->bind_param("i", $a_id);
            $sentencia->execute();
            $sentencia->store_result();
        
            $numero = $sentencia->num_rows();
        
            if($numero>0){
        
        
                echo"<div class='container-xl'>
                <div class='row gy-0 my-5' id='centrar' >";
                $sentencia->fetch();

                $a_nacimiento = fecha($a_nacimiento);
                echo'<section class="testimonies-section">
                
                <div class="testimonies">
                    <div class="img-people"><img src="..'.$a_foto.'"></div>
                    <div class="txt-people">
                        <h3>'.$a_nombre.' '.$a_apellidos.' "'.$a_alias.'"</h3>
                        <h5>Nacido el '.$a_nacimiento.'</h5>
                        <h5>Teléfono '.$a_telefono.'</h5>
                        <h5>Correo Electrónico '.$a_correo.'</h5>';

                            echo'<form method="post" id="" action="./video_actor_concreto.php" enctype="multipart/form-data">
                                    <input type = "submit" name = "videos_completos" value = "Ver videos de actor">
                                    <input type = "hidden" name = "actor" value = "'.$a_id.'">
                                    </form>
                                    <form method="post" id="" action="fotos_actor_enlace.php?id='.$a_id.'" enctype="multipart/form-data">
                                    <input type = "submit" name = "fotos_completas" value = "Ver fotos de actor">
                                    <input type = "hidden" name = "actor" value = "'.$a_id.'">
                                    </form>
                                    <form method="post" id="" action="./actuaciones_completas_actor.php" enctype="multipart/form-data">
                                    <input type = "submit" name = "actuaciones" value = "Ver actuaciones de actor">
                                    <input type = "hidden" name = "actor" value = "'.$a_id.'">
                           </form>';


                    echo'</div>';

                    if($a_curiosidades != null){
                        echo'<div class="txt-people">
                        <h4>Curiosidades: '.$a_curiosidades.'</h4>
                        </div>
                        ';
                    }

                    if($a_biografia != null){
                        echo'<div class="txt-people">
                        <h4>Biografía: '.$a_biografia.'</h4>
                        </div>
                        ';
                    }

                    if($a_trabajos != null){
                        echo'<div class="txt-people">
                        <h4>Trabajos: '.$a_trabajos.'</h4>
                        </div>
                        ';
                    }
        
                }
                echo"</div>
                </div>
            </div></main></section>";

            echo insertar_footer($parametro1, $parametro2);

        }

    //muestro los errores de acceso        

    }else{
        echo "<h2 class='error'>NECESITA REGISTRARSE PARA ACCEDER A ESTA PÁGINA</h2>";
        // $spin = spin();
        // $imprimo .= $spin;
        echo'<META HTTP-EQUIV="REFRESH"CONTENT="2;URL=./vistaError.php">';
    }



?>