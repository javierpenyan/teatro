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

    if(isset($_SESSION['tipo'])){

        // echo $_SESSION['tipo']."<br>";

        if(isset($_GET['c_id'])){
            // echo $_GET['a_id']."entra2<br>";

            $c_id = $_GET['c_id'];


             //introduzco el header y la cabecera dependiendo del tipo de usuario
            echo "<main>";

            echo '<div class="img-header5">
            <div class="welcome">
              <h1>Bienvenidos TodoTeatro</h1>
              <hr>
              <p>Especializada en gestión de eventos de teatro</p>
              <p>entre actores y compañías</p>
            </div>       
            </div>
                ';
            
            echo "<section>";


   
            require_once('./funciones.php');

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

            //realizo las consultas necesarias

        $sentencia = "select compañia.nombre, 
        compañia.creacion, compañia.telefono, compañia.correo,
        compañia.direccion,compañia.foto,
        compañia.curiosidades,
        compañia.trayectoria
        from compañia 
        where compañia.id = ?";


        $consulta = $conexion->prepare($sentencia);

        $consulta->bind_param("i", $c_id);
        $consulta->bind_result($c_nombre, $c_creacion,  
        $tel, $corr, $c_direccion,
        $foto, $curiosidades, $trayectoria);

        $consulta->execute();

        $numero = $consulta->num_rows();

    
        // if($numero>0){
        
        
                echo"<div class='container-xl'>
                <div class='row gy-0 my-5' id='centrar' >";
        $consulta->fetch();

            $c_creacion = fecha($c_creacion);
        echo "<h2 class='display-5 fw-bold' style='color: #FD9815; text-align: center; margin-bottom: 40px; margin-top: 80px; font-family: 'Lemonada', cursive;'>Datos de la compañía:</h2>";


                        echo'<section class="testimonies-section">
                        <div class="testimonies">
                        <div class="img-people"><img src="..'.$foto.'"></div>
                        <div class="txt-people">
                            <h3>'.$c_nombre.'</h3>
                            <h5>Creada en '.$c_creacion.'</h5>
                            <h5>Teléfono '.$tel.'</h5>
                            <h5>Correo Electrónico '.$corr.'</h5>
                            <h5>Dirección '.$c_direccion.'</h5>';

                            echo'
                                    <form method="post" id="" action="actuaciones_completas_compañia.php" enctype="multipart/form-data">
                                    <input type = "submit" name = "actuaciones" value = "Ver actuaciones de compañia">
                                    <input type = "hidden" name = "compañia" value = "'.$c_id.'">
                           </form>';


                    echo'</div>';

                    if($curiosidades != null){
                        echo'<div class="txt-people">
                        <h4>Curiosidades: '.$curiosidades.'</h4>
                        </div>
                        ';
                    }

                    if($trayectoria != null){
                        echo'<div class="txt-people">
                        <h4>Curiosidades: '.$trayectoria.'</h4>
                        </div>
                        ';
                    }
        
                // }
                echo"</div>
                </div>
            </div></section></main>";

            //inserto el footer
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