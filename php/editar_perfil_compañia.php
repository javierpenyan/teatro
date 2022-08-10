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
//llamo a las funciones
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

        if(isset($_POST['modificar_datos'])){


            $nombre = $_POST['nombre'];
            $pass = $_POST['pass'];
            $creacion = $_POST['creacion'];
            $tel = $_POST['tel'];
            $direccion = $_POST['direccion'];



            $n = $_FILES['foto']['name'];
            $tipo = $_FILES['foto']['type'];
            $tmp = $_FILES['foto']['tmp_name'];
            $error = $_FILES['foto']['error'];
            $ruta = "../asset/imagenes";
            $var="";
            $reg="/asset/imagenes";
            $error_foto = true;


            if($error === 0){

                if(!file_exists($ruta)){
                    mkdir($ruta);
                }

                if(strrpos($tipo, "jpeg")!==false || strrpos($tipo, "png")!==false || strrpos($tipo, "jpg")!==false){


                    if(strrpos($tipo, "jpeg")!==false || strrpos($tipo, "jpg")!==false){
                        $extension="jpeg";
                        $var=$ruta."/".$nombre."_".$id.".jpg";
                        $reg=$reg."/".$nombre."_".$id.".jpg";



                    }else{
                        $extension="png";
                        $var=$ruta."/".$nombre."_".$id.".png";
                        $reg=$reg."/".$nombre."_".$id.".png";


                    }


                    move_uploaded_file($tmp, $var);
                    $error_foto = false;
                }

            }

            $compruebo = compruebo_editar_compañia($nombre, $direccion, $creacion, $tel, $pass);       



            //realizo las consultas correspondientes para cada caso

            if($error == 0 && $compruebo ==0){

                if($pass == null){
                    $pass = md5(md5($pass));
                    $sentencia = "update compañia set compañia.nombre = ?, compañia.direccion = ?,
                    compañia.creacion = ?, compañia.telefono =?
                    compañia.foto = ?
                    where compañia.id = ?";
    
                    $consulta = $conexion->prepare($sentencia);
    
                    $consulta->bind_param("ssssssi", $nombre, $direccion, $creacion, $tel, $reg, $id);
    
                    $consulta->execute();
    
                    // $consulta->fetch();
    
                    $consulta->close();
    
                    echo "<h2 class='error'>Cambios guardados correctamente</h2>";
                    // $spin = spin();
                    // $imprimo .= $spin;
                    echo'<META HTTP-EQUIV="REFRESH"CONTENT="2;URL=././perfil_compañia.php">';
                }else{
                    $pass = md5(md5($pass));
                    $sentencia = "update compañia set compañia.nombre = ?, compañia.direccion = ?,
                    compañia.creacion = ?, compañia.telefono =?, compañia.contraseña = ?,
                    compañia.foto = ?
                    where compañia.id = ?";
    
                    $consulta = $conexion->prepare($sentencia);
    
                    $consulta->bind_param("ssssssi", $nombre, $direccion, $creacion, $tel, $pass, $reg, $id);
    
                    $consulta->execute();
    
                    // $consulta->fetch();
    
                    $consulta->close();
    
                    echo "<h2 class='error'>Cambios guardados correctamente</h2>";
                    // $spin = spin();
                    // $imprimo .= $spin;
                    echo'<META HTTP-EQUIV="REFRESH"CONTENT="2;URL=././perfil_compañia.php">';                }

                // $conexion = conexion();


            }elseif($error !=0 && $compruebo == 0){

                if($pass == null){
                    $pass = md5(md5($pass));
                // $conexion = conexion();
                $sentencia = "update compañia set compañia.nombre = ?, compañia.direccion = ?,
                compañia.creacion = ?, compañia.telefono =?
                where compañia.id = ?";
           

                $consulta = $conexion->prepare($sentencia);

                $consulta->bind_param("ssssi", $nombre, $direccion, $creacion, $tel, $id);

                $consulta->execute();

                // $consulta->fetch();

                $consulta->close();

                echo "<h2 class='error'>Cambios guardados correctamente</h2>";
                // $spin = spin();
                // $imprimo .= $spin;
                echo'<META HTTP-EQUIV="REFRESH"CONTENT="2;URL=././perfil_compañia.php">';
                }else{
                    $pass = md5(md5($pass));
                                    // $conexion = conexion();
                $sentencia = "update compañia set compañia.nombre = ?, compañia.direccion = ?,
                compañia.creacion = ?, compañia.telefono =?, compañia.contraseña = ?
                where compañia.id = ?";

                $consulta = $conexion->prepare($sentencia);

                $consulta->bind_param("sssssi", $nombre, $direccion, $creacion, $tel, $pass, $id);

                $consulta->execute();

                // $consulta->fetch();

                $consulta->close();

                echo "<h2 class='error'>Cambios guardados correctamente</h2>";
                // $spin = spin();
                // $imprimo .= $spin;
                echo'<META HTTP-EQUIV="REFRESH"CONTENT="2;URL=./perfil_compañia.php">';
                }



            }else{
                echo "<h2 class='error'>Erro ".$compruebo."</h2>";
                // $spin = spin();
                // $imprimo .= $spin;
                echo'<META HTTP-EQUIV="REFRESH"CONTENT="2;URL=./perfil_compañia.php">';
            }

        }


        if(isset($_POST['modificar'])){

            $sentencia = "select compañia.nombre, compañia.contraseña, 
            compañia.creacion, compañia.telefono, compañia.correo,
             compañia.direccion,compañia.foto,
             compañia.curiosidades,
            compañia.trayectoria
        from compañia where compañia.id = ?";

        $consulta = $conexion->prepare($sentencia);

        $consulta->bind_param("i", $id);
        $consulta->bind_result($nombre, $pass, $creacion,  
        $tel, $corr, $direccion,
         $foto, $curiosidades, $trayectoria);

            $consulta->execute();

            $consulta->store_result();

            $consulta->fetch();

            $consulta->close();

            echo'<h2 class="display-5 fw-bold" style="color: #FD9815; text-align: center; margin-bottom: 40px; margin-top:50px; ">Editar datos de mí compañía</h2>';


        echo'<section class="testimonies-section">
            <div class="testimonies">
                <div class="img-people"><img src="..'.$foto.'"></div>
                <div class="txt-people">';
                echo'<h2>Regístrese como Compañía:</h2>
                <form action="#" method="post" enctype="multipart/form-data">
                    <label for="nombre">Nombre</label>
                        <input type="text" name="nombre" id="nombre" value = "'.$nombre.'">
                    <label for="direccion">Dirección</label>
                        <input type="text" name="direccion" id="direccion" value = "'.$direccion.'">
                    <label for="creacion">Fecha de creación</label>
                        <input type="date" name="creacion" id="creacion" value = "'.$creacion.'">
                    <label for="tel">Número de teléfono</label>
                        <input type="text" name="tel" id="tel" value = "'.$tel.'">
                    <label for="pass">contraseña</label>
                        <input type="password" name="pass" id="pass" >
                    <label for="foto">Fotografía</label>
                        <input type="file" name="foto" id="foto" value = "'.$foto.'">
                    <input type="submit" name="modificar_datos" value="modificar datos">
                </form>
                </div>';


            echo'</div>
        </section></section></section>';

        //introduzco footer
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