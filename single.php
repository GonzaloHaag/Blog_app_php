<?php
require 'admin/config.php';
require 'components/header.php';
## Archivo para ver el post entero --> recibira el id del post por URL (variable GET)
// echo $_GET['id']; 
require 'functions/functions.php';

$conexion = connect_BD($bd_config);
if(!$conexion) {
    header('Location:error.php');
}
$id_post = $_GET['id']; //Me guardo el parametro que llega por url como ?id=1, y asi..
if(empty($id_post)) {
    /** Si esta vacio el id, que diriga al index.php */
    header('Location:index.php');
}
$id_post_limpio = limpiar_id_post($id_post);
$post = get_post_por_id($conexion,$id_post_limpio);
if(!$post) {
    /** Significa que no tengo post con ese id en mi base de datos */
    header('Location:index.php');
}
$post = $post[0]; /** Tiene que ser en la posicion 0, solo devuelve 1 pero esta dentro de un array */
?>

<body>
<div class="contenedor contenedor-posts">
    <div class="post">
        <article>
            <h2><?php echo $post['titulo'] ?></h2>
            <p class="fecha"><?php echo fecha($post['fecha']) ?></p>
            <div class="thumb">
                    <img src="<?php RUTA ?>images/<?php echo $post['thumb'] ?>" alt="<?php echo $post['titulo'] ?>" />
            </div>
            <p class="extracto">
                <?php echo nl2br($post['texto']) ?>
                <!-- La funcion nl2br es para respetar los espacios -->
            </p>
            <p class="extracto">
                <?php echo nl2br($post['texto']) ?>
            </p>
        </article>
    </div>
</div>
<?php require 'components/footer.php'; ?>
</body>