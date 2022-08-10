<?php

    function conexion()
    {
        $conexion = new mysqli('localhost', 'root', '', 'teatro');
        $conexion->set_charset('utf8');

        return $conexion;
    };

    function insertar_menu($parametro1, $parametro2){
  

       // menu para usuarios no registrados
            $cabecera = "<nav class='navbar navbar-expand-md navbar-dark fixed-top bg-dark' id='menu'>
            <div class='container-fluid'>
              <a class='navbar-brand' href='".$parametro2."index.php'><img class='foto' img id='logo'  src='".$parametro2."/asset/imagenes/logo.png' ></a>
      
              <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarCollapse' aria-controls='navbarCollapse' aria-expanded='false' aria-label='Toggle navigation'>
              <span class='navbar-toggler-icon'></span>
              </button>
              <div class='collapse navbar-collapse' id='navbarCollapse'>
              <ul class='navbar-nav me-auto mb-2 mb-md-0'>
                <li class='nav-item'>
                <a class='nav-link' href='".$parametro2."index.php'>PRINCIPAL</a>
                </li>
                <li class='nav-item'>
                <a class='nav-link' href='".$parametro1."actores.php'>ACTORES</a>
                </li>
                <li class='nav-item'>
                <a class='nav-link' href='".$parametro1."actuaciones.php'>ACTUACIONES</a>
                </li>
                <li class='nav-item'>
                <a class='nav-link' href='".$parametro1."casting.php'>CASTINGS</a>
                </li>
                <li class='nav-item'>
                <a class='nav-link' href='".$parametro1."compañias.php'>COMPAÑÍAS</a>
                </li>
                <li class='nav-item'>
                <a class='nav-link' href='".$parametro1."login.php'>ACCEDER</a>
                </li>
              </ul>
            
              </div>
            </div>
            </nav>";
            return $cabecera;
    }

    function insertar_menu_actores($parametro1, $parametro2){

      // menu para actores
           $cabecera = "<nav class='navbar navbar-expand-md navbar-dark fixed-top bg-dark' id='menu'>
           <div class='container-fluid'>
             <a class='navbar-brand' href='".$parametro2."index.php'><img class='foto' img id='logo'  src='".$parametro2."asset/imagenes/logo.png' ></a>
     
             <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarCollapse' aria-controls='navbarCollapse' aria-expanded='false' aria-label='Toggle navigation'>
             <span class='navbar-toggler-icon'></span>
             </button>
             <div class='collapse navbar-collapse' id='navbarCollapse'>
             <ul class='navbar-nav me-auto mb-2 mb-md-0'>
               <li class='nav-item'>
               <a class='nav-link' href='".$parametro2."index.php'>PRINCIPAL</a>
               </li>
               <li class='nav-item'>
               <a class='nav-link' href='".$parametro1."perfil_usuario.php'>MI PERFIL</a>
               </li>
               <li class='nav-item'>
               <a class='nav-link' href='".$parametro1."fotos_actor.php'>MIS FOTOS</a>
               </li>
               <li class='nav-item'>
               <a class='nav-link' href='".$parametro1."videos.php'>MIS VIDEOS</a>
               </li>
               <li class='nav-item'>
               <li class='nav-item'>
               <a class='nav-link' href='".$parametro1."mis_obras.php'>MIS ACTUACIONES</a>
               </li>
               <li class='nav-item'>
               <a class='nav-link' href='".$parametro1."calendario_actores.php'>MI CALENDARIO</a>
               </li>
               <li class='nav-item'>
               <a class='nav-link' href='".$parametro1."actores.php'>ACTORES</a>
               </li>
               <li class='nav-item'>
               <a class='nav-link' href='".$parametro1."actuaciones.php'>ACTUACIONES</a>
               </li>
               <li class='nav-item'>
               <a class='nav-link' href='".$parametro1."casting.php'>CASTINGS</a>
               </li>
               <li class='nav-item'>
               <a class='nav-link' href='".$parametro1."compañias.php'>COMPAÑÍAS</a>
               </li>
               <li class='nav-item'>
               <a class='nav-link' href='".$parametro1."cerrar_sesion.php'>CERRAR SESIÓN</a>
               </li>
             </ul>
           
             </div>
           </div>
           </nav>";
           return $cabecera;
   };

   
   function insertar_menu_compañias($parametro1, $parametro2){

    // menu para actores
         $cabecera = "<nav class='navbar navbar-expand-md navbar-dark fixed-top bg-dark' id='menu'>
         <div class='container-fluid'>
           <a class='navbar-brand' href='".$parametro2."index.php'><img class='foto' img id='logo'  src='".$parametro2."asset/imagenes/logo.png' ></a>
   
           <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarCollapse' aria-controls='navbarCollapse' aria-expanded='false' aria-label='Toggle navigation'>
           <span class='navbar-toggler-icon'></span>
           </button>
           <div class='collapse navbar-collapse' id='navbarCollapse'>
           <ul class='navbar-nav me-auto mb-2 mb-md-0'>
             <li class='nav-item'>
             <a class='nav-link' href='".$parametro2."index.php'>PRINCIPAL</a>
             </li>
             <li class='nav-item'>
             <a class='nav-link' href='".$parametro1."perfil_compañia.php'>MI PERFIL</a>
             </li>
             <li class='nav-item'>
             <li class='nav-item'>
             <a class='nav-link' href='".$parametro1."mis_obrasc.php'>MIS OBRAS</a>
             </li>
             <li class='nav-item'>
             <a class='nav-link' href='".$parametro1."mis_castingc.php'>MIS CASTINGS</a>
             </li>
             <li class='nav-item'>
             <a class='nav-link' href='".$parametro1."mis_actores.php'>MIS ACTORES</a>
             </li>
             <li class='nav-item'>
             <a class='nav-link' href='".$parametro1."calendario_compañias.php'>MI CALENDARIO</a>
             </li>
             <li class='nav-item'>
             <a class='nav-link' href='".$parametro1."actores.php'>ACTORES</a>
             </li>
             <li class='nav-item'>
             <a class='nav-link' href='".$parametro1."actuaciones.php'>ACTUACIONES</a>
             </li>
             <li class='nav-item'>
             <a class='nav-link' href='".$parametro1."casting.php'>CASTINGS</a>
             </li>
             <li class='nav-item'>
             <a class='nav-link' href='".$parametro1."compañias.php'>COMPAÑÍAS</a>
             </li>
             <li class='nav-item'>
             <a class='nav-link' href='".$parametro1."cerrar_sesion.php'>CERRAR SESIÓN</a>
             </li>
           </ul>
         
           </div>
         </div>
         </nav>";
         return $cabecera;
 };


