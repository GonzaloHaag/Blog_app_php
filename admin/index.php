<?php
## ARCHIVO QUE PODRA VER SOLO EL ADMIN --> VAMOS A TRABAJAR CON SESIONES 
## ESTE ARCHIVO CORRESPONDE A LA RUTA /admin --> CLAVE
session_start();
require 'config.php';
require '../components/header.php';
require '../functions/functions.php'; //Llamo a mi archivo 
$conexion = connect_BD($bd_config); //Le paso el arreglo de la bd config, porque la funcion lo recibe como parametro

//Comprobar conexion
if(!$conexion) {
    header('Location:../error.php');
}
//Comprobar session
comprobar_sesion();

$posts = get_posts($blog_config['post_per_page'],$conexion);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="favicon.png" type="image/x-icon">
    <script src="https://kit.fontawesome.com/94b7263109.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="<?php echo RUTA ?>css/styles.css">
    <title>Blog Admin</title>
</head>
<body>
<div class="contenedor contenedor-posts">
    <h2>Panel de control</h2>
    <div class="btn-container">
    <a href="/admin/nuevo.php" class="btn">Nuevo post</a>
    <a href="/admin/cerrar.php" class="btn">Cerrar sesión</a>
    </div>
    <?php foreach($posts as $post): ?>
        <div class="post">
        <article>
            <h2 class="titulo"><?php echo $post['id'] . '.' . $post['titulo'] ?></h2>
            <div class="actions">
            <a href="/admin/editar.php?id=<?php echo $post['id'] ?>">Editar</a>
            <a href="../single.php?id=<?php echo $post['id'] ?>">Ver</a>
            <a href="/admin/borrar.php?id=<?php echo $post['id'] ?>">Borrar</a>
            </div>
           
        </article>
    </div>
    <?php endforeach; ?>
    <?php require '../components/paginacion.php'; ?>
</div>
<?php require '../components/footer.php'; ?>
</body>
</html>
