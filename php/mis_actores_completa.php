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

    if(isset($_COOKIE['mantener'])){
        session_decode($_COOKIE['mantener']);
    }


 //introduzco el header y la cabecera dependiendo del tipo de usuario

    if(isset($_SESSION['tipo'])){

        if($_SESSION['tipo'] == 'compañia'){
            $id_compañia = $_SESSION['id'];
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
           echo insertar_menu_compañias($parametro1, $parametro2);

            if($_GET['id_actor']){

                $id_actor = $_GET['id_actor'];


                $sentencia = "select actores.f_nacimiento, actores.telefono, actores.correo, actores.id, actores.nombre, actores.apellidos, actores.alias, actores.foto
                from actores
                where actores.id = ?
                ";
        
                $consulta = $conexion->prepare($sentencia);
        
                $consulta->bind_result($nacimiento, $telefono, $correo, $id_actor,
                $nombre, $apellidos, $alias, $foto);
                $consulta->bind_param("i", $id_actor);
                $consulta->execute();
        
        
                $consulta->store_result();
        
                echo"<div class='container-xl'>
                <div class='row gy-0 my-5' id='centrar' >";

                $consulta->fetch();
                $nacimiento = fecha($nacimiento);
                echo'<section class="testimonies-section">
                <div class="testimonies">
                    <div class="img-people"><img src="..'.$foto.'"></div>
                    <div class="txt-people">
                        <h3>'.$nombre.' '.$apellidos.' "'.$alias.'"</h3>
                        <h5>Nacido el '.$nacimiento.'</h5>
                        <h5>Teléfono '.$telefono.'</h5>
                        <h5>Correo Electrónico '.$correo.'</h5>';
                echo'</div></div>';

                    
                echo "</div><h2 class='display-5 fw-bold' style='color: #FD9815; text-align: center; margin-bottom: 40px; margin-top: 80px; '>Participa en las siguientes obras de la compañía:</h2>";


                $sentencia = "select distinct obra.nombre, obra.id, obra.imagen,
                obra.fecha
                from obra, participantes_obra, compañia
                where obra.compañia = compañia.id and
                 participantes_obra.obra = obra.id and
                participantes_obra.actor = ? and
                compañia.id = ?
                ";
        
                $consulta = $conexion->prepare($sentencia);
        
                $consulta->bind_result($nombre_obra, $id_obra, $imagen, $fecha);
                $consulta->bind_param("ii", $id_actor, $id_compañia);
                $consulta->execute();
        
        
                $consulta->store_result();
        
                echo"<div class='container-xl'>
                <div class='row gy-0 my-5' id='centrar' >";
                while($consulta->fetch()){

                    $fecha = fecha($fecha);
                    echo'<div class="target card my-5 mx-5" style="width: 18rem;">
                    <img src="..'.$imagen.'" class="card-img-top" alt="foto">
                    <div class="card-body">
                        <h5 class="card-title">OBRA:</h5>
                        <p class="card-text">'.$nombre_obra.'</p>
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
                echo"</div>
                </div>
            </div></section></main>";

            //inserto footer

                echo insertar_footer($parametro1, $parametro2);


                //     echo"<a href='./mis_obra_completa_c.php?id_obra=".$id_obra."'>";
                //     echo'<div class="card my-5 mx-5" style="width: 18rem;">
                //         <img src="..'.$imagen.'" class="card-img-top" alt="foto">
                //         <div class="card-body">
                //             <h5 class="card-title">OBRA:</h5>
                //             <p class="card-text">'.$nombre.'</p>
                //             <p class="card-text">'.$fecha.'</p>
                //         </div>';
        
        
                //     echo"</a>";
                    
                    
                // }
                // echo"</div></div>";


    
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