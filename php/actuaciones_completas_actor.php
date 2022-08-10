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
    setlocale(LC_ALL, "es-ES.UTF-8");
//En caso de que esté guardada la sesión la obtengo
    if (isset($_COOKIE['mantener'])) {
        session_decode($_COOKIE['mantener']);
    }

 //introduzco el header y la cabecera dependiendo del tipo de usuario

    if(isset($_SESSION['tipo'])){

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
    // llamo a funciones
        require_once('./funciones.php');
    
        $hoy = fecha_hoy();
    
        $hoy_cal = date("Y-m-d");
    
        $conexion = conexion();
    
    
        if (isset($_SESSION['tipo'])) {
    
            if ($_SESSION['tipo'] == 'compañia') {
    
                $parametro1 = "./";
                $parametro2 = "../";
                echo insertar_menu_compañias($parametro1, $parametro2);
            } elseif ($_SESSION['tipo'] == 'actor') {
    
                $parametro1 = "./";
                $parametro2 = "../";
                echo insertar_menu_actores($parametro1, $parametro2);
            }
        } else {
    
            $parametro1 = "./";
            $parametro2 = "../";
            echo insertar_menu($parametro1, $parametro2);
        }
    
    
        if (isset($_POST['actuaciones'])) {
    
            $actor = $_POST['actor'];
    
            $hoy = fecha_hoy();
            // echo"$hoy<br>";
    
            $dias_hoy = dias_fecha($hoy);
    
            echo '<h5 class="display-5 fw-bold" style="color: #FD9815; text-align: center; margin-bottom: 40px; margin-top: 80px;">Actuaciones del actor:</h5>';

            // echo"actor ---> $actor";

                    //realizo la consulta necesaria

            $sentencia = "select obra.nombre, obra.imagen, 
                obra.fecha
                from obra,  actores, participantes_obra
                where 
                participantes_obra.obra = obra.id
                and participantes_obra.actor = actores.id
                and actores.id = ?
                order by obra.fecha
                ";
    
            $consulta = $conexion->prepare($sentencia);
    
            $consulta->bind_param("i", $actor);
    
            $consulta->bind_result($obra, $foto, $fecha);
    
            $consulta->execute();
    
    
            $consulta->store_result();
    
            echo "<div class='container-xl'>
                <div class='row gy-0 my-5' id='centrar' >";
    
            while ($consulta->fetch()) {
    
                $dias_obra = dias_fecha($fecha);
    
                $resta_dias = $dias_obra - $dias_hoy; //marca de tiempo en segundos del timepo que falta hasta que empiece la obra
                // echo"$resta_dias<br>";
                $fecha = fecha($fecha);
                echo '<div class="card my-5 mx-5 target" style="width: 18rem;">
                        <img src="..' . $foto . '" class="card-img-top" alt="foto">
                        <div class="card-body">
                            <h5 class="card-title">OBRA:</h5>
                            <p class="card-text">' . $obra . '</p>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">' . $fecha . '</li>
                        </ul></div>
                        ';
            }
    
            echo "
                    </div>
                </div>";
    
            $consulta->close();
        }
    
        
        echo"</main></section>";
    
        //introduzco el footer
        echo insertar_footer($parametro1, $parametro2);

        //muestro los errores de acceso
    }else{
        echo "<h2 class='error'>NECESITA REGISTRARSE PARA ACCEDER A ESTA PÁGINA</h2>";
        // $spin = spin();
        // $imprimo .= $spin;
        echo'<META HTTP-EQUIV="REFRESH"CONTENT="2;URL=./vistaError.php">';
    }




  
    ?>

</body>

</html>