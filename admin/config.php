<?php
## Archivo donde voy a tener la configuracion de mi pagina
define('RUTA','http://127.0.0.1:8000/'); //Constanste llamada RUTA

// Array con la configuracion de mi base de datos
$bd_config = array (
    'base_de_datos' => 'curso_php_blog',
    'user' => 'root',
    'password' => '12345'
); 
// array con la configuracion de mis blog
$blog_config = array(
    'post_per_page' => 2,
    'carpeta_imagenes' => 'images/'
);
//Configuracion del user y password que son admin
$blog_admin = array(
   'user' => 'Lalo',
   'password' => 'LukaD'
)
?>