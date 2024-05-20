<?php 
## Necesito la variable global RUTA para enlazar mi css y tenerla disponible
## Esa variable esta en config.php pero la llamo desde los archivos que invoco al header

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="favicon.png" type="image/x-icon">
    <script src="https://kit.fontawesome.com/94b7263109.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="<?php echo RUTA ?>css/styles.css">
    <title>Blog</title>
</head>
    <!-- Archivo donde tendre solamente mi header, para utilizarlo en varias paginas -->
    <header>
        <div class="contenedor contenedor-header">
            <div class="logo izquierda">
                <a href="<?php echo RUTA ?>">Mi primer blog</a>
            </div>
            <div class="derecha">
                <!-- Buscador -->
                <form name="busqueda" class="buscar" action="<?php echo RUTA; ?>buscar.php" method="get">
                    <!-- Voy a mandar los datos a /buscar.php con el metodo get -->
                    <input type="text" name="busqueda" placeholder="Buscar" autocomplete="off" />
                    <button type="submit" class="icono fa fa-search"></button>
                </form>
                <nav class="menu">
                    <ul>
                        <li>
                            <a href="#">
                                <i class="fa fa-twitter social-icon"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fa fa-facebook social-icon"></i>
                            </a>
                        </li>
                        <li>
                            <a href="login.php">
                              <i class="fa-solid fa-right-to-bracket"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

</html>