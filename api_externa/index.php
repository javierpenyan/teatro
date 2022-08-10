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
    <script type="text/javascript" src="app.js" defer></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../asset/imagenes/logo.jpg">
    <title>Document</title>
</head>
<body>

<?php

    require_once "../php/funciones.php";
    $parametro1 = '../';
    $parametro2 = "../controladores/";
    echo insertar_menu($parametro1, $parametro2);


    echo "<main>";

    echo '<div class="img-header12">
    <div class="welcome">
      <h1>Bienvenidos TodoTeatro</h1>
      <hr>
      <p>Especializada en gestión de eventos de teatro</p>
      <p>entre actores y compañías</p>
    </div>       
    </div>
        ';
    
    echo "<section>";

  


    if(isset($_SESSION['tipo'])){

        if($_SESSION['tipo'] == 'compañia'){

            $parametro1="../php/";
            $parametro2="../";
            echo insertar_menu_compañias($parametro1, $parametro2);

        }elseif($_SESSION['tipo'] == 'actor'){

            $parametro1="../php/";
            $parametro2="../";
            echo insertar_menu_actores($parametro1, $parametro2);

        }

        }else{

            $parametro1="../php/";
            $parametro2="../";
            echo insertar_menu($parametro1, $parametro2);

    }

    ?>
    <!-- Navigation -->

    <div class = "centroBoton"><input type="button" class="btn btn-primary" id="descargar" value="Ver y actualizar listado de eventos culturales"></div>


    
    <div class="mt-5 container">
        <!-- APPLICATION -->
        <div id="App" class="justify-content-center row pt-5">
            <div class="col-md-8">
			    <table  class="table text-center table-hover">
				<thead>
                <tr>
				  <th>Dirección</th>
				  <th>Fecha</th>
                  <th>Lugar</th>
                  <th>Coste</th>
				</tr>
                <thead>
				<tbody id="lista_api">

                </tbody>
				</table>
			</div>

            
                
        </div>
      
    </div>
    
    <!-- <div id="cargando">
        <h3>Cargando datos</h3>    
        <progress>Cargando datos</progress>
    </div> -->

    <div id="mensaje" class="fixed-top  mx-auto mt-5 toast text-center" data-delay="3000" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header w-100">
            <img src="info.jpg" width="8%" class="mr-2" >
            <strong class="w-100 mr-auto">Mensaje informativo</strong>
        </div>
    </div>
    <?php
    echo insertar_footer($parametro1, $parametro2);
    ?>
</body>

</html>