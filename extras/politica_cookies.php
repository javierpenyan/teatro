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
    <title>Document</title>
</head>
<body>

<?php

    require_once "../php/funciones.php";
    // $parametro1 = '../';
    // $parametro2 = "../";
    $parametro1Footer = "./";
    $parametro2Footer = "";
    // echo insertar_menu($parametro1, $parametro2);


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

            $parametro1="../";
            $parametro2="../";
            echo insertar_menu($parametro1, $parametro2);

    }

    ?>





        <section class="container-md">
            <div class="row gy-0 my-0">
                <div class="col-md-12 my-5">
                    <h2 class="my-3">POLÍTICA DE COOKIES:</h2>
                    <h4>Política de Cookies</h4>
                    <P>En esta web se utilizan cookies de terceros y propias para conseguir que tengas una mejor experiencia de navegación, puedas compartir contenido en redes sociales y para que podamos obtener estadísticas de los usuarios.

Puedes evitar la descarga de cookies a través de la configuración de tu navegador, evitando que las cookies se almacenen en su dispositivo.

Como propietario de este sitio web, te comunico que no utilizamos ninguna información personal procedente de cookies, tan sólo realizamos estadísticas generales de visitas que no suponen ninguna información personal.

Es muy importante que leas la presente política de cookies y comprendas que, si continúas navegando, consideraremos que aceptas su uso.

Según los términos incluidos en el artículo 22.2 de la Ley 34/2002 de Servicios de la Sociedad de la Información y Comercio Electrónico, si continúas navegando, estarás prestando tu consentimiento para el empleo de los referidos mecanismos.</P>
                    <h4 class="my-3">Entidad Responsable</h4>
                    <P>La entidad responsable de la recogida, procesamiento y utilización de tus datos personales, en el sentido establecido por la Ley de Protección de Datos Personales es la página Todo Teatro, propiedad de Javier Peña Navarrete – C/Cervantes 25.</P>
                    <h4 class="my-3">¿Qué son las cookies?</h4>
                    <P>Las cookies son un conjunto de datos que un servidor deposita en el navegador del usuario para recoger la información de registro estándar de Internet y la información del comportamiento de los visitantes en un sitio web. Es decir, se trata de pequeños archivos de texto que quedan almacenados en el disco duro del ordenador y que sirven para identificar al usuario cuando se conecta nuevamente al sitio web. Su objetivo es registrar la visita del usuario y guardar cierta información. Su uso es común y frecuente en la web ya que permite a las páginas funcionar de manera más eficiente y conseguir una mayor personalización y análisis sobre el comportamiento del usuario.</P>
                    <h4 class="my-3">Cookies de rendimiento</h4>
                    <P>Este tipo de Cookie recuerda sus preferencias para las herramientas que se encuentran en los servicios, por lo que no tiene que volver a configurar el servicio cada vez que usted visita. A modo de ejemplo, en esta tipología se incluyen: Ajustes de volumen de reproductores de vídeo o sonido. Las velocidades de transmisión de vídeo que sean compatibles con su navegador. Los objetos guardados en el “carrito de la compra” en los servicios de e-commerce tales como tiendas.</P>
                    <h4 class="my-3">Cookies de geo-localización</h4>
                    <P>Estas cookies son utilizadas para averiguar en qué país se encuentra cuando se solicita un servicio. Esta cookie es totalmente anónima, y sólo se utiliza para ayudar a orientar el contenido a su ubicación.</P>
                    <h4 class="my-3">Cookies de registro</h4>
                    <P>Las cookies de registro se generan una vez que el usuario se ha registrado o posteriormente ha abierto su sesión, y se utilizan para identificarle en los servicios con los siguientes objetivos:

Mantener al usuario identificado de forma que, si cierra un servicio, el navegador o el ordenador y en otro momento u otro día vuelve a entrar en dicho servicio, seguirá identificado, facilitando así su navegación sin tener que volver a identificarse. Esta funcionalidad se puede suprimir si el usuario pulsa la funcionalidad [cerrar sesión], de forma que esta cookie se elimina y la próxima vez que entre en el servicio el usuario tendrá que iniciar sesión para estar identificado.

Comprobar si el usuario está autorizado para acceder a ciertos servicios, por ejemplo, para participar en un concurso.

Adicionalmente, algunos servicios pueden utilizar conectores con redes sociales tales como Facebook o Twitter. Cuando el usuario se registra en un servicio con credenciales de una red social, autoriza a la red social a guardar una Cookie persistente que recuerda su identidad y le garantiza acceso a los servicios hasta que expira. El usuario puede borrar esta Cookie y revocar el acceso a los servicios mediante redes sociales actualizando sus preferencias en la red social que específica.</P>
                    <h4 class="my-3">Cookies de analíticas</h4>
                    <P>Cada vez que un usuario visita un servicio, una herramienta de un proveedor externo genera una cookie analítica en el ordenador del usuario. Esta cookie que sólo se genera en la visita, servirá en próximas visitas a los servicios de Javier Peña Navarrete para identificar de forma anónima al visitante. Los objetivos principales que se persiguen son:

Permitir la identificación anónima de los usuarios navegantes a través de la cookie (identifica navegadores y dispositivos, no personas) y por lo tanto la contabilización aproximada del número de visitantes y su tendencia en el tiempo.
Identificar de forma anónima los contenidos más visitados y por lo tanto más atractivos para los usuarios Saber si el usuario que está accediendo es nuevo o repite visita.

Importante: Salvo que el usuario decida registrarse en un servicio de Javier Peña Navarrete, la cookie nunca irá asociada a ningún dato de carácter personal que pueda identificarle. Dichas cookies sólo serán utilizadas con propósitos estadísticos que ayuden a la optimización de la experiencia de los usuarios en el sitio.</P>
                    <h4 class="my-3">Cookies de publicidad</h4>
                    <P>Este tipo de cookies permiten ampliar la información de los anuncios mostrados a cada usuario anónimo en los servicios de Javier Peña Navarrete. Entre otros, se almacena la duración o frecuencia de visualización de posiciones publicitarias, la interacción con las mismas, o los patrones de navegación y/o comportamientos del usuario ya que ayudan a conformar un perfil de interés publicitario. De este modo, permiten ofrecer publicidad afín a los intereses del usuario.</P>
                    <h4 class="my-3">Cookies publicitarias de terceros</h4>
                    <P>Además de la publicidad gestionada por las webs de Javier Peña Navarrete en sus servicios, las webs de Javier Peña Navarrete ofrecen a sus anunciantes la opción de servir anuncios a través de terceros (“Ad-Servers”). De este modo, estos terceros pueden almacenar cookies enviadas desde los servicios de Javier Peña Navarrete procedentes de los navegadores de los usuarios, así como acceder a los datos que en ellas se guardan.

Las empresas que generan estas cookies tienen sus propias políticas de privacidad. En la actualidad, las webs de Javier Peña Navarrete utilizan la plataforma Doubleclick (Google) para gestionar estos servicios.</P>
                    <h4 class="my-3">¿Cómo puedo deshabilitar las cookies en mi navegador?</h4>
                    <P>Se pueden configurar los diferentes navegadores para avisar al usuario de la recepción de cookies y, si se desea, impedir su instalación en el equipo. Asimismo, el usuario puede revisar en su navegador qué cookies tiene instaladas y cuál es el plazo de caducidad de las mismas, pudiendo eliminarlas.</P>
                </div>
            </div>
        </section>
    </main>

    <?php


$p1 = '';
$p2 = '../';

echo insertar_footer($parametro1Footer, $parametro2);


    ?>
</body>

</html>