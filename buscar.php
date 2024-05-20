<?php
require 'admin/config.php';
require 'components/header.php';
require 'functions/functions.php';
## A este archivo dirige la barra de busqueda y recibo el parametro por URL lo que se escriba
// echo $_GET['busqueda'];

$conexion = connect_BD($bd_config);
if(!$conexion) {
    header('Location:error.php'); 
}
if($_SERVER['REQUEST_METHOD'] == 'GET' && !empty($_GET['busqueda'])) {
  /** Si llega un get y no esta vacia la variable busqueda, quiere decir que me escribieron algo */
  $text_busqueda = limpiarDatos($_GET['busqueda']); //Limpio lo que me escribieron
  $statement = $conexion->prepare('SELECT * FROM articulos WHERE titulo LIKE :busqueda OR texto LIKE :busqueda');
  /** que el texto o el titulo coincidan con lo que me escriben en el input */
  $statement->execute(array(
    ':busqueda' => "%$text_busqueda%" // los % van para que busque lo que CONTENGA, sino hara que sea exactamente igual
  ));
  $result = $statement->fetchAll();

  if(empty($result)) {
    /** Si esta vacio es porque no encontro nada */
    $titulo = 'No se encontraron articulos con el resultado '.$text_busqueda;
  }
  else {
     $titulo = 'Resultados de la busqueda: '.$text_busqueda;
  }
}
else {
    header('Location:index.php');
}
?>
<!-- Arranco desde el body, porque el archivo header.php ya tiene  el css incrustado -->
<body>
<div class="contenedor contenedor-posts">
    <div class="title-search">
        <h1><?php echo $titulo ?></h1>
    </div>
    <?php foreach($result as $post): ?>
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