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

if(isset($_SESSION['tipo'])){ //si está logueado
    if($_SESSION['tipo'] == 'compañia'){ //y ademas está logueado como actor

        if(isset($_SESSION['id'])){

            $id = $_SESSION['id'];
            // echo"entraaa -> $id<br>";
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


        $parametro1="./";
        $parametro2="../";
        echo insertar_menu_compañias($parametro1, $parametro2);






        //Comportamiento de CURIOSIDADES

        if(isset($_POST['insertar_curiosidades'])){

            $curiosidad = $_POST['curiosidad'];

            $sentencia = "update compañia set compañia.curiosidades = ? where compañia.id = ?";

            $consulta = $conexion->prepare($sentencia);

            $consulta->bind_param("si", $curiosidad, $id);
            
            $consulta->execute();

            $consulta->store_result();

            // $consulta->fetch();

            $consulta->close();
        }

        if(isset($_POST['modificacion_curiosidades'])){
            $curiosidad = $_POST['curiosidad'];

            $sentencia = "update compañia set compañia.curiosidades = ? where compañia.id = ?";

            $consulta = $conexion->prepare($sentencia);

            $consulta->bind_param("si", $curiosidad, $id);
            
            $consulta->execute();

            $consulta->store_result();

            // $consulta->fetch();

            $consulta->close();
        }


         //Comportamiento de BIOGRAFÍA

         if(isset($_POST['insertar_trayectoria'])){

            // echo"ENTRRRRRAAAA<br>";

            $trayectoria = $_POST['trayectoria'];

            $sentencia = "update compañia set compañia.trayectoria = ? where compañia.id = ?";

            $consulta = $conexion->prepare($sentencia);

            $consulta->bind_param("si", $trayectoria, $id);
            
            $consulta->execute();

            $consulta->store_result();

            // $consulta->fetch();

            $consulta->close();
        }

        if(isset($_POST['modificacion_trayectoria'])){
            $trayectoria = $_POST['trayectoria'];

            $sentencia = "update compañia set compañia.trayectoria = ? where compañia.id = ?";

            $consulta = $conexion->prepare($sentencia);

            $consulta->bind_param("si", $trayectoria, $id);
            
            $consulta->execute();

            $consulta->store_result();

            // $consulta->fetch();

            $consulta->close();
        }

        


        $sentencia = "select compañia.nombre, compañia.contraseña, 
            compañia.creacion, compañia.telefono, compañia.correo,
            compañia.contraseña, compañia.direccion,compañia.foto,
             compañia.curiosidades,
            compañia.trayectoria
        from compañia where compañia.id = ?";

        $consulta = $conexion->prepare($sentencia);

        $consulta->bind_param("i", $id);
        $consulta->bind_result($nombre, $pass, $creacion,  
        $tel, $corr, $pass, $direccion,
         $foto, $curiosidades, $trayectoria);

            $consulta->execute();

            $consulta->store_result();

            $consulta->fetch();

            $consulta->close();

            echo'<h2 class="display-5 fw-bold" style="color: #FD9815; text-align: center; margin-bottom: 40px; margin-top:50px;">Datos de mí compañía</h2>';
        $creacion = fecha($creacion);

                echo'<section class="testimonies-section">
            <div class="testimonies">
                <div class="img-people"><img src="..'.$foto.'"></div>
                <div class="txt-people">
                    <h3>'.$nombre.'</h3>
                    <h5>Creada en '.$creacion.'</h5>
                    <h5>Teléfono '.$tel.'</h5>
                    <h5>Correo Electrónico '.$corr.'</h5>
                    <h5>Dirección '.$direccion.'</h5>

                    <form action="./editar_perfil_compañia.php" method="post" enctype="multipart/form-data">
                    <input type="submit" name="modificar" value="modificar" >
                </form>';

                echo'</div>';

                echo'<div class="txt-people">';
                if($curiosidades != null){

                    if(isset($_POST['modificar_curiosidades'])){
                        echo'<h2>Modificar Curiosidad:</h2>
                        <form action="#" method="post" enctype="multipart/form-data">
                            <label for="w3review">Inserte Curiosidades</label>
                            <textarea id="curiosidad" name="curiosidad" rows="4" cols="50" values = "'.$curiosidades.'">
                            </textarea>
                            <input type="submit" name="modificacion_curiosidades" value="Modificar" id="modificacion_curiosidades">
                        </form>';
                    }else{
                        echo "<h4>Curiosidades:</h4>";
                        echo"<h5>$curiosidades</h5>";
                        echo' 
                        <form action="#" method="post" enctype="multipart/form-data">
                            <input type="submit" name="modificar_curiosidades" value="Modificar Curiosidades" id="modificar_curiosidades">
                        </form>';
                    }
        
                }else{
        
                   echo' <h2>Insertar curiosidades:</h2>
                    <form action="#" method="post" enctype="multipart/form-data">
                        <label for="w3review">Inserte Curiosidades</label>
                        <textarea id="curiosidad" name="curiosidad" rows="4" cols="50">
                        </textarea>
                        <input type="submit" name="insertar_curiosidades" value="Insertar" id="insertar_curiosidades">
                    </form>';
                }
                echo'</div>';

                echo'<div class="txt-people">';

                if($trayectoria != null){
                    if(isset($_POST['modificar_trayectoria'])){
                        echo' <h2>Modificar Trayectoria:</h2>
                        <form action="#" method="post" enctype="multipart/form-data">
                            <label for="w3review">Inserte Trayectoria</label>
                            <textarea id="trayectoria" name="trayectoria" rows="4" cols="50" values = "'.$trayectoria.'">
                            </textarea>
                            <input type="submit" name="modificacion_trayectoria" value="Modificar" id="modificacion_trayectoria">
                        </form>';
                    }else{
                        echo "<h4>Trayectoria:</h4>";
                        echo"<h5>$trayectoria</h5>";
                        echo'
                        <form action="#" method="post" enctype="multipart/form-data">
                            <input type="submit" name="modificar_trayectoria" value="Modificar Trayectoria" id="modificar_trayectoria">
                        </form>';
                    }
        
                }else{
        
                   echo' <h2>Insertar Trayectoria:</h2>
                    <form action="#" method="post" enctype="multipart/form-data">
                        <label for="w3review">Inserte Trayectoria</label>
                        <textarea id="trayectoria" name="trayectoria" rows="4" cols="50">
                        </textarea>
                        <input type="submit" name="insertar_trayectoria" value="Insertar" id="insertar_trayectoria">
                    </form>';
                }

                echo'</div>';

            echo'</div>
        </section></main>';

        //inserto footer
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

</body>
</html>