//comprobación registro actor
    function comprueba_registro_cliente($nombre, $apellidos, $alias, $nac, $tel, $correo, $pass){
      $verificado=0;
      $today = fecha_hoy();

      //comprobamos que no hay ningun cliente registrado con el correo introducido
      $conexion = conexion();

      $numero = 0;
  
      $sentencia = "select count(actores.correo) from actores where actores.correo = ?";
  
      $consulta = $conexion->prepare($sentencia);
  
      $consulta->bind_param("s", $correo);
      $consulta->bind_result($numero_actores);
     
      $consulta->execute();
      $consulta->store_result();
      
      $numero = $consulta->num_rows;

      if($numero>0){
        echo"$numero<br>";
        $consulta->fetch();

        if($numero_actores>0){
          echo"$numero_actores<br>";
          $verificado = "Ese correo ya tiene un actor asociado";
        }

      }

      $consulta->close();


      if (!strlen(trim($nombre)) > 0) {
        $verificado = "Error en el nombre";
      } elseif (!strlen(trim($apellidos)) > 0) {
          $verificado = "Error en el apellido";
      } elseif (!strlen(trim($alias)) > 0) {
          $verificado = "Error en el alias";
      } elseif (!strlen(trim($correo)) > 0) {
        $verificado = "Error en el correo electrónico";
      } elseif (!preg_match("`^.{6,15}$`", $pass) || !preg_match("`[A-Z]`", $pass) || !preg_match("`[0-9]`", $pass) || !preg_match("`[a-z]`", $pass)) {
        $verificado = "Error al introducir la contraseña";
      } elseif (!preg_match("`^[6789][0-9]{8}$`", $tel)) {
        $verificado = "error al introducir el número de teléfono";
      } elseif (($nac<'1900-01-01') || $nac>$today) {
        // echo"$nac<br>";
        // echo"$today<br>";
          $verificado = "Error en la introducción de la fecha de nacimiento";
      }

      return $verificado;
    }

    //compruebo registro compañía
    function comprueba_registro_compañia($nombre, $direccion, $creacion, $tel, $correo, $pass){
      $verificado=0;
      $today = fecha_hoy();

      //comprobamos que no hay ningun cliente registrado con el correo introducido
      $conexion = conexion();

      $numero = 0;
  
      $sentencia = "select count(compañia.correo) from compañia where compañia.correo = ?";
  
      $consulta = $conexion->prepare($sentencia);
  
      $consulta->bind_param("s", $correo);
      $consulta->bind_result($numero_compañias);
     
      $consulta->execute();
      $consulta->store_result();
      
      $numero = $consulta->num_rows;

      if($numero>0){
        echo"$numero<br>";
        $consulta->fetch();

        if($numero_compañias>0){
          echo"$numero_compañias<br>";
          $verificado = "Ese correo ya tiene una compañía asociada";
        }

      }


      $consulta->close();


      if (!strlen(trim($nombre)) > 0) {
        $verificado = "Error en el nombre";
      } elseif (!strlen(trim($direccion)) > 0) {
          $verificado = "Error en la dirección";
      } elseif (!strlen(trim($correo)) > 0) {
          $verificado = "Error en el correo electrónico";
      } elseif (!preg_match("`^.{6,15}$`", $pass) || !preg_match("`[A-Z]`", $pass) || !preg_match("`[0-9]`", $pass) || !preg_match("`[a-z]`", $pass)) {
        $verificado = "Error al introducir la contraseña";
      } elseif (!preg_match("`^[6789][0-9]{8}$`", $tel)) {
        $verificado = "Error al introducir el número de teléfono"; 
      } elseif ($creacion>$today) {
        // echo"$nac<br>";
        // echo"$today<br>";
          $verificado = "Error en la introducción de la fecha de creación";
      }

      return $verificado;
    }

        
    //transformo a fecha con  formato español
    function transformar_fecha_tabla($fecha){
      $f = strtotime($fecha);
      $ano= date('Y', $f);
      $dia=date('d', $f);
      $mes=date('m', $f);
      $resultado = "$ano-$mes-$dia";
      return $resultado;
    }

    //funcion que obtiene el día de hoy
    function fecha_hoy(){
      $hoy = time();
      $hoy = date("Y-m-d");
      return $hoy;
    }

    //función que devuelve los dias de fecha introducida
    function dias_fecha($fecha){
      $time = strtotime($fecha);
      $dia = $time/(60*60*24);
      return $dia; //devuelves un numero de dias
    }

    //compruebo datos de edición de compañía

    function compruebo_editar_compañia($nombre, $direccion, $creacion, $tel, $pass){
      $verificado=0;
      $today = fecha_hoy();


      if (!strlen(trim($nombre)) > 0) {
        $verificado = "Error en el nombre";
      } elseif (!strlen(trim($direccion)) > 0) {
          $verificado = "Error en la dirección";
      } elseif (($pass != null) && (!preg_match("`^.{6,15}$`", $pass) || !preg_match("`[A-Z]`", $pass) || !preg_match("`[0-9]`", $pass) || !preg_match("`[a-z]`", $pass))) {
        $verificado = "Error al introducir la contraseña";
      } elseif (!preg_match("`^[6789][0-9]{8}$`", $tel)) {
        $verificado = "Error al introducir el número de teléfono"; 
      } elseif ($creacion>$today) {
        // echo"$nac<br>";
        // echo"$today<br>";
          $verificado = "Error en la introducción de la fecha de creación";
      }

      return $verificado;
    }


    //compruebo datos de editar cliente
    function comprueba_editar_cliente($nombre, $apellidos, $alias, $nac, $tel, $correo, $pass){
      $verificado=0;
      $today = fecha_hoy();

      if (!strlen(trim($nombre)) > 0) {
        $verificado = "Error en el nombre";
      } elseif (!strlen(trim($apellidos)) > 0) {
          $verificado = "Error en el apellido";
      } elseif (!strlen(trim($alias)) > 0) {
          $verificado = "Error en el alias";
      } elseif (!strlen(trim($correo)) > 0) {
        $verificado = "Error en el correo electrónico";
      } elseif (!preg_match("`^.{6,15}$`", $pass) || !preg_match("`[A-Z]`", $pass) || !preg_match("`[0-9]`", $pass) || !preg_match("`[a-z]`", $pass)) {
        $verificado = "Error al introducir la contraseña";
      } elseif (!preg_match("`^[6789][0-9]{8}$`", $tel)) {
        $verificado = "error al introducir el número de teléfono";
      } elseif (($nac<'1900-01-01') || $nac>$today) {
        // echo"$nac<br>";
        // echo"$today<br>";
          $verificado = "Error en la introducción de la fecha de nacimiento";
      }

      return $verificado;
    }

    //compruebo datos de editar cliente
    function comprueba_editar_cliente2($nombre, $apellidos, $alias, $nac, $tel, $pass){
      $verificado=0;
      $today = fecha_hoy();

      if (!strlen(trim($nombre)) > 0) {
        $verificado = "Error en el nombre";
      } elseif (!strlen(trim($apellidos)) > 0) {
          $verificado = "Error en el apellido";
      } elseif (!strlen(trim($alias)) > 0) {
          $verificado = "Error en el alias";
      } elseif (($pass != null) &&  (!preg_match("`^.{6,15}$`", $pass) || !preg_match("`[A-Z]`", $pass) || !preg_match("`[0-9]`", $pass) || !preg_match("`[a-z]`", $pass))) {
        $verificado = "Error al introducir la contraseña";
      } elseif (!preg_match("`^[6789][0-9]{8}$`", $tel)) {
        $verificado = "error al introducir el número de teléfono";
      } elseif (($nac<'1900-01-01') || $nac>$today) {
        // echo"$nac<br>";
        // echo"$today<br>";
          $verificado = "Error en la introducción de la fecha de nacimiento";
      }

      return $verificado;
    }

    //compruebo inserciones de obras
    function comprueba_obras($nombre, $descripcion, $duracion, $fecha){
      $verificado=0;
      $today = fecha_hoy();

      if (!strlen(trim($nombre)) > 0) {
        $verificado = "Error en el nombre";
      } elseif (!strlen(trim($descripcion)) > 0) {
          $verificado = "Error en la descripcion";
      } elseif (!($fecha > $today)) {
          $verificado = "Error en la fecha";
      } elseif (!($duracion > 0)) {
        $verificado = "Error en la fecha";
      }

      return $verificado;

    }

    //compruebo ediciones de obras

    function comprueba_editar_obra_completac($nombre, $descripcion, $fecha, $duracion){
      $verificado=0;
      $today = fecha_hoy();

      if (!strlen(trim($nombre)) > 0) {
        $verificado = "Error en el nombre";
      } elseif (!strlen(trim($descripcion)) > 0) {
          $verificado = "Error en la descripcion";
      } elseif (!($fecha > $today)) {
          $verificado = "Error en la fecha";
      } elseif (!($duracion > 0)) {
        $verificado = "Error en la fecha";
      }

      return $verificado;

    }

    //compruebo introducciones de casting

    function comprueba_casting($obra, $descripcion, $fecha, $fecha_resolucion, $hora, $ciudad){
      $verificado=0;
      $today = fecha_hoy();

      if (!strlen(trim($descripcion)) > 0) {
        $verificado = "Error en la descripcion";
      } elseif (!strlen(trim($hora)) > 0) {
          $verificado = "Error en la hora";
      } elseif (!($fecha > $today)) {
          $verificado = "Error en la fecha";
      } elseif (!($fecha_resolucion > $fecha)) {
        $verificado = "Error en la fecha de resolución";
      } elseif (!strlen(trim($ciudad)) > 0) {
        $verificado = "Error en la ciudad";
      } elseif (!strlen(trim($obra)) > 0) {
        $verificado = "Error en la obra";
      }
      return $verificado;

    }

    //copruebo ediciones de casting

    function comprueba_casting_editar($descripcion, $fecha, $fecha_resolucion, $hora, $ciudad){
      $verificado=0;
      $today = fecha_hoy();

      if (!strlen(trim($descripcion)) > 0) {
        $verificado = "Error en la descripcion";
      } elseif (!strlen(trim($hora)) > 0) {
          $verificado = "Error en la hora";
      } elseif (!($fecha > $today)) {
          $verificado = "Error en la fecha";
      } elseif (!($fecha_resolucion > $fecha)) {
        $verificado = "Error en la fecha de resolución";
      } elseif (!strlen(trim($ciudad)) > 0) {
        $verificado = "Error en la ciudad";
      }
      return $verificado;

    }

    //función que inserta footer
    function insertar_footer($parametro1, $parametro2)
{
    $footer = "    
              <footer class='page-footer font-small purple pt-4 ' id='colores'>

            <!-- Footer Links -->
            <div class='container-fluid text-center text-md-left'>
        
              <!-- Grid row -->
              <div class='row'>
        
                <!-- Grid column -->
                <div class='col-md-6 mt-md-0 mt-3'>
        
                  <!-- Content -->
                  <h5 class='text-uppercase'>TodoTeatro, para Artistas del Teatro</h5>
                  <p>Disfruta de tu aplicación</p>
                  <img class='foto' img id='logo'  src='".$parametro2."/asset/imagenes/logo.png' >
        
                </div>
                <!-- Grid column -->
        
                <hr class='clearfix w-100 d-md-none pb-3'>
        
                <!-- Grid column -->
                <div class='col-md-3 mb-md-0 mb-3'>
        
                  <!-- Links -->
                  <h5 class='text-uppercase'>Accede a:</h5>
        
                  <ul class='list-unstyled'>
                    <li>
                      <a href='".$parametro1."../extras/politica_cookies.php'>Política de cookies</a>
                    </li>
                    <li>
                      <a href='".$parametro1."../extras/potitica_privacidad.php'>Política de privacidad</a>
                    </li>
                    <li>
                      <a href='".$parametro1."../extras/avisos_legales.php'>Avisos legales</a>
                    </li>
                  </ul>
        
                </div>
                <!-- Grid column -->
        
                <!-- Grid column -->
                <div class='col-md-3 mb-md-0 mb-3'>
        
                  <!-- Links -->
                  <h5 class='text-uppercase'>Accede a:</h5>
        
                  <ul class='list-unstyled'>
                    <li>
                      <a href='".$parametro2."index.php'>Inicio</a>
                    </li>
                    <li>
                      <a href='".$parametro1."../api_externa/index.php'>Eventos Comunidad de Madrid</a>
                    </li>
                    <li>
                      <a href='".$parametro1."actuaciones.php'>Actuaciones</a>
                    </li>
                  </ul>
        
                </div>
                <!-- Grid column -->
        
              </div>
              <!-- Grid row -->
        
            </div>
            <!-- Footer Links -->
        
            <!-- Copyright -->
            <div class='footer-copyright text-center py-3'>© 2018 Copyright:
              <a href='#'>todoTeatro@info.com</a>
            </div>
            <!-- Copyright -->
        
          </footer>";
    return $footer;
}

