<?php 
session_start();
## Archivo para borrar un post , voy a recibir el id(GET) por url del post a eliminar
require 'config.php';
require '../components/header.php';
require '../functions/functions.php';

comprobar_sesion();

$conexion = connect_BD($bd_config);
if(!$conexion) {
    header('Location:../error.php');
}
$id_post = limpiar_id_post($_GET['id']); //Obtengo el id que llega por url

if(!$id_post) {
    //Si no hay id dirigo al /admin
    header('Location:'.RUTA.'admin');
}

$statement = $conexion->prepare('DELETE FROM articulos WHERE id = :id');

$statement->execute(array(
    ':id' => $id_post
));

header('Location:'.RUTA.'admin');
?>