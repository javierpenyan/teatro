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
    <script src="./js/app_modalMap.js" defer></script>
    <title>Document</title>
</head>
<body>

<?php

require_once('./funciones.php');

$conexion = conexion();

if(isset($_COOKIE['mantener'])){
    session_decode($_COOKIE['mantener']);
}

if(isset($_SESSION['tipo'])){ //si está logueado
    if($_SESSION['tipo'] == 'actor'){ //y ademas está logueado como actor

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
        echo insertar_menu_actores($parametro1, $parametro2);

        if(isset($_POST['modificar_datos'])){



            $nombre = $_POST['nombre'];
            $apellidos = $_POST['apellidos'];
            $alias = $_POST['alias'];
            $nac = $_POST['nacimiento'];
            $tel = $_POST['tel'];
            $pass = $_POST['pass'];

            // echo"$nombre,--- $apellidos,--- $alias,--- $tel,--- $pass,--- $id//<br>";


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

            $compruebo = comprueba_editar_cliente2($nombre, $apellidos, $alias, $nac, $tel, $pass);       

            if($error == 0 && $compruebo ==0){

                if($pass == null){
                    $pass = md5(md5($pass));
                    $sentencia = "update actores set actores.nombre =?, actores.apellidos =?,
                    actores.alias =?, actores.f_nacimiento =?, actores.telefono =?, actores.foto=?
                    where actores.id =?";
                    // echo"$nombre,--- $apellidos,--- $alias,--- $tel,--- $pass,--- $id//<br>";
    
                    $consulta = $conexion->prepare($sentencia);
    
                    $consulta->bind_param("sssssssi", $nombre, $apellidos, $alias, $nac, $tel, $reg, $id);
    
                    $consulta->execute();
    
                    // $consulta->fetch();
    
                    $consulta->close();
    
                        
                    echo "<h2 class='error'>CAMBIOS GUARDADOS CORRECTAMENTE</h2>";
                    // $spin = spin();
                    // $imprimo .= $spin;
                    echo'<META HTTP-EQUIV="REFRESH"CONTENT="2;URL=./perfil_usuario.php">';
    
                    // echo"Cambios guardados correctamente con foto <br>";
                }else{
                    $pass = md5(md5($pass));
                    $sentencia = "update actores set actores.nombre =?, actores.apellidos =?,
                actores.alias =?, actores.f_nacimiento =?, actores.telefono =?,
                actores.contraseña =?, actores.foto=?
                where actores.id =?";
                // echo"$nombre,--- $apellidos,--- $alias,--- $tel,--- $pass,--- $id//<br>";

                $consulta = $conexion->prepare($sentencia);

                $consulta->bind_param("sssssssi", $nombre, $apellidos, $alias, $nac, $tel, $pass, $reg, $id);

                $consulta->execute();

                // $consulta->fetch();

                $consulta->close();

                    
                echo "<h2 class='error'>CAMBIOS GUARDADOS CORRECTAMENTE</h2>";
                // $spin = spin();
                // $imprimo .= $spin;
                echo'<META HTTP-EQUIV="REFRESH"CONTENT="2;URL=./perfil_usuario.php">';

                // echo"Cambios guardados correctamente con foto <br>";
                }

                // $conexion = conexion();
                

            }elseif($error !=0 && $compruebo == 0){
                // $conexion = conexion();

                if($pass == null){
                    $pass = md5(md5($pass));
                    $sentencia = "update actores set actores.nombre =?, actores.apellidos =?,
                    actores.alias =?, actores.f_nacimiento =?, actores.telefono =?
                    where actores.id =?";
                    // echo"$nombre,--- $apellidos,--- $alias,--- $tel,--- $pass,--- $id//<br>";
    
                    $consulta = $conexion->prepare($sentencia);
    
                    $consulta->bind_param("sssssi", $nombre, $apellidos, $alias, $nac, $tel, $id);
    
                    $consulta->execute();
    
                    // $consulta->fetch();
    
                    $consulta->close();
    
                    echo "<h2 class='error'>CAMBIOS GUARDADOS CORRECTAMENTE</h2>";
                    // $spin = spin();
                    // echo $spin;
                    echo'<META HTTP-EQUIV="REFRESH"CONTENT="2;URL=./perfil_usuario.php">';
                    // echo"Cambios guardados correctamente sin foto <br>";
                }else{
                    $pass = md5(md5($pass));
                    $sentencia = "update actores set actores.nombre =?, actores.apellidos =?,
                    actores.alias =?, actores.f_nacimiento =?, actores.telefono =?,
                    actores.contraseña =?
                    where actores.id =?";
                    // echo"$nombre,--- $apellidos,--- $alias,--- $tel,--- $pass,--- $id//<br>";
    
                    $consulta = $conexion->prepare($sentencia);
    
                    $consulta->bind_param("ssssssi", $nombre, $apellidos, $alias, $nac, $tel, $pass, $id);
    
                    $consulta->execute();
    
                    // $consulta->fetch();
    
                    $consulta->close();
    
                    echo "<h2 class='error'>CAMBIOS GUARDADOS CORRECTAMENTE</h2>";
                    // $spin = spin();
                    // echo $spin;
                    echo'<META HTTP-EQUIV="REFRESH"CONTENT="2;URL=./perfil_usuario.php">';
                    // echo"Cambios guardados correctamente sin foto <br>";
                }

                

            }else{
                echo "<h2 class='error'>ERROR $compruebo</h2>";
                // echo toastError($compruebo);
                // $spin = spin();
                // echo $spin;
                echo'<META HTTP-EQUIV="REFRESH"CONTENT="2;URL=./perfil_usuario.php">';
                // echo"ERROR: $compruebo<br>";
            }

        }


        if(isset($_POST['modificar'])){

            $sentencia = "select actores.nombre, actores.apellidos, actores.alias,
            actores.f_nacimiento, actores.telefono, actores.contraseña,
            actores.foto
            from actores
            where actores.id = ?";

        $consulta = $conexion->prepare($sentencia);

        $consulta->bind_param("i", $id);
        $consulta->bind_result($nombre, $apellidos, $alias, $nacimiento,
        $telefono, $contraseña, $foto);

            $consulta->execute();

            $consulta->store_result();

            $consulta->fetch();

            $consulta->close();

            echo'<h2 class="display-5 fw-bold" style="color: #FD9815; text-align: center; margin-bottom: 40px; margin-top: 80px">Editar Datos Personales del Actor</h2>';


        echo'<section class="testimonies-section">
            <div class="testimonies">
                <div class="img-people"><img src="..'.$foto.'"></div>
                <div class="txt-people">';
                echo'<h5 class="display-5 fw-bold" style="color: #FD9815; text-align: center; margin-bottom: 40px; font-family: "Lemonada", cursive;">Datos personales del actor</h5>';

                echo'
                <form action="#" method="post" enctype="multipart/form-data">
                    <label for="nombre">Nombre</label>
                        <input type="text" name="nombre" id="nombre" value = "'.$nombre.'">
                    <label for="apellidos">Apellidos</label>
                        <input type="text" name="apellidos" id="apellidos" value = "'.$apellidos.'">
                    <label for="alias">Alias</label>
                        <input type="text" name="alias" id="alias" value = "'.$alias.'">
                    <label for="nacimiento">Fecha de nacimiento</label>
                        <input type="date" name="nacimiento" id="nacimiento" value = "'.$nacimiento.'">
                    <label for="tel">Número de teléfono</label>
                        <input type="text" name="tel" id="tel" value = "'.$telefono.'">
                    <label for="pass">contraseña</label>
                        <input type="password" name="pass" id="pass">
                    <label for="foto">Fotografía</label>
                        <input type="file" name="foto" id="foto" value = "'.$foto.'">
                    <input type="submit" name="modificar_datos" value="modificar datos">
                </form>
                </div>';


                echo '</div>';
                echo "</div></section></div></main>";
    
                echo insertar_footer($parametro1, $parametro2);



        }

    
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