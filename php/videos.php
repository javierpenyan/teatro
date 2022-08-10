<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
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
    <script src="../js/app.js" defer></script>
<body>

<?php
        echo'
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content h-100" style="height: 90vh !important;display: flex;">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Video</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body  w-100 d-flex flex-column align-items-center" id="video-modal-content" style="height: 90vh !important;display: flex;">
                ...
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
        <div class="img-header8">
        <div class="welcome">
          <h1>Bienvenidos TodoTeatro</h1>
          <hr>
          <p>Especializada en gestión de eventos de teatro</p>
          <p>entre actores y compañías</p>
        </div>       
        </div>';
    
    
        echo"<main>
            <section>";
            echo "<h2 class='display-5 fw-bold' style='color: #FD9815; text-align: center; margin-bottom: 40px; margin-top: 80px;'>Mis videos:</h2>";



        require_once('./funciones.php');
        $parametro1 = "";
        $parametro2 = "";
        if(isset($_COOKIE['mantener'])){
            session_decode($_COOKIE['mantener']);
        }

        // echo $_SESSION['tipo'];


        
    if(isset($_SESSION['tipo'])){


        if($_SESSION['tipo'] == 'actor'){

          // echo"entra";

          $id_actor = $_SESSION['id'];




            $parametro1="./";
            $parametro2="../";
            echo insertar_menu_actores($parametro1, $parametro2);
            // AÑADIR VIDEO NUEVO
            echo'<main>
            <section method="post" enctype="multipart/form-data" >
              <div class="col-md-12 text-center">
                <form id="video-formu" >
                  <label for="video" id="video-label">video</label>
                  <input type="text" name="url" id="url" require>
                  <input type="hidden" name="actor" id="actor" value = "'.$id_actor.'">   
                  <input type="submit" id="enviar_url" name="enviar_url" value="Añadir video">
                </form>
              </div>
            </section>';

            echo"<section class='container-sm text-center my-2'>
            <div class='row gy-0 my-0 '>
                <div class='col-md-12 text-center add_video' id='add_video'>";

          echo' </div>
            </div>';

          echo'</section></main>';
          echo insertar_footer($parametro1, $parametro2);






        }else{
          echo"ERROR NO REGISTRADO";
        }
      }else{
        echo"ERROR NECESITA ESTAR REGISTRADO";
      }

      echo"</section></main>";



?>
</body>
</html>