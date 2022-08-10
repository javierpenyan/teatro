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

//introduzco el header y la cabecera dependiendo del tipo de usuario
if(isset($_SESSION['tipo'])){
    if($_SESSION['tipo'] == 'actor'){

        if(isset($_SESSION['id'])){

            $id_actor = $_SESSION['id'];
            // echo"entraaa -> $id<br>";
        }

        //borrar
        if(isset($_POST['borrar'])){
            $id_foto = $_POST['id_foto'];

            $sentencia = "delete from fotos_actor where fotos_actor.id = ?";
            
            $consulta = $conexion->prepare($sentencia);

            $consulta->bind_param("i", $id_foto);//-------------------------------------------------------------

            $consulta->execute();
        
            // $consulta->fetch();

            $consulta->close();
            // Header("refresh:1;url=../index.php");
            echo"<h2 class = 'error'>Fotografía borrada correctamente</h2>"; 

        }

        ///////////AÑADIR

        if(isset($_POST['añadir'])){

            //obtener el siguiente id:
    
            $sentencia = "SELECT `AUTO_INCREMENT` FROM  INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'teatro' AND   TABLE_NAME = 'fotos_actor';";
            
            $consulta=$conexion->query($sentencia);
            $fila=$consulta->fetch_array(MYSQLI_ASSOC);
    
    
    
            $siguiente_id = $fila['AUTO_INCREMENT'];

    
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
                    $var=$ruta."/foto_".$siguiente_id.".jpg";
                    $reg=$reg."/foto_".$siguiente_id.".jpg";
    
                    // echo"$var --- $reg ---<br>";
    
                    // echo"entra2<br>";
    
                }else{
                    $extension="png";
                    $var=$ruta."/foto_".$siguiente_id.".png";
                    $reg=$reg."/foto_".$siguiente_id.".png";
    
                    // echo"$var --- $reg ---<br>";
    
                    // echo"entra3<br>";
                }
                // echo "var -> $var<br>";
                // echo "temp -> $tmp<br>";
    
                move_uploaded_file($tmp, $var);
                $error_foto = false;
            }
    
    
    
            if(!$error_foto){
                //aqui subo cliente
                //introduzca mensaje de registrado correctamente logueese a continuación
                //nos lleve a la página de logueo
                // echo"entra<br>";
    
                $sentencia = "insert into fotos_actor (id, actor, url) values (?, ?, ?)";
            
                $consulta = $conexion->prepare($sentencia);
    
                $consulta->bind_param("iis", $siguiente_id, $id_actor, $reg);//-------------------------------------------------------------
    
                $consulta->execute();
            
                // $consulta->fetch();
    
                $consulta->close();
                // Header("refresh:1;url=../index.php");
                // echo"<h2 class = 'error'>guardado correctamente</h2>"; 
            }else{
                // echo"<h2 class = 'error'>LA FOTOGRAFÍA NO CUMPLE CON EL FORMATO REQUERIDO</h2>";
            }
        }

        ///////////FIN AÑADIR


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
        echo insertar_menu_actores($parametro1, $parametro2);


        echo "<h2 class='display-5 fw-bold' style='color: #FD9815; text-align: center; margin-bottom: 40px; margin-top: 80px;'>Mis fotografías:</h2>";

        echo"<div class='fotocontenedor'>";

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
                   
                        echo'<a href="./foto_completa.php?foto='.$id_foto.'&url='.$url.'" class ="enlaceFoto"><img src="..'.$url.'" class="fotoActor" alt="foto"> </a>
                        
                        <form action="#" method="post" enctype="multipart/form-data">
                        <input class = "boton_borrar" type="submit" name="borrar" value="Borrar" id="borrar">
                        <input type = "hidden" name = "id_foto" value = "'.$id_foto.'">
                    </form>

                        ';
                    echo"</div>";
                }

            echo"
        </div>";

        echo "<h2 class='display-5 fw-bold' style='color: #FD9815; text-align: center; margin-bottom: 40px; margin-top: 80px; '>Introduzca fotografía:</h2>";


        echo'
        <form action="#" method="post" enctype="multipart/form-data"
            <label for="foto">Fotografía</label>
                <input type="file" name="foto" id="foto">
            <input type="submit" name="añadir" value="Añadir Foto" value="añadir">
        </form></div>
        </section></main>';
                //inserto footer
        echo insertar_footer($parametro1, $parametro2);

        //muestro errores de acceso
    }else{
        echo "<h2 class='error'>NECESITA REGISTRARSE PARA ACCEDER A ESTA PÁGINA</h2>";
        $spin = spin();
        // $imprimo .= $spin;
        echo'<META HTTP-EQUIV="REFRESH"CONTENT="2;URL=./vistaError.php">';
    }
}else{
    echo "<h2 class='error'>NECESITA REGISTRARSE PARA ACCEDER A ESTA PÁGINA</h2>";
    $spin = spin();
    // $imprimo .= $spin;
    echo'<META HTTP-EQUIV="REFRESH"CONTENT="2;URL=./vistaError.php">';
}





?>

</body>
</html>