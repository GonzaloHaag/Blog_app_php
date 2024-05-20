<?php
## Archivo para editar un post
session_start(); //Siempre cada vez que uso sesiones
require 'config.php';
require '../components/header.php';
require '../functions/functions.php';

comprobar_sesion(); //Para que solo el admin pueda editar un post

$conexion = connect_BD($bd_config);
if(!$conexion) {
    header('Location:../error.php');
}

/** Voy a preguntar si se enviaron los datos mediante post */
if($_SERVER['REQUEST_METHOD'] == 'POST') {

    /** Aca es cuando guardamos los datos, ya que significa que dio click al boton de modificar articulo */
    $titulo = limpiarDatos($_POST['titulo']);
    $extracto = limpiarDatos($_POST['extracto']);
    $texto = $_POST['texto'];
    $id = limpiarDatos($_POST['id']);
    $thumb_guardada = $_POST['thumb-guardada'];
    $thumb = $_FILES['thumb'];

    if(empty($thumb['name'])) {
      // Si esta vacio es porque no pusieron otra imagen nueva, trabajo con la que ya estaba 
      $thumb = $thumb_guardada;
    }
    else {
        //Subimos la imagen
        $archivo_subido = '../'.$blog_config['carpeta_imagenes'].$_FILES['thumb']['name'];
        move_uploaded_file($_FILES['thumb']['tmp_name'],$archivo_subido);
        $thumb = $_FILES['thumb'];
    }
    //UPDATE para actualizar
    $statement = $conexion->prepare('UPDATE articulos SET titulo = :titulo, extracto = :extracto, fecha = :fecha, texto = :texto, thumb = :thumb WHERE id = :id');
    $statement ->execute(array(
        ':titulo' => $titulo,
        ':extracto' => $extracto,
        ':fecha' => date("Y-m-d H:i:s"), //Le paso fecha y hora actuales
        ':texto' => $texto,
        ':thumb' => $thumb,
        ':id' => $id
    ));

    header('Location:'.RUTA.'admin');
}
else {
    // Traigo los datos que ya tenia guardado el post para editarlos
    // Todos estos valores los pongo en los value de mis input
    $id_articulo = limpiar_id_post($_GET['id']);
    if(empty($id_articulo)) {
        // Dirigo a la ruta /admin si esta vacio
        header('Location:'.RUTA . 'admin');
    }
    $post = get_post_por_id($conexion,$id_articulo);
    if(!$post) {
        header('Location:'.RUTA . 'admin');
    }
    $post = $post[0];
}
?>
<body>
  <div class="contenedor contenedor-form">
  <div class="post">
        <article>
            <h2 class="titulo">Editar artículo</h2>
            <form class="formulario" method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">
                 <input type="hidden" name="id" value="<?php echo $post['id'] ?>" />
                 <input class="titulo-articulo" type="text" name="titulo" value="<?php echo $post['titulo'] ?>" />
                 <input class="extracto-articulo" type="text" name="extracto" value="<?php echo $post['extracto'] ?>"/>
                 <textarea rows="6" class="texto-articulo" name="texto">
                    <?php echo $post['texto'] ?>
                 </textarea>
                 <input type="file" name="thumb" />
                 <input type="hidden" name="thumb-guardada" value="<?php echo $post['thumb'] ?>" /> <!-- Para guardarme la thumb anterior -->
                 <input class="submit" type="submit" value="Modificar articulo" />
            </form>
        </article>
</div>
  </div>
<?php require '../components/footer.php' ?>
</body>