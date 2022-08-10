<?php

function conectarBD($host,$usuario,$contrasena){
    $mbd = new mysqli($host,$usuario,$contrasena);
    $mbd->set_charset("utf8");
    
    return $mbd;
}
?>