function fecha($f){
  $f1 = strtotime($f);

  $bien = date('d-m-Y', $f1);

  return $bien;

}

// function spin(){
//     $devuelve = '<div class="spinner-grow text-secondary" role="status">
//     <span class="visually-hidden">Loading...</span>
//   </div>
//   <div class="spinner-grow text-secondary" role="status">
//     <span class="visually-hidden">Loading...</span>
//   </div>
//   <div class="spinner-grow text-secondary" role="status">
//     <span class="visually-hidden">Loading...</span>
//   </div>';

//   return $devuelve;
// }

// function toastError($texto){
//   $devuelve = '
//   <div aria-live="polite" aria-atomic="true" class="d-flex justify-content-center align-items-center" style="min-height: 200px;">
//   <div id="liveToast" class="toast hide" role="danger" aria-live="danger" aria-atomic="true">
//     <div class="toast-header">
//       <div class="rounded me-2"></div>
//       <strong class="me-auto">ERROR</strong>
//       <small>Error</small>
//       <button type="button" class="ml-2 mb-1 btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
//     </div>
//     <div class="toast-body">
//       '.$texto.'
//     </div>
//   </div>
// </div>
//   ';



//   echo'<!-- Flexbox container for aligning the toasts -->
// <div aria-live="polite" aria-atomic="true" class="d-flex justify-content-center align-items-center" style="min-height: 200px;">

//   <!-- Then put toasts within -->
//   <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
//     <div class="toast-header">
//       <img src="..." class="rounded mr-2" alt="...">
//       <strong class="mr-auto">Bootstrap</strong>
//       <small>11 mins ago</small>
//       <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
//         <span aria-hidden="true">&times;</span>
//       </button>
//     </div>
//     <div class="toast-body">
//       Hello, world! This is a toast message.
//     </div>
//   </div>
// </div>';

//   return $devuelve;
// }

// function toastSuccess($texto){
//   $devuelve = '
//   <div aria-live="polite" aria-atomic="true" class="d-flex justify-content-center align-items-center" style="min-height: 200px;">
//   <div id="liveToast" class="toast hide" role="danger" aria-live="danger" aria-atomic="true">
//     <div class="toast-header">
//       <div class="rounded me-2"></div>
//       <strong class="me-auto">Proceso exitoso</strong>
//       <small>Realizado Correctamente</small>
//       <button type="button" class="ml-2 mb-1 btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
//     </div>
//     <div class="toast-body">
//       '.$texto.'
//     </div>
//   </div>
// </div>
//   ';

//   return $devuelve;
// }







?>