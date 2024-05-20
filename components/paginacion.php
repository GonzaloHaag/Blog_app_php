<?php
$numero_paginas = numero_paginas($blog_config['post_per_page'], $conexion);
$url_actual = $_SERVER['PHP_SELF']; //Obtengo la url en la que estoy
?>
<!-- Arranco con la seccion directamente, el css ya esta enlazado en el index -->
<section class="paginacion">
  <ul>
    <?php if (pagina_actual() === 1) : ?>
      <li class="disabled">&laquo;</li> <!-- Icono de volver hacia atras -->
    <?php else : ?>
      <li class="no-active">
        <a href="<?php echo $url_actual ?>?page=<?php echo pagina_actual() - 1 ?>">&laquo;</a>
      </li> <!-- Icono de volver hacia atras -->
    <?php endif ?>

    <?php for ($i = 1; $i <= $numero_paginas; $i++) : ?>
      <?php if (pagina_actual() === $i) : ?>
        <!-- Significa que me encuentro en esa pagina, para hacer el li activo -->
        <li class="active">
          <?php echo $i; ?>
        </li>
      <?php else : ?>
        <li class="no-active">
          <a href="<?php echo $url_actual ?>?page=<?php echo $i ?>"><?php echo $i ?></a>
        </li>
      <?php endif ?>
    <?php endfor ?>
  </ul>
</section>