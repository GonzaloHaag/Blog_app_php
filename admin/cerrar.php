<?php
session_start();
// Destruyo la sesion para cerrarla
session_destroy();
$_SESSION = array();

header('Location: ../');
die();
?>