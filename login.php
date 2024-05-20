<?php
session_start(); //Porque voy a trabajar con sesiones
require 'admin/config.php';
require 'components/header.php'; 
require 'functions/functions.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
      /** Verifico que se hayan enviado los datos */
      $user = limpiarDatos($_POST['usuario']); //Me guardo lo que se escribio en el input user
      $password = limpiarDatos($_POST['password']); //Me guardo lo que se escribio en el input password
      
      /** Yo en mi archivo config.php, tengo un array donde esta la configuracion para el admin. Debo 
       * preguntar si el user y password coinciden con esos valores y alli creo una sesion. Si los valores
       * no coinciden, no hago nada
       */
      if($user == $blog_admin['user'] && $password == $blog_admin['password']) {
        /* Creo la sesion con el nombre admin */
        $_SESSION['admin'] = $blog_admin['user'];
        /** Si inicio sesion, lo dirigo a la ruta /admin */
        header('Location:'.RUTA.'admin');
      }
}
?>
<body>
    <div class="contenedor login-contenedor">
        <div class="post">
            <article>
                <h2 class="titulo">Iniciar sesión</h2>
                <form class="formulario" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
                  <!-- Voy a mandar los datos a esta misma pagina con el metodo post -->
                  <input class="usuario" type="text" name="usuario" placeholder="Usuario" />
                  <input class="password" type="password" name="password" placeholder="Contraseña" />
                  <input class="submit" type="submit" value="Iniciar sesión" />
                </form>
            </article>
        </div>
    </div>
    <?php require 'components/footer.php' ?>
</body>