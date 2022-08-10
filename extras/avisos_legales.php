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
    // $parametro2 = "../controladores/";
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
                    <h2 class="my-3">AVISOS LEGALES:</h2>
                    <h4>I. INFORMACIÓN GENERAL</h4>
                    <P>En cumplimiento con el deber de información dispuesto en la Ley 34/2002 de Servicios de la Sociedad de la Información y el Comercio Electrónico (LSSI-CE) de 11 de julio, se facilitan a continuación los siguientes datos de información general de este sitio web:

La titularidad de este sitio web, Todoteatro.com, (en adelante, Sitio Web) la ostenta: Salome Todo Teatro, con NIF: 1111111P, y cuyos datos de contacto son:</P>
                    <ul>
                        <li>Nombre responsable: Javier Peña Navarrete</li>
                        <li>Actividad: App Web</li>
                        <li>Dirección: C/ Cervantes 25</li>
                        <li>Email de contacto: todoteatro@info@gmail.com</li>
                    </ul>
                    <h4 class="my-3">II. TÉRMINOS Y CONDICIONES GENERALES DE USO</h4>
                    <h5>EL OBJETO DE LAS CONDICIONES: EL SITIO WEB</h5>
                        <p>El objeto de las presentes Condiciones Generales de Uso (en adelante, Condiciones) es regular el acceso y la utilización del Sitio Web. A los efectos de las presentes Condiciones se entenderá como Sitio Web: la apariencia externa de los interfaces de pantalla, tanto de forma estática como de forma dinámica, es decir, el árbol de navegación; y todos los elementos integrados tanto en los interfaces de pantalla como en el árbol de navegación (en adelante, Contenidos) y todos aquellos servicios o recursos en línea que en su caso ofrezca a los Usuarios (en adelante, Servicios).

Todo Teatro se reserva la facultad de modificar, en cualquier momento, y sin aviso previo, la presentación y configuración del Sitio Web y de los Contenidos y Servicios que en él pudieran estar incorporados. El Usuario reconoce y acepta que en cualquier momento Todo Teatro pueda interrumpir, desactivar y/o cancelar cualquiera de estos elementos que se integran en el Sitio Web o el acceso a los mismos.</p>

                    <h5>EL USUARIO</h5>
                        <p>El acceso, la navegación y uso del Sitio Web, confiere la condición de Usuario, por lo que se aceptan, desde que se inicia la navegación por el Sitio Web, todas las Condiciones aquí establecidas, así como sus ulteriores modificaciones, sin perjuicio de la aplicación de la correspondiente normativa legal de obligado cumplimiento según el caso. Dada la relevancia de lo anterior, se recomienda al Usuario leerlas cada vez que visite el Sitio Web.</p>
                        <p>El mero acceso a este Sitio Web no supone entablar ningún tipo de relación de carácter comercial entre Todo Teatro y el Usuario.</p>

                    <h4>III. ACCESO Y NAVEGACIÓN EN EL SITIO WEB: EXCLUSIÓN DE GARANTÍAS Y RESPONSABILIDAD</h4>
                    <P>Todo Teatro no garantiza la continuidad, disponibilidad y utilidad del Sitio Web, ni de los Contenidos o Servicios. Todo Teatro hará todo lo posible por el buen funcionamiento del Sitio Web, sin embargo, no se responsabiliza ni garantiza que el acceso a este Sitio Web no vaya a ser ininterrumpido o que esté libre de error.

Tampoco se responsabiliza o garantiza que el contenido o software al que pueda accederse a través de este Sitio Web, esté libre de error o cause un daño al sistema informático (software y hardware) del Usuario. En ningún caso Todo Teatro será responsable por las pérdidas, daños o perjuicios de cualquier tipo que surjan por el acceso, navegación y el uso del Sitio Web, incluyéndose, pero no limitándose, a los ocasionados a los sistemas informáticos o los provocados por la introducción de virus.

Todo Teatro tampoco se hace responsable de los daños que pudiesen ocasionarse a los usuarios por un uso inadecuado de este Sitio Web. En particular, no se hace responsable en modo alguno de las caídas, interrupciones, falta o defecto de las telecomunicaciones que pudieran ocurrir.</P>
                    <h4 class="my-3">IV. POLÍTICA DE ENLACES</h4>
                    <P>Todo Teatro no ofrece ni comercializa por sí ni por medio de terceros los productos y/o servicios disponibles en dichos sitios enlazados.

El Usuario o tercero que realice un hipervínculo desde una página web de otro, distinto, sitio web al Sitio Web de Todo Teatro deberá saber que:

No se permite la reproducción —total o parcialmente— de ninguno de los Contenidos y/o Servicios del Sitio Web sin autorización expresa de Todo Teatro.

No se permite tampoco ninguna manifestación falsa, inexacta o incorrecta sobre el Sitio Web de Todo Teatro, ni sobre los Contenidos y/o Servicios del mismo.

A excepción del hipervínculo, el sitio web en el que se establezca dicho hiperenlace no contendrá ningún elemento, de este Sitio Web, protegido como propiedad intelectual por el ordenamiento jurídico español, salvo autorización expresa de Todo Teatro.

El establecimiento del hipervínculo no implicará la existencia de relaciones entre Todo Teatro y el titular del sitio web desde el cual se realice, ni el conocimiento y aceptación de Todo Teatro de los contenidos, servicios y/o actividades ofrecidos en dicho sitio web, y viceversa.</P>
                    <h4>V. PROPIEDAD INTELECTUAL E INDUSTRIAL</h4>
                    <P>Todo Teatro por sí o como parte cesionaria, es titular de todos los derechos de propiedad intelectual e industrial del Sitio Web, así como de los elementos contenidos en el mismo (a título enunciativo y no exhaustivo, imágenes, sonido, audio, vídeo, software o textos, marcas o logotipos, combinaciones de colores, estructura y diseño, selección de materiales usados, programas de ordenador necesarios para su funcionamiento, acceso y uso, etc.). Serán, por consiguiente, obras protegidas como propiedad intelectual por el ordenamiento jurídico español, siéndoles aplicables tanto la normativa española y comunitaria en este campo, como los tratados internacionales relativos a la materia y suscritos por España.

Todos los derechos reservados. En virtud de lo dispuesto en la Ley de Propiedad Intelectual, quedan expresamente prohibidas la reproducción, la distribución y la comunicación pública, incluida su modalidad de puesta a disposición, de la totalidad o parte de los contenidos de esta página web, con fines comerciales, en cualquier soporte y por cualquier medio técnico, sin la autorización de Todo Teatro.

El Usuario se compromete a respetar los derechos de propiedad intelectual e industrial de Todo Teatro. Podrá visualizar los elementos del Sitio Web o incluso imprimirlos, copiarlos y almacenarlos en el disco duro de su ordenador o en cualquier otro soporte físico siempre y cuando sea, exclusivamente, para su uso personal. El Usuario, sin embargo, no podrá suprimir, alterar, o manipular cualquier dispositivo de protección o sistema de seguridad que estuviera instalado en el Sitio Web.

En caso de que el Usuario o tercero considere que cualquiera de los Contenidos del Sitio Web suponga una violación de los derechos de protección de la propiedad intelectual, deberá comunicarlo inmediatamente a Todo Teatro a través de los datos de contacto del apartado de INFORMACIÓN GENERAL de este Aviso Legal y Condiciones Generales de Uso.</p>
                </div>
            </div>
        </section>
    </main>

    <?php




echo insertar_footer($parametro1Footer, $parametro2);



    ?>
</body>

</html>