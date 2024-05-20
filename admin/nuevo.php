<?php
## Archivo para que el admin pueda crear un nuevo post
session_start();
require 'config.php';
require '../components/header.php';
require '../functions/functions.php';

comprobar_sesion(); //Para que solo el admin pueda crear un post

$conexion = connect_BD($bd_config);
if(!$conexion) {
    header('Location:../error.php');
}
//Comprobar si se enviaron los datos 
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = limpiarDatos($_POST['titulo']); //Lo obtengo por name
    $extracto = limpiarDatos($_POST['extracto']);
    $texto = $_POST['texto'];
    $image = $_FILES['thumb']['tmp_name']; //Imagen que se sube 

    $archivo_subido = '../'.$blog_config['carpeta_imagenes'].$_FILES['thumb']['name'];
    // quedara algo como ../images/1.jpg

    move_uploaded_file($image,$archivo_subido); //Recibe la imagen y el destino para mover al servidor la imagen

    $statement = $conexion->prepare('INSERT INTO articulos (id,titulo,extracto,fecha,texto,thumb) VALUES (null, :titulo, :extracto,:fecha, :texto, :thumb)');
    $statement->execute(array(
        ':titulo' => $title,
        ':extracto' => $extracto,
        ':fecha' => date("Y-m-d H:i:s"), //Le paso fecha y hora actuales
        ':texto' => $texto,
        ':thumb' => $_FILES['thumb']['name']
    ));

    /** Una vez insertado, dirijo al admin */
    header('Location:'.RUTA.'admin');
}

?>
<body>
  <div class="contenedor contenedor-form">
  <div class="post">
        <article>
            <h2 class="titulo">Nuevo Post</h2>
            <form class="formulario" method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">
                 <input class="titulo-articulo" type="text" name="titulo" placeholder="Titulo del articulo" />
                 <input class="extracto-articulo" type="text" name="extracto" placeholder="Extracto del articulo" />
                 <textarea rows="6" class="texto-articulo" name="texto" placeholder="Texto del articulo"></textarea>
                 <input type="file" name="thumb" />
                 <input class="submit" type="submit" value="Crear articulo" />
            </form>
        </article>
</div>
  </div>
<?php require '../components/footer.php' ?>
</body>