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
    <link href="../estilos/style.css" rel="stylesheet"></link>
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

$id = $_SESSION['id'];
echo"$id<br>";

    $sentencia = "select actores.nombre, actores.apellidos, actores.f_nacimiento,
    actores.curiosidades, actores.telefono, actores.correo,
    actores.contraseña, actores.alias, actores.biografia, actores.trabajos,
    actores.foto
    from actores where actores.id = ?";

    $consulta = $conexion->prepare($sentencia);

    $consulta->bind_param("i", $id);
    $consulta->bind_result($nombre, $apellidos, $nacimiento, $curiosidades, $tel, $corr, $pass, $alias,
    $biografia, $trabajos, $foto);

    $consulta->execute();

    $consulta->store_result();

    $consulta->fetch();

    $consulta->close();


echo'
    <h2>Editar datos:</h2>
    <form action="#" method="post" enctype="multipart/form-data">
        <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" value="'.$nombre.'">
        <label for="apellidos">Apellidos</label>
            <input type="text" name="apellidos" id="apellidos" value="'.$apellidos.'">
        <label for="alias">Alias</label>
            <input type="text" name="alias" id="alias" value="'.$alias.'">
        <label for="nac">Fecha de nacimiento</label>
            <input type="date" name="nac" id="nac" value="'.$nacimiento.'">
        <label for="tel">Número de teléfono</label>
            <input type="text" name="tel" id="tel" value="'.$tel.'">
        <label for="correo">Correo Electrónico</label>
            <input type="text" name="correo" id="correo" value="'.$corr.'">
        <label for="pass">contraseña</label>
            <input type="pass" name="pass" id="pass" value="'.$pass.'">
        <label for="foto">Fotografía</label>
            <input type="file" name="foto" id="foto">
        <input type="submit" name="editar" value="editar" value="editar">
    </form>';

if(isset($_POST['editar'])){



        $id = $_SESSION['id'];
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $alias = $_POST['alias'];
        $nac = $_POST['nac'];
        $tel = $_POST['tel'];
        $correo = $_POST['correo'];
        $pass = $_POST['pass'];
        $compruebo="";

        $n = $_FILES['foto']['name'];
        $tipo = $_FILES['foto']['type'];
        $tmp = $_FILES['foto']['tmp_name'];
        $error = $_FILES['foto']['error'];
        $ruta = "../asset/imagenes";
        $var="";
        $reg="/asset/imagenes";
        $error_foto = true;

        echo"$error";

        if($error === 0){

            if(!file_exists($ruta)){
                mkdir($ruta);
            }

            if(strrpos($tipo, "jpeg")!==false || strrpos($tipo, "png")!==false || strrpos($tipo, "jpg")!==false){

                echo"entra1<br>";

                if(strrpos($tipo, "jpeg")!==false || strrpos($tipo, "jpg")!==false){
                    $extension="jpeg";
                    $var=$ruta."/".$nombre."_".$id.".jpg";
                    $reg=$reg."/".$nombre."_".$id.".jpg";

                    echo"$var --- $reg ---<br>";

                    echo"entra2<br>";

                }else{
                    $extension="png";
                    $var=$ruta."/".$nombre."_".$id.".png";
                    $reg=$reg."/".$nombre."_".$id.".png";

                    echo"$var --- $reg ---<br>";

                    echo"entra3<br>";
                }
                echo "var -> $var<br>";
                echo "temp -> $tmp<br>";

                move_uploaded_file($tmp, $var);
                $error_foto = false;
            }

        }

        $compruebo = comprueba_editar_cliente($nombre, $apellidos, $alias, $nac, $tel, $correo, $pass);        


        if($error == 0 && $compruebo ==0){
            // $conexion = conexion();
            $sentencia = "update actores set actores.nombre = ? , actores.apellidos = ?, 
            actores.f_nacimiento = ?,
            actores.telefono = ?, actores.correo = ?, actores.alias = ?, actores.contraseña = ?,
             actores.foto = ?
            where actores.id = ?";

            $consulta = $conexion->prepare($sentencia);
            //comprobar porque creo que en vez de foto es $reg
            $consulta->bind_param("ssssssssi", $nombre, $apellidos, $nac, $tel, $corr, $alias, $pass, $reg, $id);

            $consulta->execute();

            // $consulta->fetch();

            $consulta->close();

            echo"Cambios guardados correctamente con foto <br>";

        }elseif($error !=0 && $compruebo == 0){
            // $conexion = conexion();
            $sentencia = "update actores set actores.nombre = ? , actores.apellidos = ?, 
            actores.f_nacimiento = ?,
            actores.telefono = ?, actores.correo = ?, actores.alias = ?, actores.contraseña = ?
            where actores.id = ?";

            $consulta = $conexion->prepare($sentencia);

            $consulta->bind_param("sssssssi", $nombre, $apellidos, $nac, $tel, $corr, $alias, $pass, $id);

            $consulta->execute();

            $consulta->fetch();

            $consulta->close();

            echo"Cambios guardados correctamente sin foto <br>";

        }else{
            echo"ERROR: $compruebo<br>";
        }
    
    }
?>


</body>
</html>