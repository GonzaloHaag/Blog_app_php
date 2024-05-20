<?php
## Archivo donde tendre mis funciones 

function connect_BD($bd_config) {
    ## Funcion para conectarme a la base de datos, recibe el arreglo de mi config.php, accedo mediante las claves q le puse
   try {
     $conexion = new PDO('mysql:host=127.0.0.1;dbname='.$bd_config['base_de_datos'],$bd_config['user'],$bd_config['password']);
     return $conexion;
   }
   catch(PDOException $e) {
    // Si falla retorno false
    return false;
   }
}

## Funcion para limpiar caracteres en el input y evitar inyeccion de codigo 
function limpiarDatos($datos) {
    $datos = trim($datos); //Limpiamos espacios en blanco
    $datos = stripslashes($datos); // Quita las barras / para que no se inyecte codigo 
    $datos = htmlspecialchars($datos); // Quita caracteres especiales
    return $datos;
}
## Funcion para obtener en que pagina me encuentro
function pagina_actual():int {
  /** El get 'page' se refiere a que el argumento debe llegar asi http://127.0.0.1:8000/?page=2 */
   return isset($_GET['page']) ?  (int)$_GET['page'] : 1; //Si me llega la pagina por url, la retorno, sino retorno 1
}

## Funcion para obtener los posts desde la base de datos, recibe la conexion y los posts por pagina
function get_posts($posts_por_pagina,$conexion) {
  $inicio = (pagina_actual() > 1 ? pagina_actual() * $posts_por_pagina - $posts_por_pagina : 0);
  /** Con la conexion que recibo hago lo de siempre */
  $statement = $conexion->prepare("SELECT SQL_CALC_FOUND_ROWS * FROM articulos LIMIT $inicio, $posts_por_pagina"); /** Traeme los articulos desde $inicio, y cuantos posts */
  $statement->execute();

  return $statement->fetchAll(); // Retorno los posts encontrados
}
function numero_paginas($posts_por_pagina,$conexion) {
   $total_posts = $conexion->prepare('SELECT FOUND_ROWS() as total'); //Veo cuantas filas tengo 
   $total_posts->execute();
   $total_posts = $total_posts->fetch()['total'];

   $numero_paginas = ceil($total_posts / $posts_por_pagina);
   return $numero_paginas;
}
## Funcion para que el id de la url sea un entero y evitar que inyecten otra cosa 
function limpiar_id_post($id_post) {
    return (int)limpiarDatos($id_post); //Retorno el id como entero y limpio, para que no pasen un string
}
## Funcion para obtener el post por id
function get_post_por_id($conexion,$id_post) {
  //el id del post ya lo recibo limpio
  /** Haremos la consulta mediante query */
  $resultado = $conexion->query("SELECT * FROM articulos WHERE id=$id_post");
  $resultado = $resultado -> fetchAll();

  return ($resultado) ? $resultado : false; //Si hay un post lo retorno, sino que sea false
}

## Funcion para convertir la fecha 
function fecha($fecha) {
  $timestamp = strtotime($fecha); //Convierte una variable a tiempo
  $meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
  $dia = date('d',$timestamp);
  $mes = date('m',$timestamp) - 1;
  $anio = date('Y',$timestamp);
  $fecha = "$dia de ".$meses[$mes]." del $anio";

  return $fecha;
}

/** Funcion para proteger la ruta del admin */
function comprobar_sesion() {
  if(!isset($_SESSION['admin'])) {
    // Si no hay sesion seteada, lo dirigo al index. Recordar que estoy creando una sesion con el nombre admin
      header('Location: '. RUTA);
  }
}
?>