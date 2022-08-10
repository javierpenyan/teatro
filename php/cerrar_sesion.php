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
    <link rel="stylesheet" href="../estilos/estilo.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../asset/imagenes/logo.jpg">
    <script src="../js/app_cerrar_sesion.js" defer></script>
    <title>Document</title>
</head>
<body>
</body>
<?php

setlocale(LC_ALL,"es-ES.UTF-8");

//Llamo a funciones.php para poder traer las funciones a esta pagina
require_once('./funciones.php');

if(isset($_COOKIE['mantener'])){
    session_decode($_COOKIE['mantener']);
}

if(isset($_SESSION['tipo'])){

    if(isset($_SESSION['correo'])){

        $feedback = '';

        // $r1 = ".";
        // $r2 =".";

        // echo insertar_menu($r1, $r2);

        //sección principal
        echo "<main>";

        echo '<div class="img-header11">
        <div class="welcome">
          <h1>Bienvenidos TodoTeatro</h1>
          <hr>
          <p>Especializada en gestión de eventos de teatro</p>
          <p>entre actores y compañías</p>
        </div>       
        </div>
            ';
        
        echo "<section>";
       if($_SESSION['tipo'] == 'compañia'){

        $parametro1="";
        $parametro2="../";
        echo insertar_menu_compañias($parametro1, $parametro2);

    }elseif($_SESSION['tipo'] == 'actor'){

        $parametro1="";
        $parametro2="../";
        echo insertar_menu_actores($parametro1, $parametro2);

    }
    
            echo"<section>";

            echo'<h2 class="display-5 fw-bold" style="color: #FD9815; text-align: center; margin-bottom: 40px; margin-top:80px ">¿Desea Cerrar la Sesión?</h2>';

            
            
           
        echo"<div class = 'centrado'>
        <div class='formu'>
        <form action='#' method='POST'>
        <figure ><img src='../asset/imagenes/fin.gif' class = 'fin'></figure>
            <input class='boton' type = 'submit' name = 'cerrar' value = 'cerrar sesión'>
        </form>
        </div></div>";

        if(isset($_POST['cerrar'])){
            $_SESSION = array();
            session_destroy();
            if(isset($_COOKIE['mantener'])){
                setcookie('mantener', null, -5, '/');
            }
            
            echo"<h2 class=error>HASTA PRONTO!!!!</h2>";
            // echo"</div class = 'centrado'></div></div><div><div class='spinner-grow text-primary' role='status'>
            //         <span class='visually-hidden'>Loading...</span>
            //     </div>
            //     <div class='spinner-grow text-secondary' role='status'>
            //         <span class='visually-hidden'>Loading...</span>
            //     </div>
            //     <div class='spinner-grow text-success' role='status'>
            //         <span class='visually-hidden'>Loading...</span>
            //     </div></div><br><br>";
            echo'<META HTTP-EQUIV="REFRESH"CONTENT="1;URL=../INDEX.php">';
            // Header("refresh:1;url=../index.php"); 
        }
        // echo insertar_footer();
    }else{
        // echo "<h2 class=error>Necesita registrarse para acceder a esta página</h2>";
        echo "<h2 class='error'>NECESITA REGISTRARSE PARA ACCEDER A ESTA PÁGINA</h2>";
        $spin = spin();
        $imprimo .= $spin;
        echo'<META HTTP-EQUIV="REFRESH"CONTENT="1;URL=./login.php">';
    }
    echo "</div></main>";

echo insertar_footer($parametro1, $parametro2);
    //errores de acceso
}else{
    echo "<h2 class='error'>NO TIENE ABIERTA NINUNA SESIÓN</h2>";
    echo'<META HTTP-EQUIV="REFRESH"CONTENT="2;URL=./vistaError.php">';
}





?>
</html>