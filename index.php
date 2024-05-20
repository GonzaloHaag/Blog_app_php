<?php
require 'admin/config.php';
require 'components/header.php';
require 'functions/functions.php'; //Llamo a mi archivo 
$conexion = connect_BD($bd_config); //Le paso el arreglo de la bd config, porque la funcion lo recibe como parametro

if(!$conexion) {
    header('Location:error.php'); //Si no hay conexion dirijo a este archivo
}
$posts = get_posts( $blog_config['post_per_page'],$conexion ); // Le mando la conexion de mi funcion
if(!$posts) {
    header('Location:error.php');
}
?>
<!-- Arranco desde el body, porque el archivo header.php ya tiene  el css incrustado -->
<body>
<div class="contenedor contenedor-posts">
    <?php foreach($posts as $post): ?>
        <div class="post">
        <article>
            <a href="single.php?id=<?php echo $post['id'] ?>" class="titulo"><?php echo $post['titulo'] ?></a>
            <p class="fecha"><?php echo fecha($post['fecha']) ?></p>
            <div class="thumb">
                <a href="<?php RUTA ?>single.php?id=<?php echo $post['id'] ?>">
                    <img src="<?php RUTA ?>images/<?php echo $post['thumb'] ?>" alt="<?php echo $post['titulo'] ?>" />
                </a>
            </div>
            <p class="extracto">
                <?php echo $post['extracto'] ?>
            </p>
            <a href="single.php?id=<?php echo $post['id'] ?>" class="continuar">Leer más</a>
    </article>
    </div>
    <?php endforeach; ?>
    <?php require 'components/paginacion.php'; ?>
</div>
<?php require 'components/footer.php'; ?>
</body>