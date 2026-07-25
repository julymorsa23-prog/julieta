<?php
session_start();

// Eliminar todas las variables de sesión
$_SESSION = [];

// Destruir la sesión
session_destroy();

// Evitar que el navegador almacene la página anterior en caché
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// Redirigir al inicio de sesión
header("Location: index.php");
exit();
?>