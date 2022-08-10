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
  $imprimo = "";

  //En caso de que esté guardada la sesión la obtengo
  if(isset($_COOKIE['mantener'])){
    session_decode($_COOKIE['mantener']);
}

 //introduzco el header y la cabecera dependiendo del tipo de usuario


  if (isset($_SESSION['tipo'])) {
    $imprimo .=  "<h2 class='error'>YA TIENE ABIERTA UNA SESIÓN</h2>";
    // $spin = spin();
    // $imprimo .= $spin;
    echo'<META HTTP-EQUIV="REFRESH"CONTENT="2;URL=./vistaError.php">';
  } else {

    $imprimo= "<main>";

    echo '<div class="img-header3">
    <div class="welcome">
      <h1>Bienvenidos TodoTeatro</h1>
      <hr>
      <p>Especializada en gestión de eventos de teatro</p>
      <p>entre actores y compañías</p>
    </div>       
   </div>
';

    $imprimo .= "<section>";

   $parametro1="";
   $parametro2="../";
   $imprimo .= insertar_menu($parametro1, $parametro2);



   $imprimo .= '<h2 class="display-5 fw-bold" style="color: #FD9815; text-align: center; margin-bottom: 40px; ">Iniciar sesión</h2>';

   $imprimo .=  "<div id='ancho'>
  <div class='container mt-3 text-center'>
    

    
    
    <form action='#' method = 'post'>
    
    <div class='mb-3 mt-3'>
        <label for='correo'>Correo electrónico:</label>
        <input type='text' class='form-control' id='correo' placeholder='Introduzca el correo electrónico' name='correo' required>
      </div>
      <div class='mb-3'>
        <label for='pass'>Contraseña:</label>
        <input type='password' class='form-control' id='pass' placeholder='introduzca contraseña' name='pass' required>
      </div>
      <div class='form-check mb-3'>
        <label class='form-check-label'>
          <input class='form-check-input' type='checkbox' name='mantener' value = 'si'>Mantener sesión
        </label>
      </div>
      <p>¿Desea iniciar sesión como actor o compañía?</p>
      <select name = 'tipo' id = 'tipo' class='form-select' aria-label='Default select example'>
        <option selected value='actor'>Actor</option>
        <option value='compañia'>Compañía</option>
      </select>
      <input type='submit' class='btn btn-primary' name = 'enviar'>
    </form>
    <h3>Si aún no esta registrado, registrese como:</h3>
    <h4><a href='./registro_cliente.php'>Actor</a></h4>
    <h4><a href='./registro_compañia.php'>Compañía</a></h4>
  </div>

</div>";

    if (isset($_POST['enviar'])) {

      $correo = $_POST['correo'];
      $pass = $_POST['pass'];
      $tipo = $_POST['tipo'];
      $mantener = 'no';

      if (isset($_POST['mantener'])) {
        $mantener = $_POST['mantener'];
      }

      // $imprimo .=  "--->mantener = $mantener<br>";
      $pass = md5(md5($pass));
      // $pass = md5($pass);

      // $verificacion = comprobar_datos_registro($nick, $pass);
      // if($verificacion>=1){

      if ($tipo == 'actor') {

        // $imprimo .=  "entra1<br>";

        //realizo las consultas necesarias
        $sentencia = "select actores.id from actores where actores.correo = ? and actores.contraseña = ?";

        $consulta = $conexion->prepare($sentencia);

        $consulta->bind_param("ss", $correo, $pass);
        $consulta->bind_result($id);
        $consulta->execute();


        $consulta->store_result();
        $numero_filas = $consulta->num_rows;


        $consulta->fetch();

        $consulta->close();

        if ($numero_filas > 0) {
          $_SESSION['correo'] = $correo;
          $_SESSION['id'] = $id;
          $_SESSION['tipo'] = $tipo;

          if ($mantener == 'si') {
            // $imprimo .=  "---entraaaa manener actor";
            $datos = session_encode();
            setcookie('mantener', $datos, time() + 365 * 60 * 60 * 2, '/');
          }
          $imprimo .=  "<h2 class='error' >REGISTRADO CORRECTAMENTE</h2>";
          // Header("refresh:3;url=../index.php");
          // $spin = spin();
          // $imprimo .= $spin;
          echo'<META HTTP-EQUIV="REFRESH"CONTENT="2;URL=../index.php">';
        } else {
          $imprimo .=  "<h2 class='error'>ERROR EN EL REGISTRO</h2>";
          // $spin = spin();
          // $imprimo .= $spin;
          echo'<META HTTP-EQUIV="REFRESH"CONTENT="2;URL=./login.php">';
          // Header("refresh:3;url=./login.php");
        }
      } elseif ($tipo == 'compañia') {

        // $imprimo .=  "entra2<br>";

        $sentencia = "select compañia.id from compañia where compañia.correo = ? and compañia.contraseña = ?";

        $consulta = $conexion->prepare($sentencia);

        $consulta->bind_param("ss", $correo, $pass);
        $consulta->bind_result($id);
        $consulta->execute();


        $consulta->store_result();
        $numero_filas = $consulta->num_rows;


        $consulta->fetch();

        $consulta->close();

        if ($numero_filas > 0) {
          $_SESSION['correo'] = $correo;
          $_SESSION['id'] = $id;
          $_SESSION['tipo'] = $tipo; //puede ser actor / compañia

          if ($mantener == 'si') {
            // $imprimo .=  "---entraaaa";
            $datos = session_encode();
            setcookie('mantener', $datos, time() + 365 * 60 * 60 * 2, '/');
          }
          $imprimo .=  "<h2 class='error' >REGISTRADO CORRECTAMENTE</h2>";
          // $spin = spin();
          // $imprimo .= $spin;
          // Header("refresh:3;url=../index.php");
          echo'<META HTTP-EQUIV="REFRESH"CONTENT="2;URL=../index.php">';
        } else {
          $imprimo .=  "<h2 class='error'>ERROR EN EL REGISTRO</h2>";
          // $spin = spin();
          // $imprimo .= $spin;
          echo'<META HTTP-EQUIV="REFRESH"CONTENT="2;URL=./login.php">';

        }


      } else {
        $imprimo .=  "<h2 class = 'error'>SELECCIONE UNA OPCIÓN CORRECTA</h2>";
        // $spin = spin();
        // $imprimo .= $spin;
        echo'<META HTTP-EQUIV="REFRESH"CONTENT="2;URL=./login.php">';
        // Header("refresh:3;url=./login.php");
      }

    }

  }
  

  $imprimo .="</main></section>";

  $imprimo .= insertar_footer($parametro1, $parametro2);

  echo $imprimo;



  ?>


</body>

</html>