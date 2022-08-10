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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../asset/imagenes/logo.jpg">
    <title>Actores</title>
</head>

<?php
    require_once('./funciones.php');

    $conexion = conexion();
//En caso de que esté guardada la sesión la obtengo
    if(isset($_COOKIE['mantener'])){
        session_decode($_COOKIE['mantener']);
    }

    //introduzco el header y la cabecera dependiendo del tipo de usuario

    if(isset($_SESSION['tipo'])){
        if($_SESSION['tipo'] == 'compañia'){
            $id = $_SESSION['id'];
        
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

            $parametro1="./";
            $parametro2="../";
            echo insertar_menu_compañias($parametro1, $parametro2);
        
            if(isset($_POST['editar'])){
            
        
                $id = $_SESSION['id'];
                $id_casting = $_POST['id_casting'];
                $descripcion = $_POST['descripcion'];
                $fecha = $_POST['fecha'];
                $fecha_resolucion = $_POST['fecha_resolucion'];
                $ciudad = $_POST['ciudad'];
                $hora=$_POST['hora'];
                $id_obra = $_POST['id_obra'];
        
               
        
                $compruebo = comprueba_casting_editar($descripcion, $fecha, $fecha_resolucion, $hora, $ciudad);
        
                // echo"
                // id_obra -> $id_obra<br>
                // descripcion -> $descripcion<br>
                // fecha -> $fecha<br>
                // fecha de resolucion -> $fecha_resolucion<br>
                // hora -> $hora<br>
                // ciudad->$ciudad<br>
                // id_casting->$id_casting<br>
                // ";

                //realizo las consultas necesarias
        
                if($compruebo == 0){
                    // $conexion = conexion();
                    $sentencia = "update casting set casting.obra = ?, casting.descripcion = ?, casting.fecha = ?, casting.fecha_resolucion = ?,
                     casting.hora = ?,
                    casting.ciudad = ? where casting.id = ?";
        
                    $consulta = $conexion->prepare($sentencia);
        
                    $consulta->bind_param("isssssi", $id_obra, $descripcion, $fecha, $fecha_resolucion, $hora, $ciudad, $id_casting);
        
                    $consulta->execute();
        
                    // $consulta->fetch();
        
                    $consulta->close();

                    echo "<h2 class='error'>Cambios guardados correctamente</h2>";

                    echo'<META HTTP-EQUIV="REFRESH"CONTENT="2;URL=./mis_castingc.php">';

            
                }else{
                    echo "<h2 class='error'>Error ".$compruebo."</h2>";

                    // echo"$compruebo";
                }
        
            }
        
        
            if(isset($_POST['modificar'])){
        
                $id_casting = $_POST['id_casting'];
        
                $sentencia = "select casting.fecha, casting.hora,
                casting.fecha_resolucion, casting.descripcion,
                casting.ciudad, casting.obra
                from casting
                where casting.id = ?
                ";
            
                $consulta = $conexion->prepare($sentencia);
            
                $consulta->bind_param("i", $id_casting);
                $consulta->bind_result($fecha, $hora,
                $fecha_resolucion, $descripcion, $ciudad, $id_obra);
            
                $consulta->execute();
            
                $consulta->store_result();
            
                $consulta->fetch();
            
                $consulta->close();
            
            echo'<h2 class="display-5 fw-bold" style="color: #FD9815; text-align: center; margin-bottom: 40px; margin-top:50px; ">Editar datos del casting</h2>';

            echo'
                <form action="#" method="post" enctype="multipart/form-data">';
                
            echo"

                <select name='id_obra' id='id_obra'>";
                        $consulta = "select obra.nombre, obra.id id_obra
                        from obra
                        where obra.compañia = $id
                        ";
                        $resultado = $conexion->query($consulta);
                        $numero_filas = $resultado->num_rows;
                        // echo"hay $numero_filas actores";
                        while($fila = $resultado->fetch_array(MYSQLI_ASSOC)){
                            if($fila['id_obra'] == $id_obra){
                                echo"<option value='".$fila['id_obra']."'>".$fila['nombre']." '</option>";
                            }else{
                                echo"<option value='".$fila['id_obra']."'>".$fila['nombre']."'</option>";
                            }
                        }
        
                    echo'</select>
                    <label for="nombre">Fecha</label>
                        <input type="date" name="fecha" id="fecha" value="'.$fecha.'">
                    <label for="descripcion">Hora</label>
                        <input type="time" name="hora" id="hora" value="'.$hora.'">
                    <label for="fecha">Fecha de Resolución</label>
                        <input type="date" name="fecha_resolucion" id="fecha_resolucion" value="'.$fecha_resolucion.'">
                    <label for="duracion">Descripción</label>
                        <input type="text" name="descripcion" id="descripcion" value="'.$descripcion.'">
                    <label for="ciudad">Ciudad</label>
                        <input type="text" name="ciudad" id="ciudad" value="'.$ciudad.'">
                        <input type="hidden" name="id_casting" id="id_casting" value="'.$id_casting.'">
                    <input type="submit" name="editar" value="editar">
                </form></section></main>';

                //inserto el footer
                echo insertar_footer($parametro1, $parametro2);
        
            }
            //muesto errores acceso
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