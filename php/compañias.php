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

if(isset($_COOKIE['mantener'])){
    session_decode($_COOKIE['mantener']);
}

echo "<main>";

//introduzco el header y la cabecera dependiendo del tipo de usuario
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

if(isset($_SESSION['tipo'])){

    if($_SESSION['tipo'] == 'compañia'){

        $parametro1="./";
        $parametro2="../";
        echo insertar_menu_compañias($parametro1, $parametro2);

    }elseif($_SESSION['tipo'] == 'actor'){

        $parametro1="./";
        $parametro2="../";
        echo insertar_menu_actores($parametro1, $parametro2);

    }

    }else{

        $parametro1="./";
        $parametro2="../";
        echo insertar_menu($parametro1, $parametro2);

    }


        

        $conexion = conexion();
        $compruebo_imagen=false;

        $principio_paginacion = 0;
        $final_paginacion = 0;
        $pagina = 0;
        $numero_noticias=0;
        $pagina_anterior=0;
        // $pagina_menos = 0;


        if(isset($_POST['buscar'])){

            $datos = $_POST['dato_compañia'];

             //comprobamos si la pagina en la que nos encontramos para mostrar las noticias de 4 en 4
        if(isset($_POST['siguiente'])){
            // echo"entraa2 -- pp $principio_paginacion fp $final_paginacion pg $pagina <br>";
            $principio_paginacion = $_POST['principio_paginacion']+4;
            $final_paginacion = $_POST['final_paginacion'];
            $pagina = $_POST['pagina'] + 1;
            // echo"entraa2-2 -- pp $principio_paginacion fp $final_paginacion pg $pagina <br>";
            //enviar datos hidden

        }elseif(isset($_POST['anterior'])){
            // echo"entraaaaaaaaa3 -- pp $principio_paginacion fp $final_paginacion pg $pagina <br>";
            $principio_paginacion = $_POST['principio_paginacion']-4;
            $final_paginacion = $_POST['final_paginacion'];
            $pagina = $_POST['pagina']-1;
            // echo"entraaaaaaaaa3 -3-- pp $principio_paginacion fp $final_paginacion pg $pagina <br>";

        }else{
            $conexion = conexion();   
            $principio_paginacion = 0;
            $final_paginacion = 4;
            $pagina = 1;
        }
        

        //realizo la consulta necesaria
        
        $datos = "%".$datos."%";

        $sentencia = "select compañia.id, compañia.nombre, compañia.foto 
        from compañia
        where compañia.nombre like ?";

        $consulta = $conexion->prepare($sentencia);

        $consulta->bind_result($c_id, $c_nombre, $c_foto);
        $consulta->bind_param("s", $datos);
        $consulta->execute();


        $consulta->store_result();

        // $numero = 


        // echo"</div>";
        echo '
        <div id="fondo" class="bg-image shadow-2-strong" style="margin-top: 50px; height: auto;">
        <div class="mask" >
        <div class="album py-5" >
        <!-- <div class="album py-5 bg-dark" > -->
        <div class="container"  >';
        ?>
        <h2 class="display-5 fw-bold" style="color: #FD9815; text-align: center; margin-bottom: 40px;">Compañías</h2>
        <?php
        echo '<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3"  >
        ';
        // echo"<ul>";
        while($consulta->fetch()){
            echo '
            <div class="col">
               <div style="color: black; margin: 30px; margin-top: 40px; border-radius: 20px;" class="card shadow-sm">
                 <!-- <svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"/><text x="43%" y="50%" fill="#eceeef" dy=".3em">FOTOO</text></svg>-->
                 <!-- <img  src="..' . $c_foto . '" class="card-img-top" alt="foto"> -->
                 <img class="bd-placeholder-img rounded-circle" width="200rem" height="200rem" style="border-style: solid; border-width: 5px; border-color: white; object-fit: cover; margin: 0 auto; margin-top: -30px; box-shadow: 2px 1px 16px #000000;"  src="../' . $c_foto . '" class="card-img-top" alt="foto">
                 <div class="card-body" >
                     <div style="width: 100%;">
                       <p style="text-align:center; color: #B68D00" class="card-text"><strong>' . $c_nombre . '</strong></p>';
                       echo'<div class="d-flex justify-content-between align-items-center">
                         <div style="margin: 0 auto" class="btn-group">';

                        if (isset($_SESSION['tipo'])) {
                            echo'<a  href="./compañia_completa.php?c_id=' . $c_id . '" class="card-link"><button style="border-radius: 20px; border-color: white; background-color: #D0D0D0; color: grey;" type="button" class="btn btn-sm btn-outline-secondary"><strong>VER MÁS</strong></button></a>';
                                    }else{
                                        echo'<a  href="./login.php" class="card-link"><button style="border-radius: 20px; border-color: white; background-color: #D0D0D0; color: grey;" type="button" class="btn btn-sm btn-outline-secondary"><strong>VER MÁS</strong></button></a>';
                                    }
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
        </div>
        ';

        $consulta->close();






        $sentencia = "select count(compañia.Id) from compañia";

        $consulta = $conexion->prepare($sentencia);

        $consulta->bind_result($numero_compañias);

        $consulta->execute();

        $consulta->store_result();

        $consulta->fetch();

        $consulta->close();

        echo"<div class=buscar>
                    
        <form method='post' action='#' enctype='multipart/form-data'>";
        echo'<h2 class="display-5 fw-bold" style="color: #FD9815; text-align: center; margin-bottom: 40px;">Buscar compañía</h2>';
            echo"
            <label for='busqueda_compañia'>Buscar por nombre de la compañia</label>
            <input type='text' name='dato_compañia' id='busqueda_compañia' placeholder='Introduzca nombre de la compañía' required ><br>
            <input type='submit' name='buscar' value = 'buscar'>
            </form>
        </div>";






        }else{ //AQUI TERMINA LA BUSQUEDA Y COMIENZA NORMAL

                //comprobamos si la pagina en la que nos encontramos para mostrar las noticias de 4 en 4
            if(isset($_POST['siguiente'])){
                // echo"entraa2 -- pp $principio_paginacion fp $final_paginacion pg $pagina <br>";
                $principio_paginacion = $_POST['principio_paginacion']+4;
                $final_paginacion = $_POST['final_paginacion'];
                $pagina = $_POST['pagina'] + 1;
                // echo"entraa2-2 -- pp $principio_paginacion fp $final_paginacion pg $pagina <br>";
                //enviar datos hidden

            }elseif(isset($_POST['anterior'])){
                // echo"entraaaaaaaaa3 -- pp $principio_paginacion fp $final_paginacion pg $pagina <br>";
                $principio_paginacion = $_POST['principio_paginacion']-4;
                $final_paginacion = $_POST['final_paginacion'];
                $pagina = $_POST['pagina']-1;
                // echo"entraaaaaaaaa3 -3-- pp $principio_paginacion fp $final_paginacion pg $pagina <br>";

            }else{
                
                $conexion = conexion();   
                $principio_paginacion = 0;
                $final_paginacion = 4;
                $pagina = 1;
            }
            

            //realizo la consulta necesaria
            
            $sentencia = "select compañia.id, compañia.nombre, compañia.foto from compañia order by compañia.nombre asc limit ?, ?";

            $consulta = $conexion->prepare($sentencia);

            $consulta->bind_result($c_id, $c_nombre, $c_foto);
            $consulta->bind_param("ii", $principio_paginacion, $final_paginacion);
            $consulta->execute();


            $consulta->store_result();

            // $numero = 


            // echo"</div>";
            echo '
            <div id="fondo" class="bg-image shadow-2-strong" style="margin-top: 50px; height: auto;">
            <div class="mask" >
            <div class="album py-5" >
            <!-- <dechoiv class="album py-5 bg-dark" > -->
            <div class="container"  >';
            ?>
            <h2 class="display-5 fw-bold" style="color: #FD9815; text-align: center; margin-bottom: 40px;">Compañías</h2>
            <?php
            echo '<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3"  >
            ';
            // echo"<ul>";
            while($consulta->fetch()){
                echo '
                <div class="col">
                   <div style="color: black; margin: 30px; margin-top: 40px; border-radius: 20px;" class="card shadow-sm">
                     <!-- <svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"/><text x="43%" y="50%" fill="#eceeef" dy=".3em">FOTOO</text></svg>-->
                     <!-- <img  src="..' . $c_foto . '" class="card-img-top" alt="foto"> -->
                     <img class="bd-placeholder-img rounded-circle" width="200rem" height="200rem" style="border-style: solid; border-width: 5px; border-color: white; object-fit: cover; margin: 0 auto; margin-top: -30px; box-shadow: 2px 1px 16px #000000;"  src="../' . $c_foto . '" class="card-img-top" alt="foto">
                     <div class="card-body" >
                         <div style="width: 100%;">
                           <p style="text-align:center; color: #B68D00" class="card-text"><strong>' . $c_nombre . '</strong></p>';
                           echo'<div class="d-flex justify-content-between align-items-center">
                             <div style="margin: 0 auto" class="btn-group">';
    
                            if (isset($_SESSION['tipo'])) {
                                echo'<a  href="./compañia_completa.php?c_id=' . $c_id . '" class="card-link"><button style="border-radius: 20px; border-color: white; background-color: #D0D0D0; color: grey;" type="button" class="btn btn-sm btn-outline-secondary"><strong>VER MÁS</strong></button></a>';
                                        }else{
                                            echo'<a  href="./login.php" class="card-link"><button style="border-radius: 20px; border-color: white; background-color: #D0D0D0; color: grey;" type="button" class="btn btn-sm btn-outline-secondary"><strong>VER MÁS</strong></button></a>';
                                        }
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
            </div>
            ';

            $consulta->close();

            echo"</ul><div class = 'paginacion'><p class = 'pag'>pagina $pagina</p> <br></div>";




            $sentencia = "select count(compañia.Id) from compañia";

            $consulta = $conexion->prepare($sentencia);

            $consulta->bind_result($numero_compañias);

            $consulta->execute();

            $consulta->store_result();

            $consulta->fetch();

            $consulta->close();



            echo"
            <form method='post' id='f_c' action='#' enctype='multipart/form-data'>
            <input type = 'hidden' name = 'principio_paginacion' value = '$principio_paginacion'>
            <input type = 'hidden' name = 'final_paginacion' value = '$final_paginacion'>
            <input type = 'hidden' name = 'pagina' value = '$pagina'>
            ";

            if(($principio_paginacion +4) < $numero_compañias){

                echo"<input type='submit' name='siguiente' value='siguiente'> <br>
            ";
            }

            if($pagina != 1){
                echo"<input type='submit' name='anterior' value='anterior'> <br>";
            }

            echo"</form>";


            echo"<div class=buscar>
                    
            <form method='post' action='#' enctype='multipart/form-data'>";
            echo'<h2 class="display-5 fw-bold" style="color: #FD9815; text-align: center; margin-bottom: 40px;">Buscar compañía</h2>';
                echo"
                <label for='busqueda_compañia'>Buscar por nombre de la compañia</label>
                <input type='text' name='dato_compañia' id='busqueda_compañia' placeholder='Introduzca nombre de la compañía' required ><br>
                <input type='submit' name='buscar' value = 'buscar'>
                </form>
            </div>";

        }

        echo"</main></section>";
//inserto el footer
        echo insertar_footer($parametro1, $parametro2);
    


   