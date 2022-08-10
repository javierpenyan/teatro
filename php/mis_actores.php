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

    $hoy = fecha_hoy();

    $tipo = $_SESSION['tipo'];

    $conexion = conexion();

        //En caso de que esté guardada la sesión la obtengo

    if (isset($_COOKIE['mantener'])) {
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

        
            $parametro1 = "./";
            $parametro2 = "../";
            echo insertar_menu_compañias($parametro1, $parametro2);
            
            echo'<h2 class="display-5 fw-bold" style="color: #FD9815; text-align: center; margin-bottom: 40px; margin-top:80px">Actores que trabajan para la compañía </h2>';


            $sentencia = "select distinct actores.id, actores.nombre, actores.apellidos,
             actores.alias, actores.foto
            from actores, obra, participantes_obra
            where participantes_obra.actor = actores.id and 
            participantes_obra.obra = obra.id and
            obra.compañia = ?
            ";
    
            $consulta = $conexion->prepare($sentencia);
    
            $consulta->bind_result($id_actor, $nombre, $apellidos, $alias, $foto);
            $consulta->bind_param("i", $id_compañia);
            $consulta->execute();
            
    
            $consulta->store_result();
    
            echo '
            <div id="fondo" class="bg-image shadow-2-strong" style="margin-top: 50px; height: auto;">
            <div class="mask" ">
            <div class="album py-5" >
            <!-- <div class="album py-5 bg-dark" > -->
            <div class="container"  >';
            echo '<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3"  >';
            while($consulta->fetch()){
                echo '
                <div class="col">
                   <div style=" margin: 30px; margin-top: 40px; border-radius: 20px;" class="card shadow-sm">
                     <!-- <svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"/><text x="43%" y="50%" fill="#eceeef" dy=".3em">FOTOO</text></svg>-->
                     <!-- <img  src="..' . $foto . '" class="card-img-top" alt="foto"> -->
                     <img class="bd-placeholder-img rounded-circle" width="200rem" height="200rem" style="border-style: solid; border-width: 5px; border-color: white; object-fit: cover; margin: 0 auto; margin-top: -30px; box-shadow: 2px 1px 16px #000000;"  src="..' . $foto . '" class="card-img-top" alt="foto">
                     <div class="card-body" >
                         <div style="width: 100%;>
                           <p style="text-align:center; color: #B68D00" class="card-text"><strong>' . $nombre . '</strong></p>';
                           echo'<div class="d-flex justify-content-between align-items-center">
                             <div style="margin: 0 auto" class="btn-group">';
                                echo'<a  href="./mis_actores_completa.php?id_actor='.$id_actor.'" class="card-link"><button style="border-radius: 20px; border-color: white; background-color: #D0D0D0; color: grey;" type="button" class="btn btn-sm btn-outline-secondary"><strong>VER MÁS</strong></button></a>';
                             echo'</div>';
                           echo'</div>
                         </div>
                     </div>
                   </div>
                 </div>
             ';
            };
            echo '
            </div><!-- /.row -->
            </div></section></main>
            ';

            //inserto footer

            echo insertar_footer($parametro1, $parametro2);

            //muesto errores de acceso
            
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