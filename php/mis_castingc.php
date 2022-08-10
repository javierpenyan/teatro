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

//introduzco main y header
echo "<main>";

echo '<div class="img-header8">
<div class="welcome">
  <h1>Bienvenidos TodoTeatro</h1>
  <hr>
  <p>Especializada en gestión de eventos de teatro</p>
  <p>entre actores y compañías</p>
</div>       
</div>
    ';

echo "<section>";

//llamo a las funciones
require_once('./funciones.php');

$conexion = conexion();

//si tengo habilitado mantener la sesión recupero los datos
if(isset($_COOKIE['mantener'])){
    session_decode($_COOKIE['mantener']);
}

$hoy = fecha_hoy();

// echo"$hoy<br>";


$dias_hoy = dias_fecha($hoy);




if(isset($_SESSION['tipo'])){ //si está logueado
    if($_SESSION['tipo'] == 'compañia'){ //y ademas está logueado como actor
        if(isset($_SESSION['id'])){
            $id = $_SESSION['id'];
            // echo"$id<br>";
        }

        //realizo las consultas necesarias

        $parametro1="./";
        $parametro2="../";
        echo insertar_menu_compañias($parametro1, $parametro2);

        if(isset($_POST['insertar'])){

            $sentencia = "SELECT `AUTO_INCREMENT` FROM  INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'teatro' AND   TABLE_NAME = 'obra';";
        
            $consulta=$conexion->query($sentencia);
            $fila=$consulta->fetch_array(MYSQLI_ASSOC);

            $siguiente_id = $fila['AUTO_INCREMENT'];
            $id_compañia = $_SESSION['id'];
            $obra = $_POST['obra'];
            $descripcion = $_POST['descripcion'];
            $fecha = $_POST['fecha'];
            $fecha_resolucion = $_POST['fecha_resolucion'];
            $hora = $_POST['hora'];
            $ciudad = $_POST['ciudad'];

           

            $compruebo = comprueba_casting($obra, $descripcion, $fecha, $fecha_resolucion, $hora, $ciudad);

        // echo"$compruebo<br>";

        if($compruebo == 0){
            //aqui subo cliente
            //introduzca mensaje de registrado correctamente logueese a continuación
            //nos lleve a la página de logueo
            // echo"entra<br>";

            $sentencia = "insert into casting (fecha, hora, fecha_resolucion, descripcion, obra, ciudad) values (?, ?, ?, ?, ?, ?)";
        
            $consulta = $conexion->prepare($sentencia);

            $consulta->bind_param("ssssis", $fecha, $hora, $fecha_resolucion, $descripcion, $obra, $ciudad);//-------------------------------------------------------------

            $consulta->execute();
        
            // $consulta->fetch();

            $consulta->close();
            // Header("refresh:1;url=../index.php");
            // echo"guardado correctamente<br>"; 
            echo "<h2 class='error'>Casting guardado correctamente</h2>";
            // $spin = spin();
            // $imprimo .= $spin;
            

        }else{
            // echo"$compruebo";
            echo "<h2 class='error'>Error ".$compruebo."</h2>";
            // $spin = spin();
            // $imprimo .= $spin;
            // echo'<META HTTP-EQUIV="REFRESH"CONTENT="2;URL=./mis_castingc.php">';        
        }

    }

        



    echo "<h2 class='display-5 fw-bold' style='color: #FD9815; text-align: center; margin-bottom: 40px; margin-top: 80px; font-family: 'Lemonada', cursive;'>Castings futuros de la compañía</h2>";

        $sentencia = "select casting.id, obra.id, obra.nombre, casting.fecha, 
        casting.hora, casting.fecha_resolucion, 
        casting.descripcion, casting.ciudad, obra.imagen, compañia.nombre
        from casting, obra, compañia
        where casting.obra = obra.id and
        obra.compañia = ?
        and casting.fecha > ?
        and compañia.id = obra.compañia
        order by casting.fecha asc
        ";

  

        $consulta = $conexion->prepare($sentencia);

        $consulta->bind_result($id_casting, $id_obra, $nombre_obra, $fecha,
        $hora, $resolucion, $descripcion, $ciudad, $imagen, $c_nombre);
        $consulta->bind_param("is", $id, $hoy);
        // echo"----$id<br>";
        $consulta->execute();


        $consulta->store_result();
        // echo "<h2>$fecha</h2>";


        echo"<div class='container-xl'>";
        echo"<div class='row gy-0 my-5' id='centrar' >";
        while($consulta->fetch()){
            $fecha_mostrar3 = fecha($fecha);

            echo'<div class="card my-5 mx-5 target" style="width: 18rem;">
            <img src="..'.$imagen.'" class="card-img-top" alt="foto">
            <div class="card-body">
                <h5 class="card-title">OBRA:</h5>
                <p class="card-text">'.$nombre_obra.'</p>
                <p class="card-text">'.$descripcion.'</p>
                
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">'.$ciudad.'</li>
                <li class="list-group-item">'.$fecha_mostrar3.'</li>
            </ul>
            ';

                    echo'<div class="card-body">
                    <a href="./mis_casting_completa_c.php?id_casting='.$id_casting.'" class="card-link">VER MAS</a>
                </div>
            </div>';
            
        }


    echo"</div>
    </div>
</div>";


    $consulta->close();


    echo "<h2 class='display-5 fw-bold' style='color: #FD9815; text-align: center; margin-bottom: 40px; margin-top: 80px; font-family: 'Lemonada', cursive;'>Insertar casting:</h2>";

    echo'
    <form action="#" method="post" enctype="multipart/form-data">
    <select name="obra" id="obra">';
    $consulta = "select obra.nombre, obra.id id_obra
    from obra
    where obra.compañia = $id";
    // echo"$id----entra<br>";
    
    $resultado = $conexion->query($consulta);
    $numero_filas = $resultado->num_rows;
    // echo"hay $numero_filas actores";
    while($fila = $resultado->fetch_array(MYSQLI_ASSOC)){
        if($cont == 0){
            echo"<option value='".$fila['id_obra']."' selected>".$fila['nombre']."'</option>";
        }else{
            echo"<option value='".$fila['id_obra']."'>".$fila['nombre']."</option>";
        }
    }
    echo'
    </select>
        <label for="fecha">Fecha</label>
            <input type="date" name="fecha" id="fecha">
        <label for="hora">Hora</label>
            <input type="time" name="hora" id="hora">
        <label for="fecha_resolucion">Fecha de resolución</label>
            <input type="date" name="fecha_resolucion" id="fecha_resolucion">
        <label for="descripcion">Descripción</label>
            <input type="text" name="descripcion" id="descripcion">
        <label for="ciudad">Ciudad</label>
            <input type="text" name="ciudad" id="ciudad">
        <input type="submit" name="insertar" value="Insertar" id="insertar">
        </form></section></main>';

        //inserto footer
    echo insertar_footer($parametro1, $parametro2);

    //muestro mensajes de error

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