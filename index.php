<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./estilos/estilo.css">
    <script src="./js/app_modalMap.js" defer></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="./asset/imagenes/logo.jpg">
    <title>Pagina principal</title>
</head>
<body>

<?php


setlocale(LC_ALL, "es-ES.UTF-8");
//En caso de que esté guardada la sesión la obtengo


if (isset($_COOKIE['mantener'])) {
    session_decode($_COOKIE['mantener']);
}


     //introduzco el header y la cabecera dependiendo del tipo de usuario
echo"<main>";

echo'<div id="into">
<div id="intro-title">
<h1>Bienvenidos TodoTeatro</h1>
<hr>
<p class = "index-p">Especializada en gestión de eventos de teatro</p>
<p class = "index-p">entre actores y compañías</p>
</div>
<div id="intro-background">

    <video class="lazy entered loaded" autoplay="" muted="" loop="" playsinline="" data-ll-status="loaded" src="./asset/imagenes/video.mp4">
    
  </video>
</div>
</div>';




// llamo a funciones

    require_once('./php/funciones.php');


    if(isset($_SESSION['tipo'])){

        if($_SESSION['tipo'] == 'compañia'){

            $parametro1="./php/";
            $parametro2="./";
            echo insertar_menu_compañias($parametro1, $parametro2);

        }elseif($_SESSION['tipo'] == 'actor'){

            $parametro1="./php/";
            $parametro2="./";
            echo insertar_menu_actores($parametro1, $parametro2);

        }

        }else{

            $parametro1="./php/";
            $parametro2="./";
            echo insertar_menu($parametro1, $parametro2);

    }



    $conexion = conexion();

    $c_c=0;
    $clase_c="";

   //realizo las consultas necesarias

    $sentencia = $conexion->prepare("select actores.nombre,actores.foto, actores.id from actores order by rand() limit 5;");

    $sentencia->bind_result($a_nombre, $a_foto, $a_id);
    $sentencia->execute();
    $sentencia->store_result();

    $numero = $sentencia->num_rows();

    if($numero>0){


        echo '
        <div id="fondo" class="bg-image shadow-2-strong" style="margin-top: 50px; height: auto;">
        <div class="mask" >
        <div class="album py-5" >
        <!-- <div class="album py-5 bg-dark" > -->
        <div class="container"  >';
        ?>
        <h2 class="display-5 fw-bold" style="color: #FD9815; text-align: center; margin-bottom: 40px;">Actores</h2>
        <?php
        echo '<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3"  >
        ';
        while($sentencia->fetch()){
            // echo"<li>$a_nombre</li>";
            echo '
            <div class="col">
               <div style="margin: 30px; margin-top: 40px; border-radius: 20px;" class="card shadow-sm">
                 <!-- <svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"/><text x="43%" y="50%" fill="#eceeef" dy=".3em">FOTOO</text></svg>-->
                 <!-- <img  src=".'.$a_foto.'" class="card-img-top" alt="foto"> -->
                 <img class="bd-placeholder-img rounded-circle" width="200rem" height="200rem" style="border-style: solid; border-width: 5px; border-color: white; object-fit: cover; margin: 0 auto; margin-top: -30px; box-shadow: 2px 1px 16px #000000;"  src=".'.$a_foto.'" class="card-img-top" alt="foto">
                 <div class="card-body" >
                     <div style="width: 100%;">
                       <p style="text-align:center; color: #B68D00" class="card-text"><strong>' . $a_nombre . '</strong></p>';
                       echo'<div class="d-flex justify-content-between align-items-center">
                         <div style="margin: 0 auto" class="btn-group">';

                        if (isset($_SESSION['tipo'])) {
                            echo'<a  href="./php/actor_completo.php?a_id=' . $a_id . '" class="card-link"><button style="border-radius: 20px; border-color: white; background-color: #D0D0D0; color: grey;" type="button" class="btn btn-sm btn-outline-secondary"><strong>VER MÁS</strong></button></a>';
                                    }else{
                                        echo'<a  href="./php/login.php" class="card-link"><button style="border-radius: 20px; border-color: white; background-color: #D0D0D0; color: grey;" type="button" class="btn btn-sm btn-outline-secondary"><strong>VER MÁS</strong></button></a>';
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



    }else{
        echo "<h3 class='error'>No hay actores registrados</h3>";    }

    $sentencia->close();

    $sentencia = $conexion->prepare("select compañia.id, compañia.nombre, compañia.foto from compañia order by rand() limit 5;");
    //foto de actores 

    $sentencia->bind_result($c_id ,$c_nombre, $c_foto);
    $sentencia->execute();
    $sentencia->store_result();

    $numero = $sentencia->num_rows();

    

    if($numero>0){

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
        while($sentencia->fetch()){
            // echo"<li>$c_nombre --> <img src='$c_foto'></li>";


            echo '
            <div class="col">
               <div style="color: black; margin: 30px; margin-top: 40px; border-radius: 20px;" class="card shadow-sm">
                 <!-- <svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"/><text x="43%" y="50%" fill="#eceeef" dy=".3em">FOTOO</text></svg>-->
                 <!-- <img  src="..' . $c_foto . '" class="card-img-top" alt="foto"> -->
                 <img class="bd-placeholder-img rounded-circle" width="200rem" height="200rem" style="border-style: solid; border-width: 5px; border-color: white; object-fit: cover; margin: 0 auto; margin-top: -30px; box-shadow: 2px 1px 16px #000000;"  src=".' . $c_foto . '" class="card-img-top" alt="foto">
                 <div class="card-body" >
                     <div style="width: 100%;">
                       <p style="text-align:center; color: #B68D00" class="card-text"><strong>' . $c_nombre . '</strong></p>';
                       echo'<div class="d-flex justify-content-between align-items-center">
                         <div style="margin: 0 auto" class="btn-group">';

                        if (isset($_SESSION['tipo'])) {
                            echo'<a  href="./php/compañia_completa.php?c_id='. $c_id . '" class="card-link"><button style="border-radius: 20px; border-color: white; background-color: #D0D0D0; color: grey;" type="button" class="btn btn-sm btn-outline-secondary"><strong>VER MÁS</strong></button></a>';
                                    }else{
                                        echo'<a  href="./php/login.php" class="card-link"><button style="border-radius: 20px; border-color: white; background-color: #D0D0D0; color: grey;" type="button" class="btn btn-sm btn-outline-secondary"><strong>VER MÁS</strong></button></a>';
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

    }else{
        echo "<h3 class='error'>No hay compañías registradas</h3>";
    }

    $sentencia->close();


//programo el mapa con el modal de las CCAA


    echo'
        <section id="contDivMap"><div id="divMap">';
        echo'<h2 class="display-5 fw-bold" style="color: #FD9815; text-align: center; margin-bottom: 40px; margin-top: 80px; cursive;">Principales Teatros por Comunidad Autónoma</h2>';
        echo'<!-- Activación de por localizaciones -->
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 803.85 508.18">
            <title>map-nat</title>
            <polygon class="b map-layer"
                points="525.35 79.5 483.35 75.5 476.35 83.5 373.35 72.5 366.35 64.5 310.35 68.5 300.35 57.5 295.35 57.5 288.35 64.5 288.35 57.5 270.35 70.5 274.35 83.5 246.34 83.5 231.34 99.5 238.34 110.5 247.34 109.5 243.34 124.5 249.34 118.5 246.34 129.5 255.34 130.5 246.34 141.5 256.35 138.5 247.34 145.5 253.34 219.5 223.34 319.5 238.34 325.5 243.34 310.5 246.34 319.5 243.34 325.5 231.34 325.5 238.34 341.5 248.34 332.5 243.34 408.5 262.35 399.5 288.35 408.5 308.35 397.5 383.35 455.5 421.35 420.5 490.35 422.5 493.35 417.5 503.35 414.5 510.35 421.5 529.35 388.5 567.35 377.5 559.35 370.5 601.35 316.5 589.35 309.5 582.35 282.5 632.35 222.5 625.35 216.5 720.35 157.5 714.35 140.5 720.35 140.5 724.35 135.5 713.35 110.5 753.35 68.5 803.35 85.5 803.35 0.5 545.35 0.5 525.35 79.5 525.35 79.5">
            </polygon>
            
            <!-- ...................................................................................................................................................................... -->
            <!-- ====================================================================================================================================================================== -->
            <!-- ...................................................................................................................................................................... -->
            <!-- EXTREMADURA -->
            <g class="principal-layer g" data-key="ext">
                <path
                    d="M392.35,276.5l-5.75-25-37.25-21-22.43,10.25.43,5.75-9,26-18,4,18,29s-11,29-10,29c.41,0,8.15,4.6,17.1,10,12.73,7.68,27.9,17,27.9,17l25-12v-16l13.8-13.8,20.2-20.2v-13Z">
                </path>
            </g>
            <!-- ANDALUCIA -->
            <path class="principal-layer g" data-key="and"
                d="M516.35,377.5v-12l-13-9-7-2-3-22-66,8-35.2-20.8-13.8,13.8v16l-25,12s-15.17-9.31-27.9-17l-14.8,12.59-10.3,24.4,3.21,18.63,4.79-2.63,75,58,38-35,69,2,3-5,10-3,7,7L529.06,389Z">
            </path>
            <!-- CANARIAS -->
            <g class="g ica-vec" data-key="ica">
                <polygon points="11.35 456.5 15.35 456.5 18.34 459.5 15.35 474.5 8.35 459.5 11.35 456.5 11.35 456.5">
                </polygon>
                <polygon points="1.34 501.5 6.34 502.5 10.35 498.5 12.35 500.5 8.35 507.5 1.34 503.5 1.34 501.5 1.34 501.5">
                </polygon>
                <polygon points="34.34 484.5 37.34 483.5 42.34 487.5 38.34 490.5 33.34 488.5 34.34 484.5 34.34 484.5">
                </polygon>
                <polygon points="48.34 477.5 77.34 467.5 78.34 469.5 57.34 492.5 48.34 477.5 48.34 477.5"></polygon>
                <polygon
                    points="94.34 484.5 102.34 486.5 105.34 484.5 105.34 499.5 98.34 502.5 90.34 498.5 94.34 484.5 94.34 484.5">
                </polygon>
                <polygon
                    points="139.34 487.5 148.34 484.5 157.34 461.5 162.34 459.5 160.34 483.5 150.34 484.5 146.34 490.5 139.34 487.5 139.34 487.5">
                </polygon>
                <polygon
                    points="162.34 455.5 164.34 447.5 173.34 443.5 174.34 444.5 176.34 440.5 179.34 440.5 177.34 449.5 166.34 456.5 162.34 455.5 162.34 455.5">
                </polygon>
            </g>
            <!-- ARAGON -->
            <polygon class="principal-layer g" data-key="ara"
                points="540.35 140.5 545.35 150.5 540.35 158.5 522.35 154.5 525.35 168.5 513.35 184.5 513.35 200.5 522.35 200.5 535.35 224.5 525.35 236.5 535.1 250.16 545.35 246.5 553.35 252.5 548.35 257.5 562.35 263.5 583.35 238.5 583.35 216.5 598.17 223.09 608.35 170.5 625.35 135.5 621.55 117.78 589.35 110.5 575.35 111.5 567.47 103.63 540.35 140.5">
            </polygon>
            <!-- CATALUNYA -->
            <polygon class="principal-layer g" data-key="cat"
                points="724.35 135.5 723.51 133.6 713.35 127.5 694.35 135.5 686.35 130.5 653.35 130.5 645.35 115.5 619.35 107.5 621.55 117.78 625.35 135.5 608.35 170.5 598.17 223.09 622.75 234.01 632.35 222.5 625.35 216.5 720.35 157.5 714.35 140.5 720.35 140.5 724.35 135.5">
            </polygon>
            <!-- BALEARES -->
            <g class="principal-layer g" data-key="bal">
                <polygon
                    points="641.35 310.5 646.35 309.5 646.35 305.5 655.35 301.5 658.35 305.5 649.35 316.5 642.35 314.5 641.35 310.5 641.35 310.5">
                </polygon>
                <polygon
                    points="649.35 327.5 650.35 320.5 657.35 323.5 657.35 327.5 652.35 323.5 649.35 327.5 649.35 327.5">
                </polygon>
                <polygon
                    points="692.35 284.5 686.35 278.5 720.35 259.5 715.35 264.5 720.35 262.5 717.35 266.5 722.35 271.5 726.35 268.5 730.35 270.5 722.35 291.5 714.35 294.5 702.35 288.5 700.35 280.5 692.35 284.5 692.35 284.5">
                </polygon>
                <polygon points="743.35 260.5 743.35 255.5 755.35 252.5 762.35 266.5 743.35 260.5 743.35 260.5">
                </polygon>
            </g>
            <!-- MADRID -->
            <polygon class="principal-layer g" data-key="mad"
                points="452.35 251.5 443.35 260.5 475.35 252.5 460.35 216.5 462.35 205.5 456.5 197.22 416.35 246.5 452.35 251.5">
            </polygon>
            <!-- CASTILLA LA MANCHA -->
            <polygon class="principal-layer g" data-key="clm"
                points="545.35 303.5 549.35 291.5 535.35 285.5 547.35 257.5 540.35 257.5 535.1 250.16 525.35 236.5 535.35 224.5 522.35 200.5 513.35 200.5 513.35 201.5 493.35 194.5 460.35 192.5 456.5 197.22 462.35 205.5 460.35 216.5 475.35 252.5 443.35 260.5 452.35 251.5 416.35 246.5 386.6 251.46 392.35 276.5 412.35 286.5 412.35 299.5 392.14 319.7 427.35 340.5 493.35 332.5 496.35 354.5 503.35 356.5 535.35 340.5 541.35 319.5 553.35 323.5 559.35 317.5 545.35 303.5">
            </polygon>
            <!-- VALENCIA -->
            <g class="principal-layer g" data-key="val">
                <polygon
                    points="622.75 234.01 598.17 223.09 583.35 216.5 583.35 238.5 562.35 263.5 548.35 257.5 547.35 257.5 535.35 285.5 549.35 291.5 545.35 303.5 559.35 317.5 553.35 323.5 553.35 354.5 563.52 365.13 601.35 316.5 589.35 309.5 582.35 282.5 622.75 234.01">
                </polygon>
                <polygon
                    points="547.35 257.5 548.35 257.5 553.35 252.5 545.35 246.5 535.1 250.16 540.35 257.5 547.35 257.5">
                </polygon>
            </g>
            <!-- MURCIA -->
            <polygon class="principal-layer g" data-key="mur"
                points="559.35 370.5 563.52 365.13 553.35 354.5 553.35 323.5 552.91 323.35 541.35 319.5 535.35 340.5 503.35 356.5 516.35 365.5 516.35 377.5 529.06 389 529.35 388.5 555.53 380.92 567.35 377.5 559.35 370.5">
            </polygon>
            <!-- GALICIA -->
            <polygon class="principal-layer g" data-key="gal"
                points="318.35 127.5 327.35 104.5 314.35 79.5 319.39 67.85 310.35 68.5 300.35 57.5 295.35 57.5 288.35 64.5 288.35 57.5 270.35 70.5 274.35 83.5 246.34 83.5 231.34 99.5 238.34 110.5 247.34 109.5 243.34 124.5 249.34 118.5 246.34 129.5 255.34 130.5 246.34 141.5 256.35 138.5 247.34 145.5 248.18 155.74 274.35 145.5 278.35 163.5 302.35 161.5 320.35 157.5 331.35 138.5 318.35 127.5">
            </polygon>
            <!-- ASTURIAS -->
            <polygon class="principal-layer g" data-key="ast"
                points="373.35 72.5 366.35 64.5 319.39 67.85 314.35 79.5 327.35 104.5 342.35 103.5 359.35 93.5 369.35 99.5 394.35 95.5 420.9 77.58 373.35 72.5">
            </polygon>
            <!-- CANTABRIA -->
            <polygon class="principal-layer g" data-key="can"
                points="420.9 77.58 401.37 90.76 421.35 99.5 427.35 110.5 445.35 111.5 438.35 102.5 450.35 92.5 459.91 90.81 468.18 82.63 420.9 77.58">
            </polygon>
            <!-- LA RIOJA -->
            <g class="principal-layer g" data-key="rio">
                <polygon
                    points="501.35 128.5 486.35 121.5 475.35 120.5 476.35 148.5 501.35 145.5 513.35 157.5 522.35 154.5 522.35 145.5 531.35 145.5 501.35 128.5">
                </polygon>
            </g>
            <!-- CASTILLA Y LEON -->
            <g class="principal-layer g" data-key="cyl">
                <polygon
                    points="522.35 154.5 513.35 157.5 501.35 145.5 476.35 148.5 475.35 120.5 486.35 121.5 466.35 106.5 478.35 103.5 467.35 89.5 459.91 90.81 450.35 92.5 438.35 102.5 445.35 111.5 427.35 110.5 421.35 99.5 401.37 90.76 394.35 95.5 369.35 99.5 359.35 93.5 342.35 103.5 327.35 104.5 318.35 127.5 331.35 138.5 322.06 154.54 336.35 157.5 353.35 176.5 324.35 205.5 326.93 240.75 349.35 230.5 386.6 251.46 416.35 246.5 460.35 192.5 493.35 194.5 513.35 201.5 513.35 184.5 525.35 168.5 522.35 154.5">
                </polygon>
                <polygon
                    points="495.35 112.5 483.35 110.5 482.35 114.5 487.35 118.5 496.35 118.5 493.35 115.5 495.35 112.5">
                </polygon>
            </g>
            <!-- EUSKADI -->
            <path class="principal-layer g" data-key="eus"
                d="M527.35,83.5l-2-4-42-4-7,8-8.17-.87-8.27,8.18,7.44-1.31,11,14-12,3,20,15,15,7-4-8,11-17Zm-40,35-5-4,1-4,12,2-2,3,3,3Z">
            </path>
            <!-- NAVARRA -->
            <polygon class="principal-layer g" data-key="nav"
                points="542.35 95.5 537.35 96.5 540.35 86.5 527.35 83.5 508.35 103.5 497.35 120.5 501.35 128.5 531.35 145.5 522.35 145.5 522.35 154.5 540.35 158.5 545.35 150.5 540.35 140.5 567.47 103.63 542.35 95.5">
            </polygon>
        </svg>
        
        </div></section>
    ';

        echo'<div class="eventosCam"><h4><a href="'.$parametro1.'../api_externa/index.php">Pincha aqui y Descubre los próximos 101 Eventos Culturales de la Comunidad de Madrid!!</a><h4></div>';



        $hoy = fecha_hoy();


    ?>
    <h2 class="display-5 fw-bold" style="color: #FD9815; text-align: center; margin-bottom: 40px; margin-top: 80px;">Castings</h2>
    <?php
//Programo la consulta de las compañías

    $sentencia = $conexion->prepare("select compañia.nombre, obra.imagen, casting.descripcion, casting.ciudad
    from compañia, obra, casting
    where compañia.id = obra.compañia and casting.obra = obra.id
    and obra.fecha > ?
    and casting.fecha > ?
    order by casting.fecha limit 0,5");

    $sentencia->bind_param("ss", $hoy, $hoy);
    $sentencia->bind_result($n_compañia, $f_compañia, $c_descripcion, $c_ciudad);
    $sentencia->execute();
    $sentencia->store_result();

    $numero = $sentencia->num_rows();

    if($numero>0){

        //programo el carrusel

        echo '<div class="container-md my-5 justify-content-center">
        <div class="row align-items-center text-center justify-content-center">
            <div class="col-md-6 align-items-center text-center justify-copntent-center">
                    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                          <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                          <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                          <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                          <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="3" aria-label="Slide 4"></button>
                          <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="4" aria-label="Slide 5"></button>
                    </div>';

        while($sentencia->fetch()){

            if($c_c == 0){
                echo'<div class="carousel-inner">
                <div class="carousel-item active">
                <img src=".' . $f_compañia . '" class="d-block w-100 img-fluid" id="carouimg" alt="...">
                <div class="carousel-caption d-none d-md-block" id="cc">
                <div id="caja">
                <h5>Casting en ' . $c_ciudad . ' de la compañía '. $n_compañia.': </h5><h5> Se busca actor para el papel de ' . $c_descripcion . '</h5>
                </div>
                </div>
                </div>   ';
                $c_c++; 
            }else{

                echo'<div class="carousel-item">
                <img src=".' . $f_compañia . '" class="d-block w-100 img-fluid" id="carouimg" alt="...">
                <div class="carousel-caption d-none d-md-block"  id="cc">
                <div id="caja"><h5>
                Casting en ' . $c_ciudad . ' de la compañía '. $n_compañia.': </h5><h5> Se busca actor para el papel de ' . $c_descripcion . '</h5>
                </div>
                </div>
                </div>';
                $c_c++;

                if($c_c == 5){
                    $c_c=0;
                }
            }
        }

        echo'</div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
        </div>
    </div>
  </div>
</div>';

    }else{
        echo "<h3>No hay casting pendientes</h3>";
    }

    $sentencia->close();    



    echo"</section>
    </main>";

    //instroduzco el footer

    echo insertar_footer($parametro1, $parametro2);


    
?>

</body>
</html>